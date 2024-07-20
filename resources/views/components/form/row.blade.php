{{-- Usage 
            <x-form.row for="first_name" :label="__('models.user.first_name')">
            </x-form.row>
    --}}

<div class="mb-3">
    <label class="form-label {{ $class ?? ''}}" for="{{ $for }}">{{ $label }}</label>
    {{ $slot }}
    @if (isset($description))
        <div class="form-text">{{ $description }}</div>
    @endif
    @error($for)
        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
    @enderror
</div>

