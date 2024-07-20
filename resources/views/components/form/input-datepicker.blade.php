
<input type="text" class="form-control" placeholder="YYYY/MM/DD" id="flatpickr-date" name="{{ $name }}" value="{{ $value ?? '' }}">

@push('links')
    <link rel="stylesheet" href="/assets/admin/vendor/libs/flatpickr/flatpickr.css">
    <link rel="stylesheet" href="/assets/admin/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css">
    <link rel="stylesheet" href="/assets/admin/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
    <link rel="stylesheet" href="/assets/admin/vendor/libs/jquery-timepicker/jquery-timepicker.css">
    <link rel="stylesheet" href="/assets/admin/vendor/libs/pickr/pickr-themes.css">
@endpush

@push('scripts')
    <script src="/assets/admin/vendor/libs/moment/moment.js"></script>
    <script src="/assets/admin/vendor/libs/jdate/jdate.js"></script>
    <script src="/assets/admin/vendor/libs/flatpickr/flatpickr-jdate.js"></script>
    <script src="/assets/admin/vendor/libs/flatpickr/l10n/fa-jdate.js"></script>
    <script src="/assets/admin/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="/assets/admin/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
    <script src="/assets/admin/vendor/libs/jquery-timepicker/jquery-timepicker.js"></script>
    <script src="/assets/admin/vendor/libs/pickr/pickr.js"></script>
    <script src="/assets/admin/js/forms-pickers.js"></script>
@endpush