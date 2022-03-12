@extends('layouts.admin')
@section('title')
    Редактирование теста
@endsection
@section('styles')
@endsection

@section('content')

    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-secondary" href="{{ route("admin.tests.index") }}">
                <i data-feather="chevron-left"></i> Назад
            </a>
        </div>
    </div>

<div class="card">

    <div class="card-header">
        Редактирование теста
    </div>

    <div class="card-body">
        <form action="{{ route("admin.tests.update", [$test->id]) }}" method="POST" id="entity-form" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('title_ru') ? 'has-error' : '' }}">
                <label for="fio">ФИО испытуемого*</label>
                @if(auth()->user()->hasRole('admin'))
                    <input type="text" id="fio" name="fio" class="form-control" required value="{{ old('fio', ($test->fio) ? $test->fio : '') }}">
                    @if($errors->has('fio'))
                        <em class="invalid-feedback">
                            {{ $errors->first('fio') }}
                        </em>
                    @endif
                @else
                    : <b>{{ $test->fio }}</b>
                @endif
            </div>

            <div class="form-group {{ $errors->has('day') ? 'has-error' : '' }}">
                <label for="day">Дата проведения теста*</label>
                @if(auth()->user()->hasRole('admin'))
                    <input type="datetime-local" id="day" name="day" value="{{ old('day', ($test->day) ? str_replace(' ','T',$test->day) : '') }}">
                    @if($errors->has('day'))
                        <em class="invalid-feedback">
                            {{ $errors->first('day') }}
                        </em>
                    @endif
                @else
                    : <b>{{ $test->day }}</b>
                @endif
            </div>

            <div class="form-group {{ $errors->has('title_ru') ? 'has-error' : '' }}">
                <label for="location">Локация проведения теста</label>
                @if(auth()->user()->hasRole('admin'))
                <input type="text" id="location" name="location" class="form-control" required value="{{ old('location', ($test->location) ? $test->location : '') }}">
                @if($errors->has('location'))
                    <em class="invalid-feedback">
                        {{ $errors->first('location') }}
                    </em>
                @endif
                @else
                    : <b>{{ $test->location }}</b>
                @endif
            </div>

            <div class="form-group {{ $errors->has('title_ru') ? 'has-error' : '' }}">
                <label for="mark">Оценка</label>
                <input type="number" min="0" id="mark" name="mark" class="form-control" value="{{ old('mark', ($test->mark) ? $test->mark : '') }}">
                @if($errors->has('mark'))
                    <em class="invalid-feedback">
                        {{ $errors->first('mark') }}
                    </em>
                @endif
                <label for="criteria">Критерий: <span id="criteria">{{ $test->criteria }}</span></label>
            </div>

            <div class="form-group {{ $errors->has('title_ru') ? 'has-error' : '' }}">
                <label for="user_id">Ответственный менеджер</label>
                @if(auth()->user()->hasRole('admin'))
                    <select name="user_id" class="form-control">
                        <option value=""> - не указан - </option>
                        @if(!empty($users))
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" @if(!empty($test->user_id) && $test->user_id == $user->id) selected @endif>{{ $user->name }}</option>
                            @endforeach
                        @endif
                    </select>
                @elseif(!empty($test->manager))
                    : <b>{{ $test->manager->name }}</b>
                @endif
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
