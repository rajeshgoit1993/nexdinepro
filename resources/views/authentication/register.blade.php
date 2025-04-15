<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Register</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link href="{{asset('/resources/assets/admin-lte/bower_components/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link href="{{ asset("/resources/assets/admin-lte/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
  <!-- iCheck -->
  <link href="{{ asset("/resources/assets/admin-lte/plugins/iCheck/square/blue.css")}}" rel="stylesheet" type="text/css" />

</head>
<body class="hold-transition register-page" style="background-image: url({{ asset("/resources/grass-and-the-sky-background.jpg") }});background-size: 100%;background-repeat: no-repeat;">
<div class="register-box">
  

  <div class="register-box-body">
    <div class="login-logo">
      <b>New </b> User Registration</a>
    </div>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif 

    <form action="{{URL::to('/register')}}" class="form-horizontal" method="POST" >
        {{csrf_field()}}
        <div style="margin-bottom: 25px" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
            <input type="email" id="email" name="email" placeholder="Email" value='{{old('email')}}' class="form-control">
        </div>
        <div style="margin-bottom: 25px" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input type="text" id="firstName" name="first_name" placeholder="First Name" class="form-control" >
        </div>
        <div style="margin-bottom: 25px" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input type="text" id="lastName" name="last_name" placeholder="Last Name" class="form-control" >
        </div>
      
        <div style="margin-bottom: 25px" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input type="password" name="password" id="password" placeholder="Password" class="form-control" >
        </div>
        <div style="margin-bottom: 25px" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input type="password" name="password_confirmation" id="password2" placeholder="Password Confirmation" class="form-control" >
        </div>  
        <div class="row">
        <div class="col-xs-4">
           <input type="submit" class="btn btn-primary btn-block btn-flat" value="SignUp">
        </div>
        <div class="col-xs-4">
          <a href="{{ URL::to('/admin') }}" class="btn btn-primary btn-block btn-flat pull-right">SignIn</a>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->
<!-- jQuery 2.2.3 -->
    <script src="{{asset('/resources/assets/admin-lte/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.6 -->
    <script src="{{asset('/resources/assets/admin-lte/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

<!-- iCheck -->
    <script src='{{ asset ("/resources/assets/admin-lte/plugins/iCheck/icheck.min.js") }}'></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>