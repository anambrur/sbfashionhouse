@extends('frontend.master')

@section("title", "Contact")

@section('content')

    <!-- page wapper-->

    <?php

    $contact_form_title = SM::smGetThemeOption("contact_form_title");

    $contact_title = SM::smGetThemeOption("contact_title");

    $contact_subtitle = SM::smGetThemeOption("contact_subtitle");

    $contact_des_title = SM::smGetThemeOption("contact_des_title");

    $contact_description = SM::smGetThemeOption("contact_description");

    $title = SM::smGetThemeOption("contact_banner_title");

    $subtitle = SM::smGetThemeOption("contact_banner_subtitle");

    $bannerImage = SM::smGetThemeOption("contact_banner_image");



    $mobile = SM::get_setting_value('mobile');

    $email = SM::get_setting_value('email');

    $address = SM::get_setting_value('address');

    ?>
 <div class="container">
<section class="page-banner-section contact-banner-section">
<div class="row">
        <div class="col-md-12">
            <div class="blog-banner-sec " style="background:url( /storage/uploads/slider-2_1.jpg) no-repeat center center /cover">
                    <div class="blog-banner-contents text-center">
                            <h1>Contact Us</h1>

                    </div>
                </div>
            </div>
         </div>

    </section>
     </div>
    <div class="columns-container">
        
        <div class="container" id="columns">

            <!-- breadcrumb -->

            <div id="contact" class="page-content page-contact">

                <div id="message-box-conact"></div>

                <div class="row">

                    <div class="col-sm-6">

                        @empty(!$contact_des_title)

                            <h3 class="page-subheading">{{ $contact_des_title }}</h3>



                        @endempty

                        <div class="contact-form-box">
                            <p>Please feel free to contact with us if you would like more
information or any help. Please contact with us directly with
products details, so that we are able to respond promptly with
the information you require.</p>
                            {!! Form::open(['method'=>'post', 'action'=>'Front\HomeController@send_mail', 'id'=>'contactMail']) !!}

                            <div class="form-group">

                                <label class="control-label">Name</label>

                                <input type="text" class="form-control input-sm" name="fullname"

                                       placeholder="Your Name*" id="fullname"/>

                            </div>

                            <div class="form-group">

                                <label class="control-label">Email address</label>

                                <input type="email" class="form-control input-sm" name="email"

                                       placeholder="Your E-mail*" id="contact_email"/>

                            </div>

                            <div class="form-group">

                                <label class="control-label">Subject</label>

                                <input name="subject" class="form-control input-sm" type="text" placeholder="Subject">

                            </div>

                            <div class="form-group">

                                <label class="control-label">Message</label>

                                <textarea name="message" id="contact_message" placeholder="Your massage"

                                          class="form-control input-sm" rows="5"></textarea>

                            </div>

                            <div class="form-group">

                                <button type="submit" id="btn-send-contact" class="btn">

                                     Submit

                                </button>



                            </div>

                            <ul class="serviceMailErrors mailErrorList concatMailErrors">

                            </ul>

                            {!! Form::close() !!}

                        </div>

                    </div>

                    <div class="col-xs-12 col-sm-6" id="contact_form_map">

                        

                        @empty(!$contact_description)

                            <p>{!! $contact_description  !!}</p>

                        @endempty

                        <br/>



                        <ul class="store_info">

                           

                            <li><i class="fa fa-phone"></i><span>{{ $mobile }}</span></li>

                            <li><i class="fa fa-envelope"></i><span><a

                                            href="mailto:{{ $email }}">{{ $email }}</a></span>

                            </li>
                             <li><i class="fa fa-home"></i>{{ $address }}

                            </li>

                        </ul>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d14594.230790359608!2d90.40310325!3d23.86983495!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1597814470096!5m2!1sen!2sbd" style="width: 100%;margin-top: 20px;" height="320" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- ./page wapper-->

@endsection