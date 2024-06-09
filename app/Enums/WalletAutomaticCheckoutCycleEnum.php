<?php

namespace App\Enums;

enum WalletAutomaticCheckoutCycleEnum: string
{
    case DAILY = 'daily';
    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';

    public function label(): string
    {
        return match ($this)
        {
            self::DAILY => 'روزانه',
            self::WEEKLY => 'هفتگی',
            self::MONTHLY => 'ماهانه',
        };
    }
}
