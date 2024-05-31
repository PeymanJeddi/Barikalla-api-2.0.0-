<?php

namespace App\Enums;

enum TransactionType: string
{
    case DONATE = 'donate';
    case CHARGE = 'charge';
    case SUBSCRIPTION = 'subscription';

    public function label(): string
    {
        return match ($this)
        {
            self::DONATE => 'دونیت',
            self::CHARGE => 'شارژ حساب',
            self::SUBSCRIPTION => 'اشتراک',
        };
    }
}
