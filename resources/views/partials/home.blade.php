@include("common.slider")
<?php
$features = SM::smGetThemeOption( "features", array() );
?>
@if(count($features)>0)
    <!--ICON BOX START-->
    <section class="common-section">
        <div class="container">
            <h1 class="canonical_title">{{ SM::smGetThemeOption( "canonical_title","Cornerstones Of Our Digital Marketing Agency" ) }}</h1>
            <div class="row">
                @foreach($features as $feature)
                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-duration="700ms" data-wow-delay="300ms">
                        <div class="icon-box text-center">
                            @isset($feature["feature_title"])
                                @isset($feature["feature_description"])
                                    <img src="{!! SM::sm_get_the_src($feature["feature_image"]) !!}"
                                         alt="{{ $feature["feature_title"] }}">
                                @endisset
                                <h3>
                                    {{ $feature["feature_title"] }}
                                </h3>
                            @endisset
                            @isset($feature["feature_description"])
                                <p>
                                    {!! strip_tags($feature["feature_description"], "<br><span><i><b>") !!}
                                </p>
                            @endisset
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--ICON BOX END-->
@endif
<?php
$home_is_seo_section_enable = SM::smGetThemeOption( "home_is_seo_section_enable", 1 );
?>
@if($home_is_seo_section_enable==1)
    @include("common.seo_form", ["isHome"=>1])
