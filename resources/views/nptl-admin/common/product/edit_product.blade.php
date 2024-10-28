@extends("nptl-admin.master")
@section("title","Edit Product")
@section("content")
    @include(('nptl-admin/common/media/media_pop_up'))
    <section id="widget-grid" class="">
        <!-- row -->
        <div class="row">
            {!! Form::model($product_info,["method"=>"PATCH","action"=>["Admin\Common\Products@update",$product_info->id]]) !!}
            @include(("nptl-admin.common.product.product_form"),
            ['f_name'=>__("common.edit"), 'btn_name'=>__("common.update")])
            {!! Form::close() !!}
        </div>
        <!-- end row -->
    </section>
@endsection