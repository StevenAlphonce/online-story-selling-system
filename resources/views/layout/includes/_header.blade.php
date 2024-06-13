<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between ">
        <a href="  @guest
{{ url('/') }}
    @else
        @if (Auth::user()->type == 'admin')
            {{ route('admin.dashboard') }}
        @else
            {{ route('stories.all') }}
        @endif @endguest"
            class="logo d-flex align-items-center">
            <span style="color: var(--green);" class="d-none d-lg-block">
                {{ __('Online Story Selling') }}
            </span>
        </a>
        <i class="{{ Request::is('dashboard', 'dashboard/*') ? 'bi bi-list toggle-sidebar-btn' : '' }}"></i>
    </div>
    <!-- End Logo -->
    <div class="search-bar">
        <form class="search-form d-flex align-items-center" method="POST" action="#">
            <input type="text" name="query" placeholder="Search" title="Enter search keyword">
            <button type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
    </div>
    <!-- End Search Bar -->
    <nav class="header-nav ms-auto mr-lg-2">
        <ul class="d-flex">
            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li>
            <!-- End Search Icon-->

            <li style="margin-right: 25px;" class="nav-item dropdown">
                <a class="nav-link " href="#" data-bs-toggle="dropdown">
                    <span class="d-md-block dropdown-toggle ps-2">Browse</span>
                </a>
                <!-- End Browse menu -->
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                    <ul class="dropdown-menu-browse">
                        <li class="dropdown-item-browse-header">Browse</li>
                        @foreach ($categories as $category)
                            @if (count($categories) > 0)
                                <li class="dropdown-item-browse"><a
                                        href="{{ route('stories.category', ['category' => $category->id]) }}">
                                        {{ $category->name }}</a></li>
                            @else
                                <li class="dropdown-item-browse"><a href="">{{ __('No categories') }}</a></li>
                            @endif
                        @endforeach

                    </ul>
                </ul>
                <!-- End Browse Dropdown Items -->
            </li>
            <!-- End Browse Nav -->


            <li style="margin-right: 25px;" class="nav-item dropdown">
                <a class="nav-link " href="#" data-bs-toggle="dropdown">
                    <span class="d-md-block dropdown-toggle ps-2">Story</span>
                </a>
                <!-- End Browse menu -->
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                    <li class="dropdown-header">
                        Stories
                        <i class="fas fa-plus-circle"></i>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li class="notification-item">

                        <i class="bi bi-file-plus"></i>

                        <div>
                            <a href="{{ url('create-story') }}">
                                <p>Create story</p>
                            </a>
                        </div>

                    </li>
                    <li class="notification-item">

                        <i class="bi bi-file-plus"></i>

                        <div>
                            <a href="{{ url('stories') }}">
                                <p>my stories</p>
                            </a>
                        </div>

                    </li>

                </ul>
                <!-- End Browse Dropdown Items -->
            </li>
            <!-- End Write Nav -->


            @if (empty(Auth::check()))
                <li style="margin-right: 25px;" class="nav-item">
                    <a class="nav-link " href="{{ url('login') }}"> Log in</a>
                    <!-- End Login link -->
                </li>
                <!-- End Login Nav -->

                <li style="margin-right: 10px;" class="nav-item">
                    <a class="nav-link " href="{{ url('register') }}"> Sign up</a>
                    <!-- End Sign up link -->
                </li>
                <!-- End Signup Nav -->
            @else
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                        data-bs-toggle="dropdown">
                        @php
                            $user = Auth::user();
                        @endphp
                        <img src="{{ $user->profile && $user->profile->photo ? asset('storage/' . $user->profile->photo) : asset('image/profile_avatar.png') }}"
                            alt="Profile_photo" class="rounded-circle">
                    </a>
                    <!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>{{ Auth::user()->name }}</h6>
                            {{-- <span>Web Designer</span> --}}
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        @if (Auth::User()->type == 'admin')
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ url('dashboard') }}">
                                    <i class="bi bi-speedometer2"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                        @endif

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('user.profile') }}">
                                <i class="bi bi-person"></i>
                                <span>My profile</span>
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="bi bi-files"></i>
                                <span>Library</span>
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="bi bi-option"></i>
                                <span>Language: English</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="bi bi-question-circle"></i>
                                <span> Help?</span>
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ url('logout') }}">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>

                    </ul>
                    <!-- End Profile Dropdown Items -->
                </li>
                <!-- End Profile Nav -->
            @endif
        </ul>
    </nav>
    <!-- End Icons Navigation -->
</header>
<!-- End Header -->
