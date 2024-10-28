@extends(('nptl-admin/master'))
@section('title',__("setting.setting"))
@section('content')
@include(('nptl-admin/common/media/media_pop_up'))
<section id="widget-grid" class="">

    <!-- row -->
    <div class="row">
        <form name="save_category" id="save_category" method="post"
              action="{{url(config('constant.smAdminSlug').'/setting/save_setting')}}"
              class="form-horizontal"
              enctype="multipart/form-data">
            {{ csrf_field() }}
            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-8">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-setting">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-cog"></i> </span>
                        <h2>Site Settings</h2>

                    </header>

                    <!-- widget div-->
                    <div>

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->
                            <input class="form-control" type="text">
                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->
                        <div class="widget-body">
                            <fieldset>
                                <div class="form-group{{ $errors->has('site_name') ? ' has-error' : '' }}">
                                    <label class="col-md-2 control-label"
                                           for="site_name">{{__("setting.siteName")}}</label>
                                    <div class="col-md-10">
                                        <input name="site_name" id="site_name" class="form-control"
                                               placeholder="{{__("setting.siteName")}}" type="text" required=""
                                               value="{{ old('site_name')!='' ? old('site_name') : SM::get_setting_value('site_name') }}">
                                        @if ($errors->has('site_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('site_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('website') ? ' has-error' : '' }}">
                                    <label class="col-md-2 control-label"
                                           for="website">{{__("Website")}}</label>
                                    <div class="col-md-10">
                                        <input name="website" id="website" class="form-control"
                                               placeholder="{{__("Website")}}" type="text" required=""
                                               value="{{ old('website')!='' ? old('website') : SM::get_setting_value('website') }}">
                                        @if ($errors->has('website'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('website') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('tag_line') ? ' has-error' : '' }}">
                                    <label class="col-md-2 control-label"
                                           for="tag_line">{{__("setting.tagLine")}}</label>
                                    <div class="col-md-10">
                                        <input name="tag_line" id="tag_line" class="form-control"
                                               placeholder="{{__("setting.tagLine")}}" type="text" required=""
                                               value="{{ old('site_name')!='' ? old('site_name') : SM::get_setting_value('tag_line') }}">
                                        @if ($errors->has('site_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('tag_line') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('about') ? ' has-error' : '' }}">
                                    <label class="col-md-2 control-label"
                                           for="about">{{__("setting.about")}}</label>
                                    <div class="col-md-10">
                                        <textarea name="about" id="about" class="form-control"
                                                  placeholder="{{__("setting.about")}}" rows="4" required="">{{ old('about')!=''? old('about') :SM::get_setting_value('about') }}
                                        </textarea>
                                        @if ($errors->has('about'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('about') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                    <label class="col-md-2 control-label"
                                           for="address">{{__("setting.address")}}</label>
                                    <div class="col-md-10">
                                        <textarea name="address" id="address" class="form-control"
                                                  placeholder="{{__("setting.address")}}" rows="4" required="">{{ old('address')!=''? old('address') :SM::get_setting_value('address') }}
                                        </textarea>
                                        @if ($errors->has('address'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                                    <label class="col-md-2 control-label" for="email">Country</label>
                                    <div class="col-md-10">
                                        <input name="country" id="country" class="form-control"
                                               placeholder="Country" type="text" required=""
                                               value="{{ old('country')!='' ? old('country') : SM::get_setting_value('country') }}">
                                        @if ($errors->has('country'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('country') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label class="col-md-2 control-label"
                                           for="email">{{__("setting.primaryEmail")}}</label>
                                    <div class="col-md-10">
                                        <input name="email" id="email" class="form-control"
                                               placeholder="{{__("setting.primaryEmail")}}" type="email" required=""
                                               value="{{ old('email')!='' ? old('email') : SM::get_setting_value('email') }}">
                                        @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('secondary_email') ? ' has-error' : '' }}">
                                    <label class="col-md-2 control-label"
                                           for="secondary_email">{{__("setting.secondaryEmail")}}</label>
                                    <div class="col-md-10">
                                        <input name="secondary_email" id="secondary_email" class="form-control"
                                               placeholder="{{__("setting.secondaryEmail")}}" type="email"
                                               required=""
                                               value="{{ old('secondary_email')!='' ? old('secondary_email') : SM::get_setting_value('secondary_email') }}">
                                        @if ($errors->has('secondary_email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('secondary_email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                                    <label class="col-md-2 control-label"
                                           for="mobile">{{__("setting.mobileNo")}}</label>
                                    <div class="col-md-10">
                                        <input name="mobile" id="mobile" class="form-control"
                                               placeholder="{{__("setting.mobileNo")}}" type="text" required=""
                                               value="{{ old('secondary_email')!='' ? old('mobile') : SM::get_setting_value('mobile') }}">
                                        @if ($errors->has('mobile'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('mobile') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('currency') ? ' has-error' : '' }}">
                                    <label class="col-md-2 control-label"
                                           for="currency">{{__("Currency")}}</label>
                                    <div class="col-md-10">
                                        <input name="currency" id="currency" class="form-control"
                                               placeholder="Currency" type="text" required=""
                                               value="{{ old('currency')!='' ? old('currency') : SM::get_setting_value('currency') }}">
                                        @if ($errors->has('currency'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('currency') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('primary_color') ? ' has-error' : '' }}">
                                    <label class="col-md-2 control-label"
                                           for="primary_color">Primary Color</label>
                                    <div class="col-md-10">
                                        <input name="primary_color" id="primary_color"
                                               class="form-control colorPicker"
                                               placeholder="Primary Color" type="text"
                                               value="{{ old('primary_color')!='' ? old('primary_color') : SM::get_setting_value('primary_color') }}">
                                        @if ($errors->has('primary_color'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('primary_color') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('secondary_color') ? ' has-error' : '' }}">
                                    <label class="col-md-2 control-label"
                                           for="secondary_color">Secondary Color </label>
                                    <div class="col-md-10">
                                        <input name="secondary_color" id="secondary_color"
                                               class="form-control colorPicker"
                                               placeholder="Secondary Color" type="text"
                                               value="{{ old('secondary_color')!='' ? old('secondary_color') : SM::get_setting_value('secondary_color') }}">
                                        @if ($errors->has('secondary_color'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('secondary_color') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('favicon') ? ' has-error' : '' }}">
                                    <label class="col-md-2 control-label"
                                           for="select-1">{{__("setting.favicon")}}</label>
                                    <div class="col-sm-2">
                                        <input type="hidden" name="favicon" id="favicon" value="">
                                        <input input_holder="favicon" img_holder="favicon_ph" is_multiple="0"
                                               type="button"
                                               class="btn btn-success sm_media_modal_show"
                                               value="{{__("setting.uploadOrSelectFile")}}">
                                        @if ($errors->has('favicon'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('favicon') }}</strong>
                                        </span>
                                        @endif

                                    </div>
                                    <div class="col-sm-8" id="favicon_ph">
                                        <img class="media_img"
                                             src="<?php echo SM::sm_get_the_src(SM::get_setting_value('favicon')) ?>"
                                             width="25px"/>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }}">
                                    <label class="col-md-2 control-label" for="logo">{{__("setting.logo")}}</label>
                                    <div class="col-sm-2">
                                        <input type="hidden" name="logo" id="logo_val" value="">
                                        <input input_holder="logo_val" img_holder="logo_ph" is_multiple="0"
                                               type="button"
                                               class="btn btn-success sm_media_modal_show"
                                               value="{{__("setting.uploadOrSelectFile")}}">
                                        @if ($errors->has('logo'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('logo') }}</strong>
                                        </span>
                                        @endif

                                    </div>
                                    <div class="col-sm-8" id="logo_ph">
                                        <img class="media_img"
                                             src="<?php echo SM::sm_get_the_src(SM::get_setting_value('logo')) ?>"
                                             width="150"/>
                                    </div>

                                </div>
                            </fieldset>

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fa fa-save"></i>
                                            Save Site Settings
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- end widget content -->

                    </div>
                    <!-- end widget div -->

                </div>
                <!-- end widget -->

            </article>
            <!-- WIDGET END -->
        </form>
        <form name="cache_setting" id="save_cache_setting" method="post"
              action="{{url(config('constant.smAdminSlug').'/setting/save_cache_setting')}}"
              class="form-horizontal"
              enctype="multipart/form-data">
            {{ csrf_field() }}
            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-4">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-cache-setting">
                    <!-- widget options:
                       usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

                       data-widget-colorbutton="false"
                       data-widget-editbutton="false"
                       data-widget-togglebutton="false"
                       data-widget-deletebutton="false"
                       data-widget-fullscreenbutton="false"
                       data-widget-custombutton="false"
                       data-widget-collapsed="true"
                       data-widget-sortable="false"

                    -->
                    <header>
                        <span class="widget-icon"> <i class="fa fa-car"></i> </span>
                        <h2>Cache Settings </h2>
                    </header>

                    <!-- widget div-->
                    <div>

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->
                            <input class="form-control" type="text">
                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->
                        <div class="widget-body">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">
                                    Is Cache Enable?
                                </label>
                                <div class="col-md-8">
                                    <label class="toggle">
                                        <input type="radio" name="is_cache_enable" value="1"
                                        <?php
                                        $is_cache_enable = SM::get_setting_value('is_cache_enable', 1);
                                        echo $is_cache_enable == 1 ? 'checked="checked"' : '';
                                        ?>>
                                        Yes
                                    </label>
                                    <label class="toggle">
                                        <input type="radio" name="is_cache_enable" value="0"
                                               <?php echo $is_cache_enable != 1 ? 'checked="checked"' : ''; ?>>
                                        No
                                    </label>
                                    @if ($errors->has('is_cache_enable'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('is_cache_enable') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('cache_update_time') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label"
                                       for="default_tax">Cache Update Time in Minutes</label>
                                <div class="col-md-8">
                                    <input name="cache_update_time" id="cache_update_time" class="form-control"
                                           placeholder="Cache Update Time in Minutes" type="number" min="1"
                                           required=""
                                           value="{{ old('cache_update_time')!='' ? old('cache_update_time') : SM::get_setting_value('cache_update_time', 10) }}">
                                    @if ($errors->has('cache_update_time'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cache_update_time') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <a class="btn btn-danger pull-left"
                                           href="{!! url(SM::smAdminSlug("flush-cache")) !!}">
                                           <i class="fa fa-trash-o"></i>
                                            Flush Cache
                                        </a>
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fa fa-save"></i>
                                            Save Cache Info
                                        </button>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <!-- end widget content -->

                    </div>
                    <!-- end widget div -->

                </div>
                <!-- end widget -->

            </article>
        </form>
        <form name="tax_setting" id="save_tax_setting" method="post"
              action="{{url(config('constant.smAdminSlug').'/setting/save_tax_setting')}}"
              class="form-horizontal"
              enctype="multipart/form-data">
            {{ csrf_field() }}
            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-4">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-tax-setting">
                    <!-- widget options:
                       usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

                       data-widget-colorbutton="false"
                       data-widget-editbutton="false"
                       data-widget-togglebutton="false"
                       data-widget-deletebutton="false"
                       data-widget-fullscreenbutton="false"
                       data-widget-custombutton="false"
                       data-widget-collapsed="true"
                       data-widget-sortable="false"

                    -->
                    <header>
                        <span class="widget-icon"> <i class="fa fa-cog"></i> </span>
                        <h2>Tax Settings </h2>

                    </header>

                    <!-- widget div-->
                    <div>

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->
                            <input class="form-control" type="text">
                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->
                        <div class="widget-body">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">
                                    Is Tax Enable?
                                </label>
                                <div class="col-md-8">
                                    <label class="toggle">
                                        <input type="radio" name="is_tax_enable" value="1"
                                        <?php
                                        $is_tax_enable = SM::get_setting_value('is_tax_enable');
                                        echo $is_tax_enable == 1 ? 'checked="checked"' : '';
                                        ?>>
                                        Yes
                                    </label>
                                    <label class="toggle">
                                        <input type="radio" name="is_tax_enable" value="0"
                                               <?php echo $is_tax_enable != 1 ? 'checked="checked"' : ''; ?>>
                                        No
                                    </label>
                                    @if ($errors->has('is_tax_enable'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('is_tax_enable') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('default_tax') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label"
                                       for="default_tax">Default Tax</label>
                                <div class="col-md-8">
                                    <input name="default_tax" id="default_tax" class="form-control"
                                           placeholder="Default Tax" type="number" max="100" min="1"
                                           required=""
                                           value="{{ old('default_tax')!='' ? old('default_tax') : SM::get_setting_value('default_tax') }}">
                                    @if ($errors->has('default_tax'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('default_tax') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('default_tax_type') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label"
                                       for="default_tax">Default Tax Type</label>
                                <div class="col-md-8">
                                    <select name="default_tax_type" id="default_tax_type" class="form-control"
                                            required="">
                                                <?php
                                                $default_tax_type = old('default_tax_type') != '' ? old('default_tax_type') : SM::get_setting_value('default_tax_type');
                                                ?>
                                        <option value="1" {{ $default_tax_type==1 ? "selected" : "" }}>Fixed
                                        </option>
                                        <option value="2" {{ $default_tax_type==2 ? "selected" : "" }}>Percentage
                                        </option>
                                    </select>
                                    @if ($errors->has('default_tax_type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('default_tax_type') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fa fa-save"></i>
                                            Save Tax Info
                                        </button>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <!-- end widget content -->

                    </div>
                    <!-- end widget div -->

                </div>
                <!-- end widget -->

            </article>
            <!-- WIDGET END -->
        </form>
        <form name="save_category" id="save_maintenance_setting" method="post"
              action="{{url(config('constant.smAdminSlug').'/setting/save_maintenance_setting')}}"
              class="form-horizontal"
              enctype="multipart/form-data">
            {{ csrf_field() }}

            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-12">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-maintenance-setting">
                    <!-- widget options:
                       usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

                       data-widget-colorbutton="false"
                       data-widget-editbutton="false"
                       data-widget-togglebutton="false"
                       data-widget-deletebutton="false"
                       data-widget-fullscreenbutton="false"
                       data-widget-custombutton="false"
                       data-widget-collapsed="true"
                       data-widget-sortable="false"

                    -->
                    <header>
                        <span class="widget-icon"> <i class="fa fa-cog"></i> </span>
                        <h2>Maintenance Settings </h2>

                    </header>

                    <!-- widget div-->
                    <div>

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->
                            <input class="form-control" type="text">
                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->
                        <div class="widget-body">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="col-md-2 control-label">
                                    Is Maintenance Mode Enable?
                                </label>
                                <div class="col-md-10">
                                    <label class="toggle">
                                        <input type="radio" name="is_maintenance_enable" value="1"
                                        <?php
                                        $is_maintenance_enable = SM::get_setting_value('is_maintenance_enable');
                                        echo $is_maintenance_enable == 1 ? 'checked="checked"' : '';
                                        ?>>
                                        Yes
                                    </label>
                                    <label class="toggle">
                                        <input type="radio" name="is_maintenance_enable" value="0"
                                               <?php echo $is_maintenance_enable != 1 ? 'checked="checked"' : ''; ?>>
                                        No
                                    </label>
                                    @if ($errors->has('is_maintenance_enable'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('is_maintenance_enable') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('maintenance_title') ? ' has-error' : '' }}">
                                <label class="col-md-2 control-label"
                                       for="default_tax">Maintenance Title</label>
                                <div class="col-md-10">
                                    <input name="maintenance_title" id="maintenance_title" class="form-control"
                                           placeholder="Your Maintenance title will be here" type="text"
                                           required=""
                                           value="{{ old('maintenance_title')!='' ? old('maintenance_title') : SM::get_setting_value('maintenance_title') }}">
                                    @if ($errors->has('maintenance_title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('maintenance_title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('maintenance_description') ? ' has-error' : '' }}">
                                <label class="col-md-2 control-label"
                                       for="default_tax">Maintenance Description</label>
                                <div class="col-md-10">
                                    <textarea name="maintenance_description" id="maintenance_description"
                                              class="form-control ckeditor"
                                              placeholder="Your Maintenance description will be here" type="number"
                                              required=""
                                              rows="8">{{ old('maintenance_description')!='' ? old('maintenance_description') : SM::get_setting_value('maintenance_description') }}</textarea>
                                    @if ($errors->has('maintenance_description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('maintenance_description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('when_site_will_live') ? ' has-error' : '' }}">
                                <label class="col-md-2 control-label"
                                       for="default_tax">When site will live?</label>
                                <div class="col-md-10">
                                    <input name="when_site_will_live" id="datetimepicker"
                                           class="form-control datetimepicker"
                                           placeholder="When your site will live in minutes like 30" type="text"
                                           required="" data-date-format="yyyy-mm-dd hh:ii"
                                           value="{{ old('when_site_will_live')!='' ? old('when_site_will_live') : SM::get_setting_value('when_site_will_live') }}">
                                    <span>Server Time Now: {{ date('Y-m-d H:i:s') }}</span>
                                    @if ($errors->has('when_site_will_live'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('when_site_will_live') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fa fa-save"></i>
                                            Save Maintenance Info
                                        </button>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <!-- end widget content -->

                    </div>
                    <!-- end widget div -->

                </div>
                <!-- end widget -->

            </article>
            <!-- WIDGET END -->

        </form>
    </div>

    <!-- end row -->

</section>
@endsection