<?php

namespace App\Http\Controllers;

use App\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
    Создание карточки бронирвоания
     */
    public function store(Request $request)
    {
        // Валидация
        $validator = Validator::make($request->all(), [
            'category_room' => 'required', // Категория номера
            'start_date' => 'required', // Дата заселения
            'end_date' => 'required', // Дата выселения
            'places' => 'required', // Количесвто бронируемых мест
            'room_id' => 'required', // Идентификатор номера
        ]);

        // В случае ошибки валидации
        if ($validator->fails()) {
            // Ответ клиенту
            return response()
                ->json($validator->errors())
                ->setStatusCode(422, 'Unprocessable entity');
        }

        $user = Auth::user();

        // Создание записи в БД
        $bookingId = Booking::create($request->all()+[
                'client' => $user->id,
            ]);

        // Ответ клиенту
        return response()
            ->json(
                [
                    'id' => $bookingId->id, // Id карточки бронирования
                    'client' => $user->client // ФИО клиента или название юр. лица
                ]
            )
            ->setStatusCode(201, 'Created');
    }


    /**
    Вывод карточек бронирования
     */
    public function index()
    {
         // Проверка на администратора/менеджера/регистратора
         if (Auth::user()->is_admin != 1 && Auth::user()->role == null) {
             return response()
             ->json()
             ->setStatusCode(403, 'Forbidden');
         }

         // Ответ клиенту
        return Booking::all();

    }

    // Подверждение карточки бронирования
    public function confirm(Request $request, Booking $booking){

        // Проверка на администратора/менеджера/регистратора
        if (Auth::user()->is_admin != 1 && Auth::user()->role == null) {
            return response()
                ->json()
                ->setStatusCode(403, 'Forbidden');
        }

        if ($booking->room_id == null) {
            // Ответ клиенту
            return response()
                ->json([
                    'room_id' => 'Cannot be empty',
                ])
                ->setStatusCode(422, 'Unprocessable entity');
        }

        // Обновление записи в БД
        $booking->update([
            'booking_status' => 1,
        ]);



        // Ответ клиенту
        return response()
            ->json(
                [
                    'id' => $booking->id,                                   // Id карточки бронирования
                    'booking_status' => $booking->booking_status,           // Статус карточки бронирования
                ]
            )
            ->setStatusCode(201, 'Created');

    }

    // Удаление карточки бронирования
    public function destroy (Booking $booking){
        // Проверка на администратора
        if (Auth::user()->is_admin != 1) {
            return response()
                ->json()
                ->setStatusCode(403, 'Forbidden');
        }

        // Удаление записи из БД
        $booking->delete();

        // Ответ клиенту
        return response()
            ->json()
            ->setStatusCode(204, 'Deleted');
    }

    // Получение одного номера
    public function show(Booking $booking)
    {

        // Проверка на администратора/менеджера/регистратора
        if (Auth::user()->is_admin != 1 && Auth::user()->role == null) {
            return response()
                ->json()
                ->setStatusCode(403, 'Forbidden');
        }

        // Ответ клиенту
        return $booking;
    }


    // Редактирование карточки бронирования
    public function update(Request $request, Booking $booking){
        // Валидация
        $validator = Validator::make($request->all(), [
            'category_room' => 'required', // Категория номера
            'start_date' => 'required', // Дата заселения
            'end_date' => 'required', // Дата выселения
            'places' => 'required', // Количесвто бронируемых мест
//            'room_id' => 'required', // Идентификатор номера
        ]);

        // В случае ошибки валидации
        if ($validator->fails()) {
            // Ответ клиенту
            return response()
                ->json($validator->errors())
                ->setStatusCode(422, 'Unprocessable entity');
        }

        $user = Auth::user();

//        if ($request->room_id == 0){
//            $booking_status = 0;
//            $room_id = null;
//        } else {
//            $booking_status = 1;
//        }

        // Обновление записи в БД
        $booking->update($request->all()+[
//            'booking_status' => $booking_status,
        ]);

        // Ответ клиенту
        return response()
            ->json(
                [
                    'id' => $booking->id, // Id карточки бронирования
                    'client' => $booking->client // ФИО клиента или название юр. лица
                ]
            )
            ->setStatusCode(201, 'Created');
    }
}
