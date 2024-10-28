@extends("email.email_master")
@section("content")
    @isset($info->subject)
        <h1 style="font-weight: 500; font-size: 24px; color: #1d2d5d; line-height: 27px;">{{ $info->subject }}</h1>
    @endisset
    <p style="margin: 0;">Message: {!! $info->message !!}</p>
@endsection