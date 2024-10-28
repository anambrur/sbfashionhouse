@extends(('nptl-admin/master'))
@section('title','Profile')
@section('subtitle', '')
@section('content')
    <section id="widget-grid" class="profile_view">

        <div class="row">
            <aside class="profile-nav col-sm-3">
                <section class="panel">
                    <div class="user-heading round">
                        <a href="#">
                            <img src="<?php echo SM::sm_get_the_src(SM::current_user_image(), 112, 112); ?>" alt="{!!SM::current_user_first_lastname();!!}">
                        </a>
                        <h1>{!!SM::current_user_first_lastname();!!}</h1>
                        <p>{!! SM::current_user_email();!!}</p>
                    </div>

                    <ul class="nav nav-pills nav-stacked">
                        <li class="active"><a href="{{url(config('constant.smAdminSlug').'/profile')}}"> <i class="icon-user"></i> Profile</a></li>
                        <li><a href="{{url(config('constant.smAdminSlug').'/edit_profile')}}"> <i class="icon-edit"></i> Edit profile</a></li>
                    </ul>

                </section>
            </aside>
            <aside class="profile-info col-sm-9">
                <section class="panel">
                    <div class="bio-graph-heading">
                        {!! SM::current_user_meta('extra_note');!!}
                    </div>
                    <div class="panel-body bio-graph-info">
                        <h1>Bio Graph</h1>
                        <div class="row">
							<?php
							$role = SM::current_user_role_name();
							if (SM::sm_string($role))
							{
							?>
                            <div class="bio-row">
                                <p><span>Role </span>: {{$role}}</p>
                            </div>
							<?php
							}
							$username = SM::current_username();
							if (SM::sm_string($username))
							{
							?>
                            <div class="bio-row">
                                <p><span>Username </span>: {{$username}}</p>
                            </div>
							<?php
							}
							$gender = SM::current_user_meta('gender');
							if (SM::sm_string($gender))
							{
							?>
                            <div class="bio-row">
                                <p><span>Gender </span>: <?php echo $gender == 'Male' ? 'Male' : 'Female'; ?></p>
                            </div>
							<?php
							}
							$mobile = SM::current_user_meta('mobile');
							if (SM::sm_string($mobile))
							{
							?>
                            <div class="bio-row">
                                <p><span>Mobile </span>: {{$mobile}}</p>
                            </div>
							<?php
							}
							$skype = SM::current_user_meta('skype');
							if (SM::sm_string($skype))
							{
							?>
                            <div class="bio-row">
                                <p><span>Skype </span>: {{$skype}}</p>
                            </div>
							<?php
							}
							$whats_app = SM::current_user_meta('whats_app');
							if (SM::sm_string($whats_app))
							{
							?>
                            <div class="bio-row">
                                <p><span>Whats App </span>: {{$whats_app}}</p>
                            </div>
							<?php
							}
							$street = SM::current_user_meta('street');
							if (SM::sm_string($street))
							{
							?>
                            <div class="bio-row">
                                <p><span>Street </span>: {{$street}}</p>
                            </div>
							<?php
							}
							$city = SM::current_user_meta('city');
							if (SM::sm_string($city))
							{
							?>
                            <div class="bio-row">
                                <p><span>City </span>: {{$city}}</p>
                            </div>
							<?php
							}
							$zip = SM::current_user_meta('zip');
							if (SM::sm_string($zip))
							{
							?>
                            <div class="bio-row">
                                <p><span>Zip </span>: {{$zip}}</p>
                            </div>
							<?php
							}
							$country = SM::current_user_meta('country');
							if (SM::sm_string($country))
							{
							?>
                            <div class="bio-row">
                                <p><span>Country </span>: {{$country}}</p>
                            </div>
							<?php
							}
							?>
                        </div>
                    </div>
                </section>

            </aside>
        </div>

    </section>
@endsection