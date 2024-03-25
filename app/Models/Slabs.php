<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slabs extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'description',
        'quantity',
        'supplier',
        'order_number',
        'price',
        'polishment',
        'thickness',
        'width',
        'length',
        'square_meters',
        'physical_position',
        'image',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
