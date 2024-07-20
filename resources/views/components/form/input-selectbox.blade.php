<select class="selectpicker w-100"  data-style="btn-default" id="selectpickerLiveSearch" name="{{ $name }}" {{ $disabled ?? '' }} data-live-search="true">
    <option value="">انتخاب نشده</option>
    @foreach ($options as $option)
        <option
        data-tokens="sdf"
        @if(isset($value) && is_array(json_decode($value)))
            {{in_array($option['id'],json_decode($value)) ? 'selected' : ''}}
        @elseif(isset($value) && $value == $option['id'])
            selected
        @endif
        value="{{$option['id']}}">  
        {{ $option[$label] ?? 'title' }}
        </option>
    @endforeach
  </select>
@push('links')
    <link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css">
    <link rel="stylesheet" href="/assets/vendor/libs/bootstrap-select/bootstrap-select.css">
@endpush
@push('scripts')
    <script src="/assets/vendor/libs/select2/select2.js"></script>
    <script src="/assets/js/forms-selects.js"></script>
    <script src="/assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
    <script src="/assets/vendor/libs/bootstrap-select/i18n/defaults-fa_IR.js"></script>
@endpush