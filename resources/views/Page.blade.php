@extends('frontend.master')

@section("title",$page->page_title)

@section("content")

    <!--CONTACT FORM START-->

    <!--BREADCRUMB START-->

    <section class="page-banner-section contact-banner-section">

        <div class="blog-banner-sec "

             style="background:url( {!! SM::sm_get_the_src( $page->banner_image ) !!}) no-repeat center center /cover">

            <div class="container">

                <div class="row">

                    <div class="blog-banner-contents text-center">

                        @empty(!$page->banner_title)

                            <h1>{{$page->banner_title}}</h1>

                        @endempty

                        @if(isset($page->banner_subtitle) && $page->banner_subtitle != '')

                            <p>{{$page->banner_subtitle}}</p>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </section>

    <section class="terms-privacy-policy">

        <div class="container">

            <div class="row">

                <div class="col-lg-12">

                    <div class="sm-content">

						<?php echo stripslashes( $page->content ) ?>

                    </div>

                </div>

            </div>

        </div>

    </section>



@endsection

