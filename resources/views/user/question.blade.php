@extends('layouts.app')

@section('docname', $test->name)

@section('content')
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $question->name }}</h5>
                <form action="{{ route('submitQuestion') }}" method="POST" class="col">
                    @csrf
                    <input type="hidden" value="{{ $test->id }}" name="test">
                    <input type="hidden" value="{{ $order }}" name="order">
                    <input type="hidden" value="{{ $question->id }}" name="question">
                    @foreach($question->answers as $key=>$answer)
                        <div class="row">
                            <div class="col">
                                {{ $answer->name }}
                            </div>
                            <div class="col">
                                @switch($question->question_variation)
                                    @case('one correct')
                                        <input type="radio" class="input" name="answer[]" value="{{ $answer->id }}">
                                        @break
                                    @case('multiple correct')
                                        <input type="checkbox" class="input" name="answer[]" value="{{ $answer->id }}">
                                        @break
                                @endswitch
                            </div>
                        </div>
                    @endforeach
                    <div class="btn-container" style="margin-top: 1em; display: flex; justify-content: space-around">
                        <div class=""></div>
                        <button class="btn btn-primary" type="submit">Далее</button>
                        <div class=""></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
