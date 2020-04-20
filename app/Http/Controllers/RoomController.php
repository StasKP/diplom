<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    // Добавление номера
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
            'name_room' => 'required', // Название номера
            'category_room' => 'required', // Категория номера
            'corpus' => 'required', // Корпус номера
            'floor' => 'required', // Этаж
        ]);

        // В случае ошибки валидации
        if ($validator->fails()) {
            // Ответ клиенту
            return response()
                ->json($validator->errors())
                ->setStatusCode(422, 'Unprocessable entity');
        }

        // Создание записи в БД
        $roomId = Room::create($request->all());

        // Ответ клиенту
        return response()
            ->json(
                [
                    'id' => $roomId->id, // Id номера
                    'name_room' => $request->name_room // Название номера
                ]
            )
            ->setStatusCode(201, 'Created');
    }

    // Получение номеров
    public function index()
    {
        // Ответ клиенту
        return Room::all();
    }

    // Получение одного номера
    public function show(Room $room)
    {
        // Ответ клиенту
        return $room;
    }

    // Удаление номера
    public function destroy (Room $room){
        // Проверка на администратора
        if (Auth::user()->is_admin != 1) {
            return response()
                ->json()
                ->setStatusCode(403, 'Forbidden');
        }

        // Удаление записи из БД
        $room->delete();

        // Ответ клиенту
        return response()
            ->json()
            ->setStatusCode(204, 'Deleted');
    }

}
