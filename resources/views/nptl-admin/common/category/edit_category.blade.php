@extends("nptl-admin.master")
@section("title","Edit Category")
@section("content")
    @include(('nptl-admin/common/media/media_pop_up'))
    <section id="widget-grid" class="">
        <!-- row -->
        <div class="row">
            {!! Form::model($category_info,["method"=>"PATCH","action"=>["Admin\Common\Categories@update",$category_info->id]]) !!}
            @include(("nptl-admin/common/category/category_form"),
            ['f_name'=>__("common.edit"), 'btn_name'=>__("common.update")])
            {!! Form::close() !!}
        </div>
        <!-- end row -->
    </section>
@endsection