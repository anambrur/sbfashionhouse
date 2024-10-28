@extends('frontend.master')
@section("title", "Subscribe Confirmed")
@section("content")
    <section class="congratulation-page-sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-sm-6">
                    <div class="congratulation-content text-center">
                        <h2 class="congration-title">Congratulations!</h2>
                        <h4>
                            You're Now Connected To Buckle Up-BD
                        </h4>
                        <div class="congrat-bar"></div>
                        <h4 class="doodle-w-title">
                            Welcome To Our World Of Possibilities!
                        </h4>
                        <div class="congrats-btn">
                            <a class="doddle-btn fill" href="{{ url("/") }}"><span></span><b></b>Go To Home</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-sm-6">
                    <div class="congratulation-iamge">
                        <img src="{{ asset("images/congratulation-img.png") }}" alt="Congratulation">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection