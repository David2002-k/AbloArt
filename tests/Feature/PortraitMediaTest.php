<?php

use App\Models\Admin;
use App\Models\Categorie;
use App\Models\Portrait;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('admin can create a portrait with a video and no image', function () {
    Storage::fake('public');
    $user = User::factory()->create();
    $admin = Admin::create(['user_id' => $user->id]);
    $categorie = Categorie::create(['nom' => 'Portraits', 'description' => null]);

    $response = $this->actingAs($user)->post(route('admin.portraits.store'), [
        'categorie_id' => $categorie->id,
        'description' => 'Portrait présenté en vidéo uniquement.',
        'video' => UploadedFile::fake()->create('making-of.mp4', 1024, 'video/mp4'),
    ]);

    $response->assertRedirect(route('admin.portraits.index'));

    $portrait = Portrait::firstOrFail();

    expect($portrait->image)->toBeNull()
        ->and($portrait->video)->toStartWith('portraits/videos/');

    $this->assertDatabaseHas('portraits', [
        'id' => $portrait->id,
        'admin_id' => $admin->id,
        'image' => null,
    ]);

    Storage::disk('public')->assertExists($portrait->video);

    $this->get(route('galerie.index'))
        ->assertOk()
        ->assertSee(asset('storage/'.$portrait->video));
});

test('admin must provide an image or a video for a new portrait', function () {
    $user = User::factory()->create();
    Admin::create(['user_id' => $user->id]);
    $categorie = Categorie::create(['nom' => 'Portraits', 'description' => null]);

    $response = $this->actingAs($user)
        ->from(route('admin.portraits.create'))
        ->post(route('admin.portraits.store'), [
            'categorie_id' => $categorie->id,
            'description' => 'Portrait sans média.',
        ]);

    $response->assertRedirect(route('admin.portraits.create'))
        ->assertSessionHasErrors('image')
        ->assertSessionDoesntHaveErrors('video');

    expect(Portrait::count())->toBe(0);
});
