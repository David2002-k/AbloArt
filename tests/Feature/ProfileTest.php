<?php

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

test('profile page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/profile');

    $response->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $user->refresh();

    $this->assertSame('Test User', $user->name);
    $this->assertSame('test@example.com', $user->email);
    $this->assertNull($user->email_verified_at);
});

test('profile information and password can be updated together', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'name' => 'Updated User',
            'email' => $user->email,
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $this->assertSame('Updated User', $user->refresh()->name);
    $this->assertTrue(Hash::check('new-password', $user->password));
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'name' => 'Test User',
            'email' => $user->email,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $this->assertNotNull($user->refresh()->email_verified_at);
});

test('user can delete their account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->delete('/profile', [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
    $this->assertNull($user->fresh());
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->delete('/profile', [
            'password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrorsIn('userDeletion', 'password')
        ->assertRedirect('/profile');

    $this->assertNotNull($user->fresh());
});

test('admin can delete their profile photo', function () {
    Storage::fake('public');
    $user = User::factory()->create();
    $photo = 'admins/photos/profile.jpg';
    Storage::disk('public')->put($photo, 'photo');
    Admin::create(['user_id' => $user->id, 'photo' => $photo]);

    $response = $this->actingAs($user)->delete(route('profile.photo.destroy'));

    $response->assertRedirect(route('profile.edit'))->assertSessionHas('status', 'photo-deleted');
    Storage::disk('public')->assertMissing($photo);
    $this->assertDatabaseHas('admins', ['id' => $user->admin->id, 'photo' => null]);
});

test('admin can delete their cv', function () {
    Storage::fake('public');
    $user = User::factory()->create();
    $cv = 'admins/cv/cv.pdf';
    Storage::disk('public')->put($cv, 'cv');
    Admin::create(['user_id' => $user->id, 'cv' => $cv]);

    $response = $this->actingAs($user)->delete(route('profile.cv.destroy'));

    $response->assertRedirect(route('profile.edit'))->assertSessionHas('status', 'cv-deleted');
    Storage::disk('public')->assertMissing($cv);
    $this->assertDatabaseHas('admins', ['id' => $user->admin->id, 'cv' => null]);
});

test('admin photo telephone and cv are saved and shown to public visitors', function () {
    Storage::fake('public');
    $user = User::factory()->create();
    Admin::create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->patch(route('profile.update'), [
        'name' => $user->name,
        'email' => $user->email,
        'telephone' => '+226 70 12 34 56',
        'photo' => UploadedFile::fake()->image('profile.jpg'),
        'cv' => UploadedFile::fake()->create('cv.pdf', 200, 'application/pdf'),
    ]);

    $response->assertRedirect(route('profile.edit'));

    $admin = $user->admin->refresh();
    expect($admin->photo)->toStartWith('admins/photos/')
        ->and($admin->telephone)->toBe('+226 70 12 34 56')
        ->and($admin->cv)->toStartWith('admins/cv/');

    Storage::disk('public')->assertExists($admin->photo);
    Storage::disk('public')->assertExists($admin->cv);

    $this->actingAs($user)
        ->get(route('profile.edit'))
        ->assertOk()
        ->assertSee('form="profile-photo-delete"', false)
        ->assertSee('form="profile-cv-delete"', false)
        ->assertSee('form="profile-telephone-delete"', false)
        ->assertSee('id="profile-photo-delete"', false)
        ->assertSee('id="profile-cv-delete"', false)
        ->assertSee('id="profile-telephone-delete"', false);

    $this->get(route('welcome'))
        ->assertOk()
        ->assertSee(asset('storage/'.$admin->photo))
        ->assertSee('tel:+22670123456', false)
        ->assertSee('Téléphone : +226 70 12 34 56')
        ->assertSee(route('profile.cv'))
        ->assertSee('Télécharger le CV');

    $this->get(route('a-propos.index'))
        ->assertOk()
        ->assertSee(asset('storage/'.$admin->photo));

    $this->get(route('profile.cv'))
        ->assertDownload('CV-AbloArt.pdf');
});

test('admin can remove the public telephone number', function () {
    $user = User::factory()->create();
    Admin::create(['user_id' => $user->id, 'telephone' => '+226 70 12 34 56']);

    $response = $this->actingAs($user)->delete(route('profile.telephone.destroy'));

    $response->assertRedirect(route('profile.edit'))
        ->assertSessionHas('status', 'telephone-deleted');

    $this->assertDatabaseHas('admins', [
        'id' => $user->admin->id,
        'telephone' => null,
    ]);
});
