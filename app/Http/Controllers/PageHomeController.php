<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Routing\Controller;

class PageHomeController extends Controller
{
    public function __invoke()
    {
        $courses = Course::query()
            ->released()
            ->orderByDesc('released_at')
            ->get();

        return view('home', compact('courses'));
    }
}
