<?php

namespace App\Models;

use App\Utility\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kind extends Model
{
    use HasFactory, ModelTrait;

    protected $guarded = ['id'];

    public function kindCategory(): BelongsTo
    {
        return $this->belongsTo(KindCategory::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Kind::class);
    }

    public function childs(): HasMany
    {
        return $this->hasMany(Kind::class, 'parent_id');
    }

    public function scopeFindByKey($query, $key)
    {
        $query = $query->whereHas('kindCategory', function ($query) use ($key) {
            is_array($key) ? $query->whereIn('key' , $key) : $query->where('key' , '=' , $key);
        });
        return $query;
    }

    public function scopeIsKindBelongsToKindCategory($query, $kindId, $kindCategoryKey)
    {
        $kinds = $this->FindByKey($kindCategoryKey)->get()->toArray();
        $status = false;
        foreach ($kinds as $kind) {
            foreach ($kind as $key => $value) {
                if ($key == 'id') {
                    if ($value == $kindId) {
                        $status = true;
                    }
                }
            }
        }
        return $status;
    }

    public function attachment()
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }
}
