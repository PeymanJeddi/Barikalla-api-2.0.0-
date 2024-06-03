<?php

namespace App\Models;

use App\Services\SmsService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    protected $fillable = [
        'mobile',
        'code',
        'expires_at'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeGenerateCode($query, $mobile, $smsTemplate = 'OTP')
    {
        if ($oldCodeobj = $this->getAliveCodeForUser($mobile)) {
            $code = $oldCodeobj->code;
        } else {
            do {
                $code = mt_rand(100000, 999999);
            } while ($this->checkCodeIsUnique($mobile, $code));
            $this->saveOtpToken($mobile, $code);
            return $this->sendSMS($mobile, $code, $smsTemplate);
        }
        if($this->rateLimitCheck($code) == true){
            return $this->sendSMS($mobile, $code, $smsTemplate);
        }else{
            return sendError('تعداد درخواست بیش از حد، لطفا دوباره امتحان کنید', [], 429);
        }
    }

    private function checkCodeIsUnique($mobile, $code)
    {
        return !!$this->where('mobile', $mobile)->where('code', $code)->first();
    }

    private function getAliveCodeForUser($mobile)
    {
        return $this->where('mobile', $mobile)->where('expires_at', '>', now())->first();
    }

    public function sendSMS($mobile, $code, $smsTemplate)
    {
        $result = SmsService::sendKavenegarOtp($mobile, $code, '', '', $smsTemplate);
        if ($result == 'successful') {
            return $this->updateCodeWithResponse($mobile, $code);
        } else {
            return sendError('ارسال پیامک با خطا مواجه شد! دوباره تلاش کنید');
        }
    }

    private function saveOtpToken($mobile, $code)
    {
        Otp::create([
            'mobile' => $mobile,
            'code' => $code,
            'expires_at' => now()->addMinutes(2)
        ]);
    }

    private function rateLimitCheck($code)
    {
        $code = $this->getOTPInfo($code);
        $updatedAtPlusOneMinute = Date("Y-m-d H:i:s", strtotime("1 Minutes", strtotime($code->updated_at)));
        if( (now() >= $code->created_at) && (now() <= $updatedAtPlusOneMinute)){
            return false;
        }else{
            return true;
        }
    }

    private function updateOTP($code)
    {
        $this::where('code', $code)->update([
            'updated_at' => now(),
        ]);
    }

    private function getOTPInfo($code)
    {
        return $this::where('code', $code)->first();
    }

    private function updateCodeWithResponse($mobile, $code)
    {
        $this->updateOTP($code);
        return sendResponse('کد با موفقیت ارسال شد', ['phone_number' => $mobile]);
        
    }
}
