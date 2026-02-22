<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">


<!-- Mirrored from themesbrand.com/velzon/html/master/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 12 Aug 2024 07:44:28 GMT -->
<head>

    <meta charset="utf-8" />
    <title>Dashboard | Barangay Informatio Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
   
    <link rel="stylesheet" href="{{ URL::asset('public/Dashboard-Template-Velzon-main/assets/libs/jsvectormap/css/jsvectormap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('public/Dashboard-Template-Velzon-main/assets/libs/swiper/swiper-bundle.min.css') }}">
    <script src="{{ asset('public/Dashboard-Template-Velzon-main/assets/js/layout.js') }}"></script>
    <link rel="stylesheet" href="{{ URL::asset('public/Dashboard-Template-Velzon-main/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('public/Dashboard-Template-Velzon-main/assets/css/icons.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('public/Dashboard-Template-Velzon-main/assets/css/app.min.css') }}">   
    <link rel="stylesheet" href="{{ URL::asset('public/Dashboard-Template-Velzon-main/assets/css/custom.min.css') }}">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
  .history-card {
    border-radius: 18px;
    overflow: hidden;
    background: linear-gradient(145deg, #ffffff, #f8fbff);
}

/* ICON STYLE */
.section-header-icon {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    background: linear-gradient(135deg, #0d6efd, #4dabf7);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

/* TIMELINE */
.timeline-item {
    position: relative;
    padding-left: 40px;
    margin-bottom: 35px;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    width: 2px;
    height: 100%;
    background: #dee2e6;
}

.timeline-dot {
    position: absolute;
    left: 8px;
    top: 8px;
    width: 16px;
    height: 16px;
    background: #0d6efd;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 0 0 3px rgba(13,110,253,0.2);
}

/* YEAR CHIP */
.chip-year {
    display: inline-block;
    padding: 6px 14px;
    font-size: 12px;
    border-radius: 50px;
    background: rgba(13,110,253,0.1);
    color: #0d6efd;
    font-weight: 600;
    margin-bottom: 8px;
}

/* POPULATION GRID */
.population-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
}

.year-pop-item {
    background: #f8f9fa;
    padding: 12px;
    border-radius: 12px;
    text-align: center;
    transition: 0.3s ease;
}

.year-pop-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.year-pop-item .year {
    font-size: 12px;
    color: #6c757d;
}

.year-pop-item .pop {
    font-weight: bold;
    font-size: 16px;
    color: #0d6efd;
}

/* STAT CARDS */
.stat-number {
    font-size: 20px;
    font-weight: bold;
    color: #0d6efd;
}

.stat-label {
    font-size: 13px;
    color: #6c757d;
}

/* DELICACY BADGE */
.delicacy-badge {
    background: #fff3cd;
    color: #856404;
    padding: 5px 10px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 600;
}

/* SOFT ANIMATION */
.timeline-item,
.year-pop-item,
.stat-number {
    animation: fadeUp 0.6s ease forwards;
}

@keyframes fadeUp {
    from {opacity:0; transform:translateY(10px);}
    to {opacity:1; transform:translateY(0);}
}
.history-card {
    border-radius: 18px;
    overflow: hidden;
    background: linear-gradient(145deg, #ffffff, #f8fbff);
}

/* HEADER ICON */
.section-header-icon {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    background: linear-gradient(135deg, #0d6efd, #4dabf7);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

/* ============================= */
/* IMAGE SLIDER */
/* ============================= */
.history-card {
    border-radius: 18px;
    overflow: hidden;
    background: linear-gradient(145deg, #ffffff, #f8fbff);
}

/* HEADER ICON */
.section-header-icon {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    background: linear-gradient(135deg, #0d6efd, #4dabf7);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

/* ============================= */
/* IMAGE SLIDER */
/* ============================= */
.history-slider {
    position: relative;
    overflow: hidden;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    margin-top: 30px;
}

.slider-wrapper {
    position: relative;
    width: 100%;
    height: 420px;
}

.slide {
    position: absolute;
    width: 100%;
    height: 100%;
    display: none;
}

.slide.active {
    display: block;
}

.slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.slide-caption {
    position: absolute;
    bottom: 0;
    width: 100%;
    padding: 20px;
    background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
    color: #fff;
    font-weight: 600;
    font-size: 16px;
}

/* SLIDER BUTTONS */
.slider-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255,255,255,0.9);
    border: none;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    font-size: 20px;
    cursor: pointer;
    transition: 0.3s;
    z-index: 10;
}

.slider-btn:hover {
    background: #0d6efd;
    color: #fff;
}

.slider-btn.prev {
    left: 15px;
}

.slider-btn.next {
    right: 15px;
}


        </style>


</head>


<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

            @include('layout.navbar')

            @include('layout.sidebar')
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

                @yield('content')
            <!-- End Page-content -->

                @include('layout.footer')
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <!--start back-to-top-->
    
    

    <!-- Theme Settings -->
   
    <!-- JAVASCRIPT -->
    <script src="{{ asset('public/js/app.js') }}"></script>

    <!-- jQuery & Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('public/Dashboard-Template-Velzon-main/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('public/Dashboard-Template-Velzon-main/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('public/Dashboard-Template-Velzon-main/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('public/Dashboard-Template-Velzon-main/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('public/Dashboard-Template-Velzon-main/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('public/Dashboard-Template-Velzon-main/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>
    <script src="{{ asset('public/Dashboard-Template-Velzon-main/assets/libs/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('public/Dashboard-Template-Velzon-main/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>
    <script src="{{ asset('public/Dashboard-Template-Velzon-main/assets/js/app.js') }}"></script>
   <script src="<?php echo asset('public/js/tinymce/tinymce.min.js')?>"></script>
  
 </script>
 
</body>



<!-- Mirrored from themesbrand.com/velzon/html/master/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 12 Aug 2024 07:45:33 GMT -->
</html>