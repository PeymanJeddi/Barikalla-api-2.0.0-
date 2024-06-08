<?php

namespace App\Enums;

enum UserStatusEnum: string
{
    case INCOMPLETE = 'incomplete';
    case PENDING = 'pending';
    case REJECTED = 'rejected';
    case VERIFIED = 'verified';

    public function label(): string
    {
        return match ($this)
        {
            self::INCOMPLETE => 'ناقص',
            self::PENDING => 'در انتظار تایید',
            self::REJECTED => 'رد شده',
            self::VERIFIED => 'تایید شده',
        };
    }
}
