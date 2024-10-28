@extends("nptl-admin.master")
@section("title","Edit Unit")
@section("content")
    @include(('nptl-admin/common/media/media_pop_up'))
    <section id="widget-grid" class="">
        <!-- row -->
        <div class="row">
            {!! Form::model($unit_info,["method"=>"PATCH","action"=>["Admin\Common\Units@update",$unit_info->id]]) !!}
            @include(("nptl-admin.common.unit.unit_form"),
            ['f_name'=>__("common.edit"), 'btn_name'=>__("common.update")])
            {!! Form::close() !!}
        </div>
        <!-- end row -->
    </section>
@endsection