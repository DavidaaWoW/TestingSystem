@extends('layouts.app')

@section('docname', $test->name)

@section('content')
    <h1>Добавить вопрос</h1>
    <form action="{{ route('addQuestion', ['test' => $test->id]) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Название вопроса</label>
            <input type="text" class="form-control" id="name" aria-describedby="emailHelp" name="name">
        </div>
        <div class="mb-3">
            <input id="questionType" type="hidden" value="one correct" name="question_type">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="bi bi-record-circle"></i></button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <button class="dropdown-item" type="button" onclick="selectQuestionType('one correct')">Один правильный ответ</button>
                </li>
                <li>
                    <button class="dropdown-item" type="button" onclick="selectQuestionType('multiple correct')">Множество правильных ответов</button>
                </li>
            </ul>
        </div>
        <div class="mb-3">
            <label for="score" class="form-label">Количество баллов за вопрос</label>
            <input type="number" class="form-control" id="score" aria-describedby="emailHelp" name="score">
        </div>
        <div class="mb-3">
            <label for="order" class="form-label">Порядковый номер</label>
            <input type="number" class="form-control" id="order" aria-describedby="emailHelp" name="order">
        </div>
        <div class="mb-3 text-center"><button type="button" class="btn btn-success" onclick="addAnswer()">Добавить ответ</button></div>
        <div class="answers" id="answers">

        </div>
        <button type="submit" class="btn btn-success" style="">Добавить</button>
    </form>

    <script>
        let type = document.getElementById('questionType');
        let radioCounter = 0;
        let answers = document.getElementById('answers');
        let selectQuestionType = (param) => {
            type.value = param;
            let inputs = document.getElementsByClassName('inp-type');
            [...inputs].forEach((el) => {
               el.type = getParamValue();
            });
        }

        let getParamValue = () => {
            switch (type.value){
                case "one correct":
                    return "radio";
                case "multiple correct":
                    return "checkbox";
            }
        }

        let addAnswer = () => {
            let answer = document.createElement("div");
            answer.setAttribute('class', 'mb-4 row');
            let child1 = document.createElement('div');
            child1.setAttribute('class', 'group col');
            answer.appendChild(child1);
            let label = document.createElement('label');
            label.setAttribute('for', 'name');
            label.setAttribute('class', 'form-label');
            label.innerHTML = "Название ответа";
            child1.appendChild(label);
            let text = document.createElement('input');
            text.setAttribute('type', 'text');
            text.setAttribute('class', 'form-control');
            text.setAttribute('id', 'name');
            text.setAttribute('name', 'title[]');
            child1.appendChild(text);
            let input = document.createElement('input');
            input.setAttribute('class', 'col input inp-type');
            input.setAttribute('name', 'correct[]');
            input.setAttribute('value', radioCounter);
            radioCounter++;
            input.setAttribute('type', getParamValue());
            answer.appendChild(input);
            answers.appendChild(answer);
        }
    </script>
@endsection
