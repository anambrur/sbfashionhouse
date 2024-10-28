@extends("master")
@section("title", "Services")
@section("content")
	<?php
	$service_title = SM::smGetThemeOption( "service_title" );
	$service_subtitle = SM::smGetThemeOption( "service_subtitle" );

	$service_seo_image = SM::smGetThemeOption( "service_seo_image" );
	$service_seo_title = SM::smGetThemeOption( "service_seo_title" );
	$service_seo_description = SM::smGetThemeOption( "service_seo_description" );
	$service_seo_link = SM::smGetThemeOption( "service_seo_link" );
	$title = SM::smGetThemeOption( "service_banner_title" );
	$subtitle = SM::smGetThemeOption( "service_banner_subtitle" );
	$bannerImage = SM::smGetThemeOption( "service_banner_image" );
	?>
	<!--CONTACT FORM START-->
	<!--BREADCRUMB START-->
	<section class="page-banner-section service-banner-section">
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
    <section class="common-section service-section">
        <div class="container">

            <div class="row" id="sm_list">
                @include('services.service_list_item')
            </div>
        </div>
    </section>
	@include("common.teams", ['class'=>' bg-gray2', 'is_home'=>1])
    @include("common.newslatter")
@endsection