<x-default-layout :title="$pageTitle">

    <x-breadcrumb :items="['کاربران', $pageTitle]">
    </x-breadcrumb>

    <x-form.layout :title="$pageTitle">
        <x-form.errors>
        </x-form.errors>
        <form action="{{ $routes['store'] }}" method="post">
            @csrf
            @method($routes['method'] ?? 'post')
            <x-form.row for="first_name" :label="__('models.user.first_name')">
                <x-form.input name="first_name" value="{{ old('first_name') ?? ($user->first_name ?? '') }}">
                </x-form.input>
            </x-form.row>

            <x-form.row for="last_name" :label="__('models.user.last_name')">
                <x-form.input name="last_name" value="{{ old('last_name') ?? ($user->last_name ?? '') }}">
                </x-form.input>
            </x-form.row>

            <x-form.row for="username" :label="__('models.user.username')">
                <x-form.input name="username" value="{{ old('username') ?? ($user->username ?? '') }}">
                </x-form.input>
            </x-form.row>

            <x-form.row for="nickname" :label="__('models.user.nickname')">
                <x-form.input name="nickname" value="{{ old('nickname') ?? ($user->nickname ?? '') }}">
                </x-form.input>
            </x-form.row>

            <x-form.row for="referral_username" :label="__('models.user.referral_username')">
                <x-form.input name="referral_username"
                    value="{{ old('referral_username') ?? ($user->referral_username ?? '') }}">
                </x-form.input>
            </x-form.row>

            <x-form.row for="address" :label="__('models.user.address')">
                <x-form.input name="address" value="{{ old('address') ?? ($user->address ?? '') }}">
                </x-form.input>
            </x-form.row>

            <x-form.row for="postalcode" :label="__('models.user.postalcode')">
                <x-form.input type="number" name="postalcode"
                    value="{{ old('postalcode') ?? ($user->postalcode ?? '') }}">
                </x-form.input>
            </x-form.row>

            <x-form.row for="national_id" :label="__('models.user.national_id')">
                <x-form.input type="number" name="national_id"
                    value="{{ old('national_id') ?? ($user->national_id ?? '') }}">
                </x-form.input>
            </x-form.row>

            <x-form.row for="fix_phone_number" :label="__('models.user.fix_phone_number')">
                <x-form.input type="number" name="fix_phone_number"
                    value="{{ old('fix_phone_number') ?? ($user->fix_phone_number ?? '') }}">
                </x-form.input>
            </x-form.row>

            <x-form.row for="email" :label="__('models.user.email')">
                <x-form.input type="email" name="email" value="{{ old('email') ?? ($user->email ?? '') }}">
                </x-form.input>
            </x-form.row>

            <x-form.row for="status" :label="__('models.user.status')">
                <x-form.input-selectbox :options="$statusOptions" label="label" name="status" value="{{ old('status') ?? ($user->status ?? '') }}">
                </x-form.input-selectbox>
            </x-form.row>

            <x-form.row for="city_id" :label="__('models.user.city_id')">
                <x-form.input name="city_id" value="{{ old('city_id') ?? ($user->city_id ?? '') }}">
                </x-form.input>
            </x-form.row>

            <x-form.row for="mobile" :label="__('models.user.mobile')">
                <x-form.input type="number" name="mobile" value="{{ old('mobile') ?? ($user->mobile ?? '') }}">
                </x-form.input>
            </x-form.row>

            <x-form.row for="birthdate" :label="__('models.user.birthdate')">
                <x-form.input-datepicker name="birthdate" value="{{ old('birthdate') ?? ($user->birthdate ?? '') }}">
                </x-form.input-datepicker>
            </x-form.row>

            <x-form.row for="gender" :label="__('models.user.gender')" class="d-block">
                <x-form.input-radio name="gender" :options="[
                    ['value' => 'male', 'title' => 'مرد'],
                    ['value' => 'female', 'title' => 'زن'],
                    ['value' => 'other', 'title' => 'سایر'],
                ]"
                    value="{{ old('gender') ?? ($user->gender ?? '') }}">
                </x-form.input-radio>
            </x-form.row>

            <x-form.row for="is_admin" :label="__('models.user.is_admin')">
                <x-form.input-checkbox name="is_admin" :options="[['value' => '1']]"
                    value="{{ old('is_admin') ?? ($user->is_admin ?? '') }}">
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
