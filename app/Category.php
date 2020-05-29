<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name_category', 'number_of_main', 'number_of_additional',
    ];

    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function room(){
        return $this->hasMany('App\Room', 'category_room', 'id');
    }

    public function booking(){
        return $this->hasMany('App\Booking', 'category_room', 'id');
    }
}
