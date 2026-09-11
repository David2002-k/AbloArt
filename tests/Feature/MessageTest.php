<?php

use App\Models\Message;

test('visitor can send a contact message', function () {
    $response = $this->post(route('messages.store'), [
        'nom' => 'Client Test',
        'email' => 'client@example.com',
        'telephone' => '0601020304',
        'sujet' => 'Commande',
        'message' => 'Je souhaite commander un portrait.',
    ]);

    $response
        ->assertRedirect(route('messages.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('messages', [
        'nom' => 'Client Test',
        'email' => 'client@example.com',
        'telephone' => '0601020304',
        'statut' => 'non_lu',
    ]);
});

test('contact message requires valid contact details', function () {
    $response = $this->from(route('messages.index'))->post(route('messages.store'), [
        'nom' => '',
        'email' => 'invalid-email',
        'message' => 'Court',
    ]);

    $response
        ->assertRedirect(route('messages.index'))
        ->assertSessionHasErrors(['nom', 'email', 'message']);

    expect(Message::count())->toBe(0);
});
