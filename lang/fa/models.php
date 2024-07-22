<?php

return [
    'models' => [
        'user' => 'کاربران',
    ],

    'user' => [
        'id' => 'شناسه',
        'first_name' => 'نام',
        'last_name' => 'نام خانوادگی',
        'is_admin' => 'مدیر',
        'username' => 'نام کاربری',
        'nickname' => 'نام مستعار',
        'referral_username' => 'نام کاربریِ معرف',
        'birthdate' => 'تاریخ تولد',
        'gender' => 'جنسیت',
        'national_id' => 'کد ملی',
        'address' => 'آدرس',
        'postalcode' => 'کد پستی',
        'mobile' => 'شماره تلفن',
        'fix_phone_number' => 'شماره تلفن ثابت',
        'email' => 'ایمیل',
        'password' => 'رمز عبور',
        'is_active' => 'وضعیت کاربر',
        'uuid' => 'کلید کاربر',
        'status' => 'وضعیت ثبت نام کاربر',
        'deleted_at' => 'حذف شده در',
        'city_id' => 'شهر',
    ],
    'kindCategory' => [
        'id' => 'شناسه',
        'title' => 'عنوان',
        'key' => 'کلید',
        'label_key' => 'عنوان کلید ثابت',
        'label_value_1' => 'عنوان مقدار یک',
        'label_value_2' => 'عنوان مقدار دو',
        'parent_id' => 'دسته‌ی مادر',
    ],
    'kind' => [
        'id' => 'شناسه',
        'key' => 'کلید',
        'value_1' => 'مقدار یک',
        'value_2' => 'مقدار دو',
        'parent_id' => 'دسته‌ی مادر',
        'childs' => 'زیردسته‌ها',
        'is_active' => 'وضعیت'
    ],
];