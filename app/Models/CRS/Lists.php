<?php

namespace App\Models\CRS;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Lists extends Model
{
    use HasFactory;

    protected $table = 'lists';

    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $casts = [
        'passenger' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    protected $fillable = [
        'name',
        'car_id',
        'driver_id',
        'passenger',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'user_id',
        'description',
        'travel',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class,'driver_id');
    }
}
