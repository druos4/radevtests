@extends('layouts.admin')
@section('title')
    Пользователи
@endsection
@section('styles')
    <style>
    </style>
@endsection
@section('content')
    <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.users.create") }}">
                    <i data-feather="plus"></i> Создать пользователя
                </a>
            </div>
    </div>

    <div class="card">
        <div class="card-header">
            Пользователи
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>E-mail</th>
                            <th>Роли</th>
                            <th>
                            </th>
                        </tr>
                    </thead>
                <tbody>
                @if(!empty($users))
                @foreach($users as $key => $user)
                <tr id="item-{{ $user->id }}">
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @foreach($user->roles as $role)
                            <span class="badge bg-info badge-info">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <a class="btn btn-sm btn-warning" href="/admin/users/{{$user->id}}/edit" role="button" title="Редактировать"><i data-feather="edit-2"></i></a>
                        <a class="btn btn-sm btn-danger btn-item-del" data-id="{{$user->id}}"
                                        role="button" title="Удалить"><i data-feather="trash-2"></i></a>
                     </td>
                 </tr>
                 @endforeach
                 @endif
            </tbody>
        </table>
    </div>

 </div>
 </div>


    <div class="modal fade" id="itemDelModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Удалить пользователя</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="del-item-id" value="0">
                    <p>Действительно удалить пользователя [<span id="del-item-title"></span>]?</p>
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
         var url = '/admin/users/' + id;
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
