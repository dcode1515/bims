<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">


<!-- Mirrored from themesbrand.com/velzon/html/master/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 12 Aug 2024 07:44:28 GMT -->
<head>

    <meta charset="utf-8" />
    <title>Dashboard | Barangay Informatio Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <link rel="stylesheet" href="{{ URL::asset('public/Dashboard-Template-Velzon-main/assets/libs/jsvectormap/css/jsvectormap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('public/Dashboard-Template-Velzon-main/assets/libs/swiper/swiper-bundle.min.css') }}">
    <script src="{{ asset('public/Dashboard-Template-Velzon-main/assets/js/layout.js') }}"></script>
    <link rel="stylesheet" href="{{ URL::asset('public/Dashboard-Template-Velzon-main/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('public/Dashboard-Template-Velzon-main/assets/css/icons.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('public/Dashboard-Template-Velzon-main/assets/css/app.min.css') }}">   
    <link rel="stylesheet" href="{{ URL::asset('public/Dashboard-Template-Velzon-main/assets/css/custom.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
  
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
    <script src="{{ asset('public/js/app.js') }}?v={{ config('app.version') }}"></script>

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

</body>


<!-- Mirrored from themesbrand.com/velzon/html/master/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 12 Aug 2024 07:45:33 GMT -->
</html>