<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Attachment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $appends = ['url'];
    static $path = 'public/uploaded';
    static $disk = 'local';


    public function getUrlAttribute()
    {
        return url($this->path);
    }

    public function getRealPathAttribute()
    {
        return str_replace('storage', 'public', $this->path);
    }

    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Kind::class, 'type_id');
    }
}
