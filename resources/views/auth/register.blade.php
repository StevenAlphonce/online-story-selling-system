@extends('layout.app')
@section('content')
    <div class="container">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <div class="card mb-3">

                            <div class="card-body">

                                <div class="pt-4 pb-2">
                                    {{-- <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5> --}}
                                </div>

                                <form class="row g-3" method="post" action="{{ url('register') }}">
                                    @csrf
                                    <div class="col-12">
                                        <label for="yourName" class="form-label">Your Name</label>
                                        <input type="text" name="name" value="{{ old('name') }}"
                                            class="form-control" id="yourName" required>
                                        <div style="color: red;font-size:12px;">{{ $errors->first('name') }}</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourEmail" class="form-label">Your Email</label>
                                        <input type="email" name="email" value="{{ old('email') }}"
                                            class="form-control" id="yourEmail" required>
                                        <div style="color:red;font-size:12px;">{{ $errors->first('email') }}</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" id="yourPassword"
                                            required>
                                        <label for="yourPassword" class="form-label">Repeate Password</label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            id="yourPassword" required>
                                        <div style="color:red;font-size:12px;">{{ $errors->first('password') }}</div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" name="terms" type="checkbox" id="acceptTerms"
                                                required>
                                            <label class="form-check-label" for="acceptTerms">I agree and accept the <a
                                                    href="#">terms and conditions</a></label>
                                            <div style="color:red;font-size:12px;">{{ $errors->first('terms') }}</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn  w-100" type="submit">Create Account</button>
                                    </div>
                                    <div class="col-12">
                                        <p class="small mb-0">Already have an account? <a href="{{ url('login') }}">Log
                                                in</a></p>
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
