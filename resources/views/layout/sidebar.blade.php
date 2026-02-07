

   
<div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ URL::asset('public/images/logo/cybercore_logo.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ URL::asset('public/images/logo/cybercore_logo.png') }}" alt="" height="17">
                    </span>
                </a>
                <!-- Light Logo-->
                 
               <a href="#" class="logo logo-light">
                <span class="logo-sm">
                    @if(Auth::user()->role === 'Super Admin')
                        <img src="{{ asset('images/logo/cybercore_logo.png') }}" alt="Default Logo" height="30">
                    @elseif(Auth::user()->barangay && Auth::user()->barangay->photo)
                        <img src="{{ asset('public/barangay/logo/' . Auth::user()->barangay->barangay_name . '/' . Auth::user()->barangay->photo) }}" 
                            alt="{{ Auth::user()->barangay->barangay_name }} Logo" height="30">
                    @else
                        <img src="{{ asset('public/images/logo/cybercore_logo.png') }}" alt="Default Logo" height="30">
                    @endif
                </span>

                <span class="logo-lg">
                    @if(Auth::user()->role === 'Super Admin')
                        <img src="{{ asset('public/images/logo/cybercore_logo.png') }}" alt="Default Logo" height="150">
                    @elseif(Auth::user()->barangay && Auth::user()->barangay->photo)
                        <img src="{{ asset('public/barangay/logo/' . Auth::user()->barangay->barangay_name . '/' . Auth::user()->barangay->photo) }}" 
                            alt="{{ Auth::user()->barangay->barangay_name }} Logo" height="150">
                    @else
                        <img src="{{ asset('public/images/logo/cybercore_logo.png') }}" alt="Default Logo" height="150">
                    @endif
                </span>
            </a>

                
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>
    
            <div id="scrollbar">
                <div class="container-fluid">
                    <div id="two-column-menu">
                    </div>

                

                    @if(Auth::check() && Auth::user()->role === 'Super Admin')
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="">
                                 <i class="ri-dashboard-line"></i> <span data-key="t-widgets">Dashboard</span>
                            </a>
                        </li>
                         
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#profiling" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="profiling">
                                   <i class="ri-user-search-line"></i> <span data-key="t-apps">Profiling</span>
                            </a>
                            <div class="collapse menu-dropdown" id="profiling">
                                <ul class="nav nav-sm flex-column">
                                   
                                    <li class="nav-item">
                                        <a href="apps-chat.html" class="nav-link" data-key="t-chat">Inhabitans</a>
                                    </li>
                                     <li class="nav-item">
                                        <a href="" class="nav-link" data-key="t-chat">Household</a>
                                    </li>
                                    
                                </ul>
                            </div>
                        </li>
                           
                      
                      <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                                <i class="ri-settings-3-line"></i> <span data-key="t-apps">Settings</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarApps">
                                <ul class="nav nav-sm flex-column">
                                   
                                    <li class="nav-item">
                                        <a href="{{route('brgy.info')}}" class="nav-link" data-key="t-chat">Barangay Info</a>
                                    </li>
                                     <li class="nav-item">
                                        <a href="{{route('position')}}" class="nav-link" data-key="t-chat">Barangay Positions</a>
                                    </li>
                                     <li class="nav-item">
                                        <a href="{{route('barangay.commitee')}}" class="nav-link" data-key="t-chat">Barangay Commitee</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link menu-link" href="{{route('user.management')}}">
                               <i class="ri-user-settings-line"></i>
                            <span data-key="t-widgets">User Management</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="widgets.html">
                                <i class="ri-file-chart-line"></i><span data-key="t-widgets">Reports</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="widgets.html">
                                <i class="ri-database-2-line"></i> <span data-key="t-widgets">Data Logs</span>
                            </a>
                        </li>
                        

                    </ul>
                   @endif

                    @if(Auth::check() && Auth::user()->role === 'Admin')
    <ul class="navbar-nav" id="navbar-nav">

                <!-- MAIN -->
                 
                <li class="menu-title"><span>Main</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#">
                        <i class="ri-dashboard-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- PROFILING -->
                <li class="menu-title"><span>Profiling</span></li>
              
              
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#profiling" data-bs-toggle="collapse">
                        <i class="ri-user-search-line"></i>
                        <span>Profiling</span>
                    </a>
                    <div class="collapse menu-dropdown" id="profiling">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="apps-chat.html" class="nav-link">Inhabitants</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">Household</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- SERVICES -->
               
                <li class="nav-item">
                    <a class="nav-link menu-link" href="widgets.html">
                        <i class="ri-award-line"></i>
                        <span>Certification</span>
                    </a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link menu-link" href="widgets.html">
                        <i class="ri-file-warning-line"></i>

                        <span>Blotter</span>
                    </a>
                </li>

              

                <!-- SETTINGS -->
                <li class="menu-title"><span>System Settings</span></li>
                                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#recordsMenu"
                        data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="recordsMenu">
                            <i class="ri-folder-chart-line"></i>
                            <span>Records</span>
                        </a>

                        <div class="collapse menu-dropdown" id="recordsMenu">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item">
                                    <a class="nav-link" href="widgets.html">
                                        <i class="ri-file-chart-line me-2"></i>
                                        Reports
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="widgets.html">
                                        <i class="ri-database-2-line me-2"></i>
                                        Data Logs
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#settings" data-bs-toggle="collapse">
                        <i class="ri-settings-3-line"></i>
                        <span>Settings</span>
                    </a>
                    <div class="collapse menu-dropdown" id="settings">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('brgy.info') }}" class="nav-link">Barangay Officials</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('purok') }}" class="nav-link">Purok</a>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>
                    @endif

                </div>
                <!-- Sidebar -->
                
            </div>

            <div class="sidebar-background"></div>
        </div>

   