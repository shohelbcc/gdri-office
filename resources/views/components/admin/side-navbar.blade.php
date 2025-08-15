<!-- ########## START: LEFT PANEL ########## -->
<div class="sl-logo">
  <a href="{{ route('home') }}" target="_blank">
    <img src="{{ asset('images/logo.png') }}" style="width: 80px; height: auto;" alt="Logo">
  </a>
</div>

<div class="sl-sideleft">


  <div class="sl-sideleft-menu">

    <!-- Dashboard -->
    @can('dashboard')
    <a href="{{ route('dashboard') }}" class="sl-menu-link {{ Route::is('dashboard') ? 'active' : '' }}">
      <div class="sl-menu-item">
      <i class="menu-item-icon fa-solid fa-home tx-20 me-2"></i>
      <span class="menu-item-label">Dashboard</span>
      </div><!-- menu-item -->
    </a><!-- sl-menu-link -->
  @endcan

    <!-- User Management Start -->
    @can('view-user')
    <a href="#" class="sl-menu-link {{Request::is('admin/user*') ? 'show-sub' : ''}}">
      <div class="sl-menu-item">
      <i class="menu-item-icon fa-solid fa-building me-2 tx-20"></i>
      <span class="menu-item-label">User Management</span>
      <i class="menu-item-arrow fa fa-angle-down ms-2"></i>
      </div><!-- menu-item -->
    </a><!-- sl-menu-link -->
    <ul class="sl-menu-sub nav flex-column">
      <li class="nav-item">
      <a href="{{ route('admin.user.index') }}"
        class="nav-link {{ request()->is('admin/user*') ? 'active' : '' }}">All Users</a>
      </li>
    </ul>
  @endcan
    <!-- User Management End -->

    <!-- Role Management Start -->
    @can('view-role')
    <a href="#"
      class="sl-menu-link {{Request::is('admin/role*') || Request::is('admin/permission*') ? 'show-sub' : ''}}">
      <div class="sl-menu-item">
      <i class="menu-item-icon fa-solid fa-user-shield me-2 tx-20"></i>
      <span class="menu-item-label">Role Management</span>
      <i class="menu-item-arrow fa fa-angle-down ms-2"></i>
      </div><!-- menu-item -->
    </a><!-- sl-menu-link -->
    <ul class="sl-menu-sub nav flex-column">
      @can('view-role')
      <li class="nav-item">
      <a href="{{ route('admin.role.index') }}"
      class="nav-link {{ request()->is('admin/role*') ? 'active' : '' }}">All Roles</a>
      </li>
    @endcan
      @can('view-permission')
      <li class="nav-item">
      <a href="{{ route('admin.permission.index') }}"
      class="nav-link {{ request()->is('admin/permission*') ? 'active' : '' }}">All Permissions</a>
      </li>
    @endcan
    </ul>
  @endcan
    <!-- Role Management End -->

    <!-- Employee Attendance Management Start -->
    @if (Auth::user()->hasRole('employee'))
    <a href="{{ route('attendance.index') }}" class="sl-menu-link {{ Route::is('attendance.index') ? 'active' : '' }}">
      <div class="sl-menu-item">
      <i class="menu-item-icon fa-solid fa-pen-to-square tx-20 me-2"></i>
      <span class="menu-item-label">Attendance</span>
      </div><!-- menu-item -->
    </a><!-- sl-menu-link -->
  @endif
    <!-- Employee Attendance Management End -->

    <!-- Admin Attendance Management Start -->
    @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('super admin'))
    <a href="{{ route('admin.attendance.index') }}"
      class="sl-menu-link {{ Route::is('admin.attendance.index') ? 'active' : '' }}">
      <div class="sl-menu-item">
      <i class="menu-item-icon fa-solid fa-pen-to-square tx-20 me-2"></i>
      <span class="menu-item-label">Attendances</span>
      </div><!-- menu-item -->
    </a><!-- sl-menu-link -->
  @endif
    <!-- Admin Attendance Management End -->

    <!-- Employee Leave Application Management Start -->
    @if (Auth::user()->hasRole('employee'))
    <a href="{{ route('leave.application.index') }}"
      class="sl-menu-link {{ Route::is('leave.application.index') ? 'active' : '' }}">
      <div class="sl-menu-item">
      <i class="menu-item-icon fa-solid fa-trash-arrow-up tx-20 me-2"></i>
      <span class="menu-item-label">Leave Applications</span>
      </div><!-- menu-item -->
    </a><!-- sl-menu-link -->
  @endif
    <!-- Employee Leave Application Management End -->

    <!-- Admin Leave Application Management Start -->
    @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('super admin'))
    <a href="{{ route('admin.leave.application.index') }}"
      class="sl-menu-link {{ Route::is('admin.leave.application.index') ? 'active' : '' }}">
      <div class="sl-menu-item">
      <i class="menu-item-icon fa-solid fa-trash-arrow-up tx-20 me-2"></i>
      <span class="menu-item-label">Leave Applications</span>
      </div><!-- menu-item -->
    </a><!-- sl-menu-link -->
  @endif
    <!-- Admin Leave Application Management End -->

    <!-- Admin Notification Management Start -->
    @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('super admin'))
    <a href="{{ route('admin.notice.index') }}"
      class="sl-menu-link {{ Route::is('admin.notice.index') ? 'active' : '' }}">
      <div class="sl-menu-item">
      <i class="menu-item-icon fa-solid fa-bell tx-20 me-2"></i>
      <span class="menu-item-label">Notifications</span>
      </div><!-- menu-item -->
    </a><!-- sl-menu-link -->
  @endif
    <!-- Admin Notification Management End -->

    <!-- Employee Notification Management Start -->
    @if (Auth::user()->hasRole('employee'))
    <a href="{{ route('employee.notice.index') }}"
      class="sl-menu-link {{ Route::is('employee.notice.index') ? 'active' : '' }}">
      <div class="sl-menu-item position-relative">
      <i class="menu-item-icon fa-solid fa-bell tx-20 me-2"></i>
      <span class="menu-item-label">Notifications</span>
      <span id="employee-unread-badge"
        class="position-absolute top-3 end-0 translate-middle badge rounded-pill bg-success">
        {{-- {{ $unreadNotices }} --}}
        <span class="visually-hidden">unread notifications</span>
      </span>
      </div><!-- menu-item -->
    </a><!-- sl-menu-link -->
  @endif
    <!-- Employee Notification Management End -->

    <!-- Employee Task Management Start -->
    @if (Auth::user()->hasRole('employee'))
    <a href="#"
      class="sl-menu-link {{ Request::is('employee/task*') || Request::is('employee/completed/task') ? 'show-sub' : ''}}">
      <div class="sl-menu-item">
      <i class="menu-item-icon fa-solid fa-user-shield me-2 tx-20"></i>
      <span class="menu-item-label">Task Management</span>
      <i class="menu-item-arrow fa fa-angle-down ms-2"></i>
      </div><!-- menu-item -->
    </a><!-- sl-menu-link -->
    <ul class="sl-menu-sub nav flex-column">
      @can('view-employee-task')
      <li class="nav-item">
      <a href="{{ route('employee.task.assigned.index') }}"
      class="nav-link {{ request()->is('employee/task*') ? 'active' : '' }}">Task Assigned</a>
      </li>
    @endcan
      @can('view-employee-task')
      <li class="nav-item">
      <a href="{{ route('employee.task.completed.index') }}"
      class="nav-link {{ request()->is('employee/completed/task') ? 'active' : '' }}">Task Received</a>
      </li>
    @endcan
    </ul>
  @endif
    <!-- Employee Task Management End -->

    <!-- Admin Notice Management Start -->
    @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('super admin'))
    <a href="#"
      class="sl-menu-link {{ Request::is('admin/task*') || Request::is('admin/completed/task') ? 'show-sub' : ''}}">
      <div class="sl-menu-item">
      <i class="menu-item-icon fa-solid fa-user-shield me-2 tx-20"></i>
      <span class="menu-item-label">Task Management</span>
      <i class="menu-item-arrow fa fa-angle-down ms-2"></i>
      </div><!-- menu-item -->
    </a><!-- sl-menu-link -->
    <ul class="sl-menu-sub nav flex-column">
      @can('view-admin-task')
      <li class="nav-item">
      <a href="{{ route('admin.task.assigned.index') }}"
      class="nav-link {{ request()->is('admin/task*') ? 'active' : '' }}">Task Assigned</a>
      </li>
    @endcan
      @can('view-admin-task')
      <li class="nav-item">
      <a href="{{ route('admin.task.completed.index') }}"
      class="nav-link {{ request()->is('admin/completed/task') ? 'active' : '' }}">Task Received</a>
      </li>
    @endcan
    </ul>
  @endif
    <!-- Admin Task Management End -->

    {{-- Home Page Content --}}

    <hr>
    <span style="display: block; font-weight:bold; text-align: center; margin: 5px auto">--- Home Content---</span>


    <!-- Branch Start -->
    @can('view-admin-branch')
      <a href="{{ route('admin.branch.index') }}" class="sl-menu-link {{ request()->is('admin/branch*') ? 'active' : '' }}">
        <div class="sl-menu-item">
        <i class="menu-item-icon fa-solid fa-building tx-20 me-2"></i>
        <span class="menu-item-label">Branches</span>
        </div><!-- menu-item -->
      </a><!-- sl-menu-link -->
    @endcan
    <!-- Branch End -->

    <!-- Admin Blog Management Start -->
    @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('super admin'))
    <a href="#" class="sl-menu-link {{ Request::is('admin/blog/*') ? 'show-sub' : ''}}">
      <div class="sl-menu-item">
      <i class="menu-item-icon fa-solid fa-blog me-2 tx-20"></i>
      <span class="menu-item-label">Blog Management</span>
      <i class="menu-item-arrow fa fa-angle-down ms-2"></i>
      </div><!-- menu-item -->
    </a><!-- sl-menu-link -->
    <ul class="sl-menu-sub nav flex-column">
      @can('view-admin-blog-category')
      <li class="nav-item">
      <a href="{{ route('admin.blog.category.index') }}"
      class="nav-link {{ request()->is('admin/blog/category*') ? 'active' : '' }}">Categories</a>
      </li>
    @endcan
      @can('view-admin-blog-author')
      <li class="nav-item">
      <a href="{{ route('admin.blog.author.index') }}"
      class="nav-link {{ request()->is('admin/blog/author*') ? 'active' : '' }}">Authors</a>
      </li>
    @endcan
      @can('view-admin-blog-tag')
      <li class="nav-item">
      <a href="{{ route('admin.blog.tag.index') }}"
      class="nav-link {{ request()->is('admin/blog/tag*') ? 'active' : '' }}">Tags</a>
      </li>
    @endcan
      @can('view-admin-blog-post')
      <li class="nav-item">
      <a href="{{ route('admin.blog.post.index') }}"
      class="nav-link {{ request()->is('admin/blog/post') ? 'active' : '' }}">Posts</a>
      </li>
    @endcan
    </ul>
  @endif
    <!-- Admin Blog Management End -->

  <!-- Why GDRI -->
  @can('view-admin-why-gdri')
    <a href="{{ route('admin.why-gdri.index', 1) }}" class="sl-menu-link {{ Route::is('admin.why-gdri.index') ? 'active' : '' }}">
      <div class="sl-menu-item">
      <i class="menu-item-icon fa-solid fa-question-circle tx-20 me-2"></i>
      <span class="menu-item-label">Why GDRI?</span>
      </div><!-- menu-item -->
    </a><!-- sl-menu-link -->
  @endcan

  <!-- Impact Stories -->
  @can('view-admin-impact-stories')
    <a href="{{ route('admin.impact-stories.index') }}" class="sl-menu-link {{ request()->is('admin/impact-stories*') ? 'active' : '' }}">
      <div class="sl-menu-item">
      <i class="menu-item-icon fa-solid fa-book-open tx-20 me-2"></i>
      <span class="menu-item-label">Impact Stories</span>
      </div><!-- menu-item -->
    </a><!-- sl-menu-link -->
  @endcan

  <!-- Our Stories Start -->
  @can('view-admin-our-stories')
    <a href="{{ route('admin.our-story.index', 1) }}" class="sl-menu-link {{ request()->is('admin/our-story*') ? 'active' : '' }}">
      <div class="sl-menu-item">
      <i class="menu-item-icon fa-solid fa-book tx-20 me-2"></i>
      <span class="menu-item-label">Our Stories</span>
      </div><!-- menu-item -->
    </a><!-- sl-menu-link -->
  @endcan
  <!-- Our Stories End -->

  <!-- Services Start -->
  @can('view-admin-services')
    <a href="{{ route('admin.services.index') }}" class="sl-menu-link {{ request()->is('admin/services*') ? 'active' : '' }}">
      <div class="sl-menu-item">
      <i class="menu-item-icon fa-solid fa-concierge-bell tx-20 me-2"></i>
      <span class="menu-item-label">Services</span>
      </div><!-- menu-item -->
    </a><!-- sl-menu-link -->
  @endcan
  <!-- Services End -->

  <!-- Project Start -->
    @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('super admin'))
      <a href="#" class="sl-menu-link {{ Request::is('admin/project*') || Request::is('admin/partners*') ? 'show-sub' : ''}}">
        <div class="sl-menu-item">
        <i class="menu-item-icon fa-solid fa-project-diagram me-2 tx-20"></i>
        <span class="menu-item-label">Project Management</span>
        <i class="menu-item-arrow fa fa-angle-down ms-2"></i>
        </div><!-- menu-item -->
      </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">
          @can('view-admin-partners')
          <li class="nav-item">
          <a href="{{ route('admin.partners.index') }}"
          class="nav-link {{ request()->is('admin/partners*') ? 'active' : '' }}">Partners</a>
          </li>
        @endcan
          @can('view-admin-project-topic')
          <li class="nav-item">
          <a href="{{ route('admin.project.topic.index') }}"
          class="nav-link {{ request()->is('admin/project/topic*') ? 'active' : '' }}">Project Topic</a>
          </li>
        @endcan
          @can('view-admin-project')
          <li class="nav-item">
          <a href="{{ route('admin.project.index') }}"
          class="nav-link {{ request()->is('admin/project*') ? 'active' : '' }}">Projects</a>
          </li>
        @endcan
        </ul>
    @endif
    <!-- Project End -->

  <!-- Publication Start -->
    @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('super admin'))
      <a href="#" class="sl-menu-link {{ Request::is('admin/publication*') ? 'show-sub' : ''}}">
        <div class="sl-menu-item">
        <i class="menu-item-icon fa-solid fa-tv me-2 tx-20"></i>
        <span class="menu-item-label">Publication</span>
        <i class="menu-item-arrow fa fa-angle-down ms-2 ms-auto"></i>
        </div><!-- menu-item -->
      </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">
          @can('view-admin-partners')
          <li class="nav-item">
          <a href="{{ route('admin.publication.type.index') }}"
          class="nav-link {{ request()->is('admin/publication/type*') ? 'active' : '' }}">Publication Types</a>
          </li>
        @endcan
          @can('view-admin-project-topic')
          <li class="nav-item">
          <a href="{{ route('admin.publication.index') }}"
          class="nav-link {{ request()->is('admin/publication*') ? 'active' : '' }}">Publications</a>
          </li>
        @endcan
        </ul>
    @endif
    <!-- Publication End -->

  <!-- Policy Start -->
    @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('super admin'))
      <a href="#" class="sl-menu-link {{ Request::is('admin/privacy*') || Request::is('admin/term*') || Request::is('admin/license*') ? 'show-sub' : ''}}">
        <div class="sl-menu-item">
        <i class="menu-item-icon fa-solid fa-building-shield me-2 tx-20"></i>
        <span class="menu-item-label">Policy Management</span>
        <i class="menu-item-arrow fa fa-angle-down ms-2"></i>
        </div><!-- menu-item -->
      </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">
          @can('view-admin-privacy')
          <li class="nav-item">
          <a href="{{ route('admin.privacy.show', 1) }}"
          class="nav-link {{ request()->is('admin/privacy*') ? 'active' : '' }}">Privacy Policy</a>
          </li>
        @endcan
          @can('view-admin-term')
          <li class="nav-item">
          <a href="{{ route('admin.term.show', 1) }}"
          class="nav-link {{ request()->is('admin/term*') ? 'active' : '' }}">Terms & Conditions</a>
          </li>
        @endcan
          @can('view-admin-license')
          <li class="nav-item">
          <a href="{{ route('admin.license.show', 1) }}"
          class="nav-link {{ request()->is('admin/license*') ? 'active' : '' }}">License</a>
          </li>
        @endcan
        </ul>
    @endif
    <!-- Policy End -->

    <!-- Contact & Socials -->
    @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('super admin'))
      <a href="#" class="sl-menu-link {{ Request::is('admin/contact/*') || Request::is('admin/social/media/*') ? 'show-sub' : ''}}">
        <div class="sl-menu-item">
        <i class="menu-item-icon fa-solid fa-tower-cell me-2 tx-20"></i>
        <span class="menu-item-label">Contact & Socials</span>
        <i class="menu-item-arrow fa fa-angle-down ms-2"></i>
        </div><!-- menu-item -->
      </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">
          @can('view-admin-privacy')
          <li class="nav-item">
          <a href="{{ route('admin.contact.show', 1) }}"
          class="nav-link {{ request()->is('admin/contact/*') ? 'active' : '' }}">Contact</a>
          </li>
        @endcan
          @can('view-admin-social-media')
          <li class="nav-item">
          <a href="{{ route('admin.social.media.show', 1) }}"
          class="nav-link {{ request()->is('admin/social/media/*') ? 'active' : '' }}">Social Media</a>
          </li>
        @endcan
        </ul>
    @endif
    <!-- Contact & Socials -->

  <!-- Home Accordian Start -->
  @can('view-admin-home-accordian')
    <a href="{{ route('admin.home.accordian.index') }}" class="sl-menu-link {{ request()->is('admin/home-accordian*') ? 'active' : '' }}">
      <div class="sl-menu-item">
      <i class="menu-item-icon fa-solid fa-folder-open tx-20 me-2"></i>
      <span class="menu-item-label">Home Accordian</span>
      </div><!-- menu-item -->
    </a><!-- sl-menu-link -->
  @endcan
  <!-- Home Accordian End -->

  <!-- District Coverage Start -->
  @can('view-admin-district-coverage')
    <a href="{{ route('admin.district.coverage.index') }}" class="sl-menu-link {{ request()->is('admin/district/coverage*') ? 'active' : '' }}">
      <div class="sl-menu-item">
      <i class="menu-item-icon fa-solid fa-location-dot tx-20 me-2"></i>
      <span class="menu-item-label">District Coverage</span>
      </div><!-- menu-item -->
    </a><!-- sl-menu-link -->
  @endcan
  <!-- District Coverage End -->

  <!-- Experience Certificate Start -->
  @can('view-admin-experience-certificates')
    <a href="{{ route('admin.experience.certificates.index') }}" class="sl-menu-link {{ request()->is('admin/experience/certificates*') ? 'active' : '' }}">
      <div class="sl-menu-item">
      <i class="menu-item-icon fa-solid fa-award tx-20 me-2"></i>
      <span class="menu-item-label">Experience Certificate</span>
      </div><!-- menu-item -->
    </a><!-- sl-menu-link -->
  @endcan
  <!-- Experience Certificate End -->



  </div><!-- sl-sideleft-menu -->

  <br>
</div><!-- sl-sideleft -->
<!-- ########## END: LEFT PANEL ########## -->

@push('scripts')
  <script>
    updateUnreadNoticeBadge();
    async function updateUnreadNoticeBadge() {
    try {
      let res = await axios.get('/employee/notice/unread-count');
      let count = res.data.count ?? 0;
      // console.log('Unread notices count:', count); // Debugging line
      let badge = document.getElementById('employee-unread-badge');
      if (badge) {
      if (count > 0) {
        badge.textContent = count;
        badge.style.display = '';
      } else {
        badge.style.display = 'none';
      }
      }
    } catch (e) {
      // ignore
    }
    }
  </script>

@endpush