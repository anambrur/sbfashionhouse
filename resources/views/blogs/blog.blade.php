@extends("master")
@section("title", "Blog")
@section("content")
	<?php
	$countStickyPost = count( $stickyBlogPost );
	$isBreadcrumbEnable = SM::smGetThemeOption( "blog_is_breadcrumb_enable", false );

	$pagination = [
		[
			"title" => "Blog"
		]
	];
	$title = SM::smGetThemeOption( "blog_banner_title" );
	$subtitle = SM::smGetThemeOption( "blog_banner_subtitle" );
	$bannerImage = SM::smGetThemeOption( "blog_banner_image" );
	?>
    <!--BREADCRUMB START-->
    <section class="page-banner-section blog-list-banner-section">
        <div class="blog-banner-sec"
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
        @if((isset($isBreadcrumbEnable) && $isBreadcrumbEnable) || !isset($isBreadcrumbEnable))
            <div class="page-breadcrumb-section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="page-breadcrumb">
                                <ul>
                                    <li><a href="{{url("")}}">Home</a></li>
                                    @if(isset($pagination))
                                        @foreach($pagination as $pg)
                                            @if(isset($pg["segment"]))
                                                <li><a href="{{url($pg["segment"])}}">{{$pg['title']}}</a></li>
                                            @else
                                                <li>{{$pg['title']}}</li>
                                            @endif
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </section>
    <!--BREADCRUMB END-->
    <section class="common-section blog-page-section">
        <div class="container">

            @if($countStickyPost>0)
                <div class="row mb60">
                    @foreach($stickyBlogPost as $blog)
                        <div class="col-lg-12">
                            <div class="blog-featured-post"
                                 style="background: url({!! SM::sm_get_the_src( $blog->image) !!})">
                                <div class="blog-featured-post-content">
                                    <a href="{!! url( "blog/$blog->slug" ) !!}">
                                        <div class="blog-featured-content text-center">
                                            <time>{{date("F d, Y", strtotime($blog->created_at))}}</time>
                                            <h3>{{$blog->title}}</h3>
                                            <p>{{$blog->short_description}}</p>
                                            <small class="doddle-btn "><span></span><b></b>Read More</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            <div class="row">
                <div class="col-sm-8">
                    <div class="row" id="sm_list">
                        @include('blogs.blog_list_item')
                    </div>
                </div>
                <div class="col-sm-4">
                    @include("common.blog_sidebar")
                </div>
            </div>
        </div>
    </section>
    <!--TEAM START-->
    @include("common.teams", ['is_home'=>1,'class'=>'bg-gray2'])
    <!--TEAM END-->
    @include("common.newslatter")
@endsection