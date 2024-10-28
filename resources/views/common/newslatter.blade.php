<!--NEWSLATTER START-->
<section class="common-section bg-black newsletter-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title-4 white mb60 text-center">
                    <h3>Email Newsletters!</h3>
                    <p>Sign up for new Seo content, updates, surveys & offers.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <div class="newsletter">
                    {!! Form::open(["method"=>"post", "action"=>'Front\Page@subscribe', 'id'=>"newsletterForm"]) !!}
                    <input name="email" type="email" placeholder="Your Email Address">
                    <div class="newsletter-btn">
                        <span></span><b></b>
                        <button value="Subscribe" type="submit" id="newsletterFormSubmit">Subscribe</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="seo-score-img newslatter-img1 wow slideInLeft" data-wow-duration="700ms" data-wow-delay="300ms">
                <img src="{{ asset('images/testmonial-bg11.png') }}" alt="">
            </div>
            <div class="seo-score-img newslatter-img2 wow fadeInUp" data-wow-duration="700ms" data-wow-delay="300ms">
                <img src="{{ asset('images/newsletter-img2.png') }}" alt="">
            </div>
            <div class="seo-score-img newslatter-img3 wow fadeInUp" data-wow-duration="700ms" data-wow-delay="300ms">
                <img src="{{ asset('images/newsletter-img3.png') }}" alt="">
            </div>
            <div class="seo-score-img newslatter-img4 wow slideInLeft" data-wow-duration="700ms" data-wow-delay="700ms">
                <img src="{{ asset('images/newsletter-img4.png') }}" alt="">
            </div>
        </div>
    </div>
</section>
<!--NEWSLATTER END-->


