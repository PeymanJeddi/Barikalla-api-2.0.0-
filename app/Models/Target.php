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

    protected static function booted(): void
    {
        // Change default target when new target created
        static::creating(function (Target $target) {
            if ($target->is_default == true) {
                $user = User::find(auth()->id());
                $user->targets()->update(['is_default' => 0]);
            }
        });
        // Change default target when old target set as default
        static::updating(function (Target $target) {
            if ($target->is_default == true) {
                $user = User::find(auth()->id());
                $user->targets()->update(['is_default' => 0]);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
