<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 10/26/17
 * Time: 4:43 PM
 */
$name=(isset($name) && $name != '') ? trim($name) : 'title';
?>
<div class="sm-title-section ">
    <div class="sm-form {{ $errors->has('title') ? ' has-error' : '' }}">
        {{ Form::label('title', 'Title', array('class' => 'requiredStar')) }}
        {{--{!! Form::label('title',__("common.title"))!!}--}}
        {!! Form::text($name, null, ['id'=>'title','required'=>'', 'data-table'=>$table, 'class'=>'form-control', 'placeholder'=>__("common.title")]) !!}
        {!! Form::hidden('id', null, ['id'=>'current_info_id']) !!}
        @if ($errors->has('title'))
            <span class="help-block">
            <strong>{{ $errors->first('title') }}</strong>
        </span>
        @endif
    </div>
    @if($isEnabledSlug)
        <div class="sm-form{{ $errors->has('slug') ? ' has-error' : '' }}">
            {!! Form::label('slug', "URL Slug")!!}
            {!! Form::text('slug', null, ['required'=>'','data-table'=>$table, 'class'=>'form-control', 'placeholder'=>"Customize your slug or make it default."]) !!}
            @if ($errors->has('slug'))
            <span class="help-block">
                <strong>{{ $errors->first('slug') }}</strong>
            </span>
            @endif
            <span style="color: #999;">After changing the title or slug a unique slug will automatically generate.</span>
        </div>
    @endif
</div>