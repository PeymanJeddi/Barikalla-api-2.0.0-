<?php

namespace App\Services;

use App\Models\Kind;
use App\Models\Transaction;
use App\Models\User;

class DonateAmountService extends Service
{
    public static function calculateWage(User $streamer, int $amount): int
    {
        $wage = 0;
        switch ($streamer->gateway->wage_type) {
            case 'default':
                $defaultWageAmount = Kind::where('key', 'default_wage')->first()->value_2;
                $wage = ($defaultWageAmount / 100) * $amount;
                break;
            case 'none':
                $noneWageAmount = Kind::where('key', 'none_wage')->first()->value_2;
                $wage = ($noneWageAmount / 100) * $amount;
                break;
            case 'custom':
                $customWageAmount = Kind::where('value_1', $streamer->username)->first()->value_2;
                $wage = ($customWageAmount / 100) * $amount;
                break;
            default:
                $defaultWageAmount = Kind::where('key', 'default_wage')->first()->value_2;
                $wage = ($defaultWageAmount / 100) * $amount;
                break;
        }
        return $wage;
    }


    public static function calculateTax(int $amount): int
    {
        $taxAmount = Kind::where('key', 'tax')->first()->value_2;
        return ($taxAmount / 100) * $amount;
    }

    public static function calculateAmount(User $streamer, Transaction $transaction): int
    {
        $amount = $transaction->raw_amount;
        $finalAmount = $amount;
        if (!$streamer->gateway->is_donator_pay_wage && $streamer->gateway->is_donator_pay_wage != '') {
            $finalAmount -= DonateAmountService::calculateWage($streamer, $amount);
        }

        if (!$streamer->gateway->is_donator_pay_tax && $streamer->gateway->is_donator_pay_tax != '') {
            $finalAmount -= DonateAmountService::calculateTax($amount);
        }

        return $finalAmount;
    }
}
