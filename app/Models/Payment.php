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
            $type = $payment->transaction->type;
            switch ($type) {
                case 'charge':
                    $payment->profit()->create([
                        'amount_user_paid' => $payment->transaction->amount,
                        'amount_user_charged' => DonateAmountService::calculateAmount($payment->transaction->user, $payment->transaction),
                        'tax' => DonateAmountService::calculateTax($payment->transaction->raw_amount),
                        'profit' => DonateAmountService::calculateWage($payment->transaction->user, $payment->transaction->raw_amount),
                    ]);
                    break;
                case 'donate':
                    $payment->profit()->create([
                        'amount_user_paid' => $payment->transaction->amount,
                        'amount_streamer_charged' => DonateAmountService::calculateAmount($payment->transaction->streamer, $payment->transaction),
                        'tax' => DonateAmountService::calculateTax($payment->transaction->raw_amount),
                        'profit' => DonateAmountService::calculateWage($payment->transaction->streamer, $payment->transaction->raw_amount),
                    ]);
                    break;
                case 'donate_with_wallet':
                    $payment->profit()->create([
                        'amount_user_paid' => $payment->transaction->raw_amount,
                        'amount_streamer_charged' => $payment->transaction->raw_amount,
                        'tax' => 0,
                        'profit' => 0,
                    ]);
                    break;
                case 'charge':
                default:
                    # code...
                    break;
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
