@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-light">Добро пожаловать!</div>

                    <div class="card-body">
                        Вы перешли на сайт санатория "Мокша", для продолжения необходимо
                        <a href="/register">Войти</a> или
                        <a href="/login">Зарегистрироваться</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
