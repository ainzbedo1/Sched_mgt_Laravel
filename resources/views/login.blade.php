<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <!--JavaScript-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>
            $(document).ready(function(){
                $(".message a").click(function() {
                  $("form").animate({ height: 'toggle', opacity: 'toggle' }, "slow");
                });
            });
        </script>
        <!-- Styles -->
        <style>
        @import url(https://fonts.googleapis.com/css?family=Roboto:300);
        html,body{
            height: 100%;
            width: 100%;
        }
        ::placeholder {
          color: #ffeeee;
          opacity: 0.50;
        }
        .login-page {
          width: 500px;
          height: 100%;
          padding: 2% 2% 2% 2%;
          margin-left: 120px;
        }
        .form {
          position: relative;
          z-index: 1;
          background: #363434;
          max-width: 500px;
          height: 100%;
          margin: 0 auto 0 auto;
          padding-top: 50px;
          padding-left: 15px;
          padding-right: 15px;
          text-align: center;
          box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
        }
        .form input {
          font-family: sans-serif;
          outline: 0;
          background: #363434;
          color: #ffcccc;
          width: 100%;
          border: none;
          margin: 0 0 15px;
          padding: 15px;
          box-sizing: border-box;
          font-size: 18px;
          -webkit-box-shadow: inset 0px 0px 3px 0px rgba(255,105,105,1);
          -moz-box-shadow: inset 0px 0px 3px 0px rgba(255,105,105,1);
          box-shadow: inset 0px 0px 3px 0px rgba(255,105,105,1);
        }
        .form button {
          font-family: sans-serif;
          text-transform: uppercase;
          outline: 0;
          background: #363434;
          width: 100%;
          border: 0;
          padding: 15px;
          color: #ff5f5f;
          font-size: 20px;
          -webkit-transition: all 0.3 ease;
          transition: all 0.3 ease;
          cursor: pointer;
          -webkit-box-shadow: 0px 0px 3px 0px rgba(255,105,105,1);
          -moz-box-shadow: 0px 0px 3px 0px rgba(255,105,105,1);
          box-shadow: 0px 0px 3px 0px rgba(255,105,105,1);
        }
        .form button:hover,.form button:active,.form button:focus {
          background: #ff5f5f;
          color: #ffffff;
        }
        .form .message {
          margin: 15px 0 0;
          color: #ffcccc;
          font-size: 18px;
        }
        .form .message a {
          color: #ff5f5f;
          text-decoration: none;
        }
        .form .register-form {
          display: none;
        }
        .container {
          position: relative;
          z-index: 1;
          max-width: 300px;
          margin: 0 auto;
        }
        .container:before, .container:after {
          content: "";
          display: block;
          clear: both;
        }
        .container .info {
          margin: 50px auto;
          text-align: center;
        }
        .container .info h1 {
          margin: 0 0 15px;
          padding: 0;
          font-size: 36px;
          font-weight: 300;
          color: #ff5959;
        }
        .container .info span {
          color: #4d4d4d;
          font-size: 12px;
        }
        .container .info span a {
          color: #000000;
          text-decoration: none;
        }
        .container .info span .fa {
          color: #EF3B3A;
        }
        body {
          background: #363434; /* fallback for old browsers */
          background: -webkit-linear-gradient(right, #363434, #363434);
          background: -moz-linear-gradient(right, #363434, #363434);
          background: -o-linear-gradient(right, #363434, #363434);
          background: linear-gradient(to left, #363434, #363434);
          font-family: sans-serif;
          -webkit-font-smoothing: antialiased;
          -moz-osx-font-smoothing: grayscale;      
        }
        </style>
    </head>
    <body>
       @if(isset(Auth::user()->email))
        <script>window.location="/main/successlogin";</script>
       @endif
      <div class = "row col-md-12" style="height:100%;">
        <div class = "col-md-8" id = "clipart_calendar" style="padding-top:70px; padding-left:50px;">
          <img src="/pics/calendar_cilpart.png" width="90%" height="60%" class="d-inline-block " alt=""/>
          <p style= "padding-left:50px;color:white;font-size:50px;font-family:calibri;color:#ffcccc;">Get Started. Try Now.</p>
        </div>
        <div class="login-page col-md-4">
          <div class="form" style="">
            <a class="message" href="{{ url('/main') }}" style="text-decoration: none;">
            <div style="color: #ffcccc; font-family: helvetica; font-size:25px;">SCHED MGT</div>
            <img src="/pics/calendar_icon.png" width="125" height="125" class="d-inline-block " alt=""/>
            </a>
            <div style="padding-top:30px;">
              <form class="register-form" method = "post" action = "{{ url('/main/register') }}">
                {{ csrf_field() }}
                <input type="text" name = "name" placeholder="name" />
                <input type="text" name = "username" placeholder="username" />
                <input type="text" name = "email" placeholder="email address" />
                <input type="password" name = "password" placeholder="password" />
                <input type="password" name = "password_confirmation" placeholder="confirm password" />
                <button type="submit" value="Register">create</button>
                <p class="message">Already registered? &nbsp;<a href="#">Sign In</a></p>
              </form>
              <form class="login-form" method = "post" action = "{{ url('/main/checklogin') }}">
              {{ csrf_field() }}
                <input type="text" name="email" placeholder="email:sample@example.com" />
                <input type="password" name = "password" placeholder="password:123" />
                <button type="submit" value="Login">login</button>
                <p class="message">Not registered? &nbsp;<a href="#">Create an account</a></p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </body>
</html>
