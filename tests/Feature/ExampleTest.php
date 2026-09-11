<?php

it('returns a successful response', function () {
    $response = $this->get('/');

    $response
        ->assertOk()
        ->assertSee('Galerie')
        ->assertSee('Demander un portrait')
        ->assertSee('Se connecter');
});
