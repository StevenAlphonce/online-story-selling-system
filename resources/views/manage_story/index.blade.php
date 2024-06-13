@extends('layout.app')
@include('layout.includes._header')
@include('layout.includes._sidebar')
@section('content')
    <main class="main" id="main" style="margin-top: 100px;">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Manage Stories</h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Author</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stories as $story)
                            <tr>
                                <th scope="row">{{ $story->id }}</th>
                                <td>{{ $story->title }}</td>
                                <td>{{ $story->user->name }}</td>
                                <td>
                                    <span class="badge {{ $story->is_enabled ? 'bg-primary' : 'bg-warning' }}">
                                        {{ $story->is_enabled ? 'Enabled' : 'Disabled' }}
                                    </span>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" class="toggle-status" data-id="{{ $story->id }}"
                                            {{ $story->is_enabled ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toggles = document.querySelectorAll('.toggle-status');

                toggles.forEach(toggle => {
                    toggle.addEventListener('change', function() {
                        const storyId = this.dataset.id;
                        const isChecked = this.checked;

                        fetch(`{{ url('/admin/stories/toggle') }}/${storyId}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    is_enabled: isChecked
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    const badge = this.closest('tr').querySelector('.badge');
                                    if (data.is_enabled) {
                                        badge.classList.remove('bg-warning');
                                        badge.classList.add('bg-primary');
                                        badge.textContent = 'Enabled';
                                    } else {
                                        badge.classList.remove('bg-primary');
                                        badge.classList.add('bg-warning');
                                        badge.textContent = 'Disabled';
                                    }
                                }
                            });
                    });
                });
            });
        </script>
    @endpush

    @include('layout.includes._footer')
@endsection
