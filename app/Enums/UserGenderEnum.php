<?php

namespace App\Enums;

enum UserGenderEnum: string
{
    case MALE = 'male';
    case FEMALE = 'female';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this)
        {
            self::MALE => 'آقا',
            self::FEMALE => 'خانم',
            self::OTHER => 'سایر',
        };
    }
}
