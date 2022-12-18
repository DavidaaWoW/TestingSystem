@extends('layouts.app')

@section('docname', $test->name)

@section('content')
    <h1 class="text-center" style="margin-bottom: 2em">Список вопросов по тесту - {{ $test->name }}:</h1>
    @foreach($questions as $question)
        <div class="col">
            <div class="card text-center" style="padding:20px; margin-bottom: 5em">
                <div class="card-body">
                    <h5 class="card-title">{{ $question->name }}</h5>
                    <div class="row mx-auto" style="margin: 2em">
                        <div class="col">
                            @foreach($question->answers as $answer)
                                <div class="row">
                                    <span class="col">{{ $answer->name }}</span>
                                    @if($answer->correct)
                                        <div class="col" style="color: green">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                <path
                                                    d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="col" style="color: red">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                <path
                                                    d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        {{--                        <form action="{{ route('editTestView', ['discipline' => $discipline->id]) }}" method="POST" class="col">--}}
                        {{--                            @csrf--}}
                        {{--                            <input type="hidden" value="{{$test->id}}" name="id">--}}
                        {{--                            <button class="btn btn-success" style="height: 40px; margin-left: 5px">--}}
                        {{--                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"--}}
                        {{--                                     class="bi bi-pencil-square" viewBox="0 0 16 16">--}}
                        {{--                                    <path--}}
                        {{--                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>--}}
                        {{--                                    <path fill-rule="evenodd"--}}
                        {{--                                          d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>--}}
                        {{--                                </svg>--}}
                        {{--                            </button>--}}
                        {{--                        </form>--}}
                        <form action="{{ route('deleteQuestion', ['test' => $test->id]) }}" method="POST" class="col">
                            @csrf
                            <input type="hidden" value="{{$question->id}}" name="id">
                            <button class="btn btn-danger" style="height: 40px; margin-left: 5px" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                    <div style="display: flex; align-items: center; flex-direction: column">
                        <span class="row">Порядковый номер: {{ $question->order_number }}</span>
                        <span class="row">Количество баллов за вопрос: {{ $question->score }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <a href="{{ route('addQuestion', ['test' => $test->id]) }}" class="sub-container"
       style="display: flex; justify-content: center; align-items:center; margin-top: 50px;">
        <button type="button" class="btn btn-success"
                style="margin-right: 10px">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                 class="bi bi-plus-square-fill" viewBox="0 0 16 16">
                <path
                    d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0z"/>
            </svg>
            Добавить
        </button>
    </a>
@endsection
