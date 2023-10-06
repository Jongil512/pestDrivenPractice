<h2>{{ $course->title }}</h2>
<h3>{{ $course->tagline }}</h3>
<q>{{ $course->description }}</q>
<ul>
    @foreach($course->learnings as $learning)
        <li>{{ $learning }}</li>
    @endforeach
</ul>
<img src="{{ $course->image }}" alt="Image of the course {{ $course->title }}">