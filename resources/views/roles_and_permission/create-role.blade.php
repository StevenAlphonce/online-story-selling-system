@extends('layout.app')

@include('layout.includes._header')

@include('layout.includes._sidebar')

@section('head')
    <style>
        .table {
            width: 50%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Style for checkboxes */
        .styled-checkbox {
            position: relative;
            cursor: pointer;
            display: inline-block;
        }

        .styled-checkbox input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 20px;
            width: 20px;
            background-color: #eee;
            border: 1px solid #ccc;
        }

        .styled-checkbox input:checked+.checkmark:after {
            content: "";
            position: absolute;
            display: block;
            left: 6px;
            top: 2px;
            width: 6px;
            height: 12px;
            border: solid #333;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
    </style>
@endsection

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Create Roles</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item">{{ __(Auth::User()->type) }}</li>
                    <li class="breadcrumb-item active">{{ __('Create Role') }}</li>
                </ol>
            </nav>
        </div>
        <!-- End Page Title -->

        <section class="section">

            <div class="card">
                <div class="card-body">

                    <h5 class="card-title">{{ __('Create New Role') }}</h5>

                    <form method="POST" action="{{ url('dashboard/add-role') }}">
                        @csrf
                        <label for="name">{{ __('New Role Name') }}</label>

                        <input type="text" required name="name" class="form-control"
                            placeholder="{{ __('Example:Author') }}" />


                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="card-title">{{ __('Permissions') }}</h5>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Permission') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissions as $permission)
                                            <tr>
                                                <td>{{ $permission->name }}</td>
                                                <td class="styled-checkbox">
                                                    <input type="checkbox" value="{{ $permission->name }}"
                                                        name="permission[]" id="permission_{{ $permission->id }}" />
                                                    <label class="checkmark"
                                                        for="permission_{{ $permission->id }}"></label>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>


                            <div class="col-md-4">
                                <h5 class="card-title">{{ __('Select user\'s type') }}</h1>

                                    <label for="userTypes">{{ __('Users Type') }}</label>
                                    <select class="form-control" name="types[]" id="type" multiple>
                                        @foreach ($userTypes as $userType)
                                            <option value="{{ $userType }}">{{ ucfirst($userType) }}</option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>

                        <input type="submit" class="btn btn-success" value="{{ __('Save') }}" />
                    </form>
                </div>
            </div>
        </section>

    </main>
@endsection
