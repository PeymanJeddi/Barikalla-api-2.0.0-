<div class="row">
    <div class="col-xl">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $title }}</h5>
                <small class="text-muted float-end primary-font">{{ $subTitle ?? '' }}</small>
            </div>
            <div class="card-body">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script src="/assets/admin/js/form-layouts.js"></script>
@endpush
