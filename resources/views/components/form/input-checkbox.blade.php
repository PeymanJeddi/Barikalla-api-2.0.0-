@foreach ($options as $option)
    <div class="form-check form-check-inline mt-3">
        <input class="form-check-input" name="{{ $name }}" type="checkbox" id="{{ $name }}" value="{{ $option['value'] }}" {{$value == $option['value'] ? 'checked' : ''}}>
        <label class="form-check-label" for="{{ $name }}">{{ $option['title'] ?? '' }}</label>
    </div>
@endforeach
