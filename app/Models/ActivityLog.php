<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_log';

    protected $fillable = [
        'log_name',
        'description',
        'subject_type',
        'event',
        'subject_id',
        'causer_type',
        'causer_id',
        'properties',
    ];

    /* public function getOldPropertiesAttribute()
     {
         return $this->properties['old'] ?? [];
     }*/
    /*public function getOldPropertiesAttribute()
    {
        return $this->properties['old'] ?? [];
    }*/
    protected function casts()
    {
        return [
            'properties' => 'array',
        ];
    }
}
