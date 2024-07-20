{{-- Usage:

    <x-breadcrumb :items="['کاربران', 'لیست کاربران']">
    </x-breadcrumb>


--}}
@php($last=array_pop($items))
<h4 class="py-3 breadcrumb-wrapper mb-4">
    @foreach ($items as $item)
        <span class="text-muted fw-light">
            {{ $item }} /
        </span>
    @endforeach
    {{ $last }}
</h4>