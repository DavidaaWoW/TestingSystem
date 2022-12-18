@extends('layouts.app')

@section('docname', $discipline->name)

@section('content')
    <h1>Добавить тест</h1>
    <form action="{{ route('addTest', ['discipline' => $discipline->id]) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Название теста</label>
            <input type="text" class="form-control" id="name" aria-describedby="emailHelp" name="name">
        </div>
        <div class="mb-3">
            <label for="time" class="form-label">Время на прохождение (в минутах)</label>
            <input type="number" class="form-control" id="time" aria-describedby="emailHelp" name="time">
        </div>
        <div class="mb-3">
            <label for="score" class="form-label">Проходной балл</label>
            <input type="number" class="form-control" id="score" aria-describedby="emailHelp" name="score">
        </div>
        <div class="mb-3">
            <label for="order" class="form-label">Порядковый номер</label>
            <input type="number" class="form-control" id="order" aria-describedby="emailHelp" name="order">
        </div>
        <button type="submit" class="btn btn-success" style="">Добавить</button>
    </form>
@endsection
