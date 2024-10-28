<!-- NEW WIDGET START -->
<article class="col-xs-12 col-sm-12 col-md-8 col-lg-8">

    <!-- Widget ID (each widget will need unique ID)-->
    <div class="jarviswidget" id="wid-add-front-user-main" data-widget-editbutton="false"
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
            <span class="widget-icon"> <i class="fa fa-user"></i> </span>
            <h2>{{ $f_name }} {{__("user.user")}}</h2>

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
                    <div class="col-sm-6">
                        <div class="sm-form {{ $errors->has('username') ? ' has-error' : '' }}">
                            {!! Form::label('username',__("user.username"))!!}
                            {!! Form::text('username', null,['required'=>'','class'=>'form-control', 'placeholder'=>__("user.username")]) !!}
                            @if ($errors->has('username'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('username') }}</strong>
                                 </span>
                            @endif
                            <span class="displayNone red username_wr">
                                 <strong>Username already exist!</strong>
                              </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sm-form{{ $errors->has('email') ? ' has-error' : '' }}">
                            {!! Form::label('email',__("user.email"))!!}
                            {!! Form::text('email', null,['required'=>'','class'=>'form-control', 'placeholder'=>__("user.email")]) !!}
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                 </span>
                            @endif
                            <span class="displayNone red email_wr">
                                 <strong>Email already exist!</strong>
                            </span>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-6">
                        <div class="sm-form{{ $errors->has('password') ? ' has-error' : '' }}">
                            {!! Form::label('password',__("user.password"))!!}
                            {!! Form::password('password', ['class'=>'form-control', 'placeholder'=>__("user.password")]) !!}
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                 </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sm-form{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            {!! Form::label('password_confirmation',__("user.passwordConfirmation"))!!}
                            {!! Form::password('password_confirmation', ['class'=>'form-control', 'placeholder'=>__("user.passwordConfirmation")]) !!}
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                 </span>
                            @endif
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-6">
                        <div class="sm-form{{ $errors->has('mobile') ? ' has-error' : '' }}">
                            {!! Form::label('mobile',__("user.mobile"))!!}
                            {!! Form::text('mobile', null,['id'=>'mobile','required'=>'','class'=>'form-control', 'placeholder'=>__("user.mobile")]) !!}
                            @if ($errors->has('mobile'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mobile') }}</strong>
                                 </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sm-form{{ $errors->has('mobile2') ? ' has-error' : '' }}">
                            {!! Form::label('mobile2',__("user.mobile2"))!!}
                            {!! Form::text('mobile2', null,['id'=>'mobile2','class'=>'form-control', 'placeholder'=>__("user.mobile2")]) !!}
                            @if ($errors->has('mobile2'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mobile2') }}</strong>
                                 </span>
                            @endif
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-6">
                        <div class="sm-form{{ $errors->has('skype') ? ' has-error' : '' }}">
                            {!! Form::label('skype',__("user.skype"))!!}
                            {!! Form::text('skype', null,['id'=>'skype','class'=>'form-control', 'placeholder'=>__("user.skype")]) !!}
                            @if ($errors->has('skype'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('skype') }}</strong>
                                 </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sm-form{{ $errors->has('whats_app') ? ' has-error' : '' }}">
                            {!! Form::label('whats_app',__("user.whatsapp"))!!}
                            {!! Form::text('whats_app', null,['id'=>'whats_app','class'=>'form-control', 'placeholder'=>__("user.whatsapp")]) !!}
                            @if ($errors->has('whats_app'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('whats_app') }}</strong>
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
    <div class="jarviswidget" id="wid-add-user-publish" data-widget-editbutton="false" data-widget-deletebutton="false">

        <header>
            <span class="widget-icon"> <i class="fa fa-save"></i> </span>
            <h2>User Publish</h2>

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
                <div class="sm-form{{ $errors->has('firstname') ? ' has-error' : '' }}">
                    {!! Form::label('firstname',__("user.firstname"))!!}
                    {!! Form::text('firstname', null,['required'=>'','class'=>'form-control', 'placeholder'=>__("user.firstname")]) !!}
                    @if ($errors->has('firstname'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('firstname') }}</strong>
                                 </span>
                    @endif
                </div>

                <div class="sm-form{{ $errors->has('lastname') ? ' has-error' : '' }}">
                    {!! Form::label('lastname',__("user.lastname"))!!}
                    {!! Form::text('lastname', null,['required'=>'','class'=>'form-control', 'placeholder'=>__("user.lastname")]) !!}
                    @if ($errors->has('lastname'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('lastname') }}</strong>
                                 </span>
                    @endif
                </div>


                <div class="form-group smart-form">
                    <label class="toggle">
						<?php
						$gender = ( isset( $user->gender ) && $user->gender == "Male" ) ? true : false;
						?>
                        {!! Form::checkbox('gender',"Male", $gender) !!}
                        <i data-swchon-text="Male" data-swchoff-text="Female"></i>Gender
                    </label>
                </div>
                <br>
                <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
					<?php
					$rolesArray = [];
					if ( count( $roles ) ) {
						foreach ( $roles as $role ) {
							$rolesArray[ $role->id ] = $role->name;
						}
					}
					?>
                    {!! Form::label('role_id', 'Role') !!}
                    {!! Form::select('role_id',$rolesArray, null,
                    ['required'=>'','class'=>'form-control']) !!}
                    @if ($errors->has('role_id'))
                        <span class="help-block">
                     <strong>{{ $errors->first('role_id') }}</strong>
                  </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                    {!! Form::label('status', 'Admin User Publication Status') !!}
                    {!! Form::select('status',['1'=>'Publish','2'=>'Pending / Draft', '3'=>'Cancel'],null,['required'=>'','class'=>'form-control']) !!}
                    @if ($errors->has('status'))
                        <span class="help-block">
                     <strong>{{ $errors->first('status') }}</strong>
                  </span>
                    @endif
                </div>

                <div class="form-group">
                    <button class="btn btn-success btn-block" type="submit">
                        <i class="fa fa-save"></i>
                        {{ $btn_name }} User
                    </button>
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
<article class="col-xs-12 col-sm-12 col-md-8 col-lg-8">

    <!-- Widget ID (each widget will need unique ID)-->
    <div class="jarviswidget" id="wid-add-user-contact" data-widget-editbutton="false"
         data-widget-deletebutton="false">

        <header>
            <span class="widget-icon"> <i class="fa fa-user"></i> </span>
            <h2>{{__("user.contactInfo")}}</h2>

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
                <div class="col-sm-6">
                    <div class="sm-form{{ $errors->has('street') ? ' has-error' : '' }}">
                        {!! Form::label('street',__("user.street"))!!}
                        {!! Form::text('street', null,['class'=>'form-control', 'placeholder'=>__("user.street")]) !!}
                        @if ($errors->has('street'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('street') }}</strong>
                                 </span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="sm-form{{ $errors->has('zip') ? ' has-error' : '' }}">
                        {!! Form::label('zip',__("user.zip"))!!}
                        {!! Form::number('zip', null,['class'=>'form-control', 'placeholder'=>__("user.zip")]) !!}
                        @if ($errors->has('zip'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('zip') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
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
                        <select name="country" id="country" class="form-control country p_complete" data-state="state"
                                required="" data-onload="<?php echo isset( $country ) ? $country : "" ?>">
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
                        {!! Form::text('city', null,['class'=>'form-control', 'placeholder'=>__("user.city")]) !!}
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
                        <select required="" name="state" id="state" class="form-control state p_complete" required=""
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
                    <div class="form-group{{ $errors->has('extra_note') ? ' has-error' : '' }}">
                        {!! Form::label('extra_note',__("user.extraNote"))!!}
                        {!! Form::textarea('extra_note', null,['class'=>'form-control ckeditor']) !!}
                        @if ($errors->has('extra_note'))
                            <span class="help-block">
                        <strong>{{ $errors->first('extra_note') }}</strong>
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
<!-- WIDGET END -->
<!-- NEW WIDGET START -->


<?php
if ( old( 'image' ) ) {
	$image = old( 'image' );
} elseif ( isset( $user->image ) ) {
	$image = $user->image;
} else {
	$image = '';
}
?>
@include(('nptl-admin/common/common/image_form'),['header_name'=>'User', 'image'=>$image])