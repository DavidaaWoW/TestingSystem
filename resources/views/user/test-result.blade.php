@extends('layouts.app')

@section('docname', $test->name)

@section('content')
<div class="col">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Вы набрали {{ $score }} баллов из {{ $total }}</h5>
            <h5 style="color: {{ $result ? 'green' : 'red' }}"> Вы {{ !$result ? 'не ' : null }}прошли тест</h5>
        </div>
        <div class="card-footer">
            <a href="{{ route('getTests', ['discipline' => $discipline]) }}"><button class="btn btn-primary">Назад к списку тестов</button></a>
        </div>
    </div>
</div>
@endsection
