<nav class="navbar navbar-expand-lg navbar-white">
    <a class="navbar-brand order-1" href="{{ route('index') }}">
      <img class="img-fluid" width="100px" src="{{ asset('reader') }}/images/logo.png" alt="Reader | Hugo Personal Blog Template">
    </a>
    <div class="collapse navbar-collapse text-center order-lg-2 order-3" id="navigation">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item dropdown">
              <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                  aria-expanded="false">
                  Trang chủ
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                  aria-expanded="false">
                  About <i class="ti-angle-down ml-1"></i>
              </a>
            <div class="dropdown-menu">

                <a class="dropdown-item" href="about-me.html">Tin xem nhiều</a>

                <a class="dropdown-item" href="about-us.html"></a>

                <a class="dropdown-item" href="about-us.html">About Us</a>

            </div>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                  aria-expanded="false">Pages <i class="ti-angle-down ml-1"></i>
              </a>
              <div class="dropdown-menu">

                  <a class="dropdown-item" href="author.html">Author</a>

                  <a class="dropdown-item" href="author-single.html">Author Single</a>

                  <a class="dropdown-item" href="advertise.html">Advertise</a>

                  <a class="dropdown-item" href="post-details.html">Post Details</a>

                  <a class="dropdown-item" href="post-elements.html">Post Elements</a>

                  <a class="dropdown-item" href="tags.html">Tags</a>

                  <a class="dropdown-item" href="search-result.html">Search Result</a>

                  <a class="dropdown-item" href="search-not-found.html">Search Not Found</a>

                  <a class="dropdown-item" href="privacy-policy.html">Privacy Policy</a>

                  <a class="dropdown-item" href="terms-conditions.html">Terms Conditions</a>

                  <a class="dropdown-item" href="404.html">404 Page</a>

              </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('contact') }}">Phản hồi</a>
            </li>
        </ul>
        <form class="search-bar">
            <input id="search-query" name="s" type="search" placeholder="Type &amp; Hit Enter...">
        </form>
    </div>
    <div class="order-2 order-lg-3 d-flex align-items-center">
      @guest
        @if (Route::has('login'))
            <a class="btn btn-primary ml-3" href="{{ route('login') }}">{{ __('Login') }}</a>
        @endif
        @if (Route::has('register'))
            <a class="btn btn-danger ml-3" href="{{ route('register') }}">{{ __('Register') }}</a>
        @endif
      @else
      <ul class="navbar-nav ">
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
          aria-expanded="false">
              {{ Auth::user()->name }}
          </a>

          <div class="dropdown-menu">
              <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                  {{ __('Logout') }}
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
              </form>
          </div>
        </li>
      </ul>
      @endguest
    </div>
    
</nav>
<!-- Modal -->
