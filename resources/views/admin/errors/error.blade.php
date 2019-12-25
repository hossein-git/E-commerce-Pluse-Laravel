<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
   <meta charset="utf-8"/>
   <title>{{ $code }}</title>

   <meta name="description" content="User login page"/>
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
   <!-- bootstrap & fontawesome -->
   <link rel="stylesheet" href="{{asset('admin-assets/css/bootstrap.min.css')}}"/>
   <link rel="stylesheet" href="{{asset('admin-assets/font-awesome/4.5.0/css/font-awesome.min.css')}}"/>
   <!-- ace styles -->
   <link rel="stylesheet" href="{{asset('admin-assets/css/ace.min.css')}}"/>

</head>

<body>
<div class="main-container">
   <div class="main-content">
      <div class="row">
         <div class="col-sm-10 col-sm-offset-1">
            <div class="error-container">
               <div class="well">
                  <h1 class="grey lighter smaller">
            <span class="blue bigger-125">
               <i class="ace-icon fa fa-sitemap"></i>
               {{ $code }}
            </span><br><br>
                     {{ $error }}
                  </h1>

                  <hr/>
                  <h3 class="lighter smaller">For more information please contact Admin!</h3>

                  <div>
                     <div class="space"></div>
                     <h4 class="smaller">Try one of the following:</h4>

                     <ul class="list-unstyled spaced inline bigger-110 margin-15">
                        <li>
                           <i class="ace-icon fa fa-hand-o-right blue"></i>
                           Re-check the url for typos
                        </li>

                        <li>
                           <i class="ace-icon fa fa-hand-o-right blue"></i>
                           Read the faq
                        </li>

                        <li>
                           <i class="ace-icon fa fa-hand-o-right blue"></i>
                           Tell us about it
                        </li>
                     </ul>
                  </div>

                  <hr/>
                  <div class="space"></div>

                  <div class="center">
                     <a href="javascript:history.back()" class="btn btn-grey">
                        <i class="ace-icon fa fa-arrow-left"></i>
                        Go Back
                     </a>

                     <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                        <i class="ace-icon fa fa-tachometer"></i>
                        Dashboard
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</body>
</html>