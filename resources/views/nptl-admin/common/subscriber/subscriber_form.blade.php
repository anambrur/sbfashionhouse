<!-- NEW WIDGET START -->
<div class="col-sm-12">
    <article class="col-xs-12 col-sm-12 col-md-8 col-lg-8">

        <!-- Widget ID (each widget will need unique ID)-->
        <div class="jarviswidget" id="wid-add-tag-main" data-widget-editbutton="false"
             data-widget-deletebutton="false">
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
                <span class="widget-icon"> <i class="fa fa-building"></i> </span>
                <h2>{{ $f_name }} Subscriber</h2>

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
                <div class="widget-body padding-10">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                {!! Form::label('email','Email')!!}
                                {!! Form::text('email', null,['class'=>'form-control']) !!}
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                 </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                                {!! Form::label('firstname','First Name')!!}
                                {!! Form::text('firstname', null,['class'=>'form-control']) !!}
                                @if ($errors->has('firstname'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('firstname') }}</strong>
                                 </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                                {!! Form::label('lastname','Last Name')!!}
                                {!! Form::text('lastname', null,['class'=>'form-control']) !!}
                                @if ($errors->has('lastname'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('lastname') }}</strong>
                                 </span>
                                @endif
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
    <!-- NEW WIDGET START -->
    <article class="col-xs-12 col-sm-12 col-md-4 col-lg-4">

        <!-- Widget ID (each widget will need unique ID)-->
        <div class="jarviswidget" id="wid-id-tag-publish" data-widget-editbutton="false"
             data-widget-deletebutton="false">

            <header>
                <span class="widget-icon"> <i class="fa fa-save"></i> </span>
                <h2>Subscriber Publish</h2>

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
                <div class="widget-body padding-10">
					<?php
					$permission = SM::current_user_permission_array();
					if (SM::is_admin() || isset( $permission ) && isset( $permission['subscribers']['tag_status_update'] ) && $permission['subscribers']['tag_status_update'] == 1)
					{
					?>
                    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                        {!! Form::label('status', 'Subscription Status') !!}
                        {!! Form::select('status',['1'=>'Subscribed','0'=>'Unsubscribed'], null, ['required'=>'','class'=>'form-control']) !!}
                        @if ($errors->has('status'))
                            <span class="help-block">
                             <strong>{{ $errors->first('status') }}</strong>
                          </span>
                        @endif
                    </div>
					<?php
					}
					?>
                    <div class="form-group">
                        <button class="btn btn-success btn-block" type="submit">
                            <i class="fa fa-save"></i>
                            {{ $btn_name }} Subscriber
                        </button>
                    </div>

                </div>
                <!-- end widget content -->

            </div>
            <!-- end widget div -->

        </div>
        <!-- end widget -->

    </article>
</div>
<!-- WIDGET END -->
<div class="col-sm-12">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

        <!-- Widget ID (each widget will need unique ID)-->
        <div class="jarviswidget" id="wid-addCustomer-contact" data-widget-editbutton="false"
             data-widget-deletebutton="false">

            <header>
                <span class="widget-icon"> <i class="fa fa-map-marker"></i> </span>
                <h2>Subscriber Location Info</h2>

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
                <div class="widget-body padding-10">
                    <div class="col-sm-4">
						<?php
						$cn = array();
						$countries = SM::$countries;
						$i = 1;
						foreach ( $countries as $country_name ) {
							//                                 if (in_array($i, array(17, 18, 19, 20)))
							//                                 {
							$cn[ $country_name ] = $country_name;
							//                                 }
							$i ++;
						}
						?>
                        <div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
                            {!! Form::label('country', __("user.country")) !!}
                            <select name="country" id="country" class="form-control country p_complete"
                                    data-state="state" data-onload="<?php echo isset( $country ) ? $country : "" ?>">
                                <option value="">Select Your Country</option>
								<?php
								$countries = SM::$countries;
								$i = 1;
								foreach ($countries as $country_name)
								{
								//                                 if (in_array($i, array(17, 18, 19, 20)))
								//                                 {
								?>
                                <option value="<?php echo $country_name; ?>"
                                        data-id="<?php echo $i; ?>"><?php echo $country_name; ?></option>
								<?php
								//                                 }
								$i ++;
								}
								?>
                            </select>
                            @if ($errors->has('country'))
                                <span class="help-block">
                             <strong>{{ $errors->first('country') }}</strong>
                          </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="sm-form{{ $errors->has('city') ? ' has-error' : '' }}">
                            {!! Form::label('city',__("user.city"))!!}
                            {!! Form::text('city', null,['class'=>'form-control','required'=>'', 'placeholder'=>__("user.city")]) !!}
                            @if ($errors->has('city'))
                                <span class="help-block">
                                <strong>{{ $errors->first('city') }}</strong>
                             </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group {{ $errors->has('state') ? ' has-error' : '' }}">
                            {!! Form::label('state', __("user.state")) !!}
                            <select required="" name="state" id="state" class="form-control state p_complete"
                                    data-onload="<?php echo isset( $state ) ? $state : ""; ?>">
                                <option value="#">Select State / Province</option>
                            </select>
                            @if ($errors->has('state'))
                                <span class="help-block">
                             <strong>{{ $errors->first('state') }}</strong>
                          </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group{{ $errors->has('extra') ? ' has-error' : '' }}">
                            {!! Form::label('extra',__("user.extraNote"))!!}
                            {!! Form::textarea('extra', null,['class'=>'form-control']) !!}
                            @if ($errors->has('extra'))
                                <span class="help-block">
                        <strong>{{ $errors->first('extra') }}</strong>
                     </span>
                            @endif
                        </div>
                    </div>


                </div>
                <!-- end widget content -->

            </div>
            <!-- end widget div -->

        </div>
        <!-- end widget -->

    </article>
</div>