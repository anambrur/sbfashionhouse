@extends("email.email_master")
@section("content")
    <h1 style="font-weight: 500; font-size: 24px; color: #1d2d5d; line-height: 27px;">
        Contact Mail from {{ $contact->fullname }}</h1>
    <p style="margin: 0;">Subject : {!! $contact->subject !!}</p>
    <p style="margin: 0;">Email : {!! $contact->email !!}</p>
    <p style="margin: 0;">Message: {!! $contact->message !!}</p>
@endsection