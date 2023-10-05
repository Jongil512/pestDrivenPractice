<?php

use function Pest\Laravel\get;

it('asd', function () {
    # Act & Assert
    get(route('home'))
        ->assertOk();
});
