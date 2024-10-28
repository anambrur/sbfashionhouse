@extends("nptl-admin.master")
@section("title","Edit Subscriber")
@section("content")
    @include(('nptl-admin/common/media/media_pop_up'))
    <section id="widget-grid" class="">
        <!-- row -->
        <div class="row">
            {!! Form::model($subscriber_info,["method"=>"PATCH","action"=>["Admin\Common\Subscribers@update",$subscriber_info->id]]) !!}
            @include(("nptl-admin/common/subscriber/subscriber_form"),
            ['f_name'=>__("common.edit"), 'btn_name'=>__("common.update")])
            {!! Form::close() !!}
        </div>
        <!-- end row -->
    </section>
    <script type="text/javascript">
        $(document).ready(function () {
			<?php if($subscriber_info->country != ''): ?>
            if ($("#country").length > 0) {
                $("#country").val('<?php echo $subscriber_info->country; ?>');
                var selectedCountryIndex = $("#country").find('option:selected').attr('data-id');
                var state = $("#country").attr('data-state');
                change_state(selectedCountryIndex, state);
            }
            if ($("#state").length > 0) {
                $("#state").val('<?php echo $subscriber_info->state; ?>');
            }
			<?php endif; ?>
        });
    </script>
@endsection