@extends('layouts.app')

@section('docname', $discipline->name)

@section('content')
    <h1 class="text-center" style="margin-bottom: 2em">Тесты по дисциплине {{ $discipline->name }}:</h1>
    @foreach($tests as $test)
        @php
            $totalScore = 0;
            foreach ($test->questions as $question){
                $totalScore += $question->score;
            }
        @endphp
        <div class="col">
            <div class="card text-center" style="padding:20px; margin-bottom: 5em">
                <div class="card-body">
                    <h5 class="card-title">{{ $test->name }}</h5>
                    <div class="row mx-auto" style="margin: 2em">
                        <div class="col"></div>
                        <div class="col" style="display: flex; align-items: center"><span>Необходимо набрать {{ $test->pass_score }} баллов из {{ $totalScore }}</span></div>
                        <div class="col">
                            <div class="row">
                                <i class="bi bi-alarm"></i>
                                <div class="span">{{ $test->time }} минут</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @if($test->status == 'available')
                            <a href="{{ route('startTest', $test->id) }}">
                                <button class="btn btn-primary">Начать</button>
                            </a>
                        @elseif($test->status == 'completed')
                            @php
                                $score = 0;
                                $user_questions = \Illuminate\Support\Facades\Auth::user()->questions()->where('test', $test->id)->get();
                                foreach ($user_questions as $user_question){
                                    $score += $user_question->pivot->score;
                                }
                            @endphp
                            <div class="alert alert-success">Завершён. Набрано {{ $score }} баллов</div>
                        @elseif($test->status == 'failed')
                            <div class="alert alert-danger">Провален</div>
                            <a href="{{ route('startTest', $test->id) }}">
                                <button class="btn btn-primary">Начать заново</button>
                            </a>
                        @elseif($test->status == 'in progress')
                            <div class="alert alert-secondary">В процессе</div>
                            <a href="{{ route('startTest', $test->id) }}">
                                <button class="btn btn-primary">Продолжить</button>
                            </a>
                        @else
                            <button class="btn btn-secondary">Недоступно</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
