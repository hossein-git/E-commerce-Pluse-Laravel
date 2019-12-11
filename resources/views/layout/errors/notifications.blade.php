{{--{{ dd(session()->all()) }}--}}
@if(session('success'))
    <!--mesg-->
    <div class="alert alert-success text-center text-capitalize">
        <p>{{ session('success')  }}</p>
    </div>
@endif

@if(session('error'))
    <!--mesg-->
    <div class="alert alert-danger text-center text-capitalize">
        <p>{{ session('error')  }}</p>
    </div>
@endif

@if($errors->any())
    <!--alert-->
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>

@endif
<!-- fro ajax errors -->
@if(env('APP_AJAX'))
<div class="alert alert-danger" id="error_result" style="display:none">
    <ul id="">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<img alt="" src="{{ asset('admin-assets/5.gif') }}" class="preview" style="position: fixed;z-index: 999;height: 12em; width: 12em;overflow: visible;margin: auto; top: 0;left: 0;bottom: 0;right: 0;display: none">