<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 4/1/18
 * Time: 10:29 AM
 */
?>
@foreach($details->sortBy('id') as $detail)
    @include("customer/tickets/support-comment-item", ['detail'=>$detail])
@endforeach
@if($isFirstLoad)
    <input type="hidden" id="last_loaded_support" value="{{ isset($detail->id) ? $detail->id : '' }}"
           data-href="{!! url("dashboard/tickets/new-support-detail/$ticket->id") !!}">
@endif
