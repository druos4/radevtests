@extends('layouts.admin')
@section('title')
    Тесты
@endsection
@section('styles')
    <style>
    </style>
@endsection
@section('content')
    @if(auth()->user()->hasRole('admin'))
    <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.tests.create") }}">
                    <i data-feather="plus"></i> Создать тест
                </a>
            </div>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            Тесты
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ф.И.О.</th>
                            <th>Локация</th>
                            <th>Дата</th>
                            <th>Оценка</th>
                            <th>Критерий</th>
                            <th>Менеджер</th>
                            <th>
                            </th>
                        </tr>
                    </thead>
                <tbody>
                @if(!empty($tests))
                    <form id="form-filter" action="{{ route("admin.tests.index") }}" method="GET">
                    <tr>
                        <td>
                            <input type="number" min="1" class="form-control w-80" name="id" @if(!empty($filter['id'])) value="{{ $filter['id'] }}" @endif placeholder="ID">
                        </td>
                        <td>
                            <input type="text" class="form-control w-160" name="fio" @if(!empty($filter['fio'])) value="{{ $filter['fio'] }}" @endif placeholder="Ф.И.О.">
                        </td>
                        <td>
                            @if(!empty($locations))
                                <select name="location" class="form-control">
                                    <option value=""> - локация - </option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location }}" @if(!empty($filter['location']) && $filter['location'] == $location) selected @endif>{{ $location }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </td>
                        <td>
                            <input type="date" name="day" class="form-control">
                        </td>
                        <td>
                            <input type="number" min="1" class="form-control w-120" name="mark" @if(!empty($filter['mark'])) value="{{ $filter['mark'] }}" @endif placeholder="Оценка">
                        </td>
                        <td>
                            <input type="number" min="1" class="form-control w-120" name="criteria" @if(!empty($filter['criteria'])) value="{{ $filter['criteria'] }}" @endif placeholder="Критерий">
                        </td>
                        <td>
                            @if(!empty($managers))
                                <select name="manager" class="form-control">
                                    <option value=""> - менеджер - </option>
                                    @foreach($managers as $key => $manager)
                                        <option value="{{ $key }}" @if(!empty($filter['manager']) && $filter['manager'] == $key) selected @endif>{{ $manager }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </td>
                        <td>
                            <button type="submit" class="btn btn-sm btn-info"><i data-feather="filter"></i></button>
                            <a class="btn btn-sm btn-default" href="/admin/tests" role="button"><i data-feather="x"></i></a>
                        </td>
                    </tr>
                    </form>


                @foreach($tests as $key => $test)
                <tr id="item-{{ $test->id }}">
                    <td>{{ $test->id }}</td>
                    <td>{{ $test->fio }}</td>
                    <td>{{ $test->location }}</td>
                    <td>{{ $test->day }}</td>
                    <td>{{ $test->mark }}</td>
                    <td>{{ $test->criteria }}</td>
                    <td>
                        @if(!empty($test->manager))
                            {{ $test->manager->name }}
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-sm btn-warning" href="/admin/tests/{{$test->id}}/edit" role="button" title="Редактировать"><i data-feather="edit-2"></i></a>
                        @if(auth()->user()->hasRole('admin'))
                        <a class="btn btn-sm btn-danger btn-item-del" data-id="{{$test->id}}"
                                        role="button" title="Удалить"><i data-feather="trash-2"></i></a>
                        @endif
                     </td>
                 </tr>
                 @endforeach
                 @endif
            </tbody>
        </table>
    </div>
    <div>
        @if(!empty($tests))
        {{ $tests->appends(request()->except('page'))->links() }}
        @endif
    </div>
 </div>
 </div>


    <div class="modal fade" id="itemDelModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Удалить тест</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="del-item-id" value="0">
                    <p>Действительно удалить тест [<span id="del-item-title"></span>]?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-item-delete">Удалить</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отменить</button>
                </div>
            </div>
        </div>
    </div>

@section('scripts')
 <script>
     $('.btn-item-del').click(function (e){
         e.preventDefault();
         var id = $(this).data('id');
         $('#del-item-id').val(id);
         $('#del-item-title').html(id);
         $('#itemDelModal').modal('show');
     });

     $('.btn-item-delete').click(function(e) {
         e.preventDefault();
         var id = $('#del-item-id').val();
         var url = '/admin/tests/' + id;
         $.ajax({
             type:'DELETE',
             url:url,
             data:{},
             success:function(data) {
                 if(data.id > 0){
                     $('#item-' + data.id).remove();
                     $('#itemDelModal').modal('hide');
                 }
             }
         });
     });
 </script>
 @endsection
 @endsection
