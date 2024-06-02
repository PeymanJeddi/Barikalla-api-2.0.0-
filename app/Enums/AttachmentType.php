<?php

namespace App\Enums;

enum AttachmentType: string
{
    case AVATAR = 'avatar';
    case MELLIE_CART = 'mellie_cart';

    public function label(): string
    {
        return match ($this)
        {
            self::AVATAR => 'آواتار',
            self::MELLIE_CART => 'کارت ملی',
        };
    }
}
