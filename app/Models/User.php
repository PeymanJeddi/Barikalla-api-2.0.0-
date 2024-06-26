<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;

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
        'city_id',
        'uuid',
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
            $user->update([
                'uuid' => self::generateUUID()
            ]);
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

    private static function generateUUID(): string
    {
        do {
            $uuid = Str::random(50);
        } while (User::where('uuid', $uuid)->exists());
        return $uuid;
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

    public function payments(): HasMany
    {
        return $this->hasMany(Transaction::class, 'user_id')->whereHas('payment')->with('payment');
    }

    public function transactionsReceived(): HasMany
    {
        return $this->hasMany(Transaction::class, 'streamer_id');
    }

    public function getallTransactionsAttribute()
    {
        $transactions = $this->transactions;
        $transactiosReceived = $this->transactionsReceived;

        return $transactions->merge($transactiosReceived);
    }

    public function checkoutRequests(): HasMany
    {
        return $this->hasMany(StreamerCheckoutRequest::class, 'user_id');
    }

    public function avatar(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachable')->whereRelation('type', 'key', 'avatar');
    }

    public function birthCertificate(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachable')->whereRelation('type', 'key', 'birth-certificate');
    }

    public function nationalCard(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachable')->whereRelation('type', 'key', 'national-card');
    }

    public function gateway(): HasOne
    {
        return $this->hasOne(Gateway::class);
    }

    public function links(): BelongsToMany
    {
        return $this->belongsToMany(Kind::class, 'link_user', 'user_id', 'link_id')->withPivot('value')->withPivot('alt');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(Kind::class, 'city_id');
    }
}
