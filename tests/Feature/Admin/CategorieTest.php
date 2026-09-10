<?php

use App\Models\Admin;
use App\Models\Categorie;
use App\Models\Portrait;
use App\Models\User;

function adminUserForCategories(): User
{
    $user = User::factory()->create();
    Admin::create(['user_id' => $user->id]);

    return $user;
}

test('admin can create a category', function () {
    $user = adminUserForCategories();

    $response = $this->actingAs($user)->post(route('admin.categories.store'), [
        'nom' => 'Portraits en studio',
        'description' => 'Travaux réalisés en studio.',
    ]);

    $response->assertRedirect(route('admin.categories.index'));
    $this->assertDatabaseHas('categories', ['nom' => 'Portraits en studio']);
});

test('admin cannot delete a category used by a portrait', function () {
    $user = adminUserForCategories();
    $categorie = Categorie::create(['nom' => 'Portraits', 'description' => null]);
    Portrait::create([
        'categorie_id' => $categorie->id,
        'admin_id' => $user->admin->id,
        'description' => 'Portrait de test',
        'image' => 'portraits/test.jpg',
    ]);

    $response = $this->actingAs($user)->delete(route('admin.categories.destroy', $categorie));

    $response->assertRedirect(route('admin.categories.index'));
    $response->assertSessionHas('error');
});
