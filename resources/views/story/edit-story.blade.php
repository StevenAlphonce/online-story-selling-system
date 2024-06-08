 @extends('layout.app')

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
                     <div class="col-md-3">
                         <div class="card">
                             <img style="height: 90%" class="img" src="{{ asset('storage/' . $story->cover) }}"
                                 alt="Story Cover">
                             <div class="card-body text-center">
                                 <h5 class="card-title">{{ $story->title }}</h5>
                                 <button class="btn btn-outline-primary">View as reader</button>
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
                                             <form action="{{ route('story.update', $story->id) }}" method="POST"
                                                 class="row g-3" enctype="multipart/form-data">
                                                 @csrf
                                                 @if ($isEdit)
                                                     @method('PUT')
                                                 @endif
                                                 <div class="row g-3">
                                                     <div class="col-md-6">
                                                         <table class="">
                                                             <thead>
                                                                 <tr>
                                                                     <th colspan="2"></th>
                                                                 </tr>
                                                             </thead>
                                                             <tbody>
                                                                 <tr>
                                                                     <td> <label for="storyTitle"
                                                                             class="form-label">{{ __('Title') }}</label>
                                                                         <input type="text" name="story_title"
                                                                             class="form-control" placeholder="Story Title"
                                                                             value="{{ $isEdit ? $story->title : old('story_title') }}">

                                                                         @if ($errors->has('story_title'))
                                                                             <span class="invalid-feedback"
                                                                                 style="display: block;" role="alert">
                                                                                 <strong>{{ $errors->first('story_title') }}</strong>
                                                                             </span>
                                                                         @endif
                                                                     </td>

                                                                 </tr>
                                                                 <tr>
                                                                     <td>
                                                                         <label for="storyDescription"
                                                                             class="form-label">{{ __('Description') }}</label>
                                                                         <textarea name="story_description" class="form-control" rows="4" cols="50">
                                                                {{ $isEdit ? $story->description : old('story_description') }}
                                                             </textarea>

                                                                         @if ($errors->has('story_description'))
                                                                             <span class="invalid-feedback"
                                                                                 style="display: block;" role="alert">
                                                                                 <strong>{{ $errors->first('story_description') }}</strong>
                                                                             </span>
                                                                         @endif
                                                                     </td>
                                                                 </tr>
                                                             </tbody>
                                                         </table>
                                                     </div>
                                                     <div class="col-md-6">
                                                         <table class="">
                                                             <tbody>
                                                                 <tr>
                                                                     <td>
                                                                         {{-- Story vover --}}

                                                                         <div class="mb-3">
                                                                             <img id="image-preview"
                                                                                 src="{{ asset('storage/' . $story->cover) }}"
                                                                                 alt="Story Cover"
                                                                                 style="max-height: 250px;float: center;">
                                                                         </div>
                                                                         <div class="form-group">
                                                                             <input type="file" name="image"
                                                                                 placeholder="Upload Cover" id="image"
                                                                                 value="{{ $isEdit ? $story->cover : old('image') }}">
                                                                             @if ($errors->has('image'))
                                                                                 <span class="invalid-feedback"
                                                                                     style="display: block;" role="alert">
                                                                                     <strong>{{ $errors->first('image') }}</strong>
                                                                                 </span>
                                                                             @endif
                                                                         </div>
                                                                     </td>
                                                                 </tr>
                                                             </tbody>
                                                         </table>
                                                     </div>
                                                 </div>
                                                 <div class="row g-2 mt-1">
                                                     <div class="col-md-4">
                                                         <label for="mainCharacter"
                                                             class="form-label">{{ __('Main Character') }}</label>
                                                         <input type="text" name="main_character" class="form-control"
                                                             placeholder="Main Character"
                                                             value="{{ $isEdit ? $story->main_character : old('main_character') }}">

                                                         @if ($errors->has('main_character'))
                                                             <span class="invalid-feedback" style="display: block;"
                                                                 role="alert">
                                                                 <strong>{{ $errors->first('main_character') }}</strong>
                                                             </span>
                                                         @endif
                                                     </div>
                                                     <div class="col-md-4">
                                                         <label for="category"
                                                             class="form-label">{{ __('Category') }}</label>
                                                         <select class="form-select" name="category" id="category"
                                                             required>
                                                             <option value="">{{ __('Select a category') }}</option>
                                                             @foreach ($categories as $category)
                                                                 <option value="{{ $category->id }}"
                                                                     @if (old('category') == $category->id) selected
            @elseif ($isEdit && $story->categories()->first()->id == $category->id)
                selected @endif>
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


                                                         @if ($errors->has('category'))
                                                             <span class="invalid-feedback" style="display: block;"
                                                                 role="alert">
                                                                 <strong>{{ $errors->first('category') }}</strong>
                                                             </span>
                                                         @endif
                                                     </div>

                                                     <div class="col-md-4">
                                                         <label for="tags"
                                                             class="form-label">{{ __('Tags') }}</label>
                                                         <input type="text" name="tags" class="form-control"
                                                             value="{{ $isEdit ? $story->tags : old('tags') }}">
                                                     </div>
                                                 </div>

                                                 <div class="row g-2 mt-1">
                                                     <div class="col-md-6">
                                                         <div class="col-md-12">
                                                             <label for="copyright"
                                                                 class="form-label">{{ __('Copyright') }}</label>
                                                             <select class="form-select" name="copyright" id="copyright">
                                                                 <option selected>{{ __('Select Copyright') }}</option>
                                                                 <option value="ARR">{{ __('All right reserved') }}
                                                                 </option>
                                                                 <option value="PD">{{ __('Public Domain') }}</option>
                                                                 <option value="CC">{{ __('Creative common (CC)') }}
                                                                 </option>
                                                             </select>
                                                             @if ($errors->has('copyright'))
                                                                 <span class="invalid-feedback" style="display: block;"
                                                                     role="alert">
                                                                     <strong>{{ $errors->first('copyright') }}</strong>
                                                                 </span>
                                                             @endif
                                                         </div>

                                                         <div class="col-md-12 form-check form-switch">
                                                             <label class="form-check-label"
                                                                 for="flexSwitchCheckChecked">{{ __('Allow Rating') }}</label>
                                                             <input class="form-check-input" type="checkbox"
                                                                 name="rating" id="flexSwitchCheckChecked" checked>
                                                         </div>
                                                     </div>
                                                     <div class="col-md-6">
                                                         <div class="col-md-12">
                                                             <label for="language"
                                                                 class="form-label">{{ __('Language') }}</label>
                                                             <select class="form-select" name="language" id="language">
                                                                 <option selected>
                                                                     {{ $isEdit ? $story->language : __('Select Language') }}
                                                                 </option>
                                                                 <option value="ksw">{{ __('Kiswahili') }}</option>
                                                                 <option value="en">{{ __('English') }}</option>
                                                                 <option value="fr">{{ __('French') }}</option>
                                                             </select>

                                                             @if ($errors->has('language'))
                                                                 <span class="invalid-feedback" style="display: block;"
                                                                     role="alert">
                                                                     <strong>{{ $errors->first('language') }}</strong>
                                                                 </span>
                                                             @endif
                                                         </div>

                                                         <div class="col-md-12">
                                                             <button style="float: inline-end;" type="submit"
                                                                 class="btn mt-2">{{ __($isEdit ? 'Update Details' : 'Save Details') }}
                                                             </button>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </form>
                                         </div>
                                     </div>
                                     <div class="tab-pane fade show active" id="bordered-table" role="tabpanel"
                                         aria-labelledby="table-tab">

                                         <!-- Table of content card-->
                                         <div class="card-body">
                                             <a href="{{ route('chapter.create', ['story' => $story->id]) }}"
                                                 class="btn  mt-3 mb-3">+ New Chapter</a>
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
                                                                     type="submit" class="not-btn"><i
                                                                         class="bi bi-trash"></i>
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
