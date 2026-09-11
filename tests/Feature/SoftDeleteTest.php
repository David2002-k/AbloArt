<?php

use App\Models\Admin;
use App\Models\Categorie;
use App\Models\Portrait;
use App\Models\User;

test('deleting a portrait keeps it in the database but hides it from normal queries', function () {
    $user = User::factory()->create();
    $admin = Admin::create(['user_id' => $user->id]);
    $categorie = Categorie::create(['nom' => 'Portraits de test']);
    $portrait = Portrait::create([
        'categorie_id' => $categorie->id,
        'admin_id' => $admin->id,
        'image' => 'portraits/test.jpg',
    ]);

    $portrait->delete();

    expect(Portrait::find($portrait->id))->toBeNull();
    expect(Portrait::withTrashed()->find($portrait->id))->not->toBeNull();
    expect(Portrait::withTrashed()->find($portrait->id)->deleted_at)->not->toBeNull();
});
