<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 10/31/17
 * Time: 12:06 PM
 */
?>
@extends("master")
@section("title", $serviceInfo->title)
@section("content")
	<?php
	$service_detail_mail_title = SM::smGetThemeOption( "service_detail_mail_title", "Hire Us" );
	$service_detail_mail_subtitle = SM::smGetThemeOption( "service_detail_mail_subtitle", "15 Day FREE Trial" );

	$serviceFeature = ( isset( $serviceInfo->features ) && $serviceInfo->features != '' ) ? json_decode( $serviceInfo->features, true ) : array();
	$extra = ( isset( $serviceInfo->extra ) && $serviceInfo->extra != '' ) ? json_decode( $serviceInfo->extra, true ) : array();
	$section_title = ( isset( $extra["section_title"] ) && $extra["section_title"] != '' ) ? $extra["section_title"] : "";
	$section_description = ( isset( $extra["section_description"] ) && $extra["section_description"] != '' ) ? $extra["section_description"] : "";
	$section_image = ( isset( $extra["section_image"] ) && $extra["section_image"] != '' ) ? $extra["section_image"] : "";
	$accordion = ( isset( $extra["accordion"] ) && $extra["accordion"] != '' ) ? $extra["accordion"] : array();

	$title = $serviceInfo->title;
	$subtitle = $serviceInfo->subtitle;
	$bannerImage = ( isset( $extra["banner_image"] ) && $extra["banner_image"] != '' ) ? $extra["banner_image"] : "";
	?>
    <section class="page-banner-section team-banner-section">
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

    @if($serviceInfo->layout==2)
        <!-- start single service item -->
        <section class="single-service-item">
            <div class="container">
                <div class="row">
                    <div class="border-top1 common-section clearfix">
                        <div class="col-md-12">
                            <div class="package-pheader sm-content">
							    <?php echo stripslashes( $serviceInfo->description ); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        @if(count($serviceFeature)>0)
            <section class="padding-bottom50 service-details-sec">
                <div class="container">
                    <div class="row">
                        <div class="main-item clearfix">
                            @foreach($serviceFeature as $feature)
								<?php
								$last4Start = $loop->count % 4;
								$last4Start = ( $last4Start == 0 ) ? 4 : $last4Start;
								$loopStart = $loop->count - $last4Start;
								?>
                                <div class="col-lg-3 col-sm-6 @if($loop->iteration > $loopStart) {{ 'last-row-item' }} @endif">
                                    <div class="single-service-details text-center">
                                        @isset($feature['feature_image'])
                                            <img src="<?php echo SM::sm_get_the_src( $feature["feature_image"] ) ?>"
                                                 alt="{{ $feature['feature_title'] }}">
                                        @endisset
                                        <h4>{{ $feature['feature_title'] }}</h4>
                                        <P>
                                            {{ $feature['feature_description'] }}
                                        </P>
                                        <span class="traingle-bar"></span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- start single service item -->
        <section class="single-service-item">
            <div class="container">
                <div class="row">
                    <div class="border-top1 common-section clearfix">
                        <div class="col-md-6 col-sm-6">
                            <div class="single-serv-img">
                                <img src="<?php echo SM::sm_get_the_src( $serviceInfo->image ) ?>"
                                     alt="{{ $serviceInfo->title }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="single-service-content sm-content">
                                <h2 class="single-serv-title">{{ $serviceInfo->title }}</h2>
								<?php echo stripslashes( $serviceInfo->description ); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="single-service-item">
            <div class="container">
                <div class="row">
                    <div class="border-top1 common-section clearfix">
                        @empty(!$section_image)
                            <div class="col-md-6">
                                <div class="single-serv-img">
                                    <img src="<?php echo SM::sm_get_the_src( $section_image ) ?>"
                                         alt="{{ $serviceInfo->title }}">
                                </div>
                            </div>
                        @endempty
                        <div class="col-md-6">
                            <div class="single-service-content">
                                @empty(!$section_title)
                                    <h2 class="single-serv-title">{{ $section_title }}</h2>
                                @endempty
                                @empty(!$section_description)
                                    <P>{{ $section_description }}</P>
                                @endempty
                                @if(count($accordion)>0)
                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                        @foreach($accordion as $accr)
                                            <div class="panel panel-default" id="collapse_cat{{ $loop->iteration }}">
                                                <div class="panel-heading" role="tab"
                                                     id="heading{{ $loop->iteration }}">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" role="button" data-toggle="collapse"
                                                           data-parent="#accordion"
                                                           href="#collapse{{ $loop->iteration }}"
                                                           aria-expanded="{{ $loop->iteration == 1 ? "true": "false" }}"
                                                           aria-controls="collapse{{ $loop->iteration }}">
                                                            {{ $accr["accordion_title"] }}
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse{{ $loop->iteration }}"
                                                     class="panel-collapse collapse {{ $loop->iteration == 1 ? "in": "" }}"
                                                     role="tabpanel"
                                                     aria-labelledby="heading{{ $loop->iteration }}"
                                                     aria-expanded="{{ $loop->iteration == 1 ? "true": "false" }}">
                                                    <div class="panel-body">
                                                        <div class="tab-content">
                                                            <p>{!! $accr["accordion_description"]  !!}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    @endif
    <!--NEWSLATTER START-->
    <section class="common-section bg-black newsletter-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="section-title-4 white mb60 text-center">
                        <h2>{!! $service_detail_mail_title !!}</h2>
                        <p>{!! $service_detail_mail_subtitle !!}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="hire-form">
                        {!! Form::open(["method"=>"post","route"=>"serviceMail", "id"=>"serviceMail"]) !!}
                        <input type="hidden" name="service_id" value="{{ $serviceInfo->id }}">
                        <input type="hidden" name="service" value="{{ $serviceInfo->title }}">
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="text" id="client_full_name" name="full_name" placeholder="Your Name"
                                       class="abzk-inp-name">
                            </div>
                            <div class="col-lg-12">
                                <input type="email" id="client_email" name="email" placeholder="Your Email Address"
                                       class="abzk-inp-name">
                            </div>
                            <div class="col-lg-12">
                                <input type="text" id="client_phone" name="phone" placeholder="01715-XXX-XXX"
                                       class="abzk-inp-name">
                            </div>
                            <div class="col-lg-12">
                                <div class="g-recaptcha contact-recaptcha"
                                     data-sitekey="{{  SM::smGetThemeOption( "recaptcha_sitekey", "6Ldz50AUAAAAAMa3WIz4WOPhF1RX6fMMHbzyUnS4") }}"></div>
                            </div>
                        </div>
                        <div class="contact-submit-btn hire-form-btn">
                            <span></span><b></b>
                            <input value="send Message" type="submit">
                        </div>
                        <span class="loading" style="display: none"><i class="fa fa-refresh fa-spin"></i></span>
                        <ul class="mailErrorList serviceMailErrors">
                        </ul>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="seo-score-img wow slideInLeft" data-wow-duration="700ms" data-wow-delay="300ms"
                     style="left: 38px; bottom: -50px;">
                    <img src="{!! asset('images/testmonial-bg11.png') !!}" alt="{{ $serviceInfo->title }}">
                </div>
                <div class="seo-score-img wow fadeInRight" data-wow-duration="700ms" data-wow-delay="300ms"
                     style="right: -66px; top: -28px;">
                    <img src="{!! asset('images/newsletter-img2.png') !!}" alt="{{ $serviceInfo->title }}">
                </div>
                <div class="seo-score-img wow fadeInUp" data-wow-duration="700ms" data-wow-delay="300ms"
                     style="top: 56px; left: 515px;">
                    <img src="{!! asset('images/newsletter-img3.png') !!}" alt="{{ $serviceInfo->title }}">
                </div>
                <div class="seo-score-img wow slideInLeft" data-wow-duration="700ms" data-wow-delay="700ms"
                     style="left: 120px; top: 70px;">
                    <img src="{!! asset('images/newsletter-img4.png') !!}" alt="{{ $serviceInfo->title }}">
                </div>
            </div>
        </div>
    </section>
    <!--NEWSLATTER END-->
    @include("common.teams", ['class'=>' bg-gray2', 'is_home'=>1])
    @include("common.newslatter")
@endsection
@section("footer_script")
	<?php
	SM::smGetSystemFrontEndJs( [
		"https://www.google.com/recaptcha/api.js"
	], 1 );
	?>
@endsection