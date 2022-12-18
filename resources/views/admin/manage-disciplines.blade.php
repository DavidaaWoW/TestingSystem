@extends('layouts.app')

@section('docname', 'Disciplines')

@section('content')
    @foreach($disciplines as $discipline)
        <div class="col-sm-6">
            <div class="card text-center" style="padding:20px; max-width:400px;">
                <a href="{{ route('getTests', ['discipline' => $discipline->id]) }}" class=""><img src="{{ $discipline->img }}" class="card-img-top mx-auto" style="width:300px;" alt=""></a>
                <div class="card-body">
                    <h5 class="card-title">{{ $discipline->name }}</h5>
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-success" style="height: 40px; margin-left: 5px"
                                    data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                    data-disciplineId="{{ $discipline->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path
                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd"
                                          d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>
                            </button>
                        </div>
                        <form action="{{ route('deleteDiscipline') }}" method="POST" class="col">
                            @csrf
                            <input type="hidden" value="{{$discipline->id}}" name="id">
                            <button class="btn btn-danger" style="height: 40px; margin-left: 5px" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="sub-container" style="display: flex; justify-content: center; align-items:center; margin-top: 50px;">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop2"
                style="margin-right: 10px">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                 class="bi bi-plus-square-fill" viewBox="0 0 16 16">
                <path
                    d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0z"/>
            </svg>
            Добавить
        </button>
    </div>

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('editDiscipline') }}" style="max-width: 1000px">
                    @csrf
                    <div class="modal-body">
                        <h5>Новое название</h5>
                        <input type="text" id="inp1" class="form-control" style="max-width: 300px; margin-bottom: 10px"
                               name="newName">
                        <h5>Новое изображение</h5>
                        <input type="text" id="inp2" class="form-control" style="max-width: 300px;" name="newImage">
                        <input type="hidden" id="hidden" name="id">
                    </div>
                    <div class="mx-auto text-center" style="padding: 1em;">
                        <button type="submit" class="btn btn-primary">Обновить</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Отмена
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('addDiscipline') }}" style="max-width: 1000px">
                    @csrf
                    <div class="modal-body">
                        <h5>Название</h5>
                        <input type="text" id="inp1" class="form-control" style="max-width: 300px; margin-bottom: 10px"
                               name="newName">
                        <h5>Изображение</h5>
                        <input type="text" id="inp2" class="form-control" style="max-width: 300px;" name="newImage">
                        <input type="hidden" id="hidden" name="id">
                    </div>
                    <div class="mx-auto text-center" style="padding: 1em;">
                        <button type="submit" class="btn btn-primary">Добавить</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Отмена
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

    <script>
        $('#staticBackdrop').on('show.bs.modal', function (event) {
            let disciplineId = $(event.relatedTarget).data('disciplineid')
            $(this).find('#hidden').val(disciplineId)
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8"
            crossorigin="anonymous"></script>
@endsection
