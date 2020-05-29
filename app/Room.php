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

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_room', 'id');
    }

    public function room(){
        return $this->hasMany('App\Place', 'room_id', 'id');
    }

    public function booking(){
        return $this->hasMany('App\Booking', 'room_id', 'id');
    }
}
