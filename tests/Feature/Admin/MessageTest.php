<?php

use App\Models\Admin;
use App\Models\Message;
use App\Models\User;

test('admin can read all messages and update their status', function () {
    $user = User::factory()->create();
    Admin::create(['user_id' => $user->id]);
    $message = Message::create([
        'nom' => 'Client Test',
        'email' => 'client@example.com',
        'sujet' => 'Portrait de famille',
        'message' => 'Je souhaite obtenir un devis pour un portrait.',
    ]);

    $this->actingAs($user)
        ->get(route('admin.messages.index'))
        ->assertOk()
        ->assertSee($message->message)
        ->assertSee('mailto:client@example.com?subject=Re%3A%20Portrait%20de%20famille');

    $response = $this->actingAs($user)->patch(route('admin.messages.update', $message), [
        'statut' => 'traite',
    ]);

    $response->assertRedirect(route('admin.messages.index'));
    $this->assertDatabaseHas('messages', [
        'id' => $message->id,
        'statut' => 'traite',
    ]);
});

test('guest cannot access the message inbox', function () {
    $response = $this->get(route('admin.messages.index'));

    $response->assertRedirect(route('login'));
});

test('non-admin user cannot access the message inbox', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('admin.messages.index'));

    $response->assertForbidden();
});
