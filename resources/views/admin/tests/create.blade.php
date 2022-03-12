@extends('layouts.admin')
@section('title')
    Создание Теста
@endsection
@section('styles')
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        Создание теста
    </div>

    <div class="card-body">
        <form action="{{ route("admin.tests.store") }}" method="POST" id="entity-form" enctype="multipart/form-data">
            @csrf

            <div class="form-group {{ $errors->has('title_ru') ? 'has-error' : '' }}">
                <label for="fio">ФИО испытуемого*</label>
                <input type="text" id="fio" name="fio" class="form-control" required value="{{ old('fio') }}">
                @if($errors->has('fio'))
                    <em class="invalid-feedback">
                        {{ $errors->first('fio') }}
                    </em>
                @endif
            </div>

            <div class="form-group {{ $errors->has('day') ? 'has-error' : '' }}">
                <label for="day">Дата проведения теста*</label>
                <input type="datetime-local" id="day" name="day" value="{{ old('day') }}">
                @if($errors->has('day'))
                    <em class="invalid-feedback">
                        {{ $errors->first('day') }}
                    </em>
                @endif
            </div>

            <div class="form-group {{ $errors->has('title_ru') ? 'has-error' : '' }}">
                <label for="location">Локация проведения теста</label>
                <input type="text" id="location" name="location" class="form-control" required value="{{ old('location') }}">
                @if($errors->has('location'))
                    <em class="invalid-feedback">
                        {{ $errors->first('location') }}
                    </em>
                @endif
            </div>

            <div class="form-group {{ $errors->has('title_ru') ? 'has-error' : '' }}">
                <label for="mark">Оценка</label>
                <input type="number" min="0" id="mark" name="mark" class="form-control" value="{{ old('mark') }}">
                @if($errors->has('mark'))
                    <em class="invalid-feedback">
                        {{ $errors->first('mark') }}
                    </em>
                @endif
                <label for="criteria">Критерий: <span id="criteria"></span></label>
            </div>

            <div class="form-group {{ $errors->has('title_ru') ? 'has-error' : '' }}">
                <label for="user_id">Ответственный менеджер</label>
                <select name="user_id" class="form-control">
                    <option value=""> - не указан - </option>
                    @if(!empty($users))
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div>
                <button class="btn btn-success btn-save" type="submit">Сохранить</button>
                <a href="/admin/tests" class="btn btn-secondary">Отменить</a>
            </div>

        </form>
    </div>
</div>


@endsection

@section('scripts')
    <script>
        $('#mark').keyup(function (e){
            var mark = $(this).val();
            $.ajax({
                type:'POST',
                url:'/admin/tests/criteria',
                data:{mark:mark},
                success:function(data) {
                    $('#criteria').html(data.criteria);
                }
            });
        });
    </script>
@endsection
