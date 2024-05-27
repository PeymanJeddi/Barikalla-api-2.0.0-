<?php

namespace App\Services;
use Exception;
use Ghasedak\Laravel\GhasedakFacade;
use Illuminate\Support\Facades\Log;
use Kavenegar;

class SmsService extends Service
{
    public static function sendKavenegarOtp($receptor, $token, $token2, $token3, $template)
    {
        try{
            //Send null for tokens not defined in the template
            //Pass token10 and token20 as parameter 6th and 7th
            $result = Kavenegar::VerifyLookup($receptor, $token, $token2, $token3, $template, $type = 'sms');
            return 'successful';
        }
        catch(\Kavenegar\Exceptions\ApiException $e){
            // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
            Log::info($e->errorMessage());
            return 'error';
        }
        catch(\Kavenegar\Exceptions\HttpException $e){
            // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
            Log::info($e->errorMessage());
            return 'error';
        }
    }
}