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
                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ URL::asset('public/images/logo/cybercore_logo.png') }}" alt="" height="30">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ URL::asset('public/images/logo/cybercore_logo.png') }}" alt="" height="150">
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
                 
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>