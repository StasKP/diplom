<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'password_repeat', 'first_name', 'surname', 'phone', 'is_admin', 'is_corporate', 'corporate_name', 'client',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'api_token', 'created_at', 'updated_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //    Генерация токена
    public function generateToken()
    {
        // Запись токена в БД
        $this->api_token = Hash::make(Str::random(40));
        $this->save();

        return $this->api_token;
    }

    // Выход
    public function logout()
    {
        // Удаление токена из БД
        $this->api_token = null;
        $this->save();
    }
}
