<?php

namespace App\Enums;

enum GatewayWageTypeEnum: string
{
    case DEFAULT = 'default';
    case NONE = 'none';
    case CUSTOM = 'custom';

    public function label(): string
    {
        return match ($this)
        {
            self::DEFAULT => 'پیش فرض',
            self::NONE => 'بدون کارمزد',
            self::CUSTOM => 'سفارشی',
        };
    }
}
