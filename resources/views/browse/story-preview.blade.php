@extends('layout.app')
@include('layout.includes._header')

@push('style')
    <style>
        .chapter-body {
            line-height: 1.6;
            padding-right: 45px;
        }

        .toc {
            padding: 20px;
            background-color: #f8f9fa;
            border-right: 1px solid #ddd;
        }

        .toc ul {
            list-style-type: none;
            padding: 0;
        }

        .toc li {
            cursor: pointer;
            margin-bottom: 5px;
        }

        .buy-btn {
            float: inline-end;
            font-size: small;
            color: var(--green);
            border: solid var(--light) 1px;
        }

        .chapter-content {
            padding: 20px;
            text-align: justify;
        }

        .blurred {
            filter: blur(5px);
            pointer-events: none;
        }
    </style>
@endpush

@section('content')
    <!-- Full Screen Modal -->
    <div style="margin-top: 60px" class="main">

        <div class="modal-header justify-content-between">
            <!-- The story reading modal-header-left -->
            <div style="width: 500px;" class="modal-header-left">

                <button style="font-size: 30px;marin-left:30px;" class="not-btn">
                    <i class="bi bi-chevron-compact-left" onclick="history.back()"></i>
                </button>

                <div style="margin-left: 20px" class="status">
                    <h5 class="modal-title">{{ $story->title }}</h5>
                    <small class="text-muted">
                        <span style="padding: 10px">by</span>{{ __($story->user->name) }}
                    </small>
                </div>
            </div>

            <div class="modal-header-right">
                <button class="vote not-btn" id="vote-button" data-chapter-id="#" class="btn btn-primary"><i
                        class="bi bi-star"></i>
                    <span class="text">Vote</span>
                </button>
            </div>
        </div>

        <div class="container-fluid mt-2">
            <div class="row">
                <!-- Table of Contents -->
                <div class="col-md-4 toc">
                    <h5>{{ $story->title }} Table of Contents</h5>
                    <p>{!! $story->description !!}</p>
                    <ul id="toc-list">
                        @foreach ($chapters as $index => $chapter)
                            <li data-chapter-index="{{ $index }}">
                                <span>{{ $index + 1 }}</span> {{ $chapter->title }}
                                <span style="color:green; margin-left:30px;padding:5px;font-weight:bolder;">
                                    Tsh {{ $chapter->price->price }} /=
                                </span>
                                <form action="{{ route('paypal') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="chapter_id" value="{{ $chapter->id }}" />
                                    <input type="hidden" name="price" value="{{ $chapter->price->price ?? 0 }}" />
                                    <button
                                        style="background-color:green;border-radius:9px; color:white; margin-left:30px; margin-top:-25px;padding:5px;"
                                        type="submit" class="buy-btn">{{ 'Buy Now' }}</button>
                                </form>
                                <hr>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <!-- Chapter Content -->
                <div class="col-md-8 chapter-content">
                    <!-- Chapter Details will be loaded here dynamically -->
                </div>
            </div>
        </div>
        <!-- End Full Screen Modal -->
    @endsection

    @push('scripts')
        <script>
            // Function to load chapter details based on index
            function loadChapter(index) {
                var chapter = @json($chapters);
                var selectedChapter = chapter[index];
                var chapterContent = `
                <div class="chapter-header">
                    <h2>${selectedChapter.title}</h2>
                    <div class="chapter-stat d-flex text-center">
                        <div class="me-3"><i class="bi bi-eye"></i> <span>{{ $visitors }}</span></div>
                        <div class="me-3"><i class="bi bi-hand-thumbs-up"></i> <span>${selectedChapter.likes}</span></div>
                    </div>
                    <hr>
                    <div class="chapter-body">
                        ${selectedChapter.content}
                    </div>
                </div>
            `;
                $('.chapter-content').html(chapterContent);
            }

            // Initialize first chapter load
            $(document).ready(function() {
                loadChapter(0); // Load first chapter by default

                // Handle click on TOC items
                $('#toc-list li').click(function() {
                    var index = $(this).data('chapter-index');
                    loadChapter(index);
                });
            });
        </script>
    @endpush
