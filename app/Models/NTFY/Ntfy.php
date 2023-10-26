<?php

namespace App\Models\NTFY;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Ntfy extends Model
{
    use HasFactory;

    protected $table = 'ntfies';

    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $casts = [
        'image' => 'array',
        'passenger' => 'array',
        'published_at' => 'datetime:Y-m-d H:i',
        'is_active' => 'boolean',
    ];

    protected $fillable = [
        'image',
        'title',
        'user_id',
        'body',
        'passenger',
        'published_at',
        'is_active',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActived($query)
    {
        $query->where('is_active', true);
    }

    public function scopePublished($query)
    {
        $query->where('published_at', '>=', Carbon::now())->orderBy('published_at', 'ASC');
    }

    protected static function boot()
    {
        parent::boot();

        /** @var Model $model */
        static::updating(function ($model) {
            if ($model->isDirty('image') && ($model->getOriginal('image') !== null)) {
                Storage::disk('public')->delete($model->getOriginal('image'));
            }
        });
    }
}
