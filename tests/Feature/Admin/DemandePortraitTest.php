<?php

use App\Models\Admin;
use App\Models\DemandePortrait;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

test('admin can update a portrait request status and download its reference photo', function () {
    Storage::fake('public');
    Storage::disk('public')->put('demandes/references/reference.jpg', 'image-data');
    $user = User::factory()->create();
    Admin::create(['user_id' => $user->id]);
    $demande = DemandePortrait::create([
        'nom' => 'Client Test',
        'email' => 'client@example.com',
        'description' => 'Je souhaite un portrait de famille.',
        'photo_reference' => 'demandes/references/reference.jpg',
    ]);

    $this->actingAs($user)
        ->get(route('admin.demandes.index'))
        ->assertOk()
        ->assertSee(route('admin.demandes.photo', $demande));

    $this->actingAs($user)
        ->patch(route('admin.demandes.statut', $demande), ['statut' => 'terminee'])
        ->assertRedirect();

    $this->assertDatabaseHas('demande_portraits', [
        'id' => $demande->id,
        'statut' => 'terminee',
    ]);

    $this->actingAs($user)
        ->get(route('admin.demandes.photo', $demande))
        ->assertDownload('photo-demande-'.$demande->id.'.jpg');
});

test('guest cannot change request status or download its photo', function () {
    $demande = DemandePortrait::create([
        'nom' => 'Client Test',
        'email' => 'client@example.com',
        'description' => 'Je souhaite un portrait de famille.',
        'photo_reference' => 'demandes/references/reference.jpg',
    ]);

    $this->patch(route('admin.demandes.statut', $demande), ['statut' => 'refusee'])
        ->assertRedirect(route('login'));

    $this->get(route('admin.demandes.photo', $demande))
        ->assertRedirect(route('login'));
});

test('non-admin cannot change request status or download its photo', function () {
    $user = User::factory()->create();
    $demande = DemandePortrait::create([
        'nom' => 'Client Test',
        'email' => 'client@example.com',
        'description' => 'Je souhaite un portrait de famille.',
        'photo_reference' => 'demandes/references/reference.jpg',
    ]);

    $this->actingAs($user)
        ->patch(route('admin.demandes.statut', $demande), ['statut' => 'refusee'])
        ->assertForbidden();

    $this->actingAs($user)
        ->get(route('admin.demandes.photo', $demande))
        ->assertForbidden();
});

test('admin cannot set a request to an unsupported status', function () {
    $user = User::factory()->create();
    Admin::create(['user_id' => $user->id]);
    $demande = DemandePortrait::create([
        'nom' => 'Client Test',
        'email' => 'client@example.com',
        'description' => 'Je souhaite un portrait de famille.',
    ]);

    $this->actingAs($user)
        ->from(route('admin.demandes.index'))
        ->patch(route('admin.demandes.statut', $demande), ['statut' => 'supprimee'])
        ->assertRedirect(route('admin.demandes.index'))
        ->assertSessionHasErrors('statut');

    $this->assertDatabaseHas('demande_portraits', [
        'id' => $demande->id,
        'statut' => 'en_attente',
    ]);
});
