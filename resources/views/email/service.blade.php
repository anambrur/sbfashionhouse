@extends('email.email_master')
@section("content")
    <h1 style="font-weight: 500; font-size: 24px; color: #1d2d5d; line-height: 27px;">
        Service Mail from {!! $info->full_name  !!}</h1>
    <p style="margin: 0;">Mobile : {!! $info->phone !!}</p>
    <p style="margin: 0;">Email : {!! $info->email !!}</p>
    <p style="margin: 0;">Service Required id: {!! $info->service_id !!}</p>
    <p style="margin: 0;">Service Required Title: {!! $info->service !!}</p>
@endsection