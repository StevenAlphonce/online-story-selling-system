 @extends('layout.app')

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
                     <a href="#" class="btn skip" data-bs-dismiss="modal">{{ __('Skip') }}</a>
                 </div>
             </div>
             <div class="container">
                 <div class="row">

                     <div class="col-md-12">
                         <div class="modal-form-wrapper card">

                             <div class="card-body">
                                 <form action="{{ $isEdit ? route('story.edit' . $story->id) : 'create-story' }}"
                                     method="POST" class="row g-3" enctype="multipart/form-data">
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
                                                             <input type="text" name="story_title" class="form-control"
                                                                 placeholder="Story Title"
                                                                 value="{{ $isEdit ? $story->title : old('story_title') }}">

                                                             @if ($errors->has('story_title'))
                                                                 <span class="invalid-feedback" style="display: block;"
                                                                     role="alert">
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
                                                                 <span class="invalid-feedback" style="display: block;"
                                                                     role="alert">
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
                                                                     src = 'https://cdn.dribbble.com/users/4438388/screenshots/15854247/media/0cd6be830e32f80192d496e50cfa9dbc.jpg?resize=1000x750&vertical=center'
                                                                     alt="Story Cover"
                                                                     style="max-height: 250px;float: center;">
                                                             </div>
                                                             <div class="form-group">
                                                                 <input type="file" name="image"
                                                                     placeholder="Upload Cover" id="image"
                                                                     value="{{ $isEdit ? $story->cover : old('image') }}">
                                                                 @if ($errors->has('image'))
                                                                     <span class="invalid-feedback" style="display: block;"
                                                                         role="alert">
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
                                                 <span class="invalid-feedback" style="display: block;" role="alert">
                                                     <strong>{{ $errors->first('main_character') }}</strong>
                                                 </span>
                                             @endif
                                         </div>
                                         <div class="col-md-4">
                                             <label for="category" class="form-label">{{ __('Category') }}</label>
                                             <select class="form-select" name="category" id="category">
                                                 <option selected>{{ __('Select a category') }}</option>
                                                 @foreach ($categories as $category)
                                                     @if (old('category') == $category->id)
                                                         <option selected value="{{ $category->id }}"
                                                             {{ $isEdit ? ($story->category_id === $category->id ? 'selected' : '') : '' }}>
                                                             {{ $category->name }}
                                                         </option>
                                                     @else
                                                         <option value="{{ $category->id }}"
                                                             {{ $isEdit ? ($story->category_id === $category->id ? 'selected' : '') : '' }}>
                                                             {{ $category->name }}
                                                         </option>
                                                     @endif
                                                 @endforeach
                                             </select>

                                             @if ($errors->has('category'))
                                                 <span class="invalid-feedback" style="display: block;" role="alert">
                                                     <strong>{{ $errors->first('category') }}</strong>
                                                 </span>
                                             @endif
                                         </div>

                                         <div class="col-md-4">
                                             <label for="tags" class="form-label">{{ __('Tags') }}</label>
                                             <input type="text" name="tags" class="form-control"
                                                 value="{{ $isEdit ? $story->tags : old('tags') }}">
                                         </div>
                                     </div>

                                     <div class="row g-2 mt-1">
                                         <div class="col-md-6">
                                             <div class="col-md-12">
                                                 <label for="copyright" class="form-label">{{ __('Copyright') }}</label>
                                                 <select class="form-select" name="copyright" id="copyright">
                                                     <option selected>{{ __('Select Copyright') }}</option>
                                                     <option value="ARR">{{ __('All right reserved') }}</option>
                                                     <option value="PD">{{ __('Public Domain') }}</option>
                                                     <option value="CC">{{ __('Creative common (CC)') }}</option>
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
                                                 <input class="form-check-input" type="checkbox" name="rating"
                                                     id="flexSwitchCheckChecked" checked>
                                             </div>
                                         </div>
                                         <div class="col-md-6">
                                             <div class="col-md-12">
                                                 <label for="language" class="form-label">{{ __('Language') }}</label>
                                                 <select class="form-select" name="language" id="language">
                                                     <option selected>
                                                         {{ $isEdit ? $story->language : __('Select Language') }}</option>
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
                                                     class="btn">{{ __('Save Details') }}
                                                 </button>
                                             </div>
                                         </div>
                                     </div>
                                 </form>
                             </div>
                         </div>

                     </div>
                 </div>
             </div>
         </div>
     </div>

     <!-- End Full Screen Modal-->
 @endsection
