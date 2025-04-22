@extends('layouts.app')

@section('title', 'Дякуємо')

@section('content')
    <div class="alert alert-success">
        <h4>Замовлення успішно оформлене!</h4>
        <p>Очікуйте дзвінка від нашого менеджера 😊</p>
    </div>
    <a href="{{ route('catalog') }}" class="btn btn-outline-primary">Назад до каталогу</a>
@endsection
