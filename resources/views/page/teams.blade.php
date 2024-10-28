<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 10/26/17
 * Time: 3:08 PM
 */
?>
@extends("master")
@section("title", "Teams")
@section("content")
	<?php
	$title = SM::smGetThemeOption( "team_banner_title" );
	$subtitle = SM::smGetThemeOption( "team_banner_subtitle" );
	$bannerImage = SM::smGetThemeOption( "team_banner_image" );
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
    @include("common.teams")
@endsection