<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 10/14/17
 * Time: 4:41 PM
 */
?>
@extends("master")
@section("title", $caseInfo->title)
@section("content")
	<?php
	$extra = SM::sm_unserialize( $caseInfo->extra );
	?>
    @if(isset($extra['banner']) && $extra['banner']!='')
        <section class="page-banner-section">
            <div class="ab-page-banner-section-inner">
                <img src="{!! SM::sm_get_the_src($extra['banner']) !!}" alt="case detals">
            </div>
        </section>
    @endif
    <!--CASE DETAILS START-->
    <section class="case-details-section common-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-4 text-center">
                        <h1>{{ $caseInfo->title }}</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="sm-content case-study-de-content">
                        @if(isset($extra['about_title']) && $extra['about_title']!='')
                            <h2>{{ $extra['about_title'] }}</h2>
                            @endisset
                            <div class="home-blog-meta">
                                <a href="javascript:0" class="mrks_like"
                                   data-id="{{ urlencode(base64_encode($caseInfo->id)) }}" data-type="case">
                                    <i class="fa fa-heart"></i>
                                    {{ SM::getCountTitle($caseInfo->likes, 'Like') }}
                                </a>
                                <a href="javascript:0">
                                    <i class="fa fa-comments"></i>
                                    {{ SM::getCountTitle($caseInfo->comments, 'Comment') }}
                                </a>
                                <a href="javascript:0">
                                    <i class="fa fa-eye"></i>
                                    {{ SM::getCountTitle($caseInfo->views, 'View') }}
                                </a>
                            </div>
                            {!! stripslashes($caseInfo->description) !!}
                            <div class="cases-btn">
                                @if($caseInfo->is_enable_site_link==1)
                                    <a class="doddle-btn fill"
                                       href="{!! $caseInfo->site_link !!}"><span></span><b></b>
                                        @if($caseInfo->site_link_title !='')
                                            {{ $caseInfo->site_link_title }}
                                        @else
                                            Visit site
                                        @endif
                                    </a>
                                @endif
                            </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="case-study-de-img">
                        <img src="{!! SM::sm_get_the_src($caseInfo->image, 550, 550) !!}" alt="{{ $caseInfo->title }}">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--CASE KEY ELEMENT START-->
    <section class="key-element-sec common-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-4 white text-center">
                        @if(isset($extra['key_element_title']) && $extra['key_element_title']!='')
                            <h3>{{ $extra['key_element_title'] }}</h3>
                        @endif
                        @if(isset($extra['key_element_subtitle']) && $extra['key_element_subtitle']!='')
                            <p>{{ $extra['key_element_subtitle'] }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="key-elment-content">
                        <h3 class="key-elment-title">
                            <img src="{!! asset('images/key-elemt-title-icon.png') !!}" alt="Objective">
                            Objective
                        </h3>
                        {!! stripslashes($caseInfo->objective) !!}
                    </div>
                </div>
                <div class="col-lg-4 no-padding">
                    <div class="key-element-image">
                        @if(isset($extra['key_element_img']) && $extra['key_element_img']!='')
                            <img src="{!! SM::sm_get_the_src($extra['key_element_img']) !!}" alt="key_element">
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="key-element-requirment">
                        <h3 class="key-elment-title">
                            <img src="{!! asset('images/key-elemt-title-icon1.png') !!}" alt="requirements">
                            Requirements
                        </h3>
                        {!! stripslashes($caseInfo->requirements) !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if($caseInfo->case_style==2)
        <!--THROUGH OUR ACTION START-->
        <section class="through-our-sec common-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title-4 text-center">
                            @if(isset($extra['affiliate_title']) && $extra['affiliate_title']!='')
                                <h3>{{ $extra['affiliate_title'] }}</h3>
                            @endif
                            @if(isset($extra['affiliate_subtitle']) && $extra['affiliate_subtitle']!='')
                                <p>{{ $extra['affiliate_subtitle'] }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="through-our-content">
                            @if(isset($extra['affiliate_initial_description']) && $extra['affiliate_initial_description']!='')
                                {!! stripslashes($extra['affiliate_initial_description']) !!}
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="through-our-img">
                            @if(isset($extra['affiliate_initial_image']) && $extra['affiliate_initial_image']!='')
                                <img src="{!! SM::sm_get_the_src($extra['affiliate_initial_image']) !!}"
                                     alt="Initial Description">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="through-our-img">
                            @if(isset($extra['affiliate_page_speed_image']) && $extra['affiliate_page_speed_image']!='')
                                <img src="{!! SM::sm_get_the_src($extra['affiliate_page_speed_image']) !!}"
                                     alt="Page Speed">
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="through-our-content">
                            @if(isset($extra['affiliate_page_speed_description']) && $extra['affiliate_page_speed_description']!='')
                                {!! stripslashes($extra['affiliate_page_speed_description']) !!}
                            @endif
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="through-our-content">
                            @if(isset($extra['affiliate_rating_description']) && $extra['affiliate_rating_description']!='')
                                {!! stripslashes($extra['affiliate_rating_description']) !!}
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="through-our-img">
                            @if(isset($extra['affiliate_rating_image']) && $extra['affiliate_rating_image']!='')
                                <img src="{!! SM::sm_get_the_src($extra['affiliate_rating_image']) !!}"
                                     alt="SEO Rating">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="through-our-content">
                            @if(isset($extra['affiliate_seo_check_description']) && $extra['affiliate_seo_check_description']!='')
                                {!! stripslashes($extra['affiliate_seo_check_description']) !!}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        @if(isset($extra['affiliate_seo_check_image']) && $extra['affiliate_seo_check_image']!='')
                            <div class="through-our-img">
                                <img src="{!! SM::sm_get_the_src($extra['affiliate_seo_check_image']) !!}"
                                     alt="SEO Speed">
                            </div>
                        @endif
                        <div class="through-our-content">
                            @if(isset($extra['affiliate_extra_description']) && $extra['affiliate_extra_description']!='')
                                {!! stripslashes($extra['affiliate_extra_description']) !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="through-our-sec common-section">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="sm-content through-our-content through-our-content1">
                            @if(isset($extra['extra']) && $extra['extra']!='')
                                {!! stripslashes($extra['extra']) !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            </div>
        @endif

        <!--CASE STUDY END-->
            <!--TESTMONIAL START-->
		<?php
		$home_testimonial_style = SM::smGetThemeOption( "home_testimonial_style", "bg-black" );
		?>
        <!--TESTMONIAL START-->
        @include("common.testimonials", ["style"=>$home_testimonial_style])
        <!--TESTMONIAL END-->
            <div class="clearfix case-social">
				<?php
				$url = urlencode( url( "cases/" . $caseInfo->slug ) );
				$urlEncodeTitle = urlencode( $caseInfo->title );
				?>
                <a class="fb" target="_blank" href="https://www.facebook.com/sharer.php?u={{ $url }}"><i
                            class="fa fa-facebook"></i>Facebook</a>
                <a class="tw" target="_blank"
                   href="http://twitter.com/share?text={{ $urlEncodeTitle }}&url={{ $url }}&hashtags=DoodleDigital"><i
                            class="fa fa-twitter"></i>Twitter</a>
                <a class="lk" target="_blank"
                   href="https://www.linkedin.com/shareArticle?url={{ $url }}&title={{ $urlEncodeTitle }}"><i
                            class="fa fa-linkedin"></i>Linkedin</a>
                <a class="gp" target="_blank" href="https://plus.google.com/share?url={{ $url }}"><i
                            class="fa fa-google-plus"></i>Google+</a>
                <a class="pi" target="_blank"
                   href="https://pinterest.com/pin/create/bookmarklet/?media={{ asset(SM::sm_get_the_src($caseInfo->image, 550, 550)) }}&url={{ $url }}&is_video=false&description={{ $urlEncodeTitle }}"><i
                            class="fa fa-pinterest-p"></i>Pinterest</a>
            </div>
            <!--TEAM START-->
        @include("common.teams", ['is_home'=>1])
        <!--TEAM END-->
            <!--TESTMONIAL START-->
        @include("common.newslatter")
        <!--TESTMONIAL END-->
@endsection
