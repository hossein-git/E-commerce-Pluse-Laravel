<h4>Track Order : {{ $order['code']  }}</h4>
<p>your orders  have being <b>{{ $order['status'] }}</b> to your address</p>

<strong>Thank you</strong>
<span><a href="{{route('home')}}">{{ env('APP_NAME') }}</a></span>
<p><img src="{{ $message->embed(asset('images/site_logo.png')) }}" alt="logo"></p>