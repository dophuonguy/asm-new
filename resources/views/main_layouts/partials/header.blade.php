<div class="header--topbar  bg--color-1">
    <div class="container">
        <div class="float--left float--xs-none text-xs-center">
            <!-- Header Topbar Info Start -->
            <ul class="header--topbar-info nav">
                <li>
                    <a href="{{ route('home') }}">
                        <img style="border-radius: 12px; height: 40px;" src="{{ asset('reader/images/logo.png') }}" alt="logo">
                    </a>
                </li>
                <li><i class="fa fm fa-map-marker"></i>Hà nội</li>
                <li><i class="fa fm fa-mixcloud"></i>28<sup>0</sup> C</li>
                <li style="text-transform: capitalize" ><i class="fa fm fa-calendar"></i>Hôm nay ( {{ $now->translatedFormat('l') }}, Ngày {{ $now->translatedFormat('jS F')}} Năm {{ $now->translatedFormat('Y')}} )</li>
            </ul>
            <!-- Header Topbar Info End -->
        </div>

        <div class="float--right float--xs-none text-xs-center">
            <!-- Header Topbar Action Start -->
            <ul class="header--topbar-action nav">
                    @guest
                    <li class="btn-cta">
                        <a href="{{ route('login') }}">
                            <i class="fa fm fa-user-o"></i>
                            <span>Đăng Nhập</span>
                        </a>
                    </li>
                    <li class="btn-cta">
                        <a href="{{ route('register') }}">
                            <i class="fa fm fa-user-o"></i>
                            <span>Đăng kí</span>
                        </a>
                    </li>
                    @endguest

                    @auth
                        <li class="has-dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <i class="fa fm fa-user-o"></i>
                                {{ auth()->user()->name }} 
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                @if(auth()->user()->role->name !== 'user')
                                <li>
                                    <a href="{{ route('admin.index') }}">Admin - Dashbroad</a>
                                </li>
                                @endif
                                <li>
                                    <a href="{{ route('profile') }}">Tài khoản của tôi</a>
                                </li>
                                <li>
                                    <a onclick="event.preventDefault(); document.getElementById('nav-logout-form').submit();"
                                    href="">Đăng xuất
                                    <i class="fa fm fa-arrow-circle-right"></i>
                                    </a>

                                    <form id="nav-logout-form" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth

            </ul>
            <!-- Header Topbar Action End -->


            <!-- Header Topbar Social Start -->
            <ul class="header--topbar-social nav hidden-sm hidden-xxs">
                
            </ul>
            <!-- Header Topbar Social End -->
        </div>
    </div>
</div>
<!-- Header Topbar End -->

<!-- Header Navbar Start -->
<div class="header--navbar navbar bd--color-1 bg--color-0" data-trigger="sticky">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#headerNav"
                aria-expanded="false" aria-controls="headerNav">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div id="headerNav" class="navbar-collapse collapse float--left">
            <!-- Header Menu Links Start -->
            <ul class="header--menu-links nav navbar-nav" data-trigger="hoverIntent">
                <li>
                    <a href="{{ route('home') }}">
                        <i class="icon_home fa fa-home"></i>
                    </a>
                </li>
                @foreach($categories as $category)
                    <li><a href="{{ route('categories.show', $category) }}">{{ $category->name }}</a></li>
                @endforeach

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Trang<i
                            class="fa flm fa-angle-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('about') }}">Giới thiệu</a></li>
                        <li><a href="{{ route('contact.create') }}">Liên hệ</a></li>
                        <li><a href="{{ route('erorrs.404') }}">404</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('categories.index') }}">
                        <span style="color: #ccc; margin-right: 10px;">Tất cả</span>
                        <img  width="17" class="icon-menu" src="https://static.vnncdn.net/v1/icon/menu-center.svg">
                    </a>
                </li>
            </ul>
            <!-- Header Menu Links End -->
        </div>

        <!-- Header Search Form Start -->
        <form method="POST" action="{{ route('search') }}" class="header--search-form float--right" data-form="validate">
            @csrf	
            <input type="search" name="search" placeholder="Search..." class="header--search-control form-control"
            required>

            <button type="submit" class="header--search-btn btn"><i
                    class="header--search-icon fa fa-search"></i></button>
        </form>
        <!-- Header Search Form End -->
    </div>
</div>