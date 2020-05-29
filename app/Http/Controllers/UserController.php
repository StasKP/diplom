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
            'first_name' => 'required',                 // Имя
            'surname' => 'required',                    // Фамилия
            'email' => 'required|unique:users|min:8',   // Email
            'phone' => 'required',                      // Телефон
            'password' => 'required|min:8',             // Пароль
            'password_repeat' => 'required|min:8',      // Повтор пароля
        ]);

        // В случае ошибки валидации
        if ($validator->fails()){
            // Ответ клиенту
            return response()
                ->json($validator->errors())
                ->setStatusCode(422, 'Unprocessable entity');
        }

        // Проверка физическое ли лицо
        if ($request->is_corporate == 0) {
            $client = $request->first_name.' '.$request->surname;
        }

        // или юридическое
        if ($request->is_corporate == 1) {
            $client = $request->corporate_name;
        }

        // Создание записи в БД
        $userId = User::create([
                'password' => Hash::make($request->password),
                'client' => $client,
//                'is_corporate'
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
            'email' => 'required',      // Email
            'password' => 'required'    // Пароль
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
                    'token' => $user->generateToken(),  // Генерация токена
                    'client' => $user->client           // Отправка имени пользователя
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

    // Получение одного пользователя
    public function index(User $user){
        // Проверка на администратора/менеджера/регистратора
        if (Auth::user()->is_admin != 1 && Auth::user()->role == null) {
            return response()
                ->json()
                ->setStatusCode(403, 'Forbidden');
        }

        return $user;
    }
}
