<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Target extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        // Change active target when new target created
        static::creating(function (Target $target) {
            if ($target->is_active == true) {
                $user = User::find(auth()->id());
                $user->targets()->update(['is_active' => 0]);
            }
        });
        // Change active target when old target activated
        static::updating(function (Target $target) {
            if ($target->is_active == true) {
                $user = User::find(auth()->id());
                $user->targets()->update(['is_active' => 0]);
            }
        });
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
