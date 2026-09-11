<?php

use App\Models\Temoignage;

test('visitor can submit a testimony for moderation', function () {
    $response = $this->post(route('temoignages.store'), [
        'nom' => 'Client Test',
        'message' => 'Une très belle expérience avec AbloArt.',
    ]);

    $response
        ->assertRedirect(route('temoignages.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('temoignages', [
        'nom' => 'Client Test',
        'message' => 'Une très belle expérience avec AbloArt.',
        'publie' => false,
    ]);
});

test('visitor must provide a meaningful testimony', function () {
    $response = $this->from(route('temoignages.index'))->post(route('temoignages.store'), [
        'nom' => '',
        'message' => 'Court',
    ]);

    $response
        ->assertRedirect(route('temoignages.index'))
        ->assertSessionHasErrors(['nom', 'message']);

    expect(Temoignage::count())->toBe(0);
});
