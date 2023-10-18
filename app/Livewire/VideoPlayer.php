<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class VideoPlayer extends Component
{

    public $video;
    public $courseVideos;

    public function mount(): void
    {
        $this->courseVideos = $this->video->course->videos;
    }
    public function render(): View
    {
        return view('livewire.video-player');
    }

    public function markVideoAsCompleted()
    {
        auth()->user()->videos()->attach($this->video);
    }

    public function markVideoAsNotCompleted()
    {
        auth()->user()->videos()->detach($this->video);
    }
}
