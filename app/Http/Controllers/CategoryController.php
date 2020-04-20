<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    // Добавление категорий номеров
    public function store (Request $request)
    {
        // Проверка на администратора
        if(Auth::user()->is_admin != 1) {
            return response()
                ->json()
                ->setStatusCode(403, 'Forbidden');
        }

        // Валидация
        $validator = Validator::make($request->all(),[
            'name_category' => 'required', // Название категории
            'number_of_main' => 'required', // Количество основных мест категории
            'number_of_additional' => 'required' // Количество дополнительных мест категории
        ]);

        // В случае ошибки валидации
        if ($validator->fails()){
            // Ответ клиенту
            return response()
                ->json($validator->errors())
                ->setStatusCode(422, 'Unprocessable entity');
        }

        // Создание записи в БД
        $categoryId = Category::create($request->all());

        // Ответ клиенту
        return response()
            ->json(
                [
                    'id' => $categoryId->id, // Id категории
                    'name_category' => $request->name_category // Название категории
                ]
            )
            ->setStatusCode(201, 'Created');
    }

    // Редактирование категорий номеров
    public function update (Request $request, Category $category)
    {
        // Проверка на администратора
        if (Auth::user()->is_admin != 1) {
            return response()
                ->json()
                ->setStatusCode(403, 'Forbidden');
        }

        // Валидация
        $validator = Validator::make($request->all(),[
            'name_category' => 'required', // Название категории
            'number_of_main' => 'required', // Количество основных мест категории
            'number_of_additional' => 'required' // Количество дополнительных мест категории
        ]);

        // В случае ошибки валидации
        if ($validator->fails()){
            // Ответ клиенту
            return response()
                ->json($validator->errors())
                ->setStatusCode(422, 'Unprocessable entity');
        }

        // Обновление записи в БД
        $category->update($request->all());

        // Ответ клиенту
        return response()
            ->json(
                [
                    'id' => $category->id, // Id категории
                    'name_category' => $category->name_category, // Название категории
                    'number_of_main' => $category->number_of_main, // Количество основных мест категории
                    'number_of_additional' => $category->number_of_additional, // Количество дополнительных мест категории
                ]
            )
            ->setStatusCode(201, 'Created');
    }

    // Получение наименований категорий
    public function index()
    {
        // Ответ клиенту
        return Category::all();
    }

    // Получение одного наименования категории
    public function show (Category $category)
    {
        // Ответ клиенту
        return $category;
    }

    // Удаление категории номеров
    public function destroy (Category $category){
        // Проверка на администратора
        if (Auth::user()->is_admin != 1) {
            return response()
                ->json()
                ->setStatusCode(403, 'Forbidden');
        }

        // Удаление записи из БД
        $category->delete();

        // Ответ клиенту
        return response()
            ->json()
            ->setStatusCode(204, 'Deleted');
    }
}
