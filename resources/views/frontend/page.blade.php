@extends('frontend.master')

@section("title",$page->page_title)

@section("content")

    <!-- page wapper-->
<?php

    $wwrTitle = SM::smGetThemeOption("wwr_title");

    $wwrSubtitle = SM::smGetThemeOption("wwr_subtitle");

    $wwrDescription = SM::smGetThemeOption("wwr_description");

    $ourMission = SM::smGetThemeOption("our_mission");

    $ourVision = SM::smGetThemeOption("our_vision");

    $histories = SM::smGetThemeOption("histories");

    $historiesCount = count($histories);

    $title = SM::smGetThemeOption("about_banner_title");

    $subtitle = SM::smGetThemeOption("about_banner_subtitle");

    $bannerImage = SM::smGetThemeOption("about_banner_image");

    ?>
    <div class="columns-container">

        <div class="container" id="columns">

            <!-- breadcrumb -->
        
            <div class="blog-banner-sec " style="background: url( /storage/uploads/{{$page->image}}) no-repeat center center /cover">

            <div class="container">

                <div class="row">

                    <div class="blog-banner-contents text-center">

                        
                            <h1>{{ $page->page_title }}</h1>

                        
                        
                    </div>

                </div>

            </div>

        </div>
        
            <!-- ./breadcrumb -->

            <!-- page heading-->

            <h2 class="page-heading">

                <span class="page-heading-title2">{{ $page->page_title }}</span>

            </h2>

            <!-- ../page heading-->

            <div id="contact" class="page-content page-contact">

                <div id="message-box-conact"></div>

                <div class="row">

                    <div class="col-xs-12 col-sm-12" id="contact_form_map">
                        <p>{!! stripslashes( $page->content ) !!}</p>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- ./page wapper-->

@endsection

