<?php

namespace App\Models;

use App\Services\DonateAmountService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
    ];

    protected static function booted(): void
    {
        static::created(function (Payment $payment) {
            if ($payment->transaction->type == 'donate') {
                $payment->profit()->create([
                    'amount_user_paid' => $payment->transaction->amount,
                    'amount_streamer_charged' => DonateAmountService::calculateAmount($payment->transaction->streamer, $payment->transaction),
                    'profit' => DonateAmountService::calculateWage($payment->transaction->streamer, $payment->transaction->raw_amount),
                ]);
            }
        });
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function profit(): HasOne
    {
        return $this->hasOne(Profit::class);
    }
}
