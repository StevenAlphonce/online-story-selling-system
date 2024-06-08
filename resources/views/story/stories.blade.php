  @extends('layout.app')
  @include('layout.includes._header')

  {{-- @include('layout.includes._sidebar') --}}

  @section('content')
      <main style="margin-top: 100px" class="container">

          <section class="section">

              @if ($stories->isEmpty())
                  <div class="no-story-card card justify-content-center ">
                      <p class="card-text h3 text-center text my-auto">
                          Hi, {{ Auth::User()->name }} ! You haven't written any stories yet.
                      </p>
                      <a href="{{ url('create-story') }}" class="btn mx-auto my-auto">
                          <i class="bi bi-plus m-1"></i> Create a Story</a>
                  </div>
              @else
                  <div class="story-card">
                      <div class="story-card-header">
                          {{-- <div class="card-title">All Stories</div> --}}
                          <a href="{{ url('create-story') }}" class="btn">
                              <i class="bi bi-plus"></i>
                              New Story
                          </a>
                      </div>

                      <div class="row">
                          @foreach ($stories as $story)
                              <div class="story-single row">
                                  <div class="story-cover col-md-2">
                                      <img class="img" src="{{ asset('storage/' . $story->cover) }}" alt="Story Cover">
                                  </div>

                                  <div class="story-statinfo-wrapper col-md-5">
                                      <div class="story-info ">
                                          <a href="{{ route('story.edit', $story->id) }}"
                                              class="card-title h5 ">{{ $story->title }}</a>
                                          <p class="card-text fw-bold mt-2">
                                              {{ count($story->chapters()->where('is_draft', true)->get()) }} <span
                                                  class="text-muted">Draft</span>
                                          </p>
                                          <p class="card-text text-muted">{{ $story->updated_at }}</p>
                                      </div>

                                      <div class="story-stat">
                                          <i class="bi bi-eye"></i><span>1</span>
                                          <i class="bi bi-star"></i><span>3</span>
                                          <i class="bi bi-chat-dots"></i><span>6</span>
                                      </div>
                                  </div>
                                  <div class="story-configurations col-md-5">

                                      <div class="story-operation">
                                          <form action="{{ route('story.delete', $story->id) }}" method="POST"
                                              class="d-inline">
                                              @csrf
                                              @method('DELETE')
                                              <button type="submit" class="not-btn config-op"><i class="bi bi-trash"></i>
                                                  <span>Delete Story</span></button>

                                          </form>
                                          <a class="config-op" href="#">
                                              <i class="bi bi-eye"></i> <span>View as a Reader</span>
                                          </a>
                                      </div>

                                  </div>
                              </div>
                          @endforeach

                      </div>
                  </div>
              @endif
          </section>
      </main>
  @endsection
