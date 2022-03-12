@extends('layouts.admin')
@section('title')
    Dashboard
@endsection
@section('styles')
    <style>
    </style>
@endsection

@section('content')
    <div class="row">
        @if(auth()->user()->hasRole('admin'))
            <div class="card col-6">
                <div class="card-header">
                    Пользователи
                </div>
                <div class="card-body">
                    <a class="btn btn-primary" href="/admin/users" role="button">Редактировать пользователей</a>
                </div>
            </div>
        @endif

        <div class="card col-6">
            <div class="card-header">
                Тесты
            </div>
            <div class="card-body">
                <a class="btn btn-primary" href="/admin/tests" role="button">Редактировать тесты</a>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>

    </script>
@endsection
