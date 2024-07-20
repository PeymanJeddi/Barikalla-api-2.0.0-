<!DOCTYPE html>
<html lang="fa" class="light-style layout-navbar-fixed layout-menu-fixed" dir="rtl" data-theme="theme-default"
    data-assets-path="/assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <title>{{ $title }}</title>

    <meta name="description" content="">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/img/favicon/favicon.ico">

    <!-- Icons -->
    <link rel="stylesheet" href="/assets/vendor/fonts/boxicons.css">
    <link rel="stylesheet" href="/assets/vendor/fonts/fontawesome.css">
    <link rel="stylesheet" href="/assets/vendor/fonts/flag-icons.css">

    <!-- Core CSS -->
    <link rel="stylesheet" href="/assets/vendor/css/rtl/core.css" class="template-customizer-core-css">
    <link rel="stylesheet" href="/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css">
    <link rel="stylesheet" href="/assets/css/demo.css">
    <link rel="stylesheet" href="/assets/vendor/css/rtl/rtl.css">


    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/assets/vendor/libs/typeahead-js/typeahead.css">
    <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="/assets/vendor/libs/sweetalert2/sweetalert2.css">

    
    @stack('links')

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="/assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="/assets/js/config.js"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('admin.partials._menu')
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                @include('admin.partials._navbar')

                <!-- / Navbar -->

                <!-- Content wrapper -->
                @yield('content')
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="/assets/vendor/libs/popper/popper.js"></script>
    <script src="/assets/vendor/js/bootstrap.js"></script>
    <script src="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="/assets/vendor/libs/hammer/hammer.js"></script>

    <script src="/assets/vendor/libs/i18n/i18n.js"></script>
    <script src="/assets/vendor/libs/typeahead-js/typeahead.js"></script>

    <script src="/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="/assets/js/dashboards-analytics.js"></script>
    <script src="/assets/js/extended-ui-sweetalert2.js"></script>
    <script src="/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

    <!-- Custom JS -->
    <script src="/assets/js/custom/app-backend.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    @stack('scripts')
    {{-- @include('sweetalert::alert') --}}

</body>

</html>
