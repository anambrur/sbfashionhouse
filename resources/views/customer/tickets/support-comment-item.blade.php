<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 4/1/18
 * Time: 10:29 AM
 */
?>
<?php
$user = $detail->user;
?>
@if($user->id==1)
    <li>
        <div class="support-commment">
            <img src="{!! SM::sm_get_the_src(  $user->image , 112, 112) !!}"
                 alt="User">
            <h3><a href="#">{{ $user->username }}</a></h3>
            <div class="con-date">{{date("h:i A d F, Y", strtotime($detail->created_at))}}</div>
            <p>{!! stripslashes($detail->message) !!}</p>
        </div>
    </li>
@else
    <li>
        <div class="support-commment current-user">
            <img src="{!! SM::sm_get_the_src(  $user->image , 112, 112) !!}"
                 alt="User">
            <h3><a href="#">{{ $user->username }}</a></h3>
            <div class="con-date">{{date("h:i A d F, Y", strtotime($detail->created_at))}}</div>
            <p>{!! stripslashes($detail->message) !!}</p>
        </div>
    </li>
@endif
