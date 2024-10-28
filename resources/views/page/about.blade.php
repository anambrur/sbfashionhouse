@extends("master")
@section("title", "About")
@section("content")
	<?php
	$wwrTitle = SM::smGetThemeOption( "wwr_title" );
	$wwrSubtitle = SM::smGetThemeOption( "wwr_subtitle" );
	$wwrDescription = SM::smGetThemeOption( "wwr_description" );
	$ourMission = SM::smGetThemeOption( "our_mission" );
	$ourVision = SM::smGetThemeOption( "our_vision" );
	$histories = SM::smGetThemeOption( "histories" );
	$historiesCount = count( $histories );
	$title = SM::smGetThemeOption( "about_banner_title" );
	$subtitle = SM::smGetThemeOption( "about_banner_subtitle" );
	$bannerImage = SM::smGetThemeOption( "about_banner_image" );
	?>
    <section class="page-banner-section about-banner-section">
        <div class="blog-banner-sec "
             style="background:url( {!! SM::sm_get_the_src( $bannerImage ) !!}) no-repeat center center /cover">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="blog-banner-contents text-center">
                            @empty(!$title)
                                <h1>{{$title}}</h1>
                            @endempty
                            @if(isset($subtitle) && $subtitle != '')
                                <p>{{$subtitle}}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="common-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="about-content">
                        <div class="ab-mis-icon">
                            <img src="{{ asset('images/who_we_are.png') }}" alt="about">
                            <h2>{{ $wwrTitle }}</h2>
                        </div>
                        @empty(!$wwrSubtitle)
                            <p class="plead">{{ $wwrSubtitle }}</p>
                        @endempty
                        {!! stripslashes($wwrDescription) !!}
                    </div>
                    @empty(!$ourMission)
                        <div class="about-mission">
                            <div class="ab-mis-icon">
                                <img src="{{ asset('images/icon1.png') }}" alt="Mission">
                                <h3>Our Mission</h3>
                            </div>
                            <p>{!! stripslashes($ourMission) !!}</p>
                        </div>
                    @endempty
                    @empty(!$ourVision)
                        <div class="about-mission">
                            <div class="ab-mis-icon">
                                <img src="{{ asset('images/icon2.png') }}" alt="Mission">
                                <h3>Our Vision</h3>
                            </div>
                            <p>{!! stripslashes($ourVision) !!}</p>
                        </div>
                    @endempty
                </div>
            </div>
        </div>
    </section>
    @include("common.teams", ['class'=>' bg-gray2', 'is_home'=>1])
	<?php
	$about_testimonial_style = SM::smGetThemeOption( "about_testimonial_style", "" );
	?>
    @include("common.testimonials", ["style"=>$about_testimonial_style])
    @include("common.newslatter")
@endsection