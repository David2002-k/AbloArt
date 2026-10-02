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

test('testimony page separates submission from published testimonials', function () {
    Temoignage::create([
        'nom' => 'Client publié',
        'message' => 'Une expérience publiée et très agréable.',
        'publie' => true,
    ]);
    Temoignage::create([
        'nom' => 'Client en attente',
        'message' => 'Ce témoignage attend encore sa validation.',
        'publie' => false,
    ]);

    $this->get(route('temoignages.index'))
        ->assertOk()
        ->assertSee('testimonial-submission')
        ->assertSee('published-testimonials')
        ->assertSee('Partager un témoignage')
        ->assertSee('Témoignages publiés')
        ->assertSee('Une expérience publiée et très agréable.')
        ->assertDontSee('Ce témoignage attend encore sa validation.');
});
