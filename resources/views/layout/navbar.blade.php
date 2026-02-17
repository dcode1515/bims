<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
               

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger material-shadow-none" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

            
                
            </div>

            <div class="d-flex align-items-center">

              
               
               
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar material-shadow-none btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar material-shadow-none btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>

                

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                              @php
                                $user = Auth::user();
                                $initials = strtoupper(substr($user->firstname, 0, 1) . substr($user->lastname, 0, 1));
                            @endphp
                              @if(!empty($user->photo))
                                <img
                                    class="rounded-circle header-profile-user"
                                    src="{{ asset('public/user/profile/' . $user->firstname . '_' . $user->lastname . '/' . $user->photo) }}"
                                    alt="Header Avatar">
                            @else
                                <div class="rounded-circle header-profile-user d-flex align-items-center justify-content-center bg-primary text-white fw-bold">
                                    {{ $initials }}
                                </div>
                            @endif
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">
                                    
                                    {{Auth::user()->firstname}} {{Auth::user()->middle_initial}}. {{Auth::user()->lastname}}
                                </span>
                                <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">{{Auth::user()->barangay->barangay_name}}</span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome {{Auth::user()->firstname}}!</h6>
                        <a class="dropdown-item" href="{{ route('profile.show', ['id' => Auth::id()]) }}"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
                        <a class="dropdown-item"
                    href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                        <span class="align-middle">Logout</span>
                    </a>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
