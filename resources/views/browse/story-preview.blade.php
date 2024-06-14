@extends('layout.app')
@include('layout.includes._header')

@push('style')
    <style>
        .chapter-body {
            line-height: 1.6;
            padding: 20px;
        }
    </style>
@endpush
@section('content')
    <!-- Full Screen Modal -->
    <div style="margin-top: 60px" class="main">
        <div class="modal-header justify-content-between">
            <div style="width: 500px;" class="modal-header-left">

                <button style="font-size: 30px;marin-left:30px;" class="not-btn">
                    <i class="bi bi-chevron-compact-left" onclick="history.back()">
                    </i>
                </button>

                <div style="margin-left: 20px" class="status">

                    <h5 class="modal-title">{{ $story->title }}</h5>
                    <small class="text-muted">
                        <span style="padding: 10px">by</span>{{ __($story->user->name) }}
                    </small>
                </div>
                @if ($chapters->isNotEmpty())
                    <div style="top:20px;" class="dropdown">
                        <button style="margin: 5px 0px 0px 50px;font-size:20px;" class="not-btn" type="button"
                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-chevron-compact-down"></i>
                        </button>
                        <div style="width: auto;padding:10px;margin-left:-80px;" class="dropdown-menu"
                            aria-labelledby="dropdownMenuButton">
                            <small class="text-muted p-2"> {{ $story->title }} (Table of Contents)</small>
                            <ul style="list-style: none;padding:0px;margin:0px;">
                                @foreach ($chapters as $index => $chapter)
                                    <li>
                                        <a class="dropdown-item chapter-link" href="#"
                                            data-story-id="{{ $story->id }}" data-chapter-id="{{ $chapter->id }}"
                                            data-chapter-index="{{ $index }}">
                                            Chapter {{ $index + 1 }}: {{ $chapter->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-2"></div>
                <!-- Right Column: Story Content -->
                <div class="col-md-9">
                    <div class="chapter-header">
                        <h5 id="chapter-title">
                            <!--Chapter heading  -->
                        </h5>
                        <div class="d-flex  mb-2">
                            <span class="me-3"><i class="bi bi-eye"></i>-</span>
                            <span class="me-3"><i class="bi bi-hand-thumbs-up"></i>-</span>
                            <span><i class="bi bi-chat"></i>-</span>
                        </div>
                    </div>
                    <hr>
                    @if ($chapters->isEmpty())
                        <p>No chapters available for this story.</p>
                    @else
                        <div style="text-align: justify;" id="chapter-content" class="chapter-body px-4">
                            {!! nl2br(e($story->content)) !!}
                        </div>
                        <div class="text-end mt-4">
                            <button id="next-chapter-btn" class="btn" style="display:none;">Next Chapter</button>
                        </div>
                    @endif
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
    </div>
    <!-- End Full Screen Modal-->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            function loadChapter(chapterLink) {
                var storyId = chapterLink.data('story-id');
                var chapterId = chapterLink.data('chapter-id');
                var chapterIndex = chapterLink.data('chapter-index');
                var url = `/stories/${storyId}/chapters/${chapterId}/content`;

                console.log(`Fetching content from URL: ${url}`);

                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(data) {
                        $('#chapter-title').text(`Chapter ${chapterIndex + 1}: ` + data.title);
                        $('#chapter-content').html('<p>' + data.content + '</p>');

                        // Show and configure the next chapter button
                        if (chapterIndex + 1 < {{ $chapters->count() }}) {
                            var nextChapter = $(
                                `.chapter-link[data-chapter-index=${chapterIndex + 1}]`);
                            $('#next-chapter-btn').show().off('click').on('click', function() {
                                nextChapter.trigger('click');
                            });
                        } else {
                            $('#next-chapter-btn').hide();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error(`Error fetching chapter content: ${textStatus}, ${errorThrown}`);
                        console.error(jqXHR.responseText);
                        alert('Error fetching chapter content. Check console for details.');
                    }
                });
            }

            $('.chapter-link').on('click', function(event) {
                event.preventDefault();
                loadChapter($(this));
            });

            // Trigger click on the first chapter link to load the first chapter initially
            if ($('.chapter-link').length > 0) {
                $('.chapter-link').first().trigger('click');
            }
        });
    </script>
@endpush
