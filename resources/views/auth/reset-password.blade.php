
@extends('layout.app')
@section('content')
{{-- <div class="registration-form-container">
  <form action="" method="post">
    @csrf
      <h3>{{__('Reset password')}}</h3>

      @include('layout.includes._massage')
    
      <input type="email" name="email" value="{{old('email')}}" class="box form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{__('Email')}}">

      <input type="submit" value="Reset Password" class="btn">
      <p>{{__('You have an account ? ')}}<a href="{{url('login')}}" id="login-btn">{{__('Login')}}</a></p>
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
                <h5 class="card-title text-center pb-0 fs-4">Recover your Account</h5>
                <p class="text-center small">Enter your email to reset your password</p>
              </div>
              @include('layout.includes._massage')
              <form class="row g-3 needs-validation" action="" method="post">
                @csrf
                <div class="col-12">
                  <label for="yourEmail" class="form-label">Email</label>
                  <input type="email" name="email" class="form-control" id="yourEmail" required>
                </div>

              
                <div class="col-12">
                  <button class="btn btn-primary w-100" type="submit">Reset Password</button>
                </div>
                <div class="col-12">
                  <p class="small mb-0">Don't have account? <a href="{{url('register')}}">Create an account</a></p>
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
