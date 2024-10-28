@extends("email.email_master")
@section("content")
    @if($info->isAlreadySubscribed==0)
        <h1 style="font-weight: 700; font-size: 24px; color: #1d2d5d; line-height: 27px;">Need to Confirm
            Subscription.</h1>
        <p>Please confirm your subscription by
            <a target="_blank" style="color: #f68c26" href="{!! url('subscribe-confirmation/'.urlencode($info->email)) !!}">
                Clicking here
            </a>.
            Or copy this link to browser {!! url('subscribe-confirmation/'.urlencode($info->email)) !!}
        </p>
        <p>
            Thank you again!
        </p>
    @else
        <h1 style="font-weight: 700; font-size: 24px; color: #1d2d5d; line-height: 27px;">
            Thank you for subscribe to newsletter.
        </h1>
        <p>Your subscription has been confirmed. If at any time you wish to stop receiving our
            newsletter, you can click on the <a style="#f68c26" target="_blank"
                                                href="{!! url('unsubscribe/'.urlencode($info->email)) !!}">Unsubscribe</a>
            link in the bottom of newsletter.
        </p>
        <p>
            Thank you again!
        </p>
    @endif
@endsection