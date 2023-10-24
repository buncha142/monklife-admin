<?php

namespace App\Models\CRS;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Driver extends Model
{
    use HasFactory;

    protected $table = 'drivers';

    protected $guarded = [];

    public function scopeActived($query)
    {
        $query->where('is_active', true)->orderBy('is_default', 'desc');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
