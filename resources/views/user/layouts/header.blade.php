<header class="top-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between">
                    <div class="header-search">
                        <i class="bi bi-search"></i>
                        <input type="search" class="" placeholder="search...">
                    </div>
                    <div class="menu-icon"><i class="bi bi-list"></i></div>
                    <div class="d-flex align-items-center">
                        <div class="px-3 ">
                            <a href="{{ URL::to('/user/notifications') }}">
                                <div class="notifications mt-1">
                                    <i class="bi bi-bell-fill header-notification "></i>
                                    <div class="number">
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="d-flex align-items-center user-account ps-2">

                            <div class="user-icon">
                                @if (Auth::user()->profile_image)
                                @php
                                    $image = Auth::user()->profile_image;
                                @endphp
                                <img class="mw-100 rounded rounded-circle"
                                    src="{{ URL::to('/storage/images/users/sm/' . $image) }}" alt="">
                            @else
                                <img src="{{ URL::to('/assets/images/Avatar.png') }}" alt="">
                            @endif                            </div>
                            <div class="dropdown profile-dropdown">
                                <button class=" dropdown-toggle" type="button" id="dropdownMenuButton1"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <a class="dropdown-item" href="{{ URL::to('/settings') }}">
                                            <i class="bi bi-gear me-2"></i>Settings
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ URL::to('/logout') }}">
                                            <i class="bi bi-box-arrow-left me-2"></i>Logout
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</header>
