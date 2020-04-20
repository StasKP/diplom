<?php

namespace App\Http\Controllers;

use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StatusController extends Controller
{
    // Добавление состояния номера
    public function store(Request $request)
    {
        // Проверка на администратора
        if (Auth::user()->is_admin != 1) {
            return response()
                ->json()
                ->setStatusCode(403, 'Forbidden');
        }

        // Валидация
        $validator = Validator::make($request->all(), [
            'name_status' => 'required', // Название состояния
        ]);

        // В случае ошибки валидации
        if ($validator->fails()) {
            // Ответ клиенту
            return response()
                ->json($validator->errors())
                ->setStatusCode(422, 'Unprocessable entity');
        }

        // Создание записи в БД
        $statusId = Status::create($request->all());

        // Ответ клиенту
        return response()
            ->json(
                [
                    'id' => $statusId->id, // Id состояния
                    'name_status' => $request->name_status // Название состояния
                ]
            )
            ->setStatusCode(201, 'Created');
    }

    // Редактирование состояния номера
    public function update(Request $request, Status $status)
    {
        // Проверка на администратора
        if (Auth::user()->is_admin != 1) {
            return response()
                ->json()
                ->setStatusCode(403, 'Forbidden');
        }

        // Валидация
        $validator = Validator::make($request->all(),[
            'name_status' => 'required', // Название состояния номера
        ]);

        // В случае ошибки валидации
        if ($validator->fails()){
            // Ответ клиенту
            return response()
                ->json($validator->errors())
                ->setStatusCode(422, 'Unprocessable entity');
        }

        // Обновление записи в БД
        $status->update($request->all());

        // Ответ клиенту
        return response()
            ->json(
                [
                    'id' => $status->id, // Id категории
                    'name_status' => $status->name_status, // Название категории
                ]
            )
            ->setStatusCode(201, 'Created');
    }

    // Получение состояний номера
    public function index()
    {
        // Ответ клиенту
        return Status::all();
    }

    // Получение одного состояния номера
    public function show (Status $status)
    {
        // Ответ клиенту
        return $status;
    }

    // Удаление состояния номера
    public function destroy (Status $status){
        // Проверка на администратора
        if (Auth::user()->is_admin != 1) {
            return response()
                ->json()
                ->setStatusCode(403, 'Forbidden');
        }

        // Удаление записи из БД
        $status->delete();

        // Ответ клиенту
        return response()
            ->json()
            ->setStatusCode(204, 'Deleted');
    }
}
