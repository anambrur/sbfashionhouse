<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 10/12/17
 * Time: 11:22 AM
 */
$testimonialTitle  = SM::smGetThemeOption( "testimonial_title" );
$testimonials      = SM::smGetThemeOption( "testimonials" );
$testimonialsCount = count( $testimonials );
?>
@if($testimonialsCount > 0)
    <section class="common-section {{ $style }} testmonial-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="swiper-container testmonial-carousel">
                        <div class="col-lg-4 col-xs-12 text-center">
                            <h3 class="test-caro-title {{ $style=="" ? "color-black" : "" }}
                                    {{ isset($title_class) ? $title_class : '' }}
                                    ">{!! stripslashes($testimonialTitle) !!}</h3>
                        </div>
                        <div class="fixed-testmonial-shap"></div>
                        <div class="swiper-wrapper">
                            @foreach($testimonials as $testimonial)
                                <div class="swiper-slide">
                                    <div class="col-sm-4">
                                        <div class="client-logo">
                                            @if($style=="bg-black")
                                                <img src="{!! SM::sm_get_the_src($testimonial["testimonial_logo"], 210, 153) !!}"
                                                     alt="{{ $testimonial["title"] }}">
                                            @else
                                                <img src="{!! SM::sm_get_the_src($testimonial["testimonial_logo_about"], 210, 153) !!}"
                                                     alt="{{ $testimonial["title"] }}">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-7 col-lg-offset-1 client-content">
                                        <div class="test-content-in">
                                            <div class="test-client-img">
                                                <img src="{!! SM::sm_get_the_src($testimonial["testimonial_image"], 112, 112) !!}"
                                                     alt="{{ $testimonial["title"] }}">
                                            </div>
                                            <p>{!! stripslashes($testimonial["description"]) !!}</p>
                                            <h4>{{ $testimonial["title"] }}</h4>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="testmonial-control">
                        <div class="tbtn tprev"><img src="{{ asset('images/arrow-left.png') }}" alt=""></div>
                        <div class="tbtn tnext"><img src="{{ asset('images/arrow-right.png') }}" alt=""></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="seo-score-img seo-score-img1 wow fadeInUp" data-wow-duration="700ms" data-wow-delay="300ms">
                    <img src="{{ asset('images/testmonial-bg11.png') }}" alt="">
                </div>
                <div class="seo-score-img seo-score-img2 wow fadeInUp" data-wow-duration="1s" data-wow-delay="300ms">
                    <img src="{{ asset('images/testmonial-bg2.png')}}" alt="">
                </div>
            </div>
        </div>
    </section>
@endif
