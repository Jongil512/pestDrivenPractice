<?php

use Illuminate\Foundation\Testing\RefreshDatabase as RefreshDatabaseAlias;
use function Pest\Laravel\get;

uses(RefreshDatabaseAlias::class);

it('asd', function () {
    # Act & Assert
    get(route('home'))
        ->assertOk();
});
