<?php

use App\Models\Admin;
use App\Models\ReseauSocial;
use App\Models\User;

test('admin can create an active social network', function () {
    $user = User::factory()->create();
    Admin::create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->post(route('admin.reseaux.store'), [
        'nom' => 'Instagram',
        'url' => 'https://instagram.com/abloart',
        'icone' => 'instagram',
        'actif' => '1',
    ]);

    $response->assertRedirect(route('admin.reseaux.index'));
    $this->assertDatabaseHas('reseau_socials', [
        'nom' => 'Instagram',
        'actif' => true,
    ]);
});

test('admin can hide a social network', function () {
    $user = User::factory()->create();
    Admin::create(['user_id' => $user->id]);
    $reseau = ReseauSocial::create([
        'nom' => 'Facebook',
        'url' => 'https://facebook.com/abloart',
        'actif' => true,
    ]);

    $response = $this->actingAs($user)->put(route('admin.reseaux.update', $reseau), [
        'nom' => 'Facebook',
        'url' => 'https://facebook.com/abloart',
        'actif' => '0',
    ]);

    $response->assertRedirect(route('admin.reseaux.index'));
    expect($reseau->refresh()->actif)->toBeFalse();
});
