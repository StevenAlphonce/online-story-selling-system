@extends('layout.app')
@include('layout.includes._header')
@section('content')
    <div style="margin-top: 50px;" class="container">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-2">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <div class="card mb-3">

                            <div class="card-body">

                                <div class="pt-4 pb-2">

                                </div>
                                @include('layout.includes._massage')
                                <form class="row g-3" action="" method="post">
                                    @csrf
                                    <div class="col-12">
                                        <label for="yourEmail" class="form-label">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                                            <input type="email" name="email"
                                                class="form-control {{ $errors->has('email') ? 'has-danger' : '' }}"
                                                required value="{{ old('mail') }}">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Password</label>
                                        <input type="password" name="password"
                                            class="form-control {{ $errors->has('password') ? 'has-danger' : '' }}"
                                            required>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                                            <label class="form-check-label" for="rememberMe">Remember me</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn w-100" type="submit">Login</button>
                                    </div>
                                    <div class="col-12">
                                        <p class="small mb-0">Don't have account? <a href="{{ url('register') }}">Create an
                                                account</a></p>
                                        <p class="small mb-0">You forgot your password ? <a
                                                href="{{ url('reset') }}">Reset</a></p>
                                    </div>
                                </form>

                            </div>
                        </div>



                    </div>
                </div>
            </div>

        </section>

    </div>
    @include('layout.includes._footer')
@endsection
