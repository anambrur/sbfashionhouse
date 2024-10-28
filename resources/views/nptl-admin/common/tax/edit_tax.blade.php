@extends("nptl-admin.master")
@section("title","Edit Category")
@section("content")
    @include(('nptl-admin/common/media/media_pop_up'))
    <section id="widget-grid" class="">
        <!-- row -->
        <div class="row">
            {!! Form::model($tax_info,["method"=>"PATCH","action"=>["Admin\Common\Taxes@update",$tax_info->id]]) !!}
            @include(("nptl-admin/common/tax/tax_form"),
            ['f_name'=>__("common.edit"), 'btn_name'=>__("common.update")])
            {!! Form::close() !!}
        </div>
        <!-- end row -->
    </section>
@endsection
@section("footer_script")
<script>
    document.getElementById("country").value = "<?php echo $tax_info->country ?>";
</script>
@endsection