@extends('layouts.applogin')

@section('content')
  <div class="panel-login">
    <center><img style="width: 200px;" src="{{ URL::asset('images/qshop.png') }}" alt=""></center>
    <br>

    <div class="container-fluid">
      <div class="panel panel-default col-sm-12">
        <div class="panel-body">

          <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
              <label for="username">Username</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="glyphicon glyphicon-user"></i></span>
                </div>
                <input id="username" type="text" placeholder="Username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>

                @if ($errors->has('username'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                @endif

              </div>
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="glyphicon glyphicon-lock"></i></span>
                </div>

                <input placeholder="Password" id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
              </div>
            </div>

            <div class="form-group">
              <div class="custom-control custom-checkbox">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="custom-control-label" for="remember">Remember me</label>
              </div>

            </div>
            <br>
              <div class="row">

                <div class="col-sm-7  offset-sm-4">
                  <button type="submit" name="login" class="btn btn btn-outline-primary">
                    <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>
                      &nbsp; Login
                  </button>
                </div>
              </div>
          </form>

        </div>
      </div>
    </div>


  <br>
  <p class="text-center"> Applikasi Penjualan &copy; 2018 by Aldi </p>

  <hr style="border-color:#999; border-style:dashed;">
  </div>
@endsection
