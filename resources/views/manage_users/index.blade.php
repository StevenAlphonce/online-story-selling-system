@extends('layout.app')
@include('layout.includes._header')
@include('layout.includes._sidebar')
@section('content')
    <main id="main" class="main">

        <section style="margin-top: 50px;" class="section">
            <div class="row g-3">
                <div class="card">
                    <h5 class="card-title">Story Selling System Users</h5>
                    <!-- Alert Message -->
                    <div id="status-alert" class="alert alert-success" style="display: none;"></div>

                    <!-- Table with stripped rows -->
                    <table class="table table-sm table-striped card-body">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Verification Status</th>
                                <th scope="col">Reg Date</th>
                                <th scope="col">User Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->email_verified_at)
                                            <span class="badge bg-primary">Verified</span>
                                        @else
                                            <span class="badge bg-warning">Unverified</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <!-- User Status Text -->
                                        <span
                                            class="user-status-text">{{ $user->is_enabled ? 'Enabled' : 'Disabled' }}</span>
                                    </td>
                                    <td>
                                        <!-- Toggle switch for enabling/disabling users -->
                                        <form class="" action="{{ route('users.toggleStatus', $user->id) }}"
                                            method="POST" style="display:inline-block;" class="toggle-status-form">
                                            @csrf
                                            @method('PATCH')
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="status"
                                                    onchange="toggleUserStatus(this)"
                                                    {{ $user->is_enabled ? 'checked' : '' }}>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->
                </div>

            </div>
        </section>

    </main><!-- End #main -->
    @push('scripts')
        <script>
            function toggleUserStatus(checkbox) {
                const form = checkbox.closest('form');
                const url = form.action;
                const method = form.querySelector('input[name=_method]').value;

                const formData = new FormData(form);

                fetch(url, {
                        method: method,
                        headers: {
                            'X-CSRF-TOKEN': form.querySelector('input[name=_token]').value
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Display the success message
                        const alertBox = document.getElementById('status-alert');
                        alertBox.textContent = data.message;
                        alertBox.style.display = 'block';

                        // Update the user status text
                        const userStatusText = form.closest('tr').querySelector('.user-status-text');
                        userStatusText.textContent = checkbox.checked ? 'Enabled' : 'Disabled';

                        // Hide the alert after 3 seconds
                        setTimeout(() => {
                            alertBox.style.display = 'none';
                        }, 3000);
                    })
                    .catch(error => console.error('Error:', error));
            }
        </script>
    @endpush
@endsection
