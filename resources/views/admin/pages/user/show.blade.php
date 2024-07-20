<x-default-layout :title="$pageTitle">

    <x-breadcrumb :items="['مراکز', 'لیست مراکز', $pageTitle]">
    </x-breadcrumb>
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="secondary-font fw-medium">خودروها</span>
                            <div class="d-flex align-items-baseline mt-2">
                                <h4 class="mb-0 me-2">
                                    {{ number_format($carsCount) }}
                                </h4>
                                {{-- <small class="text-success">(+42%)</small> --}}
                            </div>
                            <small>مجموع خودروها</small>
                        </div>
                        <span class="badge bg-label-warning rounded p-2">
                            <i class="bx bxs-wrench bx-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="secondary-font fw-medium">سرویس‌ها</span>
                            <div class="d-flex align-items-baseline mt-2">
                                <h4 class="mb-0 me-2">
                                    {{ number_format($servicesCount) }}
                                </h4>
                                {{-- <small class="text-success">(+29%)</small> --}}
                            </div>
                            <small>مجموع سرویس‌ها</small>
                        </div>
                        <span class="badge bg-label-primary rounded p-2">
                            <i class="bx bxs-car-mechanic bx-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                    <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                        <img width="150" src="{{ $center->avatar->url ?? asset('images/center-default-logo.png') }}"
                            alt="user image" class="d-block h-auto ms-0 ms-sm-4 rounded-3 user-profile-img">
                    </div>
                    <div class="flex-grow-1 mt-3 mt-sm-5">
                        <div
                            class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                            <div class="user-profile-info">
                                <h4>
                                    {{ $center->name }}
                                </h4>
                                <ul
                                    class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                    <li class="list-inline-item fw-semibold"><i class="bx bx-pen"></i>
                                        {{ $center->guild->value_1 }}</li>
                                    <li class="list-inline-item fw-semibold"><i class="bx bx-map"></i> شهر
                                        {{ $center->city->value_1 }}
                                    </li>
                                    <li class="list-inline-item fw-semibold">
                                        <i class="bx bx-calendar-alt"></i> عضویت در
                                        {{ Morilog\Jalali\CalendarUtils::strftime('%d %B %Y', strtotime($center->getAttributes()['created_at'])) }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-12">
            <h6 class="text-muted">اطلاعات مرکز</h6>
            <div class="nav-align-top mb-4">
                <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-justified-profile" aria-controls="navs-pills-justified-profile"
                            aria-selected="true" tabindex="-1">
                            <i class="tf-icons bx bx-home me-1"></i>پروفایل
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-justified-cars"
                            aria-controls="navs-pills-justified-cars" aria-selected="true" tabindex="-1">
                            <i class="tf-icons bx bxs-wrench me-1"></i>خودروها
                        </button>
                    </li>
                </ul>
                <div class="tab-content" style="background-color: transparent; box-shadow: none">
                    <div class="tab-pane fade show active" id="navs-pills-justified-profile" role="tabpanel">
                        <div class="row">
                            <div class="col-xl-4 col-lg-5 col-md-5">

                                <!-- About Center -->
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <small class="text-muted text-uppercase">درباره</small>
                                        <ul class="list-unstyled mb-4 mt-3">
                                            <li class="d-flex align-items-center mb-3">
                                                <i class="bx bx-user"></i><span class="fw-semibold mx-2">نام:</span>
                                                <span>
                                                    {{ $user->first_name }}
                                                </span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3">
                                                <i class="bx bx-user"></i><span class="fw-semibold mx-2">نام
                                                    خانوادگی:</span>
                                                <span>
                                                    {{ $user->last_name }}
                                                </span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3">
                                                <i class="bx bx-phone"></i><span class="fw-semibold mx-2">شماره
                                                    تلفن:</span>
                                                <span>
                                                    {{ $user->phone }}
                                                </span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3">
                                                <i class="bx bx-male-female"></i><span class="fw-semibold mx-2">جنسیت:</span>
                                                <span>
                                                    {{ __("columns.gender.$user->gender")}}
                                                </span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3">
                                                <i class="bx bx-user"></i><span class="fw-semibold mx-2">سرویس‌کار دعوت
                                                    کننده:</span>
                                                <span>
                                                    {{ $user->provider->fullname ?? '-' }}
                                                </span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3">
                                                <i class="bx bx-store"></i><span class="fw-semibold mx-2">مرکز دعوت
                                                    کننده:</span>
                                                <span>
                                                    {{ $user->center->name ?? '-' }}
                                                </span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3">
                                                <i class="bx bx-check"></i><span class="fw-semibold mx-2">وضعیت ثبت
                                                    نام:</span>
                                                @if ($user->register_status == 'complete_info')
                                                    <span class="badge bg-label-danger">ناقص</span>
                                                @elseif ($user->register_status == 'choose_role')
                                                    <span class="badge bg-label-info">انتخاب نقش</span>
                                                @else
                                                    <span class="badge bg-label-success">تکمیل</span>
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--/ About Center -->
                            <div class="col-xl-8 col-lg-7 col-md-7">
                                <!-- Projects table -->
                                <div class="card">
                                    <div class="card-datatable table-responsive">
                                        {{-- <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer"> --}}
                                        <div class="card-header pb-0 pt-sm-0">
                                            <div class="head-label text-start">
                                                <h5 class="card-title m-2">لیست سرویس‌ها</h5>
                                            </div>
                                        </div>
                                        {{ $dataTable->table() }}
                                        {{-- </div> --}}
                                    </div>
                                </div>
                                <!--/ Projects table -->
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-pills-justified-cars" role="tabpanel">
                        @livewire('admin.user.car', ['user' => $user])
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="row">
        <div class="col mt-3">
            <a href="{{ url()->previous() }}">
                <button type="button" class="btn btn-secondary">بازگشت</button>
            </a>
        </div>
    </div>

    @push('links')
        <link rel="stylesheet" href="/assets/admin/vendor/libs/datatables-bs5/datatables.bootstrap5.css">z
        <link rel="stylesheet" href="/assets/admin/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css">
        <link rel="stylesheet" href="/assets/admin/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css">
        <link rel="stylesheet" href="/assets/admin/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css">
        <link rel="stylesheet" href="/assets/admin/vendor/libs/flatpickr/flatpickr.css">
        <!-- Row Group CSS -->
        <link rel="stylesheet" href="/assets/admin/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css">
        <!-- Form Validation -->
        <link rel="stylesheet" href="/assets/admin/vendor/libs/formvalidation/dist/css/formValidation.min.css">
    @endpush

    @push('scripts')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
        <script src="/assets/admin/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
        <script src="/assets/admin/vendor/libs/datatables-bs5/i18n/fa.js"></script>
    @endpush
</x-default-layout>
