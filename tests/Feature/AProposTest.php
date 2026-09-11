<?php

test('visitor can view the about page', function () {
    $response = $this->get(route('a-propos.index'));

    $response
        ->assertOk()
        ->assertSee('À propos de nous')
        ->assertSee("L'art de raconter", false);
});
