@extends("nptl-admin.master")
@section("title","Edit Package")
@section("content")
    @include(('nptl-admin/common/media/media_pop_up'))
    <section id="widget-grid" class="">
        <!-- row -->
        <div class="row">
            {!! Form::model($package_info,["method"=>"PATCH","action"=>["Admin\Common\Packages@update", $package_info->id]]) !!}
            @include(("nptl-admin/common/package/package_form"),
            ['f_name'=>__("common.edit"), 'btn_name'=>__("common.update")])
            {!! Form::close() !!}

        </div>
        <!-- end row -->
    </section>
@endsection
@section('footer_script')
    <script>
        (function ($) {
            packageTypeChanged(<?php echo $package_info->type ?>);
        })(jQuery)
    </script>
@endsection