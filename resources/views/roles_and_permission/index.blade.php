@extends('layout.app')
@include('layout.includes._header')


@include('layout.includes._sidebar')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Roles and Permission</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item">{{ __(Auth::User()->type) }}</li>
                    <li class="breadcrumb-item active">{{ __('Roles') }}</li>
                </ol>
            </nav>
        </div>
        <!-- End Page Title -->
        <section class="section role-permission">
            <div class="card">

                <div class="card-body">
                    <h5 class="card-title">{{ 'Roles' }}</h5>

                    <a href="{{ url('dashboard/create-role') }}" class="btn btn-success">{{ __('Create Roles') }}</a>

                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <td>{{ __('Name') }}</td>
                                <td>{{ __('Actions') }}</td>
                            </tr>
                        </thead>
                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td>
                                    <a href="{{ url('dashboard/edit-role') }}/{{ $role->id }}"
                                        class="btn btn-success">{{ __('Edit') }}</a>
                                    <a href="{{ url('dashboard/delete-role') }}/{{ $role->id }}"
                                        class="btn btn-danger">{{ __('Delete') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </section>
    </main>
@endsection
