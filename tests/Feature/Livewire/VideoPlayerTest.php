<?php

use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\User;
use App\Models\Video;
use Livewire\Livewire;

function createCourseVideos(int $videosCount = 1): Course
{
    return Course::factory()
        ->has(Video::factory()->count($videosCount))
        ->create();
}

beforeEach(function () {
    $this->loggedInUser = loginAsUser();
});

it('shows details for given video', function () {
    # Arrange
    $course = createCourseVideos();

    # Act & Assert
    $video = $course->videos->first();
    Livewire::test(VideoPlayer::class, ['video' => $video])
        ->assertSeeText([
            $video->title,
            $video->description,
            "({$video->duration_in_min}min)"
        ]);
});

it('shows given video', function () {
    # Arrange
    $course = createCourseVideos();

    # Act & Assert
    $video = $course->videos->first();
    Livewire::test(VideoPlayer::class, ['video' => $video])
        ->assertSeeHtml('<iframe src="https://player.vimeo.com/video/' . $video->vimeo_id . '"');
});

it('shows list of all course videos', function () {
    # Arrange
    $course = createCourseVideos(3);

    # Act & Assert
    Livewire::test(VideoPlayer::class, ['video' => $course->videos()->first()])
        ->assertSee([
            ...$course->videos->pluck('title')->toArray(),
        ])
        ->assertSeeHtml([
            route('page.course-videos', $course->videos[1]),
            route('page.course-videos', $course->videos[2]),
        ]);
});

it('does not include route for current video', function () {
# Arrange
    $course = createCourseVideos();

    # Act & Assert
    Livewire::test(VideoPlayer::class, ['video' => $course->videos()->first()])
        ->assertDontSeeHtml(route('page.course-videos', $course->videos()->first()));

});

it('marks video as completed', function () {
    # Arrange
    $course = createCourseVideos();

    $this->loggedInUser->purchasedCourses()->attach($course);

    # Act & Assert
    expect($this->loggedInUser->watchedVideos)->toHaveCount(0);

    loginAsUser($this->loggedInUser);
    Livewire::test(VideoPlayer::class, ['video' => $course->videos()->first()])
        ->assertMethodWired('markVideoAsCompleted')
        ->call('markVideoAsCompleted')
        ->assertMethodNotWired('markVideoAsCompleted')
        ->assertMethodWired('markVideoAsNotCompleted');

    $this->loggedInUser->refresh();
    expect($this->loggedInUser->watchedVideos)
        ->toHaveCount(1)
        ->first()->title->toEqual($course->videos()->first()->title);
});

it('marks video as not completed', function () {
    # Arrange
    $course = createCourseVideos();

    $this->loggedInUser->purchasedCourses()->attach($course);
    $this->loggedInUser->watchedVideos()->attach($course->videos()->first());

    # Act & Assert
    expect($this->loggedInUser->watchedVideos)->toHaveCount(1);

    loginAsUser($this->loggedInUser);
    Livewire::test(VideoPlayer::class, ['video' => $course->videos()->first()])
        ->assertMethodWired('markVideoAsNotCompleted')
        ->call('markVideoAsNotCompleted')
        ->assertMethodNotWired('markVideoAsNotCompleted')
        ->assertMethodWired('markVideoAsCompleted');

    $this->loggedInUser->refresh();
    expect($this->loggedInUser->watchedVideos)
        ->toHaveCount(0);
});
