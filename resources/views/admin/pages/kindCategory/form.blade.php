<x-default-layout :title="$pageTitle">

    <x-breadcrumb :items="['کاربران', $pageTitle]">
    </x-breadcrumb>

    <x-form.layout :title="$pageTitle">
        <x-form.errors>
        </x-form.errors>
        <form action="{{$routes['store']}}" method="post">
            @csrf
            @method($routes['method'] ?? 'post')
            <x-form.row for="first_name" :label="__('models.user.first_name')">
              <x-form.input name="first_name" value="{{ old('first_name') ?? $user->first_name ?? '' }}" >
              </x-form.input>
            </x-form.row>
            
            <x-form.row for="last_name" :label="__('models.user.last_name')">
              <x-form.input name="last_name" value="{{ old('last_name') ?? $user->last_name ?? '' }}">
              </x-form.input>
            </x-form.row>

            <x-form.row for="phone" :label="__('models.user.phone')">
              <x-form.input type="number" name="phone" value="{{ old('phone') ?? $user->phone ?? '' }}">
              </x-form.input>
            </x-form.row>

            {{-- <div class="col-md-6 col-12 mb-4">
              <label for="flatpickr-date" class="form-label">انتخاب‌گر تاریخ</label>
              <input type="text" class="form-control" placeholder="YYYY/MM/DD" id="flatpickr-date">
            </div> --}}
            <x-form.row for="birthdate" :label="__('models.user.birthdate')">
              <x-form.input-datepicker name="birthdate" value="{{ old('birthdate') ?? $user->birthdate ?? '' }}">
              </x-form.input-datepicker>
            </x-form.row>

            <x-form.row for="gender" :label="__('models.user.gender')" class="d-block">
              <x-form.input-radio name="gender" :options="[['value' => 'male', 'title' => 'مرد'], ['value' => 'female', 'title' => 'زن'], ['value' => 'other', 'title' => 'سایر']]" value="{{ old('gender') ?? $user->gender ?? '' }}">
              </x-form.input-radio>
            </x-form.row>

            <x-form.row for="is_admin" :label="__('models.user.is_admin')">
              <x-form.input-checkbox name="is_admin" :options="[['value' => '1']]" value="{{ old('is_admin') ?? $user->is_admin ?? '' }}">
              </x-form.input-checkbox>
            </x-form.row>
            {{-- <div class="mb-3">
                <label class="form-label" for="basic-default-fullname">نام کامل</label>
                <input type="text" class="form-control" id="basic-default-fullname" placeholder="جان اسنو">
            </div>
            <div class="mb-3">
                <label class="form-label" for="basic-default-company">شرکت</label>
                <input type="text" class="form-control" id="basic-default-company" placeholder="مایکروسافت">
            </div>

            <div class="mb-3">
                <label class="form-label" for="basic-default-phone">شماره تلفن</label>
                <input type="text" id="basic-default-phone" class="form-control phone-mask text-start"
                    placeholder="658 799 8941" dir="ltr">
            </div>
            <div class="mb-3">
                <label class="form-label" for="basic-default-message">پیام</label>
                <textarea id="basic-default-message" class="form-control" placeholder="متن پیام را اینجا بنویسید"></textarea>
            </div> --}}
            <button type="submit" class="btn btn-primary">ارسال</button>
        </form>
    </x-form.layout>
</x-default-layout>
