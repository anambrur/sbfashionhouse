@extends("nptl-admin.master")
@section("title","Edit Attributetitles")
@section("content")
    @include(('nptl-admin/common/media/media_pop_up'))
    <section id="widget-grid" class="">
        <!-- row -->
        <div class="row">
            {!! Form::model($attributetitle_info,["method"=>"PATCH","action"=>["Admin\Common\Attributetitles@update",$attributetitle_info->id]]) !!}
            @include(("nptl-admin.common.attributetitle.attributetitle_form"),
            ['f_name'=>__("common.edit"), 'btn_name'=>__("common.update")])
            {!! Form::close() !!}
        </div>
        <!-- end row -->
    </section>
@endsection