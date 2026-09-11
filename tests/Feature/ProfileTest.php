<?php

use App\Models\Admin;
use App\Models\User;
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
