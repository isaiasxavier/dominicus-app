<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slab extends Model
{
    use SoftDeletes;

    protected $fillable
        = [
            'name',
            'brand',
            'description',
            'quantity',
            'supplier',
            'order_number',
            'price',
            //        'polishment',                         //Foi alterado para finish
            'thickness',
            'width',
            'length',
            'square_meters',
            'physical_position',
            'user_id',
            'image',
            'type_stone',
            'finish',
        ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getSquareMetersAttribute($value): float|int
    {

        return round($value / 1000000, 2);
    }

    protected function casts(): array
    {
        return [
            'image' => 'array',
        ];
    }
}
