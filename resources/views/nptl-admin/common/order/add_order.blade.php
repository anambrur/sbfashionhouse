@extends(('nptl-admin/master'))
@section('title','Add Package')
@section('content')
    @include(('nptl-admin/common/media/media_pop_up'))
    <section id="widget-grid" class="">
        <!-- row -->
        <div class="row">
            {!! Form::open(["method"=>"post","action"=>"Admin\Common\Packages@store"]) !!}
            @include(("nptl-admin/common/package/package_form"),
            ['f_name'=>__("common.add"), 'btn_name'=>__("common.save")])
            {!! Form::close() !!}
        </div>
        <!-- end row -->
    </section>
@endsection
@section('footer_script')
    <script>
        (function ($) {
            packageTypeChanged(1);
        })(jQuery)
    </script>
@endsection