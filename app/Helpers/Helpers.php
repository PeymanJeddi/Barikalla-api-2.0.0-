<?php

if (!function_exists('isEnglishNumbers')) {
    function toEnglishNumbers(String $string): String
    {
        if ($string !== null) {
    
            $persinaDigits1 = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            $persinaDigits2 = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١', '٠'];
            $allPersianDigits = array_merge($persinaDigits1, $persinaDigits2);
            $replaces = [...range(0, 9), ...range(0, 9)];
            return str_replace($allPersianDigits, $replaces, $string);
        } else {
            return null;
        }
    }
}

if (!function_exists('sendResponse')) {
    function sendResponse($message, $data, $code = 200)
    {
        return response()->json(['success' => true, 'message' => $message, 'data' => $data], $code);
    }
}

if (!function_exists('sendError')) {
    function sendError($message, $data= [], $code = 400)
    {
        return response()->json(['success' => false, 'message' => $message, 'data' => $data], $code);
    }
}

if (!function_exists('paginateResponse')) {
    function paginateResponse($data)
    {
        return [
            'current_page' => $data->currentPage(),
            'previous_page_url' => $data->previousPageUrl(),
            'next_page_url' => $data->nextPageUrl(),
            'last_page' => $data->lastPage(),
            'total_items' => $data->total(),
        ];
    }
}

if (!function_exists('correctPhoneNumber')) {
    function correctPhoneNumber($phoneNumber)
    {
        $phoneNumberLength = strlen($phoneNumber);
        $firstNumber = substr($phoneNumber, 0, 1);
        if ($phoneNumberLength == 10 && $firstNumber != 0) {
            $phoneNumber = '0' . $phoneNumber;
        }
        return $phoneNumber;
    }
}