<?php

use App\Models\Course;

it('adds given courses', function () {
    # Arrange
    $this->assertDatabaseCount(Course::class, 0);

    # Act & Assert
    $this->artisan('db:seed');

    $this->assertDatabaseCount(Course::class, 3);
    $this->assertDatabaseHas(Course::class, ['title' => 'Laravel For Beginners']);
    $this->assertDatabaseHas(Course::class, ['title' => 'Advanced Laravel']);
    $this->assertDatabaseHas(Course::class, ['title' => 'Laravel For Expert']);

});

it('adds given courses only once', function() {
    # Arrange
    $this->artisan('db:seed');
    $this->artisan('db:seed');

    # Act & Assert
    $this->assertDatabaseCount(Course::class, 3);

});
