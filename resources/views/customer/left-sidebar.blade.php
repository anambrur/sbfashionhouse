<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 12/4/17
 * Time: 11:46 AM
 */
?>

<div class="account-panel account-sidebar">
    <h2>My Account</h2>
    {!! Form::open(['method'=>'post', 'url'=>'dashboard/user-profile-pic-change','files'=>true, 'id'=>'profile_picture_form']) !!}
    <div class="account-profile-img">
        <img id="profile_picture_img" src="{!! SM::sm_get_the_src($userInfo->image,165,165) !!}"
             alt="{{ $userInfo->username }}">
        <span class="change-profile-pic">
                <i class="fa fa-camera"></i>
                 <input type="file" name="profile_picture">
        </span>
    </div>
    {!! Form::close() !!}
    <h4 class="change-account-name-opt">
        <?php
        $flname = $userInfo->firstname . " " . $userInfo->lastname;
        $name = trim($flname != '') ? $flname : $userInfo->username;
        ?>
        {{ $name }}
        <a href="{!! url("dashboard/edit-profile") !!}"><i class="fa fa-pencil-square-o"></i> </a>
    </h4>
    <span class="devider"></span>
    <ul>
        <li class="@if($activeMenu == 'dashboard') {{ 'active' }} @endif">
            <a href="{!! url('dashboard') !!}"><i class="fa fa-dashboard"></i> Dashboard
            </a>
        </li>
        <li class="@if($activeMenu == 'edit-profile') {{ 'active' }} @endif">
            <a href="{!! url("dashboard/edit-profile") !!}">
                <i class="fa fa-file-text-o"></i> Personal Information
            </a>
        </li>
        <li class="@if($activeMenu == 'orders') {{ 'active' }} @endif">
            <a href="{!! url('dashboard/orders') !!}"><i class="fa fa-shopping-cart"></i> My Orders
            </a>
        </li>
        <li class="@if($activeMenu == 'wishlist') {{ 'active' }} @endif">
            <a href="{!! url('dashboard/wishlist') !!}"><i class="fa fa-heart"></i> Wishlist
            </a>
        </li>
        <li class="@if($activeMenu == 'review') {{ 'active' }} @endif">
            <a href="{!! url('dashboard/review') !!}"><i class="fa fa-star"></i> Review
            </a>
        </li>

        {{--<li class="@if($activeMenu == 'coupons') {{ 'active' }} @endif">--}}
        {{--<a href="{!! url('dashboard/coupons') !!}"><i class="fa fa-thumbs-up"></i> Coupons<span--}}
        {{--class="fa fa-angle-right"></span></a>--}}
        {{--</li>--}}
        <li class="@if($activeMenu == 'downloads') {{ 'active' }} @endif">
            <a href="{!! url('dashboard/downloads') !!}"><i class="fa fa-download"></i> Downloads
            </a>
        </li>
        <li style="display: none;" class="@if($activeMenu == 'tickets') {{ 'active' }} @endif">
            <a href="{!! url('dashboard/tickets') !!}"><i class="fa fa-support"></i> My Tickets
            </a>
        </li>
        <li style="display: none;" class="@if($activeMenu == 'add-ticket') {{ 'active' }} @endif">
            <a href="{!! url('dashboard/tickets/add') !!}"><i class="fa fa-ticket"></i> Add Tickets
            </a>
        </li>
        <li>
            <a href="{!! url('logout') !!}"><i class="fa fa-power-off"></i> Log Out</a>
        </li>
    </ul>
</div>
