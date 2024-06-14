 @extends('layout.app')

 @push('style')
     <style>
         .card {
             position: relative;
             width: 100%;
             overflow: hidden;
         }

         .card img {
             width: 100%;
             transition: transform 0.3s ease;
         }

         .card:hover img {
             transform: scale(1.1);
         }

         .card .hover-buttons {
             position: absolute;
             top: 0;
             left: 0;
             width: 100%;
             height: 100%;
             display: flex;
             flex-direction: column;
             justify-content: center;
             align-items: center;
             background-color: rgba(0, 0, 0, 0.5);
             opacity: 0;
             transition: opacity 0.3s ease;
         }

         .card:hover .hover-buttons {
             opacity: 1;
         }

         .hover-buttons button,
         .hover-buttons input[type="file"] {
             margin: 10px;
             color: white;
             background-color: rgba(0, 0, 0, 0.7);
             border: none;
             padding: 10px;
             cursor: pointer;
         }

         .hover-buttons input[type="file"] {
             display: none;
         }

         .upload-label {
             cursor: pointer;

         }
     </style>
 @endpush

 @section('content')
     <!-- Full Screen Modal -->

     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header  justify-content-between">
                 <div class="modal-header-left">
                     <div class="back">
                         <button class="not-btn"><i class="bi bi-chevron-compact-left" onclick="history.back()"></i></button>
                     </div>
                     <div class="status">
                         <span class="text-muted">{{ __('Add story information') }}></span>
                         <h3 class="modal-title">{{ __('Untitled story') }}</h3>
                     </div>
                 </div>
                 <div class="modal-header-right">
                     <a href="{{ url('stories') }}" class="btn cancel">{{ __('Cancel') }}</a>
                     {{-- <a href="#" class="btn skip" data-bs-dismiss="modal">{{ __('Skip') }}</a> --}}
                 </div>
             </div>
             <div class="container mt-3">
                 <div class="row">
                     <form class="row g-3" action="{{ route('story.create') }}" method="POST"
                         enctype="multipart/form-data">
                         @csrf
                         <div class="col-md-3">
                             <div class="card">
                                 <img id="image-preview" class="img" src="{{ asset('image/no-cover.png') }}"
                                     alt="Story Cover">
                                 <div class="hover-buttons">
                                     <label for="image" class="btn upload-label">Upload Cover</label>
                                     <input type="file" name="image" id="image"
                                         onchange="document.getElementById('image-form').submit();">
                                 </div>
                                 <div class="card-body text-center">
                                     <h5 class="card-title">{{ __('Untitled story') }}</h5>
                                     @if ($errors->has('image'))
                                         <span class="invalid-feedback" style="display: block;" role="alert">
                                             <strong>{{ $errors->first('image') }}</strong>
                                         </span>
                                     @endif
                                 </div>

                             </div>
                         </div>
                         <div class="col-md-9">
                             <div class="card">
                                 <div class="card-body p-4">
                                     <!-- Title Field -->
                                     <div class="col-md-12">
                                         <label for="storyTitle" class="form-label">{{ __('Title') }}</label>
                                         <input type="text" name="story_title" class="form-control"
                                             placeholder="Story Title" value="{{ old('story_title') }}">
                                         @if ($errors->has('story_title'))
                                             <span class="invalid-feedback" style="display: block;" role="alert">
                                                 <strong>{{ $errors->first('story_title') }}</strong>
                                             </span>
                                         @endif
                                     </div>

                                     <!-- Description Field -->
                                     <div class="col-md-12 mt-2">
                                         <label for="storyDescription" class="form-label">{{ __('Description') }}</label>
                                         <div id="quill-editor" class="mb-3" style="height: 200px;"></div>
                                         <textarea rows="3" class="mb-3 d-none" name="story_description" id="quill-editor-area">
                                                
                                            </textarea>
                                         @if ($errors->has('story_description'))
                                             <span class="invalid-feedback" style="display: block;" role="alert">
                                                 <strong>{{ $errors->first('story_description') }}</strong>
                                             </span>
                                         @endif
                                     </div>

                                     <div class="row mt-2">
                                         <!-- Main Character Field -->
                                         <div class="col-md-6">
                                             <label for="mainCharacter"
                                                 class="form-label">{{ __('Main Character') }}</label>
                                             <input type="text" name="main_character" class="form-control"
                                                 placeholder="Main Character" value="{{ old('main_character') }}">
                                             @if ($errors->has('main_character'))
                                                 <span class="invalid-feedback" style="display: block;" role="alert">
                                                     <strong>{{ $errors->first('main_character') }}</strong>
                                                 </span>
                                             @endif
                                         </div>

                                         <!-- Category Field -->
                                         <div class="col-md-6">
                                             <label for="category" class="form-label">{{ __('Category') }}</label>
                                             <select class="form-select" name="category" id="category" required>
                                                 <option value="">{{ __('Select a category') }}</option>
                                                 @foreach ($categories as $category)
                                                     <option value="{{ $category->id }}"
                                                         {{ (old('category') == $category->id) == $category->id ? 'selected' : '' }}>
                                                         {{ $category->name }}
                                                     </option>
                                                 @endforeach
                                             </select>
                                             @if ($errors->has('category'))
                                                 <span class="invalid-feedback" style="display: block;" role="alert">
                                                     <strong>{{ $errors->first('category') }}</strong>
                                                 </span>
                                             @endif
                                         </div>
                                     </div>

                                     <div class="row mt-2">

                                         <!-- Tags Field -->
                                         <div class="col-md-6">
                                             <label for="tags" class="form-label">{{ __('Tags') }}</label>
                                             <input type="text" name="tags" class="form-control"
                                                 value="{{ old('tags') }}">
                                         </div>

                                         <!-- Copyright Field -->
                                         <div class="col-md-6">
                                             <label for="copyright" class="form-label">{{ __('Copyright') }}</label>
                                             <select class="form-select" name="copyright" id="copyright" required>
                                                 <option value="">{{ __('Select Copyright') }}</option>
                                                 <option value="ARR" {{ old('copyright') == 'ARR' ? 'selected' : '' }}>
                                                     {{ __('All right reserved') }}</option>
                                                 <option value="PD" {{ old('copyright') == 'PD' ? 'selected' : '' }}>
                                                     {{ __('Public Domain') }}</option>
                                                 <option value="CC" {{ old('copyright') == 'CC' ? 'selected' : '' }}>
                                                     {{ __('Creative common (CC)') }}</option>
                                             </select>
                                             @if ($errors->has('copyright'))
                                                 <span class="invalid-feedback" style="display: block;" role="alert">
                                                     <strong>{{ $errors->first('copyright') }}</strong>
                                                 </span>
                                             @endif
                                         </div>
                                     </div>

                                     <div class="row mt-2">
                                         <!-- Rating Field -->
                                         <div class="col-md-6 form-check form-switch">
                                             <label style="margin:8px 0 20px 0;" class="form-check-label"
                                                 for="flexSwitchCheckChecked">{{ __('Allow Rating') }}</label>
                                             <input type="hidden" name="rating" value="0">
                                             <input style="margin:10px 5px 25px 0;" class="form-check-input"
                                                 type="checkbox" name="rating" id="flexSwitchCheckChecked"
                                                 value="1" {{ old('rating') ? 'checked' : '' }}>
                                         </div>

                                         <!-- Language Field -->
                                         <div class="col-md-6">
                                             <label for="language" class="form-label">{{ __('Language') }}</label>
                                             <select class="form-select" name="language" id="language" required>
                                                 <option value="">{{ __('Select Language') }}</option>
                                                 <option value="ksw" {{ old('language') == 'ksw' ? 'selected' : '' }}>
                                                     {{ __('Kiswahili') }}</option>
                                                 <option value="en" {{ old('language') == 'en' ? 'selected' : '' }}>
                                                     {{ __('English') }}</option>
                                                 <option value="fr" {{ old('language') == 'fr' ? 'selected' : '' }}>
                                                     {{ __('French') }}</option>
                                             </select>
                                             @if ($errors->has('language'))
                                                 <span class="invalid-feedback" style="display: block;" role="alert">
                                                     <strong>{{ $errors->first('language') }}</strong>
                                                 </span>
                                             @endif
                                         </div>
                                     </div>

                                     <!-- Submit Button -->
                                     <div class="col-md-12">
                                         <button style="float: inline-end;" type="submit"
                                             class="btn mt-2">{{ __('Save Details') }}</button>
                                     </div>

                                 </div>
                     </form>
                 </div>

             </div>
         </div>

         <!-- End Full Screen Modal-->
         @push('scripts')
             <script>
                 document.addEventListener('DOMContentLoaded', function() {
                     var editor = new Quill('#quill-editor', {
                         theme: 'snow'
                     });
                     var quillEditor = document.getElementById('quill-editor-area');

                     // Load existing content into Quill editor
                     var content = {!! json_encode(old('story_description')) !!};
                     editor.root.innerHTML = content;

                     editor.on('text-change', function() {
                         quillEditor.value = editor.root.innerHTML;
                     });

                     quillEditor.addEventListener('input', function() {
                         editor.root.innerHTML = quillEditor.value;
                     });

                     document.getElementById('story-form').onsubmit = function() {
                         quillEditor.value = editor.root.innerHTML;
                     };
                 });
             </script>
         @endpush
     @endsection
