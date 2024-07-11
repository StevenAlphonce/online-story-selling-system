@extends('layout.app')
@include('layout.includes._header')

@section('content')
    <main class="container" style="margin-top:100px;">

        <section style="margin-top: 50px;" class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-md-12">

                    <div class="row">
                        <!-- Sales Card -->
                        <div class="col-xxl-4 col-md-6">

                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title">Customers</h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>
                                                @foreach ($purchaseStats as $storyTitle => $userCount)
                                                    <tr>

                                                        <td>{{ $userCount }}</td>
                                                    </tr>
                                                @endforeach
                                            </h6>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div><!-- End Sales Card -->

                        <!-- Revenue Card -->
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card revenue-card">

                                <div class="card-body">
                                    <h5 class="card-title">Revenue</h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-currency-dollar"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>${{ $formattedTotalEarned }}</h6>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Revenue Card -->
                    </div>
                </div><!-- End Left side columns -->



            </div>
        </section>
    </main>
@endsection
