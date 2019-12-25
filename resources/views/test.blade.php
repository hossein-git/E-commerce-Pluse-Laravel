@extends('layout.front.index' )
@section('title')
   test
@stop
@section('extra_css')
   <style>
      show {
         width: 400px;
         height: 400px;
      }

      .small-img {
         width: 350px;
         height: 70px;
         margin-top: 10px;
         position: relative;
         left: 25px;
      }

      .small-img .icon-left, .small-img .icon-right {
         width: 12px;
         height: 24px;
         cursor: pointer;
         position: absolute;
         top: 0;
         bottom: 0;
         margin: auto 0;
      }

      .small-img .icon-left { transform: rotate(180deg) }

      .small-img .icon-right { right: 0; }

      .small-img .icon-left:hover, .small-img .icon-right:hover { opacity: .5; }

      .small-container {
         width: 310px;
         height: 70px;
         overflow: hidden;
         position: absolute;
         left: 0;
         right: 0;
         margin: 0 auto;
      }

      .small-container div {
         width: 800%;
         position: relative;
      }

      .small-container .show-small-img {
         width: 70px;
         height: 70px;
         margin-right: 6px;
         cursor: pointer;
         float: left;
      }

      .small-container .show-small-img:last-of-type { margin-right: 0; }
   </style>
@stop
@section('content')
   <div class="show" href="{{ $pp->cover }}">
      <img src="{{ $pp->cover }}" id="show-img" >
   </div>

   <div class="small-img">
      <img src="images/online_icon_right@2x.png" class="icon-left" alt="" id="prev-img">

      <div class="small-container">
         <div id="small-img-roll">
            @foreach($pp->photos as $f)
               <img src="{{ $f->src }}" class="show-small-img" alt="">

               @endforeach
         </div>
      </div>
      <img src="images/online_icon_right@2x.png" class="icon-right" alt="" id="next-img">
   </div>
@endsection
@section('extra_js')


@stop