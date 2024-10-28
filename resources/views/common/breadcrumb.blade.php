<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 10/5/17
 * Time: 12:18 PM
 */
?>
<!--BREADCRUMB START-->
<section class="page-banner-section">
    <div class="page-banner-section-inner">
        <div class="container">
            <div class="row">
                <div class="page-banner-content text-center">
                    @empty(!$title)
                        <h1>{{$title}}</h1>
                    @endempty
                    @if(isset($subtitle) && $subtitle != '')
                        <p>{{$subtitle}}</p>
                    @endif
                </div>
                @empty(!$image)
                    <div class="page-banner-img">
                        <img src="{!! SM::sm_get_the_src( $image ) !!}" alt="banner">
                    </div>
                @endempty
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
