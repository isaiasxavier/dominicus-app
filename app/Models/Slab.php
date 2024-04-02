<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slab extends Model
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
//        'polishment',                         //Foi alterado para finish
        'finish',
        'thickness',
        'width',
        'length',
        'square_meters',
        'physical_position',
        'image',
        'user_id',
        'type_stone',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Calcula a área em milímetros quadrados e multiplica pela quantidade
    public function getSquareMetersAttribute($value): float|int
    {
        // Converte o valor de milímetros quadrados para metros quadrados
        return $value / 1000000;
    }
}
