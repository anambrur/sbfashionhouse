<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 10/21/17
 * Time: 12:42 PM
 */
?>
<!--SEO SCORE START-->
<?php
$home_seo_title = SM::smGetThemeOption( "home_seo_title", "" );
$home_seo_btn_title = SM::smGetThemeOption( "home_seo_btn_title", "" );
?>
<section class="common-section bg-black seo-score-section">
    <div class="container">
        <div class="row">
            <div class="seo-score-img seo-form-img1 wow fadeInUp" data-wow-duration="1s" data-wow-delay="300ms">
                <img src="{{ asset('images/seo_score_02.png') }}" alt="">
            </div>
            <div class="seo-score-img seo-form-img2 wow slideInLeft" data-wow-duration="1500ms" data-wow-delay="300ms">
                <img src="{{ asset('images/seo_score_01.png') }}" alt="">
            </div>
            <div class="seo-score-img seo-form-img3 wow fadeInUp" data-wow-duration="1s" data-wow-delay="300ms">
                <img src="{{ asset('images/seo_score_033.png')}}" alt="">
            </div>
            <div class="seo-score-img seo-form-img4 wow slideInRight" data-wow-duration="1s" data-wow-delay="300ms">
                <img src="{{ asset('images/seo_score_04.png') }}" alt="">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <div class="seo-score-form text-center">
                    {!! Form::open(["method"=>"get","action"=>'Front\Page@seoScore', "id"=>"seo_form"]) !!}
                    <h2 class="seo-score-title">{{ $home_seo_title }}</h2>
                    <div class="seo-score-input clearfix">
                        {!! Form::url("seo_url", null, ['placeholder'=>"Type in your website url", 'id'=>'seo_url']) !!}
                        {!! Form::email("email", null, ['placeholder'=>"Type in your Email", 'id'=>'seo_email']) !!}
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="seo-score-submit">
                        <span></span><b></b>
                        <input id="seo_submit_btn" type="submit" value="{{ $home_seo_btn_title }}">
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</section>
<!--SEO SCORE END-->
