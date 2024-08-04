<?php

namespace App\Enums;

enum TransactionType: string
{
    case DONATE = 'donate';
    case CHARGE = 'charge';
    case SUBSCRIPTION = 'subscription';
    case WITHDRAW = 'withdraw';
    case DONATE_WITH_WALLET = 'donate_with_wallet';

    public function label(): string
    {
        return match ($this)
        {
            self::DONATE => 'دونیت',
            self::CHARGE => 'شارژ حساب',
            self::SUBSCRIPTION => 'اشتراک',
            self::WITHDRAW => 'برداشت',
            self::DONATE_WITH_WALLET => 'دونیت با کیف پول',
        };
    }
}
