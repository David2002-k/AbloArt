<?php

use App\Models\Admin;
use App\Models\Temoignage;
use App\Models\User;

test('admin can review and publish a testimony', function () {
    $user = User::factory()->create();
    Admin::create(['user_id' => $user->id]);
    $temoignage = Temoignage::create([
        'nom' => 'Client Test',
        'message' => 'Une expérience remarquable avec AbloArt.',
        'publie' => false,
    ]);

    $this->actingAs($user)
        ->get(route('admin.temoignages.index'))
        ->assertOk()
        ->assertSee($temoignage->message)
        ->assertSee('Valider et publier');

    $response = $this->actingAs($user)->patch(route('admin.temoignages.update', $temoignage), [
        'publie' => '1',
    ]);

    $response->assertRedirect(route('admin.temoignages.index'));
    $this->assertDatabaseHas('temoignages', [
        'id' => $temoignage->id,
        'publie' => true,
    ]);

    $this->get(route('temoignages.index'))
        ->assertOk()
        ->assertSee($temoignage->message);
});

test('guest cannot access testimony moderation', function () {
    $response = $this->get(route('admin.temoignages.index'));

    $response->assertRedirect(route('login'));
});

test('non-admin user cannot moderate testimonies', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('admin.temoignages.index'));

    $response->assertForbidden();
});
