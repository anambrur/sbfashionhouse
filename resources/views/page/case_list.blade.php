<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 10/14/17
 * Time: 2:25 PM
 */
?>
@extends("master")
@section("title", "Cases")
@section("content")
	<?php
	$countCases = count( $cases );
	$title = SM::smGetThemeOption( "case_banner_title" );
	$subtitle = SM::smGetThemeOption( "case_banner_subtitle" );
	$bannerImage = SM::smGetThemeOption( "case_banner_image" );
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
    <!--CASE STUDY START-->
    <section class="common-section case-study-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="case-study-nav">
                        <li class="active" data-filter="all">All Projects</li>
                        @foreach($categories as $id => $title)
                            <li data-filter=".cat_{{ $id }}">{{ $title }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="row" id="mixitup">
                @foreach($cases as $case)
                    <div class="col-md-4 col-sm-6 mix
                    @foreach($case->categories as  $cat)
                            cat_{{ $cat->id }}
                    @endforeach">
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
            <div class="row">
                <div class="col-lg-12">
                    {!! $cases->links('common.pagination') !!}
                </div>
            </div>
        </div>
    </section>
    <!--CASE STUDY END-->
    <!--TEAM START-->
    @include("common.teams", ['is_home'=>1,'class'=>'bg-gray2'])
    <!--TEAM END-->
    @include("common.newslatter")
@endsection