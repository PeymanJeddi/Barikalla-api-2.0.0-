<?php

namespace App\Services;

use App\Models\Target;
use App\Models\User;

class TargetService extends Service
{
    
    public static function chargetTarget(Target $target, int $amount)
    {
        $target->target_donated += $amount;
        $target->save();
        return $target;
    }

}