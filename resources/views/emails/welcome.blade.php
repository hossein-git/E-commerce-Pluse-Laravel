<h2>Welcome {{ $name }}</h2>

<p>My profile <a href="{{ route('front.profile',auth()->id()) }}"></a></p>


<span><a href="{{route('home')}}">{{ env('APP_NAME') }}</a></span>
<p><img src="{{ $message->embed(asset('images/site_logo.png')) }}" alt="logo"></p>
