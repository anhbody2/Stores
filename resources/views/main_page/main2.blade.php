@extends('entry')
@push('styles')
@vite('resources/css/main/entry.css')
@vite('resources/css/main/card.css')
@endpush
@section('content')
<div class="container-fluid d-block ">
        <div class="cursor">

                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
        </div>
        <h1>the <span class="c-text  ">way</span> you <span class="c-text ">learn</span> show <span class="c-text ">how</span> your brain <span class="c-text ">interact</span>.</h1>
        <div class="content">
                <section class="banner" id="banner">
                        <div class="slider" style="--quantity: 10">
                                @foreach($courses as $course)
                                <div class="item" style="--position: {{ $loop->iteration }}"><a href="">
                                                <img
                                                        src="{{$course ->image}}" alt="">
                                        </a></div>
                                @endforeach

                        </div>

                        <div id="container3D">

                        </div>


                </section>


                <h1 class="text"> we <span class="c-text ">help you</span> out</h1>
        </div>
        
        <p class="fonts-medium">We have a <span class="c-text ">team support</span> full day, with <span class="c-text ">big heart</span> and experience, and had a lot of
                <span class="c-text ">colaboration</span> with the most <span class="c-text ">community</span> about the niches.
                <div class="col-12 d-flex justify-content-center ">
                <a href="/courses" class="btn btn-primary  w-50  py-3 " type="submit">FIND OUT NOW</a>
        </div>
        </p>

        <div class="container-xxl py-5">
                <div class="container">
                        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                                <h1 class="mb-5 fs-1">Team Instructors</h1>
                        </div>
                        <div class="row g-4">
                                @foreach($users as $user)
                                @if($user->isadmin == true)
                                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                        <div class="team-item bg-light">
                                                <div class="overflow-hidden">
                                                        <img class="img-fluid" src="{{$user -> image}}" alt="">
                                                </div>
                                                <div class="position-relative d-flex justify-content-center" style="margin-top: -23px;">
                                                        <div class="bg-light d-flex justify-content-center pt-2 px-1">
                                                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                                                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                                                        </div>
                                                </div>
                                                <div class="text-center p-4">
                                                        <h5 class="mb-0">{{$user -> name}}</h5>
                                                        <small>Designation</small>
                                                </div>
                                        </div>
                                </div>
                                @endif
                                @endforeach

                        </div>
                </div>
        </div>
</div>

@endsection