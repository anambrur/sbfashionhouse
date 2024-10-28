@extends("nptl-admin.master")
@section("title","Edit Payment Method")
@section("content")
    @include(('nptl-admin/common/media/media_pop_up'))
    <section id="widget-grid" class="">
        <!-- row -->
        <div class="row">
            {!! Form::model($payment_method_info,["method"=>"PATCH","action"=>["Admin\Common\PaymentMethods@update",$payment_method_info->id]]) !!}
            @include(("nptl-admin/common/payment_method/payment_method_form"),
            ['f_name'=>__("common.edit"), 'btn_name'=>__("common.update")])
            {!! Form::close() !!}
        </div>
        <!-- end row -->
    </section>
@endsection