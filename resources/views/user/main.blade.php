@extends('layouts.app')

@section('docname', 'Main')

@section('content')
    @can('user')
    <h1>Just main page with some promo...</h1>
    @endcan
    <a href="{{ route('makeAdmin') }}"><button class="mx-auto btn btn-success">Стать админом!</button></a>
    <a href="{{ route('makeUser') }}"><button class="mx-auto btn btn-success">Стать пользователем!</button></a>
    <a href="{{ route('makeTeacher') }}"><button class="mx-auto btn btn-success">Стать учителем!</button></a>
@endsection
