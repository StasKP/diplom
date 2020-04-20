<?php

namespace App\Http\Controllers;

use App\Place;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PlaceController extends Controller
{
    // Добавление места
    public function store(Request $request, Room $room)
    {
        // Проверка на администратора
        if (Auth::user()->is_admin != 1) {
            return response()
                ->json()
                ->setStatusCode(403, 'Forbidden');
        }

        // Валидация
        $validator = Validator::make($request->all(), [
            'name' => 'required', // Номер места
            'is_empty' => 'required', // Свободно/Занято
            'is_primary' => 'required', // Основное/Дополнительное
        ]);

        // В случае ошибки валидации
        if ($validator->fails()) {
            // Ответ клиенту
            return response()
                ->json($validator->errors())
                ->setStatusCode(422, 'Unprocessable entity');
        }

        // Создание записи в БД
        $placeId = Place::create([
            'room_id' => $room->id,
        ]+$request->all());

        // Ответ клиенту
        return response()
            ->json(
                [
                    'id' => $placeId->id, // Id места
                    'name' => $request->name // Номер места
                ]
            )
            ->setStatusCode(201, 'Created');
    }

    // Получение мест
    public function index(Room $room)
    {
        // Получение всех мест
        $all_place = Place::all();

        $j = 0;

        $data=[];

        // Цикл выбирающий только места данной комнаты.
        for ($i = 0; $i < count($all_place); $i++) {
            $id = $all_place[$i]->room_id;
            if ($id == $room->id) {
                $data[$j] = $all_place[$i];
                $j++;
            }
        }

        // Ответ клиенту
        return $data;
    }

    // Получение одного места
    public function show(Room $room, Place $place)
    {

        // Проверка принадлежит ли место данной комнате
        if ($place->room_id == $room->id) {
            // Ответ клиенту
            return $place;
        }

        // Ответ клиенту
        return response()
            ->json()
            ->setStatusCode(404);

    }

    // Удаление места
    public function destroy (Room $room, Place $place){
        // Проверка на администратора
        if (Auth::user()->is_admin != 1) {
            return response()
                ->json()
                ->setStatusCode(403, 'Forbidden');
        }

        // Проверка принадлежит ли место данной комнате
        if ($place->room_id == $room->id) {
            // Удаление записи из БД
            $place->delete();

            // Ответ клиенту
            return response()
                ->json()
                ->setStatusCode(204, 'Deleted');
        }

        // Ответ клиенту
        return response()
            ->json()
            ->setStatusCode(404);
    }
}
