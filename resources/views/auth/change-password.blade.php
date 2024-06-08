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
                                    {{-- <h5 class="card-title text-center pb-0 fs-4">Change your password</h5> --}}
                                    <p class="text-center small">Create New Password</p>
                                </div>

                                @include('layout.includes._massage')

                                <form class="row g-3" action="" method="post">
                                    @csrf
                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" id="yourPassword"
                                            required>
                                    </div>
                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            id="yourPassword" required>
                                        <div style="color:red;font-size:12px;">{{ $errors->first('password') }}</div>
                                    </div>


                                    <div class="col-12">
                                        <button class="btn w-100" type="submit">Change Password</button>
                                    </div>
                                    <div class="col-12">
                                        <p class="small mb-0">Don't have account? <a href="{{ url('register') }}">Create an
                                                account</a></p>
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
