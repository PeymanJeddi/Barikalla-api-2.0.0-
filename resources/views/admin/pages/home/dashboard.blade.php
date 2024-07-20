<x-default-layout title="پنل مدیریت">

    <h3>به پنل مدیریت باریکلا خوش آمدید</h3>
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="secondary-font fw-medium">سود</span>
                            <div class="d-flex align-items-baseline mt-2">
                                <h4 class="mb-0 me-2">
                                    {{-- {{ number_format($carsCount) }} --}}
                                </h4>
                                {{-- <small class="text-success">(+42%)</small> --}}
                            </div>
                            <small>مجموع سود باریکلا</small>
                        </div>
                        <span class="badge bg-label-warning rounded p-2">
                            <i class="bx bx-money bx-sm"></i>
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
                            <span class="secondary-font fw-medium">کاربران</span>
                            <div class="d-flex align-items-baseline mt-2">
                                <h4 class="mb-0 me-2">
                                    {{-- {{ number_format($usersCount) }} --}}
                                </h4>
                                {{-- <small class="text-success">(+29%)</small> --}}
                            </div>
                            <small>مجموع کاربران</small>
                        </div>
                        <span class="badge bg-label-primary rounded p-2">
                            <i class="bx bx-user bx-sm"></i>
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
                            <span class="secondary-font fw-medium">دونیت‌ها</span>
                            <div class="d-flex align-items-baseline mt-2">
                                <h4 class="mb-0 me-2">
                                    {{-- {{ number_format($centersCount) }} --}}
                                </h4>
                                {{-- <small class="text-success">(+18%)</small> --}}
                            </div>
                            <small> مجموع دونیت‌ها (تومان) </small>
                        </div>
                        <span class="badge bg-label-danger rounded p-2">
                            <i class="bx bx-wallet bx-sm"></i>
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
                            <span class="secondary-font fw-medium">دونیت‌ها</span>
                            <div class="d-flex align-items-baseline mt-2">
                                <h4 class="mb-0 me-2">
                                    {{-- {{ number_format($servicesCount) }} --}}
                                </h4>
                                {{-- <small class="text-danger">(-14%)</small> --}}
                            </div>
                            <small>مجموع دونیت‌ها (تعداد)</small>
                        </div>
                        <span class="badge bg-label-success rounded p-2">
                            <i class="bx bx-donate-heart bx-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row gy-4">

        <div class="col-6">
            <div class="card">
                <div class="card-header header-elements">
                    <div>
                        <h5 class="card-title mb-1">آمار کاربران</h5>
                        <small class="text-muted primary-font">نمودار رشد کاربران پلتفرم</small>
                    </div>
                </div>
                <div class="card-body">
                    {{-- {!! $userRegistrationProgessChart->render() !!} --}}
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card">
                <div class="card-header header-elements">
                    <div>
                        <h5 class="card-title mb-1">آمار کاربران</h5>
                        <small class="text-muted primary-font">نمودار ثبت نام کاربران</small>
                    </div>
                </div>
                <div class="card-body">
                    {{-- {!! $userPerDayRegistrationChart->render() !!} --}}
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="/assets/vendor/libs/chartjs/chartjs.js"></script>
        <script src="/assets/js/main.js"></script>
    @endpush
</x-default-layout>
