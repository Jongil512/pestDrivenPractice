<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AddGivenCoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if ($this->isDataAlreadyGiven()) {
            return;
        }

        Course::create([
            'paddle_product_id' => '2047',
            'slug' => Str::of('Laravel For Beginners')->slug(),
            'title' => 'Laravel For Beginners',
            'tagline' => 'Learn Laravel from scratch',
            'description' => 'Lorem ipsum dolor sit amet',
            'image_name' => 'laravel-for-beginners.png',
            'learnings' => [
                'Learn how to ins',
                'Write your first Laravel app',
                'Build a cool project'
            ],
            'released_at' => now(),
        ]);

        Course::create([
            'paddle_product_id' => '2048',
            'slug' => Str::of('Advanced Laravel')->slug(),
            'title' => 'Advanced Laravel',
            'tagline' => 'Level 2 Learn Laravel from scratch',
            'description' => 'Lorem ipsum dolor sit amet',
            'image_name' => 'laravel-for-beginners.png',
            'learnings' => [
                'Level 2 Learn how to ins',
                'Level 2 Write your first Laravel app',
                'Level 2 Build a cool project'
            ],
            'released_at' => now(),
        ]);

        Course::create([
            'paddle_product_id' => '2049',
            'slug' => Str::of('Laravel For Expert')->slug(),
            'title' => 'Laravel For Expert',
            'tagline' => 'Level 3 Learn Laravel from scratch',
            'description' => 'Lorem ipsum dolor sit amet',
            'image_name' => 'laravel-for-beginners.png',
            'learnings' => [
                'Level 3 Learn how to ins',
                'Level 3 Write your first Laravel app',
                'Level 3 Build a cool project'
            ],
            'released_at' => now(),
        ]);
    }
    private function isDataAlreadyGiven(): bool
    {
        return Course::where('title', 'Laravel For Beginners')->exists()
            && Course::where('title', 'Advanced Laravel')->exists()
            && Course::where('title', 'Laravel For Expert')->exists();
    }
}
