<?php

namespace App\Models;

use App\Utility\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KindCategory extends Model
{
    use HasFactory, ModelTrait;
    protected $guarded = ['id'];

    public function kinds(): HasMany
    {
        return $this->hasMany(Kind::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(KindCategory::class);
    }

    public function scopefindByKey($query, $key)
    {
        return $this->where('key', $key)->first() ?? [];
    }

    public function hasChilds($kindCategoryId)
    {
        $kindCategoryCount = KindCategory::where('parent_id', $kindCategoryId)->count();
        if ($kindCategoryCount == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function child($kindCategoryId)
    {
        return KindCategory::where('parent_id', $kindCategoryId)->first();
    }
}
