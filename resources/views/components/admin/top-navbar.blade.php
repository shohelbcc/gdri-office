<!-- ########## START: HEAD PANEL ########## -->
<div class="sl-header">
    <div class="sl-header-left">
      <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a></div>
      <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href=""><i class="icon ion-navicon-round"></i></a></div>
    </div><!-- sl-header-left -->
    <div class="sl-header-right">
      <nav class="nav">
        <div class="dropdown">
          <a href="" class="nav-link nav-link-profile d-flex flex-column justify-content-center align-items-center" data-bs-toggle="dropdown">
            {{-- @if (isset(Auth::user()->photo)) --}}
            @if (!Auth::user()->photo)
              <img src="{{ asset('images/avater.jpg') }}" class="wd-32 rounded-circle" alt="">
            @else
              <img src="{{ asset(Auth::user()->photo) }}" class="wd-32 rounded-circle" alt="">
            @endif
            <span class="logged-name">{{ Auth::user()->name }}</span>
          </a>
          <div class="dropdown-menu bg-dark">
            <ul class="list-unstyled user-profile-nav">
              <li><a href="{{ route('admin.profile.edit') }}"><i class="icon ion-ios-person-outline"></i>Profile</a></li>
              <form action="{{ route('admin.logout') }}" method="post">
                @csrf
                @method('POST')
                <li>
                    <button type="submit" class="logout"><i class="icon ion-power"></i>Sign Out</button>
                </li>
              </form>

            </ul>
          </div><!-- dropdown-menu -->
        </div><!-- dropdown -->
      </nav>

    </div><!-- sl-header-right -->
  </div><!-- sl-header -->
  <!-- ########## END: HEAD PANEL ########## -->
