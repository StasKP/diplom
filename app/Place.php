<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = [
        'id', 'name', 'is_empty', 'is_primary', 'room_id', 'client',
    ];

    protected $hidden = [
        'created_at', 'updated_at',
    ];
}
