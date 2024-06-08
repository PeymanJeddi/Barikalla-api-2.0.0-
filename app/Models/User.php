<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nickname',
        'first_name',
        'last_name',
        'mobile',
        'email',
        'password',
        'username',
        'birthday',
        'gender',
        'national_id',
        'address',
        'postalcode',
        'fix_phone_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $guard_name = 'api';
    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        // Create wallet for a user when it created
        static::created(function (User $user) {
            $user->wallet()->create();
            $user->gateway()->create();
            $user->assignRole('streamer');
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function targets(): HasMany
    {
        return $this->hasMany(Target::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    public function checkoutRequests(): HasMany
    {
        return $this->hasMany(StreamerCheckoutRequest::class, 'user_id');
    }

    public function avatar(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachable')->where('type', 'avatar');
    }

    public function gateway(): HasOne
    {
        return $this->hasOne(Gateway::class);
    }

    public function links(): BelongsToMany
    {
        return $this->belongsToMany(Kind::class, 'link_user', 'user_id', 'link_id')->withPivot('value')->withPivot('alt');
    }
}
