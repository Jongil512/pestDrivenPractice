<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Video;
use Illuminate\Database\Seeder;

class AddGivenVideosSeeder extends Seeder
{
    public function run(): void
    {
        if ($this->isDataAlreadyGiven()) {
            return;
        }

        $laravelForBeginnersCourse = Course::where('title', 'Laravel For Beginners')->firstOrFail();
        $advancedLaravelCourse = Course::where('title', 'Advanced Laravel')->firstOrFail();
        $laravelForExpertCourse = Course::where('title', 'Laravel For Expert')->firstOrFail();

        Video::insert([
            [
                'course_id' => $laravelForBeginnersCourse->id,
                'slug' => 'intro1',
                'title' => 'Introduction1',
                'vimeo_id' => '330287822',
                'description' => 'Lorem ipsum dolor sit amet',
                'duration_in_min' => 2,
            ],
            [
                'course_id' => $laravelForBeginnersCourse->id,
                'slug' => 'intro',
                'title' => 'Introduction',
                'vimeo_id' => '330287829',
                'description' => 'Lorem ipsum dolor sit amet',
                'duration_in_min' => 1,
            ],
            [
                'course_id' => $laravelForBeginnersCourse->id,
                'slug' => 'routes-are-your-friends',
                'title' => 'Routes are your friends',
                'vimeo_id' => '329875646',
                'description' => 'Lorem ipsum dolor sit amet',
                'duration_in_min' => 4,
            ],
            [
                'course_id' => $advancedLaravelCourse->id,
                'slug' => 'views-101',
                'title' => 'Views 101',
                'vimeo_id' => '331956991',
                'description' => 'Lorem ipsum dolor sit amet',
                'duration_in_min' => 7,
            ],
            [
                'course_id' => $advancedLaravelCourse->id,
                'slug' => 'views-201',
                'title' => 'Views 201',
                'vimeo_id' => '331956992',
                'description' => 'Lorem ipsum dolor sit amet',
                'duration_in_min' => 7,
            ],
            [
                'course_id' => $advancedLaravelCourse->id,
                'slug' => 'views-301',
                'title' => 'Views 301',
                'vimeo_id' => '331956993',
                'description' => 'Lorem ipsum dolor sit amet',
                'duration_in_min' => 7,
            ],
            [
                'course_id' => $laravelForExpertCourse->id,
                'slug' => 'views-104',
                'title' => 'Views 104',
                'vimeo_id' => '331956994',
                'description' => 'Lorem ipsum dolor sit amet',
                'duration_in_min' => 7,
            ],
            [
                'course_id' => $laravelForExpertCourse->id,
                'slug' => 'views-105',
                'title' => 'Views 105',
                'vimeo_id' => '331956995',
                'description' => 'Lorem ipsum dolor sit amet',
                'duration_in_min' => 7,
            ],
        ]);
    }

    private function isDataAlreadyGiven(): bool
    {
        $laravelForBeginnersCourse = Course::where('title', 'Laravel For Beginners')->firstOrFail();
        $advancedLaravelCourse = Course::where('title', 'Advanced Laravel')->firstOrFail();
        $laravelForExpertCourse = Course::where('title', 'Laravel For Expert')->firstOrFail();

        return $laravelForBeginnersCourse->videos()->count() === 3
            && $advancedLaravelCourse->videos()->count() === 3
            && $laravelForExpertCourse->videos()->count() === 2;
    }
}
