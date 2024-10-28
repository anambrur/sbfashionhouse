@extends("nptl-admin.master")
@section("title","Edit Coupon")
@section("content")
    @include(('nptl-admin/common/media/media_pop_up'))
    <section id="widget-grid" class="">
        <!-- row -->
        <div class="row">
            {!! Form::model($coupon_info,["method"=>"PATCH","action"=>["Admin\Common\Coupons@update",$coupon_info->id]]) !!}
            @include(("nptl-admin/common/coupon/coupon_form"),
            ['f_name'=>__("common.edit"), 'btn_name'=>__("common.update")])
            {!! Form::close() !!}
        </div>
        <!-- end row -->
    </section>
@endsection