<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'id', 'name_room', 'category_room', 'corpus', 'floor',
    ];

    protected $hidden = [
        'created_at', 'updated_at',
    ];
}
