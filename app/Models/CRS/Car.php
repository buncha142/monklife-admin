<?php

namespace App\Models\CRS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Car extends Model
{
    use HasFactory;

    protected $table = 'cars';

    protected $guarded = [];

    public function scopeActived($query)
    {
        $query->where('is_active', true)->orderBy('is_default', 'desc');
    }

}
