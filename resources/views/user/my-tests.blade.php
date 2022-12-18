
@extends('layouts.app')

@section('docname', 'myTests')

@section('content')
    <h1 class="text-center" style="margin-bottom: 2em">Пройденные тесты:</h1>
    @foreach($tests as $test)
        @php
            $totalScore = 0;
            $test_questions = \App\Models\Question::where('test', $test->id)->get();
            foreach ($test_questions as $question){
                $totalScore += $question->score;
            }
        @endphp
        <div class="col">
            <div class="card text-center" style="padding:20px; margin-bottom: 5em">
                <div class="card-body">
                    <h5 class="card-title">Тест {{ $test->name }} по дисциплине {{ $test->discipline_name }}</h5>
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
                            @php
                                $score = 0;
                                $user_questions = \Illuminate\Support\Facades\Auth::user()->questions()->where('test', $test->id)->get();
                                foreach ($user_questions as $user_question){
                                    $score += $user_question->pivot->score;
                                }
                            @endphp
                            <div class="alert alert-success">Завершён. Набрано {{ $score }} баллов</div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
