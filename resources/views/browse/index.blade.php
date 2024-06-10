@extends('layout.app')
@include('layout.includes._header')

@section('content')
    <main style="margin-top: 100px" class="container">
        <div class="card">

            <div class="row card-body">
                @foreach ($stories as $story)
                    {{-- @if ($stories->count() == 0)
                        <div class="story-category-single col-md-12">
                            <p class=" card-title h5">{{ __('We dont find any Story on this Category right now!') }}</p>
                        </div>
                    @else --}}
                    <div class="story-category-single col-12 col-md-6 mt-4">
                        <div class="row">
                            <div class="col-4 col-md-3">
                                <div class="story-category-cover">
                                    <img src="{{ asset('storage/' . $story->cover) }}" class="img-fluid" alt="Story Image">
                                    {{-- <span
                    class="category-iteretor position-absolute  top-10 start-0 badge bg-danger rounded-pill m-2">
                    {{ $loop->iteration }}
                </span> --}}
                                </div>
                            </div>
                            <div class="col-8 col-md-9">
                                <div class="story-category-description mt-1">
                                    <a href="{{ route('story.show', $story->id) }}"
                                        class="card-title h5">{{ $story->title }} ({{ $story->status }})</a>
                                    <p class="text-muted mb-1 small">by {{ $story->user->name }}</p>
                                    <div class="row story-category-status">
                                        <span>
                                            <i class="bi bi-eye"></i>
                                            {{ $story->views }}
                                        </span>
                                        <span>
                                            <i class="bi bi-heart"></i>
                                            {{ $story->likes }}
                                        </span>
                                        <span>
                                            <i class="bi bi-chat-dots"></i>
                                            {{ $story->comments }}
                                        </span>
                                    </div>

                                    <small
                                        class="card-text story-category-desc">{{ Str::limit($story->description, 200) }}</small>
                                    <div class="story-tags mt-1">
                                        @foreach (array_slice(explode(',', $story->tags), 0, 3) as $tag)
                                            <span class="badge bg-secondary">{{ $tag }}</span>
                                        @endforeach
                                        @if (count(explode(',', $story->tags)) > 4)
                                            <span class="text-muted">+{{ count(explode(',', $story->tags)) - 4 }}
                                                more</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- @endif --}}
                @endforeach
            </div>
        </div>
        </section>
        @include('layout.includes._footer')
    @endsection
