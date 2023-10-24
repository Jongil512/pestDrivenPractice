<?php

use App\Models\Course;
use App\Models\User;
use App\Models\Video;
use Illuminate\Support\Facades\App;

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

it('adds given videos', function () {
    # Arrange
    $this->assertDatabaseCount(Video::class, 0);

    # Act & Assert
    $this->artisan('db:seed');

    $laravelForBeginnersCourse = Course::where('title', 'Laravel For Beginners')->firstOrFail();
    $advancedLaravelCourse = Course::where('title', 'Advanced Laravel')->firstOrFail();
    $laravelForExpertCourse = Course::where('title', 'Laravel For Expert')->firstOrFail();
    $this->assertDatabaseCount(Video::class, 8);

    expect($laravelForBeginnersCourse)
        ->videos
        ->toHaveCount(3);

    expect($advancedLaravelCourse)
        ->videos
        ->toHaveCount(3);

    expect($laravelForExpertCourse)
        ->videos
        ->toHaveCount(2);
});

it('adds given videos only once', function() {
    # Arrange
    $this->assertDatabaseCount(Video::class, 0);

    $this->artisan('db:seed');
    $this->artisan('db:seed');

    # Act & Assert
    $this->assertDatabaseCount(Video::class, 8);

});

it('adds local test user', function () {
    # Arrange
    App::partialMock()->shouldReceive('environment')->andReturn('local');
    $this->assertDatabaseCount(User::class, 0);

    # Act & Assert
    $this->artisan('db:seed');

    $this->assertDatabaseCount(User::class, 1);

});

it('does not adds test user for production', function () {
    # Arrange
    App::partialMock()->shouldReceive('environment')->andReturn('production');
    $this->assertDatabaseCount(User::class, 0);

    # Act & Assert
    $this->artisan('db:seed');

    $this->assertDatabaseCount(User::class, 0);

});
