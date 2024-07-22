<x-default-layout :title="$pageTitle">

    <x-breadcrumb :items="['ثوابت سیستمی', $pageTitle]">
    </x-breadcrumb>

    <x-form.layout :title="$pageTitle">
        <x-form.errors>
        </x-form.errors>
        <form action="{{$routes['store']}}" method="post">
            @csrf
            @method($routes['method'] ?? 'post')
            
            <x-form.row for="key" :label="$kindCategory->label_key">
              <x-form.input name="key" value="{{ old('key') ?? $kind->key ?? '' }}" >
              </x-form.input>
            </x-form.row>

            <x-form.row for="value_1" :label="$kindCategory->label_value_1">
              <x-form.input name="value_1" value="{{ old('value_1') ?? $kind->value_1 ?? '' }}" >
              </x-form.input>
            </x-form.row>

            @if (!empty($kindCategory->label_value_2))
              <x-form.row for="value_2" :label="$kindCategory->label_value_2">
                <x-form.input name="value_2" value="{{ old('value_2') ?? $kind->value_2 ?? '' }}" >
                </x-form.input>
              </x-form.row>
            @endif

            @if (isset($parent) && $parent == true)
              <x-form.row for="parent_id" label="{{__('models.kind.parent_id')}}">
                <x-form.input-selectbox :options="$parents" label="value_1" name="parent_id" value="{{ old('parent_id') ?? $kind->parent_id ?? '' }}">
                </x-form.input-selectbox>
              </x-form.row>
            @endif

            <x-form.row for="is_active" :label="__('models.kind.is_active')" class="d-block">
              <x-form.input-radio name="is_active" :options="[['value' => 1, 'title' => 'فعال', 'checked' => true], ['value' => 0, 'title' => 'غیر فعال']]" value="{{ old('is_active') ?? $kind->is_active ?? '' }}">
              </x-form.input-radio>
            </x-form.row>

            <button type="submit" class="btn btn-primary">ارسال</button>
            <a href="{{$routes['index']}}">
              <button type="button" class="btn btn-danger">بازگشت</button>
            </a>
        </form>
    </x-form.layout>
</x-default-layout>
