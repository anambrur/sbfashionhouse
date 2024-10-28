@extends("nptl-admin.master")
@section("title","Edit Shipping Method")
@section("content")
    @include(('nptl-admin/common/media/media_pop_up'))
    <section id="widget-grid" class="">
        <!-- row -->
        <div class="row">
            {!! Form::model($shipping_method_info,["method"=>"PATCH","action"=>["Admin\Common\ShippingMethods@update",$shipping_method_info->id]]) !!}
            @include(("nptl-admin.common.shipping_method.shipping_method_form"),
            ['f_name'=>__("common.edit"), 'btn_name'=>__("common.update")])
            {!! Form::close() !!}
        </div>
        <!-- end row -->
    </section>
@endsection