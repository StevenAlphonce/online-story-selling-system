 @extends('layout.app')
 @include('layout.includes._header')

 @section('content')
     <!-- Full Screen Modal -->

     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header  justify-content-between">
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
                     <a href="#" class="btn cancel">{{ __('Publish') }}</a>
                     <a style="width:auto;" href="{{ route('story.edit', $story->id) }}"
                         class="btn skip">{{ __('Continue Laiter') }}</a>
                 </div>
             </div>
             <div class="container">
                 <div class="row">

                     <div class="col-md-12">
                         <div class="modal-form-wrapper card">
                             <div class="card-body mt-5">
                                 <form class="form" method="POST"
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
                                     <!-- Quill Editor Default -->
                                     <div class="col-md-12 mb-4">
                                         <textarea name="content" class="form-control" rows="13" cols="100">
                                           {{ $isEdit ? $chapter->content : old('content') }}
                                        </textarea>
                                         @if ($errors->has('content'))
                                             <span class="invalid-feedback" style="display: block;" role="alert">
                                                 <strong>{{ $errors->first('content') }}</strong>
                                             </span>
                                         @endif
                                     </div>
                                     <!-- End Quill Editor Default -->
                                     <div class="form-check mb-4">
                                         <input class="form-check-input" checked type="checkbox" name="is_draft"
                                             id="is_draft" value="1">
                                         <label class="form-check-label" for="is_draft">
                                             Save as Draft
                                         </label>
                                     </div>
                                     <div class="form-bottom">
                                         <button type="submit" class="btn btn-primary">Save</button>
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
