<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 8/10/17
 * Time: 12:57 PM
 */
?>
@extends("master")
@section("title",$title)
@section("content")
    <!--NEWSLATTER START-->
    @include("partials.home")
    @include("common.newslatter")
    <!--NEWSLATTER END-->
	<?php
	$seo_marketing_video_poster = SM::smGetThemeOption( "seo_marketing_video_poster", "" );
	$seo_marketing_video = SM::smGetThemeOption( "seo_marketing_video", "" );$seo_marketing_video
	?>
    @empty(!$seo_marketing_video)
        <div class="video-popup" style="display: none;">
            <div class="videos-item player">
                <div class="video-close-icon">
                    <button type="button">
                        <img src="{!! asset('images/video-close-icon1.png') !!}" alt="Video Close">
                    </button>
                </div>
                <div class="youtube-video">
                    <video id="myVideo" class="mediaplayer video-js vjs-default-skin mv-play-pause"
                           controls preload="none" data-setup="{}"
                           poster="{!! SM::sm_get_the_src( $seo_marketing_video_poster ) !!}">
                        <source src="{!! SM::sm_get_the_src( $seo_marketing_video ) !!}" type="video/mp4"/>
                    </video>
                </div>
            </div>

        </div>
    @endempty
@endsection