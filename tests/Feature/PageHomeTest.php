<?php

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('shows courses overview', function () {
    # Arrange
    $firstCourse = Course::factory()->released()->create();
    $secondCourse = Course::factory()->released()->create();
    $thirdCourse = Course::factory()->released()->create();

    # Act & Assert

    get(route('home'))
        ->assertSeeText([
            'Course A',
            'Description Course A',
            'Course B',
            'Description Course A',
            'Course C',
            'Description Course C',
        ]);
});

it('shows only released courses', function () {
    # Arrange
    Course::factory()->create(['title' => 'Course A', 'released_at' => Carbon::yesterday()]);
    Course::factory()->create(['title' => 'Course B']);

    # Act & Assert

    get(route('home'))
        ->assertSeeText([
            'Course A',
        ])->assertDontSeeText([
            'Course B',

        ]);
});

it('shows courses by release date', function () {
    # Arrange
    Course::factory()->create(['title' => 'Course A', 'released_at' => Carbon::yesterday()]);
    Course::factory()->create(['title' => 'Course B', 'released_at' => Carbon::now()]);

    # Act & Assert
    get(route('home'))
        ->assertSeeTextInOrder([
            'Course B',
            'Course A',
        ]);
});
