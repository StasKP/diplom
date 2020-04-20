<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//----------------------------------------------Авторизация-------------------------------------------------------
Route::post('/signup', 'UserController@signup'); // Регистрация
Route::post('/login', 'UserController@login'); // Авторизация

Route::middleware('auth:api')->group(function () { // Запросы с токеном
    Route::post('/logout', 'UserController@logout'); // Выход
});

//----------------------------------------------Категории номеров-------------------------------------------------------
Route::get('/category', 'CategoryController@index'); // Получение наименований категорий
Route::get('/category/{category}', 'CategoryController@show'); // Получение одного наименования категории

Route::middleware('auth:api')->group(function () { // Запросы с токеном
    Route::post('/category', 'CategoryController@store'); // Добавление категорий номеров
    Route::patch('/category/{category}', 'CategoryController@update'); // Редактирование категорий номеров
    Route::delete('/category/{category}', 'CategoryController@destroy'); // Удаление категорий номеров
});

//----------------------------------------------Состояния номеров-------------------------------------------------------
Route::get('/status', 'StatusController@index'); // Получение состояний номера
Route::get('/status/{status}', 'StatusController@show'); // Получение одного состояния номера

Route::middleware('auth:api')->group(function () { // Запросы с токеном
    Route::post('/status', 'StatusController@store'); // Добавление состояния номера
    Route::patch('/status/{status}', 'StatusController@update'); // Редактирование состояния номера
    Route::delete('/status/{status}', 'StatusController@destroy'); // Удаление состояния номера
});

//----------------------------------------------Номера-------------------------------------------------------
Route::get('/room', 'RoomController@index'); // Получение номеров
Route::get('/room/{room}', 'RoomController@show'); // Получение номеров

Route::middleware('auth:api')->group(function () { // Запросы с токеном
    Route::post('/room', 'RoomController@store'); // Добавление номера
    Route::delete('/room/{room}', 'RoomController@destroy'); // Удаление номер
});

//----------------------------------------------Места-------------------------------------------------------
Route::get('/room/{room}/place', 'PlaceController@index'); // Получение мест
Route::get('/room/{room}/place/{place}', 'PlaceController@show'); // Получение одного места

Route::middleware('auth:api')->group(function () { // Запросы с токеном
    Route::post('/room/{room}/place', 'PlaceController@store'); // Добавление места
    Route::delete('/room/{room}/place/{place}', 'PlaceController@destroy'); // Удаление места
});

