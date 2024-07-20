
@foreach($options as $option)
    <div class="form-check form-check-inline">
        <input 
        type="radio" 
        id="{{ $name }}" 
        name="{{ $name }}" 
        value="{{$option['value']}}"
        {{$value == $option['value'] ? 'checked' : ''}}
        @if (isset($option['checked']) && $option['checked'] == true)
        checked
        @endif
        class="form-check-input">
        <label class="form-check-label" for="{{ $name }}">{{ $option['title'] }}</label>
    </div>    
@endforeach
