<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
   <meta charset="utf-8"/>
   <title>Login Page</title>

   <meta name="description" content="User login page"/>
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
   <!-- bootstrap & fontawesome -->
   <link rel="stylesheet" href="{{asset('admin-assets/css/bootstrap.min.css')}}"/>
   <link rel="stylesheet" href="{{asset('admin-assets/font-awesome/4.5.0/css/font-awesome.min.css')}}"/>
   <!-- ace styles -->
   <link rel="stylesheet" href="{{asset('admin-assets/css/ace.min.css')}}"/>

</head>

<body class="login-layout">
<div class="main-container">
   <div class="main-content">
      <div class="row">
         <div class="col-sm-10 col-sm-offset-1">
            <div class="login-container">
               <div class="center">
                  <h1>
                     <i class="ace-icon fa fa-leaf green"></i>
                     <span class="red">{{ env('APP_NAME') }}</span>
                     <span class="white" id="id-text2">Application</span>
                  </h1>
                  <h4 class="blue" id="id-company-text">&copy; ARIYAN NET</h4>
               </div>

               <div class="space-30"></div>

               <div class="position-relative">
                  <div id="login-box" class="login-box visible widget-box no-border">
                     <div class="widget-body">
                        <div class="widget-main">
                           <h4 class="header blue lighter bigger">
                              <i class="ace-icon fa fa-coffee green"></i>
                              Please Enter Your Information
                           </h4>

                           <div class="space-6"></div>


                           <form action="{{ route('login') }}" method="post">
                              @csrf
                              <fieldset class="" >
                                 <div class="@error('email') has-error @enderror">
                                    <label class="block clearfix ">
                                    <span class="block input-icon input-icon-right">
                                       <input type="email" class="form-control" placeholder="Email" name="email" required/>
                                       <i class="ace-icon fa fa-user"></i>
                                        @error('email')
                                          <span class="form-control-hint" role="alert">
                                          <strong class="text-danger">{{ $message }}</strong></span>
                                        @enderror
                                    </span>
                                    </label>
                                 </div>

                                 <div class="@error('password') has-error @enderror">
                                    <label class="block clearfix">
                                    <span class="block input-icon input-icon-right">
                                       <input type="password" class="form-control" placeholder="Password"
                                              name="password" required/>
                                       <i class="ace-icon fa fa-lock"></i>
                                    </span>
                                       @error('password')
                                       <span class="form-control-hint" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                       @enderror
                                    </label>

                                 </div>



                                 <div class="space"></div>

                                 <div class="clearfix center">
                                    <button type="submit" class=" btn btn-lg btn-primary">
                                       <i class="ace-icon fa fa-key"></i>
                                       <span class="bigger-110">Login</span>
                                    </button>
                                 </div>

                                 <div class="space-4"></div>
                              </fieldset>
                           </form>

                           <div class="social-or-login center">
                              {{--                              <span class="bigger-110">Or Login Using</span>--}}
                           </div>

                           <div class="space-6"></div>
                        </div><!-- /.widget-main -->
                     </div><!-- /.widget-body -->
                  </div><!-- /.login-box -->
               </div><!-- /.position-relative -->
            </div>
         </div><!-- /.col -->
      </div><!-- /.row -->
   </div><!-- /.main-content -->
</div><!-- /.main-container -->

</body>

</html>
