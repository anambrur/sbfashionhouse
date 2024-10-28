<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 8/10/17
 * Time: 1:00 PM
 */
?>
<!-- start banner sec -->
@if(isset($sliders) && count($sliders)>0)
    <?php
    $slider_change_autoplay = (int)SM::smGetThemeOption("slider_change_autoplay", 4);
    $slider_change_autoplay *= 3000;
    ?>
    <!-- MAIN SLIDER -->
    <section class="main-slider">
        <div class="swiper-container main">
            <div class="swiper-wrapper">
                @foreach($sliders as $slider)
                    @if($slider->style =='slide4')
                        <div data-swiper-autoplay="{{ $slider_change_autoplay }}" class="swiper-slide h_slides slide4"
                             style="background: #101639">
                            <div class="container-slider clearfix">
                                <div class="swiper-slide-content">
                                    <h3 data-swiper-parallax="100">
                                        {!! $slider->title !!}
                                    </h3>
                                    @if($slider->description!='')
                                        <p data-swiper-parallax="-200">{!!  strip_tags($slider->description, "<br><span>") !!}</p>
                                    @endif
                                    <?php
                                    $buttons = SM::sm_unserialize($slider->extra);
                                    ?>
                                    @if($buttons && is_array($buttons) && count($buttons))
                                        <div class="swiper-slide-btn">
                                            @foreach($buttons["button_label"] as $key=>$value)
                                                <?php
                                                $buttonLink = isset($buttons["button_link"][$key]) ? $buttons["button_link"][$key] : "";
                                                ?>
                                                <a class="doddle-btn @if($loop->last) {{ "fill" }} @endif"
                                                   href="{!! $buttonLink !!}"><span></span><b></b>{!! $value !!}</a>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="slide-bottom-arrow">
                                        <img src="{{ asset('images/slide-bottom-arrow.png') }}" alt="Slider bottom">
                                    </div>
                                </div>
                                <div class="swiper-slide-video">
                                    <img src="{{SM::sm_get_the_src($slider->image)}}"
                                         alt="{!! $slider->title !!}">
                                </div>
                            </div>
                        </div>
                    @elseif($slider->style =='slide1')
                        <div data-swiper-autoplay="{{ $slider_change_autoplay }}" class="swiper-slide h_slides slide1"
                             style="background: url({{ asset('images/home_banner/banner1-bg.png') }})">
                            <div class="container-slider clearfix">
                                <div class="swiper-slide-content">
                                    <h3 data-swiper-parallax="-100" class="text-center">
                                        {!! $slider->title !!}
                                    </h3>
                                    <?php
                                    $buttons = SM::sm_unserialize($slider->extra);
                                    ?>
                                    @if($buttons && is_array($buttons) && count($buttons))
                                        <div class="swiper-slide-btn text-center">
                                            @foreach($buttons["button_label"] as $key=>$value)
                                                <?php
                                                $buttonLink = isset($buttons["button_link"][$key]) ? $buttons["button_link"][$key] : "";
                                                ?>
                                                <a class="doddle-btn @if($loop->last) {{ "fill" }} @endif"
                                                   href="{!! $buttonLink !!}"><span></span><b></b>{!! $value !!}</a>
                                            @endforeach
                                        </div>
                                    @endif

                                </div>
                                <div class="swiper-slide-video">
                                    <img src="{{SM::sm_get_the_src($slider->image)}}"
                                         alt="{!! $slider->title !!}">
                                </div>
                            </div>
                        </div>
                    @elseif($slider->style =='slide2')

                        <div data-swiper-autoplay="{{ $slider_change_autoplay }}" class="swiper-slide h_slides slide2"
                             style="background: #101639">
                            <div class="container-slider clearfix">
                                <div class="swiper-slide-content">
                                    <h3 data-swiper-parallax="100">
                                        {!! $slider->title !!}
                                    </h3>
                                    @if($slider->description!='')
                                        <p data-swiper-parallax="-200">{!!  strip_tags($slider->description, "<br><span>") !!}</p>
                                    @endif
                                    <?php
                                    $buttons = SM::sm_unserialize($slider->extra);
                                    ?>
                                    @if($buttons && is_array($buttons) && count($buttons))
                                        <div class="swiper-slide-btn">
                                            @foreach($buttons["button_label"] as $key=>$value)
                                                <?php
                                                $buttonLink = isset($buttons["button_link"][$key]) ? $buttons["button_link"][$key] : "";
                                                ?>
                                                <a class="doddle-btn @if($loop->last) {{ "fill" }} @endif"
                                                   href="{!! $buttonLink !!}"><span></span><b></b>{!! $value !!}</a>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="slide-bottom-arrow">
                                        <img src="{{ asset('images/slide-bottom-arrow.png') }}" alt="slider bottom">
                                    </div>
                                </div>
                                <div class="swiper-slide-video">
                                    <img src="{{SM::sm_get_the_src($slider->image)}}"
                                         alt="{!! $slider->title !!}">
                                </div>
                            </div>
                        </div>
                    @elseif($slider->style =='slide3')
                        <div data-swiper-autoplay="{{ $slider_change_autoplay }}" class="swiper-slide h_slides slide3"
                             style="background: url({{ asset('images/home_banner/banner2-bg.png') }})">
                            <div class="container-slider clearfix">
                                <div class="swiper-slide-content">
                                    <h3 data-swiper-parallax="-100">
                                        {!! $slider->title !!}
                                    </h3>
                                    @if($slider->description!='')
                                        <p data-swiper-parallax="-200">{!!  strip_tags($slider->description, "<br><span>") !!}</p>
                                    @endif
                                    <?php
                                    $buttons = SM::sm_unserialize($slider->extra);
                                    ?>
                                    @if($buttons && is_array($buttons) && count($buttons))
                                        <div class="swiper-slide-btn">
                                            @foreach($buttons["button_label"] as $key=>$value)
                                                <?php
                                                $buttonLink = isset($buttons["button_link"][$key]) ? $buttons["button_link"][$key] : "";
                                                ?>
                                                <a class="doddle-btn @if($loop->last) {{ "fill" }} @endif"
                                                   href="{!! $buttonLink !!}"><span></span><b></b>{!! $value !!}</a>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="slide-bottom-arrow">
                                        <img src="{{ asset('images/slide-bottom-arrow.png') }}" alt="Slider bottom">
                                    </div>
                                </div>
                                <div class="swiper-slide-video">
                                    <img src="{{SM::sm_get_the_src($slider->image)}}"
                                         alt="{!! $slider->title !!}">
                                </div>
                            </div>
                        </div>
                    @else
                        <div data-swiper-autoplay="{{ $slider_change_autoplay }}" class="swiper-slide h_slides slide5"
                             style="background: url({{ asset('images/home_banner/banner3-bg.png') }})">
                            <div class="container-slider clearfix">
                                <div class="swiper-slide-content">
                                    <h4>Want an </h4>
                                    <h3 data-swiper-parallax="100">
                                        {!! $slider->title !!}
                                    </h3>
                                    @if($slider->description!='')
                                        <p data-swiper-parallax="-200">{!!  strip_tags($slider->description, "<br><span>") !!}</p>
                                    @endif
                                    <?php
                                    $buttons = SM::sm_unserialize($slider->extra);
                                    ?>
                                    @if($buttons && is_array($buttons) && count($buttons))
                                        <div class="swiper-slide-btn">
                                            @foreach($buttons["button_label"] as $key=>$value)
                                                <?php
                                                $buttonLink = isset($buttons["button_link"][$key]) ? $buttons["button_link"][$key] : "";
                                                ?>
                                                <a class="doddle-btn @if($loop->last) {{ "fill" }} @endif"
                                                   href="{!! $buttonLink !!}"><span></span><b></b>{!! $value !!}</a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <div class="swiper-slide-video">
                                    <img src="{{SM::sm_get_the_src($slider->image)}}"
                                         alt="{!! $slider->title !!}">
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="swiper-button-prev swiper-button-white"><img src="{{ asset('images/arrow-left.png') }}"
                                                                 alt="Slider Left"></div>
        <div class="swiper-button-next swiper-button-white"><img src="{{ asset('images/arrow-right.png') }}"
                                                                 alt="Slider Right"></div>
    </section>
    <!-- MAIN SLIDER -->
@endif