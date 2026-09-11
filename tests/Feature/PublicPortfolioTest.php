<?php

use App\Models\DemandePortrait;

test('visitor can access the gallery', function () {
    $this->get(route('galerie.index'))
        ->assertOk()
        ->assertSee('Galerie');
});

test('visitor can submit a portrait request', function () {
    $response = $this->post(route('demandes.store'), [
        'nom' => 'Client Test',
        'email' => 'client@example.com',
        'telephone' => '0601020304',
        'description' => 'Je souhaite un portrait de famille.',
    ]);

    $response
        ->assertRedirect(route('demandes.create'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('demande_portraits', [
        'nom' => 'Client Test',
        'email' => 'client@example.com',
        'statut' => 'en_attente',
    ]);

    expect(DemandePortrait::count())->toBe(1);
});
