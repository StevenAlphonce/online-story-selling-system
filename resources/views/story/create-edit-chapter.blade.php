@extends('layout.app')
@include('layout.includes._header')

@section('content')
    <!-- Full Screen Modal -->

    <div class="modal-dialog">
        <div class="modal-content">
            <div style="top:60;" class="modal-header  justify-content-between">
                <div class="modal-header-left">
                    <div class="back">
                        <a href="{{ route('story.edit', $story->id) }}">
                            <i class="bi bi-chevron-compact-left"></i>
                        </a>
                    </div>
                    <div class="status">
                        <span class="text-muted">{{ __($story->title) }}</span>
                        <h3 class="modal-title">{{ __($isEdit ? $chapter->title : 'Untitled Chapter') }}</h3>
                    </div>
                </div>
                <div class="modal-header-right">
                    <a href="#" class="btn cancel" onclick="submitForm(false)">{{ __('Publish') }}</a>
                    <a style="width:auto;" href="{{ route('story.edit', $story->id) }}"
                        class="btn skip">{{ __('Continue Later') }}</a>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div style="margin-top: 70px;" class="modal-form-wrapper card pt-4">
                            <div class="card-body">
                                <form class="form" method="POST" id="chapter-form"
                                    action="{{ $isEdit ? route('chapter.update', ['story' => $story->id, 'chapter' => $chapter->id]) : route('chapter.store', ['story' => $story->id]) }}">
                                    @csrf

                                    @if ($isEdit)
                                        @method('PUT')
                                    @endif
                                    <div class="col-md-12 mb-4">
                                        <input class="form-control" name="title" type="text"
                                            placeholder="Chapter Title"
                                            value="{{ $isEdit ? $chapter->title : old('title') }}" required>
                                        @if ($errors->has('title'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <div id="quill-editor" class="mb-3" style="height: 500px;"></div>
                                        <textarea rows="3" class="mb-3 d-none" name="content" id="quill-editor-area">
                                            {!! old('content', $isEdit ? $chapter->content : '') !!}
                                        </textarea>

                                        @if ($errors->has('content'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('content') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <!-- End Quill Editor Default -->

                                    <div class="form-check mb-4">
                                        <input type="hidden" name="is_draft" value="0">
                                        <input class="form-check-input" type="checkbox" name="is_draft" id="is_draft"
                                            value="1" checked>
                                        <label class="form-check-label" for="is_draft">
                                            Save as Draft
                                        </label>
                                    </div>
                                    <div class="form-bottom">
                                        <button type="button" class="btn btn-primary"
                                            onclick="submitForm(true)">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function submitForm(isDraft) {
                document.getElementById('is_draft').checked = isDraft;
                document.getElementById('chapter-form').submit();
            }


            document.addEventListener('DOMContentLoaded', function() {
                var editor = new Quill('#quill-editor', {
                    theme: 'snow'
                });
                var quillEditor = document.getElementById('quill-editor-area');

                // Load existing content into Quill editor
                var content = {!! json_encode(old('content', $isEdit ? $chapter->content : '')) !!};
                editor.root.innerHTML = content;

                editor.on('text-change', function() {
                    quillEditor.value = editor.root.innerHTML;
                });

                quillEditor.addEventListener('input', function() {
                    editor.root.innerHTML = quillEditor.value;
                });

                document.getElementById('chapter-form').onsubmit = function() {
                    quillEditor.value = editor.root.innerHTML;
                };
            });
        </script>
    @endpush

    <!-- End Full Screen Modal-->
@endsection
