<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 12/17/17
 * Time: 2:34 PM
 */
?>
@extends(('nptl-admin/master'))
@section('title', 'Social Setting')
@section('content')
    @include(('nptl-admin/common/media/media_pop_up'))
    <section id="widget-grid" class="">

        <!-- row -->
        <div class="row">

            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-site_meta">
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
                        <ul id="sm_media_tab" class="nav nav-tabs in">
                            <li class="active">
                                <a href="#site_meta_info" data-toggle="tab">Site Meta Info</a>
                            </li>
                            <li class="">
                                <a href="#fb_api_credential" data-toggle="tab">Facebook API Credential</a>
                            </li>
                            <li class="">
                                <a href="#gp_api_credential" data-toggle="tab">Google API Credential</a>
                            </li>
                            <li class="">
                                <a href="#tt_api_credential" data-toggle="tab">Twitter API Credential</a>
                            </li>
                            <li class="">
                                <a href="#li_api_credential" data-toggle="tab">Linkedin API Credential</a>
                            </li>
                        </ul>
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
                            <div id="sm_media_tab_content" class="tab-content">
                                <div class="tab-pane fade in active" id="site_meta_info">
                                    <form name="save_site_meta" id="save_site_meta" method="post"
                                          action="{{url(config('constant.smAdminSlug').'/setting/save_meta_info')}}"
                                          class="form-horizontal">
                                        {{csrf_field()}}
                                        <fieldset>
                                            <div class="form-group has-success">
                                                <div class="col-md-12">
                                                    <p class="text-center">Use comma(,) for multiple keyword's. Keywords
                                                        or Description must be less then 160 characters. If you not set
                                                        this meta site keywords and meta will be used!</p>
                                                    <hr>
                                                </div>
                                            </div>
                                            <div class="form-group{{ $errors->has('site_screenshot') ? ' has-error' : '' }}">
                                                <label class="col-md-2 control-label" for="site_screenshot">Site Screen
                                                    Shot</label>
                                                <div class="col-sm-2">
                                                    <input type="hidden" name="site_screenshot" id="site_screenshot_val"
                                                           value="{{ SM::get_setting_value( 'site_screenshot' ) }}">
                                                    <input input_holder="site_screenshot_val"
                                                           img_holder="site_screenshot_ph" is_multiple="0" type="button"
                                                           class="btn btn-success sm_media_modal_show"
                                                           value="Upload / Select File">
                                                    @if ($errors->has('site_screenshot'))
                                                        <span class="help-block">
                                 <strong>{{ $errors->first('site_screenshot') }}</strong>
                              </span>
                                                    @endif

                                                </div>
                                                <div class="col-sm-8" id="site_screenshot_ph">
                                                    <img class="media_img"
                                                         src="<?php echo SM::sm_get_the_src( SM::get_setting_value( 'site_screenshot' ) ) ?>"
                                                         width="150"/>
                                                </div>

                                            </div>
                                            <div class="form-group{{ $errors->has('seo_title') ? ' has-error' : '' }}">
                                                <label class="col-md-2 control-label" for="seo_title">SEO Title</label>
                                                <div class="col-md-10">
                                                    <input name="seo_title" id="seo_title" class="form-control"
                                                           placeholder="SEO Title" type="text" required=""
                                                           value="{{ old('seo_title')!=''? old('seo_title'): stripslashes(SM::get_setting_value('seo_title'))}}">
                                                    <p class="red"><span id="seo_title_length">70</span> characters
                                                        left!</p>
                                                    @if ($errors->has('seo_title'))
                                                        <span class="help-block">
                                 <strong>{{ $errors->first('seo_title') }}</strong>
                              </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group{{ $errors->has('site_meta_keywords') ? ' has-error' : '' }}">
                                                <label class="col-md-2 control-label" for="meta_key">Meta
                                                    keywords</label>
                                                <div class="col-md-10">
                                                    <input name="site_meta_keywords" id="meta_key" class="form-control"
                                                           placeholder="Meta keywords" type="text" required=""
                                                           value="{{ old('site_meta_keywords')!=''? old('site_meta_keywords'): stripslashes(SM::get_setting_value('site_meta_keywords'))}}">

                                                    @if ($errors->has('site_meta_keywords'))
                                                        <span class="help-block">
                                 <strong>{{ $errors->first('site_meta_keywords') }}</strong>
                              </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group{{ $errors->has('site_meta_description') ? ' has-error' : '' }}">
                                                <label class="col-md-2 control-label" for="meta_description">Meta
                                                    Description</label>
                                                <div class="col-md-10">
                                                    <input name="site_meta_description" id="meta_description"
                                                           class="form-control" placeholder="Meta Description"
                                                           type="text" required=""
                                                           value="{{ old('site_meta_description')!=''? old('site_meta_description'): stripslashes(SM::get_setting_value('site_meta_description')) }}">
                                                    <p class="red"><span id="meta_description_length">160</span>
                                                        characters left!</p>
                                                    @if ($errors->has('site_meta_description'))
                                                        <span class="help-block">
                                 <strong>{{ $errors->first('site_meta_description') }}</strong>
                              </span>
                                                    @endif
                                                </div>
                                            </div>

                                        </fieldset>

                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button class="btn btn-primary" type="submit">
                                                        <i class="fa fa-save"></i>
                                                        Save && update meta into Settings
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="fb_api_credential">
                                    <form name="save_fb_credential" id="save_fb_credential" method="post"
                                          action="{{url(config('constant.smAdminSlug').'/setting/save_fb_credential')}}"
                                          class="smart-form">
                                        {{csrf_field()}}
                                        <fieldset>
                                            <div class="form-group">
                                                <label class="toggle">
                                                    <input type="checkbox" name="fb_api_enable"
													<?php echo SM::get_setting_value( 'fb_api_enable' ) == 'on' ? 'checked="checked"' : ''; ?>>
                                                    <i data-swchon-text="ON" data-swchoff-text="OFF"></i>Enable Facebook
                                                    API
                                                </label>
                                                <br>
                                            </div>
                                            <div class="form-group{{ $errors->has('fb_app_id') ? ' has-error' : '' }}">
                                                <label class="label control-label" for="fb_app_id">Facebook App
                                                    ID</label>
                                                <div class="input">
                                                    <input name="fb_app_id" id="fb_app_id" class="form-control"
                                                           placeholder="Facebook App ID" type="text" required=""
                                                           value="{{ old('fb_app_id')!='' ? old('fb_app_id') : SM::get_setting_value('fb_app_id') }}">
                                                    @if ($errors->has('fb_app_id'))
                                                        <span class="help-block">
                                 <strong>{{ $errors->first('fb_app_id') }}</strong>
                              </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group{{ $errors->has('fb_app_secret') ? ' has-error' : '' }}">
                                                <label class="label control-label" for="fb_app_secret">Facebook App
                                                    Secret</label>
                                                <div class="input">
                                                    <input name="fb_app_secret" id="fb_app_secret" class="form-control"
                                                           placeholder="Facebook App Secret" type="text" required=""
                                                           value="{{ old('fb_app_secret')!='' ? old('fb_app_secret') : SM::get_setting_value('fb_app_secret') }}">
                                                    @if ($errors->has('fb_app_secret'))
                                                        <span class="help-block">
                                 <strong>{{ $errors->first('fb_app_secret') }}</strong>
                              </span>
                                                    @endif
                                                </div>
                                            </div>

                                        </fieldset>
                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button class="btn btn-sm btn-primary margin-right-15"
                                                            type="submit">
                                                        <i class="fa fa-save"></i>
                                                        Save or update Facebook API Credential
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="gp_api_credential">
                                    <form name="save_gp_credential" id="save_gp_credential" method="post"
                                          action="{{url(config('constant.smAdminSlug').'/setting/save_gp_credential')}}"
                                          class="smart-form">
                                        {{csrf_field()}}
                                        <fieldset>
                                            <div class="form-group">
                                                <label class="toggle">
                                                    <input type="checkbox" name="gp_api_enable"
													<?php echo SM::get_setting_value( 'gp_api_enable' ) == 'on' ? 'checked="checked"' : ''; ?>>
                                                    <i data-swchon-text="ON" data-swchoff-text="OFF"></i>Enable Google
                                                    API
                                                </label>
                                                <br>
                                            </div>
                                            <div class="form-group{{ $errors->has('gp_client_id') ? ' has-error' : '' }}">
                                                <label class="label control-label" for="gp_client_id">Google Client
                                                    ID</label>
                                                <div class="input">
                                                    <input name="gp_client_id" id="gp_client_id" class="form-control"
                                                           placeholder="Google Client ID" type="text" required=""
                                                           value="{{ old('gp_client_id')!='' ? old('gp_client_id') : SM::get_setting_value('gp_client_id') }}">
                                                    @if ($errors->has('gp_client_id'))
                                                        <span class="help-block">
                                 <strong>{{ $errors->first('gp_client_id') }}</strong>
                              </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group{{ $errors->has('gp_client_secret') ? ' has-error' : '' }}">
                                                <label class="label control-label" for="gp_client_secret">Google Client
                                                    Secret</label>
                                                <div class="input">
                                                    <input name="gp_client_secret" id="gp_client_secret"
                                                           class="form-control" placeholder="Google Client Secret"
                                                           type="text" required=""
                                                           value="{{ old('gp_client_secret')!='' ? old('gp_client_secret') : SM::get_setting_value('gp_client_secret') }}">
                                                    @if ($errors->has('gp_client_secret'))
                                                        <span class="help-block">
                                 <strong>{{ $errors->first('gp_client_secret') }}</strong>
                              </span>
                                                    @endif
                                                </div>
                                            </div>

                                        </fieldset>
                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button class="btn btn-sm btn-primary margin-right-15"
                                                            type="submit">
                                                        <i class="fa fa-save"></i>
                                                        Save or update Google API Credential
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="tt_api_credential">
                                    <form name="save_tt_credential" id="save_tt_credential" method="post"
                                          action="{{url(config('constant.smAdminSlug').'/setting/save_tt_credential')}}"
                                          class="smart-form">
                                        {{csrf_field()}}
                                        <fieldset>
                                            <div class="form-group">
                                                <label class="toggle">
                                                    <input type="checkbox" name="tt_api_enable"
													<?php echo SM::get_setting_value( 'tt_api_enable' ) == 'on' ? 'checked="checked"' : ''; ?>>
                                                    <i data-swchon-text="ON" data-swchoff-text="OFF"></i>Enable Twitter
                                                    API
                                                </label>
                                                <br>
                                            </div>
                                            <div class="form-group{{ $errors->has('tt_api_key') ? ' has-error' : '' }}">
                                                <label class="label control-label" for="tt_api_key">Twitter API
                                                    Key</label>
                                                <div class="input">
                                                    <input name="tt_api_key" id="tt_api_key" class="form-control"
                                                           placeholder="Twitter API Key" type="text" required=""
                                                           value="{{ old('tt_api_key')!='' ? old('tt_api_key') : SM::get_setting_value('tt_api_key') }}">
                                                    @if ($errors->has('tt_api_key'))
                                                        <span class="help-block">
                                 <strong>{{ $errors->first('tt_api_key') }}</strong>
                              </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group{{ $errors->has('tt_api_secret') ? ' has-error' : '' }}">
                                                <label class="label control-label" for="tt_api_secret">Twitter API
                                                    Secret</label>
                                                <div class="input">
                                                    <input name="tt_api_secret" id="tt_api_secret" class="form-control"
                                                           placeholder="Twitter API Secret" type="text" required=""
                                                           value="{{ old('tt_api_secret')!='' ? old('tt_api_secret') : SM::get_setting_value('tt_api_secret') }}">
                                                    @if ($errors->has('tt_api_secret'))
                                                        <span class="help-block">
                                 <strong>{{ $errors->first('tt_api_secret') }}</strong>
                              </span>
                                                    @endif
                                                </div>
                                            </div>


                                        </fieldset>

                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button class="btn btn-sm btn-primary margin-right-15"
                                                            type="submit">
                                                        <i class="fa fa-save"></i>
                                                        Save or update Twitter API Credential
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="li_api_credential">
                                    <form name="save_li_credential" id="save_li_credential" method="post"
                                          action="{{url(config('constant.smAdminSlug').'/setting/save_li_credential')}}"
                                          class="smart-form">
                                        {{csrf_field()}}
                                        <fieldset>
                                            <div class="form-group">
                                                <label class="toggle">
                                                    <input type="checkbox" name="li_api_enable"
													<?php echo SM::get_setting_value( 'li_api_enable' ) == 'on' ? 'checked="checked"' : ''; ?>>
                                                    <i data-swchon-text="ON" data-swchoff-text="OFF"></i>Enable Linkedin
                                                    API
                                                </label>
                                                <br>
                                            </div>
                                            <div class="form-group{{ $errors->has('li_client_id') ? ' has-error' : '' }}">
                                                <label class="label control-label" for="li_client_id">Linkedin Client
                                                    ID</label>
                                                <div class="input">
                                                    <input name="li_client_id" id="li_client_id" class="form-control"
                                                           placeholder="Linkedin Client ID" type="text" required=""
                                                           value="{{ old('li_client_id')!='' ? old('li_client_id') : SM::get_setting_value('li_client_id') }}">
                                                    @if ($errors->has('li_client_id'))
                                                        <span class="help-block">
                                 <strong>{{ $errors->first('li_client_id') }}</strong>
                              </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group{{ $errors->has('li_client_secret') ? ' has-error' : '' }}">
                                                <label class="label control-label" for="li_client_secret">Linkedin
                                                    Client Secret</label>
                                                <div class="input">
                                                    <input name="li_client_secret" id="li_client_secret"
                                                           class="form-control" placeholder="Linkedin Client Secret"
                                                           type="text" required=""
                                                           value="{{ old('li_client_secret')!='' ? old('li_client_secret') : SM::get_setting_value('li_client_secret') }}">
                                                    @if ($errors->has('li_client_secret'))
                                                        <span class="help-block">
                                 <strong>{{ $errors->first('li_client_secret') }}</strong>
                              </span>
                                                    @endif
                                                </div>
                                            </div>

                                        </fieldset>

                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button class="btn btn-sm btn-primary margin-right-15"
                                                            type="submit">
                                                        <i class="fa fa-save"></i>
                                                        Save or update Linkedin API Credential
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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


        </div>

        <!-- end row -->

    </section>
@endsection
