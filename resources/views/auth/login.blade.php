@extends('layout.app')
@section('content')
{{-- <div class="login-form-container">


  <form action="{{url('login')}}" method="POST">
    @csrf
      <h3>{{__('sign in')}}</h3>

      @include('layout.includes._massage')
      
      <input type="email" name="email" class="box" placeholder="{{__('Enter your email')}}" >
      
      <input type="password" name="password" class="box" placeholder="{{__('Enter your password')}}">
      <div class="checkbox">
          <input type="checkbox" name="remember" id="remember-me">
          <label for="remember-me"> remember me</label>
      </div>
      <input type="submit" value="sign in" class="btn">
      <p>forget password ? <a href="{{url('reset')}}">click here</a></p>
      <p>don't have an account ? <a href="{{url('register')}}" id="registration-btn">create one</a></p>
  </form>

</div> --}}

<div class="container">

  <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

          <div class="card mb-3">

            <div class="card-body">

              <div class="pt-4 pb-2">
                <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
              </div>
              @include('layout.includes._massage')
              <form class="row g-3 needs-validation" action="" method="post">
                @csrf
                <div class="col-12">
                  <label for="yourEmail" class="form-label">Email</label>
                  <div class="input-group has-validation">
                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                    <input type="email" name="email" class="form-control" id="yourEmail" required>
                  </div>
                </div>

                <div class="col-12">
                  <label for="yourPassword" class="form-label">Password</label>
                  <input type="password" name="password" class="form-control" id="yourPassword" required>
                </div>

                <div class="col-12">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember"  id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Remember me</label>
                  </div>
                </div>
                <div class="col-12">
                  <button class="btn btn-primary w-100" type="submit">Login</button>
                </div>
                <div class="col-12">
                  <p class="small mb-0">Don't have account? <a href="{{url('register')}}">Create an account</a></p>
                  <p class="small mb-0">You forgot your password ? <a href="{{url('reset')}}">Reset</a></p>
                </div>
              </form>

            </div>
          </div>

       

        </div>
      </div>
    </div>

  </section>

</div>
@endsection