@endif
<?php
$seo_features = SM::smGetThemeOption( "seo_features", array() );
$seo_feature_title = SM::smGetThemeOption( "seo_feature_title", "" );
$seo_feature_description = SM::smGetThemeOption( "seo_feature_description", "" );
$seo_feature_image = SM::smGetThemeOption( "seo_feature_image", "" );
$seo_feature_more_btn_is_enable = SM::smGetThemeOption( "seo_feature_more_btn_is_enable", 1 );
$seo_feature_more_btn_label = SM::smGetThemeOption( "seo_feature_more_btn_label", "Learn more" );
$seo_feature_more_btn_link = SM::smGetThemeOption( "seo_feature_more_btn_link", "#" );
$seo_feature_quote_btn_is_enable = SM::smGetThemeOption( "seo_feature_quote_btn_is_enable", 1 );
$seo_feature_quote_btn_label = SM::smGetThemeOption( "seo_feature_quote_btn_label", "Get a quote" );
$seo_feature_quote_btn_link = SM::smGetThemeOption( "seo_feature_quote_btn_link", "#" );
?>
@if(count($seo_features)>0)
    <!--SEO OPTIMIZITION START-->
    <section class="common-section seo-optimizition-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="section-title-4 text-center">
                        <h3>{{ $seo_feature_title }}</h3>
                        <p>{!! strip_tags($seo_feature_description, "<br><span><i><b>") !!}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-sm-6">
                    <div class="row">
                        @foreach($seo_features as $feature)
                            <div class="col-lg-6 wow fadeInUp" data-wow-duration="700ms" data-wow-delay="300ms">
                                <div class="icon-box-2">
                                    <h3>
                                        @empty(!$feature["feature_icon"])
                                            <img src="{!! SM::sm_get_the_src($feature["feature_icon"]) !!}"
                                                 alt="{!! isset($feature["feature_title"]) ? $feature["feature_title"] : "feature icon" !!}">
                                        @endempty
                                        {!! isset($feature["feature_title"]) ? $feature["feature_title"] : "" !!}
                                    </h3>
                                    <div class="clearfix"></div>
                                    <p>{!! strip_tags($feature["feature_description"], "<br><span><i><b>") !!}</p>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-lg-12">
                            @if($seo_feature_more_btn_is_enable==1)
                                <a class="doddle-btn mr10"
                                   href="{{ $seo_feature_more_btn_link }}"><span></span><b></b> {{ $seo_feature_more_btn_label }}
                                </a>
                            @endif
                            @if($seo_feature_quote_btn_is_enable==1)
                                <a class="doddle-btn fill"
                                   href="{{ $seo_feature_quote_btn_link }}"><span></span><b></b> {{ $seo_feature_quote_btn_label }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @empty(!$seo_feature_image)
                    <div class="col-lg-4 col-sm-6">
                        <div class="seo-opt-img">
                            <img src="{!! SM::sm_get_the_src($seo_feature_image) !!}" alt="Seo Feature">
                        </div>
                    </div>
                @endempty
            </div>
        </div>
    </section>
    <!--SEO OPTIMIZITION END-->
@endif
<?php
$seo_marketing_subtitle = SM::smGetThemeOption( "seo_marketing_subtitle", "" );
$seo_marketing_title = SM::smGetThemeOption( "seo_marketing_title", "" );
$seo_marketing_description = SM::smGetThemeOption( "seo_marketing_description", "" );
$seo_video_banner = SM::smGetThemeOption( "seo_video_banner", "images/video_bg.png" );
?>
<!--VIDEO START-->
<section class="common-section bg-black video-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="video-about">
                    <h4>{{ $seo_marketing_subtitle }}</h4>
                    <h3>{{ $seo_marketing_title }}</h3>
                    {!! $seo_marketing_description !!}
                </div>
            </div>
            <div class="col-lg-6">
                <div class="video-wrap">
                    <img src="{!! SM::sm_get_the_src($seo_video_banner) !!}" alt="Seo Banner">
                    <a href="javascript:0" class="video-btn">
                        <i class="fa fa-play"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--VIDEO END-->
<?php
$home_service_title = SM::smGetThemeOption( "home_service_title", "" );
$home_service_subtitle = SM::smGetThemeOption( "home_service_subtitle", "" );
$services = SM::smGetThemeOption( "services", array() );
?>
@if(count($services)>0)
    <!--ICON BOX 3 START-->
    <section class="common-section icon-box-3-section">
        <div class="container">
            <div class="row">
                <div class="section-title-4 text-center">
                    <h3>{{ $home_service_title }}</h3>
                    <p>{!! strip_tags($home_service_subtitle, "<br><span><i><b>") !!}</p>
                </div>
                @foreach($services as $service)
					<?php
					$title = isset( $service["title"] ) ? $service["title"] : "";
					$description = isset( $service["description"] ) ? $service["description"] : "";
					$link = isset( $service["link"] ) ? $service["link"] : "";
					$service_image = isset( $service["service_image"] ) ? $service["service_image"] : "";
					?>
                    <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-duration="700ms" data-wow-delay="300ms">
                        <div class="icon-box-3 text-center">
                            @empty(!$title)
                                <img src="{!! SM::sm_get_the_src($service_image, 112, 112) !!}" alt="{{ $title }}">
                                <h3>{{ $title }}</h3>
                            @endempty
                            <p>{!! strip_tags($description, "<br><span><i><b>") !!} </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--ICON BOX 3 END-->
@endif
<?php
$achievement_title = SM::smGetThemeOption( "achievement_title", "" );
$achievement_description = SM::smGetThemeOption( "achievement_description", "" );
$achievement_image = SM::smGetThemeOption( "achievement_image", "" );
$total_project = SM::smGetThemeOption( "total_project", 222 );
$total_active_client = SM::smGetThemeOption( "total_active_client", 333 );
$total_success_rate = SM::smGetThemeOption( "total_success_rate", 98 );
$total_commitment = SM::smGetThemeOption( "total_commitment", 100 );
?>
<!--OUR ACHIVMENT START-->
<section class="common-section bg-black achivment-section">
    <div class="half-img">
        <img src="{!! SM::sm_get_the_src($achievement_image) !!}" alt="{{ $achievement_title }}">
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-7 col-sm-12 col-lg-offset-5 col-sm-offset-0">
                @empty(!$achievement_title && !$achievement_description)
                    <div class="section-title-2">
                        @empty(!$achievement_title)
                            <p>{{ $achievement_title }}</p>
                        @endempty
                        @empty(!$achievement_description)
                            <h3>{!! strip_tags($achievement_description, "<br><span><i><b>") !!}</h3>
                        @endempty
                    </div>
                @endempty
                <div class="fun-fact-wrap clearfix">
                    <div class="single-fun-fact wow fadeInUp" data-wow-duration="700ms" data-wow-delay="300ms">
                        <p>Project</p>
                        <h3 data-counter="{{ $total_project }}">{{ $total_project }}</h3>
                        <div class="fun-fact-img">
                            <img src="{!! asset('/images/fun-fact-01.png') !!}" alt="Project">
                        </div>
                    </div>
                    <div class="single-fun-fact f-2nd wow fadeInUp" data-wow-duration="700ms"
                         data-wow-delay="350ms">
                        <p>Active Client</p>
                        <h3 data-counter="{{ $total_active_client }}">{{ $total_active_client }}</h3>
                        <div class="fun-fact-img">
                            <img src="{!! asset('/images/fun-fact-02.png') !!}" alt="Active Client">
                        </div>
                    </div>
                    <div class="clearfix hidden-lg hidden-md"></div>
                    <div class="single-fun-fact f-3rd wow fadeInUp" data-wow-duration="700ms"
                         data-wow-delay="400ms">
                        <p>Success Rate</p>
                        <h3 data-counter="{{ $total_success_rate }}">{{ $total_success_rate }}</h3>
                        <div class="fun-fact-img">
                            <img src="{!! asset('/images/fun-fact-03.png') !!}" alt="Success Rate">
                        </div>
                    </div>
                    <div class="single-fun-fact wow fadeInUp" data-wow-duration="700ms" data-wow-delay="450ms">
                        <p>Commitment</p>
                        <h3 data-counter="{{ $total_commitment }}">{{ $total_commitment }}</h3>
                        <div class="fun-fact-img">
                            <img src="{!! asset('/images/fun-fact-04.png') !!}" alt="Commitment">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="activity-img">
        <img src="{!! asset('/images/achivmen-shap.png') !!}" alt="{{ $achievement_title }}">
    </div>
</section>
<!--OUR ACHIVMENT END-->
<?php
$wcu_title = SM::smGetThemeOption( "wcu_title", "" );
$wcu_subtitle = SM::smGetThemeOption( "wcu_subtitle", "" );
$wcu_description = SM::smGetThemeOption( "wcu_description", "" );
$wcu_image = SM::smGetThemeOption( "wcu_image", 222 );
?>
<!--WHY CHOOSE US START-->
<section class="why-choose-sec common-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title-4 text-center">
                    <h3>{{ $wcu_title }}</h3>
                    <p>{{ $wcu_subtitle }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="why-choose-us-content">
                    {!! $wcu_description !!}
                    <div class="why-choose-img">
                        <img src="{!! SM::sm_get_the_src($wcu_image) !!}" alt="{{ $wcu_title }}">
                        <div class="why-choose-loadding">
                            <span class="why-choose-loading-bar"></span>
                            <span class="why-choose-loading-bar"></span>
                            <span class="why-choose-loading-bar"></span>
                            <span class="why-choose-loading-bar"></span>
                            <span class="why-choose-loading-bar"></span>
                        </div>
                        <div class="why-choose-loadding1">
                            <span class="why-choose-loading-bar"></span>
                            <span class="why-choose-loading-bar"></span>
                            <span class="why-choose-loading-bar"></span>
                            <span class="why-choose-loading-bar"></span>
                            <span class="why-choose-loading-bar"></span>
                        </div>

                        <div class="why-choose-loadding2">
                            <span class="why-choose-loading-bar"></span>
                            <span class="why-choose-loading-bar"></span>
                            <span class="why-choose-loading-bar"></span>
                            <span class="why-choose-loading-bar"></span>
                            <span class="why-choose-loading-bar"></span>
                        </div>

                        <div class="why-choose-loadding3">
                            <span class="why-choose-loading-bar"></span>
                            <span class="why-choose-loading-bar"></span>
                            <span class="why-choose-loading-bar"></span>
                            <span class="why-choose-loading-bar"></span>
                            <span class="why-choose-loading-bar"></span>
                        </div>

                        <div class="why-choose-loadding4">
                            <span class="why-choose-loading-bar"></span>
                            <span class="why-choose-loading-bar"></span>
                            <span class="why-choose-loading-bar"></span>
                            <span class="why-choose-loading-bar"></span>
                            <span class="why-choose-loading-bar"></span>
                        </div>
                        <div class="why-choose-loadding5">
                            <span class="why-choose-loading-bar"></span>
                            <span class="why-choose-loading-bar"></span>
                            <span class="why-choose-loading-bar"></span>
                            <span class="why-choose-loading-bar"></span>
                            <span class="why-choose-loading-bar"></span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<?php
$case_subtitle = SM::smGetThemeOption( "case_subtitle", "" );
$case_title = SM::smGetThemeOption( "case_title", "" );
$casesCount = count( $cases );
?>
@if($casesCount>0)
    <!--WORK START-->
    <section class="common-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-4 text-center">
                        <h3>{{ $case_title }}</h3>
                        <p>{{ $case_subtitle }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($cases as $case)
                    <div class="col-md-4 col-sm-6">
                        <div class="single-case">
                            <div class="home-blog-meta case-portfolio-meta">
                                <a href="javascript:0" class="mrks_like"
                                   data-id="{{ urlencode(base64_encode($case->id)) }}" data-type="case" data-suffix="0">
                                    <i class="fa fa-heart"></i>
                                    {{ SM::getCountTitle($case->likes, '', 0) }}
                                </a>
                                <a href="javascript:0">
                                    <i class="fa fa-comments"></i>
                                    {{ $case->comments }}
                                </a>
                                <a href="javascript:0">
                                    <i class="fa fa-eye"></i>
                                    {{ $case->views }}
                                </a>
                                <h3 class="cases-title">
                                    <a href="{{ url("cases/".$case->slug) }}">{{ $case->title }}</a>
                                </h3>
                            </div>
                            <div class="case-img">
                                <img class="cases-img case-img1"
                                     src="{!! SM::sm_get_the_src($case->image, 360, 380) !!}" alt="{{ $case->title }}">
                                <a href="{{ url("cases/".$case->slug) }}"
                                   class="link-wrap "><span></span><span></span></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--WORK END-->
@endif
<?php
$home_testimonial_style = SM::smGetThemeOption( "home_testimonial_style", "bg-black" );
?>
<!--TESTMONIAL START-->
@include("common.testimonials", ["style"=>$home_testimonial_style])
<!--TESTMONIAL END-->
<?php
$branding_title = SM::smGetThemeOption( "branding_title", "" );
$branding_subtitle = SM::smGetThemeOption( "branding_subtitle", "" );
$logosStr = SM::smGetThemeOption( "logos", "" );
$logos = array();
if ( $logosStr != "" && ! $logos = explode( ',', $logosStr ) ) {
	$logos[0] = array( $logosStr );
}
$logosCount = count( $logos );
?>
@if($logosCount>0)
    <!--CLIENT START-->
    <section class="common-section client-logo-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-4 text-center">
                        <h3>{{ $branding_title }}</h3>
                        <p>{{ $branding_subtitle }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="swiper-container client-slider">
                    <div class="swiper-wrapper">
                        @foreach($logos as $logo)
                            <div class="swiper-slide" data-swiper-autoplay="2500">
                                <div class="">
                                    <div class="single-client">
                                        <img src="{!! SM::sm_get_the_src($logo, 170, 95) !!}"
                                                         alt="brand">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--CLIENT END-->
@endif
<?php
$blog_title = SM::smGetThemeOption( "blog_title", "" );
$blog_subtitle = SM::smGetThemeOption( "blog_subtitle", "" );
$blogsCount = count( $blogs );
?>
@if($blogsCount>0)
    <!--LATEST BLOG START-->
    <section class="common-section bg-black latest-blog-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-4 white text-center">
                        <h3>{{ $blog_title }}</h3>
                        <p>{{ $blog_subtitle }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="swiper-container latest-blog">
                        <div class="swiper-wrapper">
                            @foreach($blogs as $blog)
                                <div class="swiper-slide">
                                    <div class="latest-blog">
                                        <div class="blog-top">
											<?php
											$sdTitle = strip_tags( stripslashes( $blog->title ), "<br><i><b>" );
											$sdSubTitle = substr( $sdTitle, 0, 50 );
											$sdTitle = ( strlen( $sdTitle ) > 50 ) ? $sdSubTitle . " ....." : $sdSubTitle;
											$likeInfo['id'] = $blog->id;
											$likeInfo['type'] = 'blog';

											$blogUrl = url( "blog/" . $blog->slug );
											?>
                                            <div class="blog-img">
                                                <a href="#">
                                                    <img
                                                            src="{!! SM::sm_get_the_src($blog->image, 358, 200) !!}"
                                                            alt=" {{ $sdTitle }}">
                                                </a>
                                            </div>
                                            <div class="home-blog-meta">
                                                <a href="javascript:0" class="mrks_like"
                                                   data-id="{{ urlencode(base64_encode($blog->id)) }}"
                                                   data-type="blog">
                                                    <i class="fa fa-heart"></i>
                                                    {{ SM::getCountTitle($blog->likes, 'Like') }}
                                                </a>
                                                <a href="{{ $blogUrl }}">
                                                    <i class="fa fa-comments"></i>
                                                    {{ SM::getCountTitle($blog->comments, 'Comment') }}
                                                </a>
                                                <a href="{{ $blogUrl }}">
                                                    <i class="fa fa-eye"></i>
                                                    {{ SM::getCountTitle($blog->views, 'View') }}
                                                </a>
                                                <div class="b-date">
                                                    <strong>{{ date("d", strtotime($blog->created_at)) }}</strong>
                                                    <b>{{ date("F-y", strtotime($blog->created_at)) }}</b>
                                                </div>
                                            </div>
                                            <h3 class="blog-title"><a
                                                        href="{!! $blogUrl !!}">
                                                    {!! $sdTitle  !!}
                                                </a>
                                            </h3>
											<?php
											$des = $blog->short_description;
											$des = ( $des != '' ) ? $des : $blog->long_description;
											$sd = strip_tags( stripslashes( $des ), "<br><b>" );
											$sdSub = substr( $sd, 0, 140 );
											$sd = ( strlen( $sd ) > 140 ) ? $sdSub . " ....." : $sdSub;
											?>
                                            <p>{!! $sd !!}</p>
                                        </div>
                                        <div class="blog-author pull-left">
                                            <img src="{!! SM::sm_get_the_src($blog->user->image, 80, 80) !!}"
                                                 alt="{{ $blog->user->username }}">
                                            <p>Posted by</p>
											<?php
											$fname = $blog->user->firstname . ' ' . $blog->user->lastname;
											$fname = ( $fname != '' ) ? $fname : $blog->user->username;
											?>
                                            <p class="name">{{ $fname }}</p>
                                        </div>
                                        <a href="{!! $blogUrl !!}" class="pull-right b_readMore">Read
                                            More</a>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="testmonial-control blog-pagi">
                        <div class="tbtn tprev"><img src="{!! asset('/images/arrow-left.png') !!}" alt="arrow left">
                        </div>
                        <div class="tbtn tnext"><img src="{!! asset('/images/arrow-right.png') !!}" alt="arrow left">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--LATEST BLOG END-->
@endif
<!--TEAM START-->
@include("common.teams", ['is_home'=>1, 'class'=>'bg-gray2'])
<!--TEAM END-->