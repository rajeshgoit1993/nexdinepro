<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <style type="text/css">
    .login_form_new {
    --stripe: #00cbef;
    --bg: #00bee0;
    background: linear-gradient(
135deg
, var(--bg) 25%, transparent 25%) -50px 0, linear-gradient(
225deg
, var(--bg) 25%, transparent 25%) -50px 0, linear-gradient(
315deg
, var(--bg) 25%, transparent 25%), linear-gradient(
45deg
, var(--bg) 25%, transparent 25%);
    background-size: 100px 100px;
    background-color: var(--stripe);
    border: 1px solid #fff;
    box-shadow: 0 4px 8px 0 rgb(0 0 0 / 20%), 0 6px 20px 0 rgb(0 0 0 / 19%);
    -webkit-box-shadow: 0 4px 8px 0 rgb(0 0 0 / 20%), 0 6px 20px 0 rgb(0 0 0 / 19%);
    -moz-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
  </style>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <!-- Theme style -->
  <link href="{{ asset("/resources/assets/admin-lte/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
  <!-- iCheck -->
  <link href="{{ asset("/resources/assets/admin-lte/plugins/iCheck/square/blue.css")}}" rel="stylesheet" type="text/css" />
</head>
<body class="hold-transition login-page" style="background-image: url({{ asset("resources/img_bg.jpg") }});background-size: 100% ;background-repeat: no-repeat;overflow-y:hidden">
  
<div class="container" style="text-align:center">
 

<div class="login-box " style="width: 550px; margin-top: 100px !important;
    margin: auto;">
  
  <!-- /.login-logo -->

  <div class="login-box-body" >
    <div class="login_form_new" style="padding: 20px 50px">
    <div class="login-logo">
      <b style="color: white">NexDine Pro </b>
    </div>
    <hr>
    @if(session('error'))
    <div class="alert alert-danger">
    {{ session('error')}}
    </div>
    @endif
    
    <form action="{{URL::route('user_password_forget')}}" id="frmSignIn" method="post" class="needs-validation">
    {{csrf_field()}}

        <div style="margin-bottom: 25px" class="input-group">
          
            <input type="email" id="email" name="email" placeholder="E-mail Address" class="form-control" value="{{old('user_id')}}" required >
        </div>

      

      <div class="row">
        <!-- /.col -->
        

      <div class="col-md-8">
          <a href="{{ URL::to('/') }}" style="display: block;text-align: left;">Login ?</a>
        </div>
        <div class="col-md-4" >
          <input type="submit" class="btn btn-primary btn-block btn-flat" value="Submit" style="background: #ffba00 !important;font-size: 20px;
    color: black;
    font-weight: bold;">
        </div>
        <!-- /.col -->
      </div>

     
    </form>
    
    <!-- /.social-auth-links -->
    
  </div>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
</div>
</body>

<!-- jQuery 2.2.3 -->
   <script src="{{asset('/resources/assets/admin-lte/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.6 -->
    <script src="{{asset('/resources/assets/admin-lte/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- iCheck -->
   {{--  <script src='{{ asset ("/resources/assets/admin-lte/plugins/iCheck/icheck.min.js") }}'></script> --}}
<script>
  // $(function () {
  //   $('input').iCheck({
  //     checkboxClass: 'icheckbox_square-blue',
  //     radioClass: 'iradio_square-blue',
  //     increaseArea: '20%' // optional
  //   });
  // });
</script>
</html>
