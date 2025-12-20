@extends('entry')
@section('content')

<!-- Testimonial Start -->
<div class="container-xxl py-5 wow fadeInUp mb-5" data-wow-delay="0.1s">
    <div class="container">
        <div class="text-center">
            <h6 class="section-title bg-white text-center text-primary px-3">Testimonial</h6>
            <h1 class="mb-5">Our Students Say!</h1>
        </div>
        <div class="owl-carousel testimonial-carousel position-relative">
            @foreach($comments as $comment)
            <div class="testimonial-item text-center">
                <img class="border rounded-circle p-2 mx-auto mb-3" src="{{
                                    $users->firstWhere('id', $comment->user_id)->image ?? 'https://i.pinimg.com/736x/f5/1d/e1/f51de1d579f664e565b167acae3c6977.jpg'
                                    }}"
                    style="width: 80px; height: 80px;">
                <h5 class="mb-0">{{
                                    $users->firstWhere('id', $comment->user_id)->name ?? 'Unknown'
                                    }}</h5>
                <p>Profession</p>
                <div class="testimonial-text bg-light text-center p-4">
                    <p class="mb-0">{{$comment -> comment}}</p>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>

    <!-- Testimonial End -->
        
@endsection