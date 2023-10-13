<?php

use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\Video;
use function Pest\Laravel\get;

it('cannot be accessed by guest', function () {
    # Arrange
    $course = Course::factory()->create();

    # Act & Assert
    get(route('page.course-videos', $course))
        ->assertRedirect(route('login'));
});

it('includes video player', function () {
    # Arrange
    $course = Course::factory()->create();


    # Act & Assert
    loginAsUser();
    get(route('page.course-videos', $course))
        ->assertOk()
        ->assertSeeLivewire(VideoPlayer::class);

});

it('shows first course video by default', function () {
    # Arrange
    $course = Course::factory()
        ->has(Video::factory()->state(['title' => 'My video']))
        ->create();

    # Act & Assert
    loginAsUser();
    get(route('page.course-videos', $course))
        ->assertOk()
        ->assertSeeText('My video');

});

it('shows provide course video', function () {
    # Arrange

    # Act & Assert

});
