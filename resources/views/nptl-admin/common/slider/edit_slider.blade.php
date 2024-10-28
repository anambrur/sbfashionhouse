@extends('nptl-admin/master')
@section('title','Edit Slider')
@section('content')
    @include(('nptl-admin/common/media/media_pop_up'))
    <section id="widget-grid" class="">
        <!-- row -->
        <div class="row">
            {!! Form::model($slider,["method"=>"patch","route"=>["updateSlider",$slider->id]]) !!}
            @include("nptl-admin.common/slider/slider_form",
            ['f_name'=>__("common.add"), 'btn_name'=>__("common.save")])
            {!! Form::close() !!}
            <script type="text/javascript">
                (function ($) {
                    $('#title').val('<?php echo $slider->title; ?>');
                    $('#subtitle').val('<?php echo $slider->subtitle; ?>');
                    $('#status').val('<?php echo $slider->status; ?>');
                })(jQuery)
            </script>
        </div>
        <!-- end row -->
    </section>
@endsection