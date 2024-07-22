<x-default-layout :title="$pageTitle">

    <x-breadcrumb :items="['ثوابت سیستمی', 'لیست ثوابت', $pageTitle]">
    </x-breadcrumb>
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <div class="card-body">
                <a href="{{ route('admin.kindcategory.kind.create', $kindCategory) }}">
                    <button type="button" class="btn btn-primary">ایجاد ثابت</button>
                </a>
                <a href="{{ url()->previous() }}">
                    <button type="button" class="btn btn-dark">بازگشت</button>
                </a>
            </div>

            {{ $dataTable->table() }}


        </div>
    </div>

    @push('links')
        <link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css">z
        <link rel="stylesheet" href="/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css">
        <link rel="stylesheet" href="/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css">
        <link rel="stylesheet" href="/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css">
        <link rel="stylesheet" href="/assets/vendor/libs/flatpickr/flatpickr.css">
        <!-- Row Group CSS -->
        <link rel="stylesheet" href="/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css">
        <!-- Form Validation -->
        <link rel="stylesheet" href="/assets/vendor/libs/formvalidation/dist/css/formValidation.min.css">
    @endpush

    @push('scripts')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
        <script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
        <script src="/assets/vendor/libs/datatables-bs5/i18n/fa.js"></script>
    @endpush

</x-default-layout>
