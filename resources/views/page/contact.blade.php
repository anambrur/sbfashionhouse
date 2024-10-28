@extends("master")
@section("title", "Contact")
@section("content")
	<?php
	$contact_form_title = SM::smGetThemeOption( "contact_form_title" );
	$contact_title = SM::smGetThemeOption( "contact_title" );
	$contact_subtitle = SM::smGetThemeOption( "contact_subtitle" );
	$contact_des_title = SM::smGetThemeOption( "contact_des_title" );
	$contact_description = SM::smGetThemeOption( "contact_description" );
	$title = SM::smGetThemeOption( "contact_banner_title" );
	$subtitle = SM::smGetThemeOption( "contact_banner_subtitle" );
	$bannerImage = SM::smGetThemeOption( "contact_banner_image" );
	?>
    <!--CONTACT FORM START-->
    <!--BREADCRUMB START-->
    <section class="page-banner-section contact-banner-section">
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
    <section class="common-section contact-us-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-4 text-center">
                        @empty(!$contact_title)
                            <h2>{{ $contact_title }}</h2>
                        @endempty
                        @empty(!$contact_subtitle)
                            <p>{{ $contact_subtitle }}</p>
                        @endempty
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-6">
                    <div class="contact-form-content">
                        @empty(!$contact_des_title)
                            <h3 class="contact-form-title">
                                <img src="{!! asset('images/contact-title-icon.png') !!}"
                                     alt="{{ $contact_des_title }}">
                                {{ $contact_des_title }}
                            </h3>
                        @endempty
                        @empty(!$contact_description)
                            {!! $contact_description  !!}
                        @endempty
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="contact-form">
                        @empty(!$contact_form_title)
                            <h3 class="contact-form-title">
                                <img src="{!! asset('images/contact-title-icon1.png') !!}"
                                     alt="{{ $contact_form_title }}">
                                {{ $contact_form_title }}
                            </h3>
                        @endempty
                        {!! Form::open(['method'=>'post', 'action'=>'Front\Page@send_mail', 'id'=>'contactMail']) !!}
                        <div class="contact-from-group">
                            <input name="fullname" type="text" placeholder="Your Name*">
                        </div>
                        <div class="contact-from-group">
                            <input type="email" name="email" id="contact_email" placeholder="Your E-mail*">
                        </div>
                        <div class="contact-from-group">
                            <input name="subject" type="text" placeholder="Subject">
                        </div>
                        <div class="contact-from-group">
                            <textarea name="message" id="contact_message" placeholder="Your massage"></textarea>
                        </div>
                        <div class="contact-from-group text-center">
                            <div class="contact-submit-btn">
                                <button class="" type="submit">
                                    <span class="loading" style="display: none;"><i
                                                class="fa fa-refresh fa-spin"></i></span> Submit
                                </button>
                            </div>
                        </div>
                        <ul class="serviceMailErrors mailErrorList concatMailErrors">
                        </ul>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--CONTACT FORM END-->
	<?php
	$contact_branch_image = SM::smGetThemeOption( "contact_branch_image" );
	$contact_branch_title = SM::smGetThemeOption( "contact_branch_title" );
	$contact_branch_subtitle = SM::smGetThemeOption( "contact_branch_subtitle" );
	$contact_branches = SM::smGetThemeOption( "contact_branches" );
	$contact_share_title = SM::smGetThemeOption( "contact_share_title" );
	$contact_share_image = SM::smGetThemeOption( "contact_share_image" );
	$site_name = SM::sm_get_site_name();
	?>
    <!--CONTACT INFO START-->
    <section class="common-section contact-info-section"
             style="background: url('<?php echo SM::sm_get_the_src( $contact_branch_image ); ?>');">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-4 white text-center">
                        @empty(!$contact_branch_title)
                            <h3>
                                {{ $contact_branch_title }}
                            </h3>
                        @endempty
                        @empty(!$contact_branch_subtitle)
                            <p>
                                {{ $contact_branch_subtitle }}
                            </p>
                        @endempty
                    </div>
                </div>
            </div>
            @if($contact_branches)
                <div class="row">
                    @foreach($contact_branches as $branch)
                        <div class="col-lg-3 col-sm-6">
                            <div class="contact-info text-center">
                                @empty(!$branch['image'])
                                    <div class="contact-info-img">
                                        <img src="<?php echo SM::sm_get_the_src( $branch['image'] ); ?>"
                                             alt="{{ $branch['title'] }}">
                                    </div>
                                @endempty
                                @empty(!$branch['title'])
                                    <h3>{{ $branch['title'] }}</h3>
                                @endempty
                                <address>
                                    @empty(!$branch['address'])
                                        <span>{{ $branch['address'] }}</span>
                                    @endempty
                                    @empty(!$branch['email'])
                                        <span>{{ $branch['email'] }}</span>
                                    @endempty
                                    @empty(!$branch['mobile'])
                                        <span>{{ $branch['mobile'] }}</span>
                                    @endempty
                                </address>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-lg-3 col-sm-6">
                        <div class="contact-info text-center">
                            @empty(!$contact_share_image)
                                <div class="contact-info-img">
                                    <img src="<?php echo SM::sm_get_the_src( $contact_share_image ); ?>"
                                         alt="{{ $contact_share_title }}">
                                </div>
                            @endempty
                            @empty(!$contact_share_title)
                                <h3>{{ $contact_share_title }}</h3>
                            @endempty
                            <address>
                                <a href="http://www.facebook.com/share.php?u={!! urlencode(url('/')) !!}&title={!! urlencode($site_name) !!}"
                                   class="con-facebook"><i class="fa fa-facebook-square"></i> Facebook</a>
                                <a href="http://twitter.com/intent/tweet?status={!! urlencode($site_name) !!}+{!! urlencode(url('/')) !!}"
                                   class="con-twitter"><i class="fa fa-twitter-square"></i> Twitter</a>
                            </address>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!--CONTACT INFO END-->


	<?php
	$contact_location_title = SM::smGetThemeOption( "contact_location_title" );
	$contact_location_subtitle = SM::smGetThemeOption( "contact_location_subtitle" );
	$contact_location_latitude = SM::smGetThemeOption( "contact_location_latitude", "23.797424" );
	$contact_location_longitude = SM::smGetThemeOption( "contact_location_longitude", "90.369409" );
	?>
    <!--MAP START-->
    <section class="common-section map-section">
        @empty(!$contact_location_title || !$contact_location_subtitle)
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title-4 text-center">
                            @empty(!$contact_location_title)
                                <h3>{{ $contact_location_title }}</h3>
                            @endempty
                            @empty(!$contact_location_subtitle)
                                <p>{{ $contact_location_subtitle }}</p>
                            @endempty
                        </div>
                    </div>
                </div>
            </div>
        @endempty
        <div class="map" id="gmap" data-latitude="{{ $contact_location_latitude }}"
             data-longitude="{{ $contact_location_longitude }}"></div>
    </section>
    <!--MAP END-->

    <!--TEAM START-->
    @include("common.teams", ['is_home'=>1])
    <!--TEAM END-->
    @include("common.newslatter")
@endsection
@section('footer_script')
	<?php
	SM::smGetSystemFrontEndJs( [
		"https://maps.google.com/maps/api/js?key=AIzaSyBHok7k4VSqgRzjM3g9q12LVoSVKvO4gAo",
		"https://www.google.com/recaptcha/api.js",
	], 1 );
	SM::smGetSystemFrontEndJs( [
		"gmap",
	] );
	?>
@endsection