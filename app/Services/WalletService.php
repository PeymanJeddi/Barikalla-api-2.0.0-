<?php

namespace App\Services;

use App\Models\User;

class WalletService extends Service
{

    public static function getUserCredit(User $user): int
    {
        return $user->wallet->credit;
    }

    public static function chargeWallet(User $user, int $amount)
    {
        $userWallet = $user->wallet;
        $userWallet->credit += $amount;
        $userWallet->save();
        return $userWallet;
    }
}