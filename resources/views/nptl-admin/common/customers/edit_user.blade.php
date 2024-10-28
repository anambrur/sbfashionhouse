@extends(('nptl-admin/master'))
@section('title','Edit Customer')
@section('content')
   @include(('nptl-admin/common/media/media_pop_up'))

<section id="widget-grid" class="">
   <!-- row -->
   <div class="row">
      {!! Form::model($user,["method"=>"patch","route"=>["updateCustomer",$user->id]]) !!}
      @include(('nptl-admin/common/customers/user_form'),['f_name'=>__("common.edit"), 'btn_name'=>__("common.update")])
      {!! Form::close() !!}
      <script type="text/javascript">
          $(document).ready(function () {
              $("#username").attr("disabled",true);
              $("#email").attr("disabled",true);
              if ($("#country").length > 0) {
                  $("#country").val('<?php echo $user->country; ?>');
                      <?php if($user->country!=''): ?>
                  var selectedCountryIndex = $("#country").find('option:selected').attr('data-id');
                  var state =$("#country").attr('data-state');
                  change_state(selectedCountryIndex, state);
                  <?php endif; ?>
              }
              if ($("#state").length > 0) {
                  $("#state").val('<?php echo $user->state; ?>');
              }
          });
      </script>
   </div>
   <!-- end row -->
</section>
@endsection