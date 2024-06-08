 @extends('layout.app')
 @include('layout.includes._header')

 @include('layout.includes._sidebar')
 @section('content')
     <main class="main" id="main">
         <div class="pagetitle">
             <h1>Story categories</h1>
             <nav>
                 <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                     <li class="breadcrumb-item active">Create Category</li>
                 </ol>
             </nav>
         </div><!-- End Page Title -->
         <section class="section">
             <div class="row g-3">
                 <div class="row mb-3">
                     <div class="col">
                         <a style="float: right;" href="{{ route('categories.create') }}" class="btn btn-success">Add
                             Category</a>
                     </div>
                 </div>
                 <div class="card">
                     <table class="table table-striped card-body">
                         <thead>
                             <tr class="card-header h5">
                                 <th>#</th>
                                 <th>Category Name</th>
                                 <th>Actions</th>
                             </tr>
                         </thead>
                         <tbody>
                             @foreach ($categories as $index => $category)
                                 <tr>
                                     <td>{{ $index + 1 }}</td>
                                     <td>{{ $category->name }}</td>
                                     <td>
                                         <a href="{{ route('categories.edit', $category->id) }}">
                                             <i class="bi bi-pencil-square"></i>
                                         </a>

                                         <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                             class="d-inline">
                                             @csrf
                                             @method('DELETE')
                                             <button type="submit" class="not-btn"><i class="bi bi-trash"></i></button>
                                         </form>
                                     </td>
                                 </tr>
                             @endforeach
                         </tbody>
                     </table>
                 </div>

             </div>
         </section>
     </main>
 @endsection
