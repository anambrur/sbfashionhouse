@extends('frontend.master')

@section("title", "About")

@section('content')

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

    <div class="container">
<section class="page-banner-section contact-banner-section">
<div class="row">
        <div class="col-md-12">
            <div class="blog-banner-sec " style="background:url( /storage/uploads/slider-2_1.jpg) no-repeat center center /cover">
                    <div class="blog-banner-contents text-center">
                            <h1>About Us</h1>

                    </div>
                </div>
            </div>
         </div>

    </section>
     </div>
   <section class="about-us-section">
       <div class="container">
           <div class="row">
               <div class="col-md-12"> 

                  <div class="section-title-about">
                   <h2>OVERVIEW</h2>
                   <p>The electronic brand ZENVO starts with comprehensive  knowledge with extensive market experience, developing most  reliable, best-in-class products which are imported from China,  Thailand and Vietnam. By being innovative and working closely  with suppliers and partners helps valued customers to evolve and  become market leaders.</p>
                    <img src="http://zenvobd.com/storage/uploads/slider-3.jpg" class="img-responsive" style="margin-top: 20px;">
               </div>
                </div>
           </div>
       </div>
   </section>
   <section class="about-us-section" style="background-color: #f5f5f5;">
       <div class="container">
           <div class="row">
               <div class="col-md-4">
                   <img src="http://zenvobd.com/storage/uploads/brochure.jpg" class="img-responsive" style="margin-top: 20px;">
               </div>
               <div class="col-md-8">
                   <div class="section-title-our-about">
                   <h2>ABOUT ZENVO</h2>
                   <p>ZENVO a Member Unit of King Tech Electronics Limited offers a  wide zone of electronics newish vehement opportunities with the  intention of reaching all kinds of superior quality and highly digital  electronic products. Actually ZENVO is the unique name in the  world's e-commerce platform where ZENVO comes from two  words 'Zen' and 'Vo'. Here 'Zen' means having a relaxing, spa-like  experience or being in the moment and 'Vo' comes from vogue.  where vogue means The prevailing fashion or style at a particular  time. That means ZENVO ensures about to be the most delusional  time with spa-like experience. And here is the success of the  naming.</p>

<p>ZENVO is actually a symbol of trust and dependence to  Bangladeshi buyers by ensuring 100% customer satisfaction. By  making sure that the customer is reaching dawn, ZENVO is  passing through. There is also 24 hours customer service which is open 7 days a week with quick delivery and  easy payment method.
</p>

                    
               </div>
               </div>
           </div>
       </div>
   </section>
   <section class="about-us-section">
       <div class="container">
           <div class="row">
               <div class="section-title-about history">
                   <h2>HISTORY</h2>
                   <p></p>
                    <img src="http://zenvobd.com/storage/uploads/slider-2.jpg" class="img-responsive" style="margin-top: 20px;">
               </div>
           </div>
       </div>
   </section>
   <section class="about-us-section" style="background-color: #f5f5f5;">
       <div class="container">
           <div class="row">
               
               <div class="col-md-12">
                   <div class="section-title-our-about our_avai">
                   <h2>OUR PRODUCTS </h2>
                   <p>Browse a list of ZENVO products designed to help to place on  home & office stay organized, get collections, keep in touch,  grow your business and more. </p>
                   <h3>FROST REFRIGERATOR </h3>
                   <p>Frost refrigerators keep food items fresh for a longer period with energy saving. Best equipment with 100% stylish & nano  technology refrigerator.</p>
                   <h3>NON-FROST REFRIGERATOR</h3>
                   <p>Non- frost refrigerator adds style to any kitchen and offers a host  of interior features that save you space and energy. </p>
                   <h3>LED TV </h3>
                   <p>LED TV offers supper slim frame, unique style with dazzling eye  touching looks and simplicity. We offer different sizes of Television with features like USB Play, Dolby Digital Sound,  VGA Port, HDMI Input and PC Connectivity. </p>
                   <h3>SMART TV</h3>
                   <p>ZENVO designed modern and user friendly smart TV with  enhanced versions. </p>
                   <p>By advanced technology, definitely you can make your browsing  experience joyful as desired in the world of online entertainment.</p>
                   <h3>AIR CONDITIONER </h3>
                   <p>You can keep your space as cool as you want, easily and  efficiently. Deodorizer filter, 100% copper tube, air swing &  perfect refrigerant amount keep your body cool and your home  comfortable. Instantly adjust the temperature of the room so you  can relax and feel nature. </p>
               </div>
               </div>
           </div>
       </div>
   </section>
@endsection