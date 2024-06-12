<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('/dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>{{ __('Dashboard') }}</span>
            </a>
        </li>
        <!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-menu-button-wide"></i>
                <span>{{ __('Manage User') }}</span>
            </a>
        </li>
        <!-- End Manage user Nav -->

        <li class="nav-item">
            <a class="nav-link" href="{{ url('dashboard/categories') }}">
                <i class="bi bi-menu-button-wide"></i>
                <span>{{ __('Categories') }}</span>
            </a>
        </li>
        <!-- End Manage user Nav -->

        <li class="nav-heading">Pages</li>

    </ul>

</aside>
