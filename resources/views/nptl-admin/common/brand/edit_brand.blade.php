@extends("nptl-admin.master")
@section("title","Edit Brand")
@section("content")
    @include(('nptl-admin/common/media/media_pop_up'))
    <section id="widget-grid" class="">
        <!-- row -->
        <div class="row">
            {!! Form::model($brand_info,["method"=>"PATCH","action"=>["Admin\Common\Brands@update",$brand_info->id]]) !!}
            @include(("nptl-admin.common.brand.brand_form"),
            ['f_name'=>__("common.edit"), 'btn_name'=>__("common.update")])
            {!! Form::close() !!}
        </div>
        <!-- end row -->
    </section>
@endsection