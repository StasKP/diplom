<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //    Регистрация
    public function signup(Request $request)
    {
        // Валидация
        $validator = Validator::make($request->all(),[
            'first_name' => 'required', // Имя
            'surname' => 'required', // Фамилия
            'email' => 'required', // Email
            'phone' => 'required', // Телефон
            'password' => 'required', // Пароль
            'password_repeat' => 'required', // Повтор пароля
        ]);

        // В случае ошибки валидации
        if ($validator->fails()){
            // Ответ клиенту
            return response()
                ->json($validator->errors())
                ->setStatusCode(422, 'Unprocessable entity');
        }

        // Создание записи в БД
        $userId = User::create([
                'password' => Hash::make($request->password)
            ] + $request->all()
        );

        // Ответ клиенту
        return response()
            ->json(['id' => $userId->id])
            ->setStatusCode(201, 'Created');
    }

    //    Авторизация
    public function login(Request $request)
    {
        // Валидация
        $validator = Validator::make($request->all(),[
            'email' => 'required', // Email
            'password' => 'required' // Пароль
        ]);

        // В случае ошибки валидации
        if ($validator->fails()){
            // Ответ клиенту
            return response()
                ->json($validator->errors())
                ->setStatusCode(422, 'Unprocessable entity');
        }

        // Проверка пароля
        if ($user = User::query()->where(['email' => $request->email])->first() and Hash::check($request->password, $user->password)) {
            // Ответ клиенту в случае успешной авторизации
            return response()
                ->json([
                    'token' => $user->generateToken() // Генерация токена
                ])
                ->setStatusCode(200, 'OK');
        }

        // Ответ киленту, если не верный пароль или логин
        return response()
            ->json([
                'login' => 'Неверный логин или пароль'
            ])
            ->setStatusCode(404, 'Not found');
    }

    // Выход
    public function logout()
    {
        // Выход пользователя
        Auth::user()->logout();
        // Ответ клиенту
        return response()
            ->json()
            ->setStatusCode(200, 'OK');
    }

}
