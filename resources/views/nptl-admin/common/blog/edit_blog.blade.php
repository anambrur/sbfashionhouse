@extends("nptl-admin.master")
@section("title","Edit Blog")
@section("content")
    @include(('nptl-admin/common/media/media_pop_up'))
    <section id="widget-grid" class="">
        <!-- row -->
        <div class="row">
            {!! Form::model($blog_info,["method"=>"PATCH","action"=>["Admin\Common\Blogs@update",$blog_info->id]]) !!}
            @include(("nptl-admin/common/blog/blog_form"),
            ['f_name'=>__("common.edit"), 'btn_name'=>__("common.update")])
            {!! Form::close() !!}
        </div>
        <!-- end row -->
    </section>
@endsection