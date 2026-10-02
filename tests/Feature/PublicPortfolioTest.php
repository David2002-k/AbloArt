<?php

use App\Models\Admin;
use App\Models\Categorie;
use App\Models\DemandePortrait;
use App\Models\Portrait;
use App\Models\ReseauSocial;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('visitor can access the gallery', function () {
    $this->get(route('galerie.index'))
        ->assertOk()
        ->assertSee('Galerie');
});

test('homepage renders accessible brand icons for social links instead of names', function () {
    foreach ([
        ['nom' => 'WhatsApp', 'icone' => 'whatsapp', 'url' => 'https://wa.me/123456789'],
        ['nom' => 'Instagramme', 'icone' => 'instagram', 'url' => 'https://instagram.com/abloart'],
        ['nom' => 'TikTok', 'icone' => 'tiktok', 'url' => 'https://tiktok.com/@abloart'],
        ['nom' => 'Facebook', 'icone' => 'facebook', 'url' => 'https://facebook.com/abloart'],
    ] as $socialNetwork) {
        ReseauSocial::create([...$socialNetwork, 'actif' => true]);
    }

    $response = $this->get(route('welcome'));

    $response
        ->assertOk()
        ->assertSee('aria-label="WhatsApp"', false)
        ->assertSee('aria-label="Instagramme"', false)
        ->assertSee('aria-label="TikTok"', false)
        ->assertSee('aria-label="Facebook"', false)
        ->assertSee('data-social-icon="whatsapp"', false)
        ->assertSee('data-social-icon="instagram"', false)
        ->assertSee('data-social-icon="tiktok"', false)
        ->assertSee('data-social-icon="facebook"', false)
        ->assertDontSee('>WhatsApp</a>', false)
        ->assertDontSee('>Instagramme</a>', false)
        ->assertDontSee('>TikTok</a>', false)
        ->assertDontSee('>Facebook</a>', false);
});

test('home portrait carousel keeps rotating without pausing on hover', function () {
    $user = User::factory()->create();
    $admin = Admin::create(['user_id' => $user->id]);
    $categorie = Categorie::create(['nom' => 'Portraits', 'description' => null]);

    Portrait::create([
        'categorie_id' => $categorie->id,
        'admin_id' => $admin->id,
        'image' => 'portraits/premier.jpg',
    ]);
    Portrait::create([
        'categorie_id' => $categorie->id,
        'admin_id' => $admin->id,
        'image' => 'portraits/deuxieme.jpg',
    ]);

    $this->get(route('welcome'))
        ->assertOk()
        ->assertSee('id="homePortraitCarousel"', false)
        ->assertSee('data-bs-interval="3000"', false)
        ->assertSee('data-bs-pause="false"', false);
});

test('gallery displays every portrait image and video together', function () {
    $user = User::factory()->create();
    $admin = Admin::create(['user_id' => $user->id]);
    $categorie = Categorie::create(['nom' => 'Portraits', 'description' => null]);
    Portrait::create([
        'categorie_id' => $categorie->id,
        'admin_id' => $admin->id,
        'description' => 'Portrait avec image et vidéo',
        'image' => 'portraits/test.jpg',
        'video' => 'portraits/test.mp4',
    ]);

    $response = $this->get(route('galerie.index'));

    $response
        ->assertOk()
        ->assertSee(asset('storage/portraits/test.jpg'))
        ->assertSee(asset('storage/portraits/test.mp4'))
        ->assertSee('Portrait avec image et vidéo')
        ->assertDontSee('portraitCarousel');
});

test('visitor can submit a portrait request', function () {
    Storage::fake('public');

    $response = $this->post(route('demandes.store'), [
        'nom' => 'Client Test',
        'email' => 'client@example.com',
        'telephone' => '0601020304',
        'description' => 'Je souhaite un portrait de famille.',
        'photo_reference' => UploadedFile::fake()->image('reference.jpg'),
    ]);

    $response
        ->assertRedirect(route('demandes.create'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('demande_portraits', [
        'nom' => 'Client Test',
        'email' => 'client@example.com',
        'statut' => 'en_attente',
    ]);

    $demande = DemandePortrait::firstOrFail();

    expect(DemandePortrait::count())->toBe(1)
        ->and($demande->photo_reference)->toStartWith('demandes/references/');

    Storage::disk('public')->assertExists($demande->photo_reference);
});
