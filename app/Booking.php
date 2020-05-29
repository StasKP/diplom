<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'client', 'category_room', 'start_date', 'end_date', 'places', 'room_id', 'booking_status',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'client', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_room', 'id');
    }

    public function room()
    {
        return $this->belongsTo('App\Room', 'room_id', 'id');
    }
}
