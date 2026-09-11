<?php

use App\Models\Admin;
use App\Models\Message;
use App\Models\User;

test('admin can see a message and its response actions', function () {
    $user = User::factory()->create();
    Admin::create(['user_id' => $user->id]);
    $message = Message::create([
        'nom' => 'Client Test',
        'email' => 'client@example.com',
        'telephone' => '0601020304',
        'sujet' => 'Portrait de famille',
        'message' => 'Je souhaite obtenir un devis.',
    ]);

    $response = $this->actingAs($user)->get(route('admin.dashboard'));

    $response
        ->assertOk()
        ->assertSee($message->nom)
        ->assertSee($message->message)
        ->assertSee('mailto:client@example.com')
        ->assertSee('tel:0601020304');
});
