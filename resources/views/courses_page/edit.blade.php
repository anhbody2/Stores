@extends('entry')
@push('styles')
@vite('resources/css/courses/form.css')
@endpush
@section('content')

<div class="wrapper">
    <div class="flip-card__inner ">
        <div class="flip-card__front w-100 px-5">
            <div class="title">Form</div>
            @if(session('success'))
            <p class="flip-card__input py-3" style="color: green">{{ session('success') }}</p>
            @endif

            <form class="flip-card__form" action="/courses/{{ $course->course_id }}/update" method="POST" enctype="multipart/form-data">
                @csrf

                <input class="flip-card__input" type="text" name="name" placeholder="Course name" value="{{ $course->name }}" required>

                <input class="flip-card__input" type="number" name="price" placeholder="Price" value="{{ $course->price }}" required step="0.01">

                <input class="flip-card__input" type="number" name="rate" placeholder="Rate" value="{{ $course->rate }}" step="0.01">

                <input class="flip-card__input" type="number" placeholder="Enrolled Testimonial" value="{{ $course->enrolled }}" name="enrolled">

                <select class="flip-card__input" name="publish_status" required>
                    <option value="1">Published</option>
                    <option value="0">Draft</option>
                </select>
                <select class="flip-card__input" name="level" required>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->category_id }}">{{ $cat->category_name }} </option>
                    @endforeach
                </select>

                <input class="flip-card__input" type="number" placeholder="Time Average" name="time_average" value="{{ $course->time_average }}">

                <textarea class="flip-card__input" placeholder="Description" name="description">{{ $course->description }}</textarea>

                <input class="flip-card__input py-3" type="file" name="image">
                <input class="flip-card__input" type="text" name="image" placeholder="Image URL">
                <button class="flip-card__btn btn-success" type="submit">Save' it!</button>
            </form>
        </div>

    </div>
</div>
@endsection
