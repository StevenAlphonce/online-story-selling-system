<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('/dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>{{ __('Dashboard') }}</span>
            </a>
        </li>
        <!-- End Dashboard Nav -->

        @can('Create Story')
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-menu-button-wide"></i>
                    <span>{{ __('Create Story') }}</span>
                </a>
            </li>
            <!-- End Create story Nav -->
        @endcan

        @can('Manage User')
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-menu-button-wide"></i>
                    <span>{{ __('Manage User') }}</span>
                </a>
            </li>
            <!-- End Manage user Nav -->
        @endcan

        @can('Manage roles and permission')
            <li class="nav-item">
                <a class="nav-link" href="{{ url('dashboard/roles-and-permission') }}">
                    <i class="bi bi-menu-button-wide"></i>
                    <span>{{ __('Roles and Permission') }}</span>
                </a>
            </li>
            <!-- End Roles and permission Nav -->
        @endcan


        <li class="nav-heading">Pages</li>


    </ul>

</aside>
