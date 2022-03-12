@extends('layouts.admin')
@section('title')
    Создание пользователя
@endsection
@section('styles')
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        Создание пользователя
    </div>

    <div class="card-body">
        <form action="{{ route("admin.users.store") }}" method="POST" id="entity-form" enctype="multipart/form-data">
            @csrf

            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">Имя*</label>
                <input type="text" id="name" name="name" class="form-control" required value="{{ old('name') }}">
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
            </div>

            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="email">E-mail*</label>
                <input type="email" id="email" name="email" class="form-control" required value="{{ old('email') }}">
                @if($errors->has('email'))
                    <em class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </em>
                @endif
            </div>

            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label for="email">Пароль*</label>
                <input type="password" id="password" name="password" class="form-control" required value="{{ old('password') }}">
                @if($errors->has('password'))
                    <em class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </em>
                @endif
            </div>

            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label for="email">Роль*</label>
                <select name="role" class="form-control">
                    @if(!empty($roles))
                        @foreach($roles as $key => $role)
                            <option value="{{ $key }}">{{ $role }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div>
                <button class="btn btn-success btn-save" type="submit">Сохранить</button>
                <a href="/admin/users" class="btn btn-secondary">Отменить</a>
            </div>

        </form>
    </div>
</div>


@endsection
