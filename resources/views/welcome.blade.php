@extends('layout.app')
@include('layout.includes._header')

@section('content')
    <section class="main-banner" id="banner">
        <div class="banner-text">
            <h3>{{ __('Home of Tanzania stories') }}</h3>
            <p>
                {{ __('If you’re a Tanzanian and need a platform to read or publish a story,') }}
                <br>
                {{ __('Online Selling System has great deals on a wide range of stories.') }}
            </p>
            <div class="banner-btn">
                <a href="{{ route('stories.all') }}"><span></span>{{ __('Start Reading') }}</a>
                <a href="{{ route('login') }}"><span></span>{{ __('Start Writting') }}</a>
            </div>
        </div>
    </section>
    @include('layout.includes._footer')
@endsection
