@extends('admin.layouts.master', ['title' =>  'باریکلا | ' . $title ?? 'باریکلا'])
@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        {{ $slot }}
    </div>
    <!-- / Content -->

    <!-- Footer -->
    @include('admin.partials._footer')
    <!-- / Footer -->

    <div class="content-backdrop fade"></div>
</div>
@endsection

