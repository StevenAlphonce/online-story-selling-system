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
                         <a href="{{ route('stories.show') }}"><i class="bi bi-chevron-compact-left"></i></a>
                     </div>
                     <div class="status">
                         <span class="text-muted">{{ __('Edit story information') }}</span>
                         <h3 class="modal-title">{{ __($story->title) }}</h3>
                     </div>
                 </div>
                 <div class="modal-header-right">
                     {{-- <a href="{{ url('stories') }}" class="btn cancel">{{ __('Cancel') }}</a> --}}
                     {{-- <a href="#" class="btn skip" data-bs-dismiss="modal">{{ __('Save') }}</a> --}}
                 </div>
             </div>
             <div class="container mt-3">
                 <div class="row">
                     <form class="row g-3" action="{{ route('story.update', $story->id) }}" method="POST"
                         enctype="multipart/form-data">
                         @csrf
                         @method('PUT')
                         <div class="col-md-3">
                             <div class="card">
                                 <img id="image-preview" class="img" src="{{ asset('storage/' . $story->cover) }}"
                                     alt="Story Cover">
                                 <div class="hover-buttons">
                                     <label for="image" class="btn upload-label">Upload Cover</label>
                                     <input type="file" name="image" id="image"
                                         onchange="document.getElementById('image-form').submit();">
                                     <button class="btn btn-outline-primary" onclick="window.location.href='#'">View
                                         as reader</button>
                                 </div>
                                 <div class="card-body text-center">
                                     <h5 class="card-title">{{ $story->title }}</h5>
                                 </div>
                             </div>
                         </div>
                         <div class="col-md-9">
                             <div class="card">
                                 <div class="card-body">

                                     <!-- Bordered Tabs -->
                                     <ul class="nav nav-tabs nav-tabs-bordered" id="borderedTab" role="tablist">
                                         <li class="nav-item" role="presentation">
                                             <button class="nav-link" id="story-details-tab" data-bs-toggle="tab"
                                                 data-bs-target="#bordered-story-details" type="button" role="tab"
                                                 aria-controls="story-details" aria-selected="true">Story Details</button>
                                         </li>
                                         <li class="nav-item" role="presentation">
                                             <button class="nav-link active" id="table-tab" data-bs-toggle="tab"
                                                 data-bs-target="#bordered-table" type="button" role="tab"
                                                 aria-controls="table" aria-selected="false">Table of Contents</button>
                                         </li>
                                     </ul>
                                     <div class="tab-content pt-2" id="borderedTabContent">
                                         <div class="tab-pane fade " id="bordered-story-details" role="tabpanel"
                                             aria-labelledby="story-details-tab">
                                             <div class="card-body">

                                                 <!-- Title Field -->
                                                 <div class="col-md-12">
                                                     <label for="storyTitle" class="form-label">{{ __('Title') }}</label>
                                                     <input type="text" name="story_title" class="form-control"
                                                         placeholder="Story Title"
                                                         value="{{ old('story_title', $story->title) }}">
                                                     @if ($errors->has('story_title'))
                                                         <span class="invalid-feedback" style="display: block;"
                                                             role="alert">
                                                             <strong>{{ $errors->first('story_title') }}</strong>
                                                         </span>
                                                     @endif
                                                 </div>

                                                 <!-- Description Field -->
                                                 <div class="col-md-12 mt-2">
                                                     <label for="storyDescription"
                                                         class="form-label">{{ __('Description') }}</label>
                                                     <textarea name="story_description" class="form-control" rows="7" cols="50">{{ old('story_description', $story->description) }}</textarea>
                                                     @if ($errors->has('story_description'))
                                                         <span class="invalid-feedback" style="display: block;"
                                                             role="alert">
                                                             <strong>{{ $errors->first('story_description') }}</strong>
                                                         </span>
                                                     @endif
                                                 </div>

                                                 <div class="row">
                                                     <!-- Main Character Field -->
                                                     <div class="col-md-6">
                                                         <label for="mainCharacter"
                                                             class="form-label">{{ __('Main Character') }}</label>
                                                         <input type="text" name="main_character" class="form-control"
                                                             placeholder="Main Character"
                                                             value="{{ old('main_character', $story->main_character) }}">
                                                         @if ($errors->has('main_character'))
                                                             <span class="invalid-feedback" style="display: block;"
                                                                 role="alert">
                                                                 <strong>{{ $errors->first('main_character') }}</strong>
                                                             </span>
                                                         @endif
                                                     </div>

                                                     <!-- Category Field -->
                                                     <div class="col-md-6">
                                                         <label for="category"
                                                             class="form-label">{{ __('Category') }}</label>
                                                         <select class="form-select" name="category" id="category"
                                                             required>
                                                             <option value="">{{ __('Select a category') }}</option>
                                                             @foreach ($categories as $category)
                                                                 <option value="{{ $category->id }}"
                                                                     {{ old('category') == $category->id || $story->categories()->first()->id == $category->id ? 'selected' : '' }}>
                                                                     {{ $category->name }}
                                                                 </option>
                                                             @endforeach
                                                         </select>
                                                         @if ($errors->has('category'))
                                                             <span class="invalid-feedback" style="display: block;"
                                                                 role="alert">
                                                                 <strong>{{ $errors->first('category') }}</strong>
                                                             </span>
                                                         @endif
                                                     </div>
                                                 </div>

                                                 <div class="row">

                                                     <!-- Tags Field -->
                                                     <div class="col-md-6">
                                                         <label for="tags"
                                                             class="form-label">{{ __('Tags') }}</label>
                                                         <input type="text" name="tags" class="form-control"
                                                             value="{{ old('tags', $story->tags) }}">
                                                     </div>

                                                     <!-- Copyright Field -->
                                                     <div class="col-md-6">
                                                         <label for="copyright"
                                                             class="form-label">{{ __('Copyright') }}</label>
                                                         <select class="form-select" name="copyright" id="copyright"
                                                             required>
                                                             <option value="">{{ __('Select Copyright') }}</option>
                                                             <option value="ARR"
                                                                 {{ old('copyright', $story->copyright) == 'ARR' ? 'selected' : '' }}>
                                                                 {{ __('All right reserved') }}</option>
                                                             <option value="PD"
                                                                 {{ old('copyright', $story->copyright) == 'PD' ? 'selected' : '' }}>
                                                                 {{ __('Public Domain') }}</option>
                                                             <option value="CC"
                                                                 {{ old('copyright', $story->copyright) == 'CC' ? 'selected' : '' }}>
                                                                 {{ __('Creative common (CC)') }}</option>
                                                         </select>
                                                         @if ($errors->has('copyright'))
                                                             <span class="invalid-feedback" style="display: block;"
                                                                 role="alert">
                                                                 <strong>{{ $errors->first('copyright') }}</strong>
                                                             </span>
                                                         @endif
                                                     </div>
                                                 </div>


                                                 <div class="row">
                                                     <!-- Rating Field -->
                                                     <div class="col-md-6 form-check form-switch">
                                                         <label style="margin:8px 0 20px 0;" class="form-check-label"
                                                             for="flexSwitchCheckChecked">{{ __('Allow Rating') }}</label>
                                                         <input type="hidden" name="rating" value="0">
                                                         <input style="margin:10px 5px 2px 0;" class="form-check-input"
                                                             type="checkbox" name="rating" id="flexSwitchCheckChecked"
                                                             {{ old('rating', $story->rating) ? 'checked' : '' }}>
                                                     </div>

                                                     <!-- Language Field -->
                                                     <div class="col-md-6">
                                                         <label for="language"
                                                             class="form-label">{{ __('Language') }}</label>
                                                         <select class="form-select" name="language" id="language"
                                                             required>
                                                             <option value="">{{ __('Select Language') }}</option>
                                                             <option value="ksw"
                                                                 {{ old('language', $story->language) == 'ksw' ? 'selected' : '' }}>
                                                                 {{ __('Kiswahili') }}</option>
                                                             <option value="en"
                                                                 {{ old('language', $story->language) == 'en' ? 'selected' : '' }}>
                                                                 {{ __('English') }}</option>
                                                             <option value="fr"
                                                                 {{ old('language', $story->language) == 'fr' ? 'selected' : '' }}>
                                                                 {{ __('French') }}</option>
                                                         </select>
                                                         @if ($errors->has('language'))
                                                             <span class="invalid-feedback" style="display: block;"
                                                                 role="alert">
                                                                 <strong>{{ $errors->first('language') }}</strong>
                                                             </span>
                                                         @endif
                                                     </div>
                                                 </div>

                                                 <!-- Submit Button -->
                                                 <div class="col-md-12">
                                                     <button style="float: inline-end;" type="submit"
                                                         class="btn mt-2">{{ __('Update Details') }}</button>
                                                 </div>
                     </form>
                 </div>
             </div>


             <div class="tab-pane fade show active" id="bordered-table" role="tabpanel" aria-labelledby="table-tab">

                 <!-- Table of content card-->
                 <div class="card-body">
                     <a href="{{ route('chapter.create', ['story' => $story->id]) }}" class="btn  mt-3 mb-3">+ New
                         Chapter</a>
                     @foreach ($story->chapters as $chapter)
                         <div class="list-group part mt-2">
                             <a href="{{ route('chapter.write', ['story' => $story->id, 'chapter' => $chapter->id]) }}"
                                 class="list-group-item list-group-item-action">
                                 <div class="d-flex w-100 justify-content-between">
                                     <h5 class="mb-1">{{ $chapter->title }}</h5>

                                     <form
                                         action="{{ route('chapter.delete', ['story' => $story->id, 'chapter' => $chapter->id]) }}"
                                         method="POST" class="d-inline">
                                         @csrf
                                         @method('DELETE')
                                         <button
                                             style="border: var(--border);border-radius:10px;background:red; color:white;font-weight:bold;"
                                             type="submit" class="not-btn"><i class="bi bi-trash"></i>
                                             <span>Delete Chapter</span></button>

                                     </form>
                                 </div>
                                 <small class="text-muted">
                                     {{ $chapter->is_draft ? 'Draft' : 'Completed' }}
                                     - {{ $chapter->updated_at }}
                                 </small>
                                 <div>
                                     <small>
                                         <span class="me-3"><i class="bi bi-eye"></i>
                                             {{ $chapter->views }}</span>
                                         <span class="me-3"><i class="bi bi-star"></i>
                                             {{ $chapter->stars }}</span>
                                         <span><i class="bi bi-chat"></i>
                                             {{ $chapter->comments }}</span>
                                     </small>
                                 </div>

                             </a>
                         </div>
                     @endforeach
                 </div><!-- End Table of content card-->
             </div>
         </div><!-- End Bordered Tabs -->

     </div>
     </div>
     </div>
     </div>
     </div>
     </div>
     </div>

     <!-- End Full Screen Modal-->
 @endsection
