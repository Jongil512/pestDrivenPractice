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
    $user = User::factory()->create();
    $course = createCourseVideos();

    $user->purchasedCourses()->attach($course);

    # Act & Assert
    expect($user->watchedVideos)->toHaveCount(0);

    loginAsUser($user);
    Livewire::test(VideoPlayer::class, ['video' => $course->videos()->first()])
        ->assertMethodWired('markVideoAsCompleted')
        ->call('markVideoAsCompleted')
        ->assertMethodNotWired('markVideoAsCompleted')
        ->assertMethodWired('markVideoAsNotCompleted');

    $user->refresh();
    expect($user->watchedVideos)
        ->toHaveCount(1)
        ->first()->title->toEqual($course->videos()->first()->title);
});

it('marks video as not completed', function () {
    # Arrange
    $user = User::factory()->create();
    $course = createCourseVideos();

    $user->purchasedCourses()->attach($course);
    $user->watchedVideos()->attach($course->videos()->first());

    # Act & Assert
    expect($user->watchedVideos)->toHaveCount(1);

    loginAsUser($user);
    Livewire::test(VideoPlayer::class, ['video' => $course->videos()->first()])
        ->assertMethodWired('markVideoAsNotCompleted')
        ->call('markVideoAsNotCompleted')
        ->assertMethodNotWired('markVideoAsNotCompleted')
        ->assertMethodWired('markVideoAsCompleted');

    $user->refresh();
    expect($user->watchedVideos)
        ->toHaveCount(0);
});
