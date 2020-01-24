<strong>Thank you {{ $data['name'] }}</strong>
<hr>
<div style="background-color: @if($data['status'] == 1) green @else red @endif ; text-align: center">
   <h2>@if($data['status'] == 1) Successful @else Error @endif</h2>
</div>
<h3>YOUR ORDER TRACK CODE IS: <span>{{ $data['track'] }}</span></h3>
<span><a href="{{route('home')}}">{{ env('APP_NAME') }}</a></span>
<p><img src="{{ $message->embed(asset('images/site_logo.png')) }}" alt="logo"></p>