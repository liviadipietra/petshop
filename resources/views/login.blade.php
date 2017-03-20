@extends('layouts.app')
@section('content')
<!-- Display Validation Errors -->


<!-- New Task Form -->
<div class="row">
  <div class="Absolute-Center is-Responsive">
    <div class="col-sm-12 col-md-10 col-md-offset-1">
      <form action="/login" method="POST" class="form-signin">
         {{ csrf_field() }}
        <div class="form-group input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
          <input class="form-control" type="email" name='email' placeholder="E-mail" />
        </div>
        <div class="form-group input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
          <input class="form-control" type="password" name='password' placeholder="Senha" />
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-def btn-block btn-lg btn-primary">Login</button>
        </div>
        <div class="form-group text-center">
          <a class="nav-link" href="{{ url('/registrar') }}">Cadastre-se</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
