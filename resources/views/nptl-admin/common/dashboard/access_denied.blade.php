@extends(('nptl-admin/master'))
@section('title','Access denied')
@section('content')
<div class="warning">
   <i class="fa fa-warning"></i>
   <h1>OPPS!<br>{{__('access_denied.access_denied_main')}}<br>{{__('access_denied.access_denied_sub')}}</h1>
</div>
@endsection