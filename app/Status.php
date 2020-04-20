<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = [
        'id', 'name_status',
    ];

    protected $hidden = [
      'created_at', 'updated_at',
    ];
}
