  @extends('layout.app')
  @include('layout.includes._header')

  @include('layout.includes._sidebar')
  @section('content')
      <main class="main" id="main">
          <div class="pagetitle">
              <h1>My Stories</h1>
              <nav>
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{ url('dashboard/categories') }}">Categories</a></li>
                      <li class="breadcrumb-item active">Create Category</li>
                  </ol>
              </nav>
          </div><!-- End Page Title -->
          <section class="section">
              <div class="row g-3">
                  <div class="card">
                      <form class="card-body"
                          action="{{ $isEdit ? route('categories.update', $category->id) : route('categories.store') }}"
                          method="POST">
                          @csrf
                          @if ($isEdit)
                              @method('PUT')
                          @endif
                          <div class="form-group g-3">
                              <label class="mt-2 card-text h5 fw-bold" for="categoryName">Category Name</label>
                              <input type="text" class="form-control mt-2" id="categoryName" name="category_name"
                                  placeholder="Enter category name"
                                  value="{{ $isEdit ? $category->name : old('category_name') }}">
                          </div>
                          @if ($errors->has('category_name'))
                              <span class="invalid-feedback" style="display: block;" role="alert">
                                  <strong>{{ $errors->first('category_name') }}</strong>
                              </span>
                          @endif
                          <button type="submit" class="btn mt-2">{{ $isEdit ? 'Update' : 'Save' }}</button>
                      </form>
                  </div>
              </div>
          </section>
      </main>
  @endsection
