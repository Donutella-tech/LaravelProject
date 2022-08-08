@extends('layouts.app')
@section('content')

    @section('title')
        Список сотрудников
    @endsection
<style>
    .alert-message {
        color: red;
    }
</style>

<div class="container-fluid">

    <div class="row">
        <div class="col-12 text-right">
            <a href="javascript:void(0)" class="btn btn-success mb-3" id="create-new-post" onclick="addPost()">Добавить сотрудника</a>
        </div>
    </div>
    <div class="row" style="clear: both;margin-top: 18px;">
        <div class="col-12">
            <table id="laravel_crud" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Иия</th>
                    <th>Должность</th>
                    <th>Дата трудоустройства</th>
                    <th>Зарплата</th>
                    <th>Номер начальника</th>
                    <th>Фото</th>
                    <th>Редактировать</th>
                    <th>Удалить</th>
                </tr>
                </thead>
                <tbody>
                @foreach($employees as $employee)
                    <tr id="row_{{$employee->id}}">
                        <td>{{ $employee->id  }}</td>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->position }}</td>
                        <td>{{ $employee->date }}</td>
                        <td>{{ $employee->salary }}</td>
                        <td>{{ $employee->boss }}</td>
                        <td>{{ $employee->image }}</td>
                            <td><a href="javascript:void(0)" data-id="{{ $employee->id }}" onclick="editPost(event.target)" class="btn btn-info">Редактировать</a></td>
                        <td><a href="javascript:void(0)" data-id="{{ $employee->id }}" class="btn btn-danger" onclick="deletePost(event.target)">Удалить</a></td></tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="post-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <form name="userForm" class="form-horizontal">
                    <input type="hidden" name="post_id" id="post_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2">Имя</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Введите имя сотрудника">
                            <span id="nameError" class="alert-message"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="position" class="col-sm-2">Должность</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="position" name="position" placeholder="Введите должность сотрудника">
                            <span id="positionError" class="alert-message"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="date" class="col-sm-2">Дата трудоустройства</label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" id="date" name="date" placeholder="Введите дату трудоустройства сотрудника">
                            <span id="dateError" class="alert-message"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="salary" class="col-sm-2">Заработная плата</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="salary" name="salary" placeholder="Введите заработную плату сотрудника">
                            <span id="salaryError" class="alert-message"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="boss" class="col-sm-2">Id босса</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="boss" name="boss" placeholder="Введите id начальника сотрудника">
                            <span id="bossError" class="alert-message"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="boss" class="col-sm-10">Выберите фотографию сотрудника</label>
                        <div class="col-sm-12">
                        <input type="file" name="image" placeholder="Выбрать изображение" id="image">
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="createPost()">Save</button>
            </div>
        </div>
    </div>

</div>
    <script type="text/javascript" >
        $('#laravel_crud').DataTable();

        function addPost() {
            $("#post_id").val('');
            $('#post-modal').modal('show');
        }

        function editPost(event) {
            var id  = $(event).data("id");
            let _url = `/list/${id}`;
            $('#nameError').text('');
            $('#positionError').text('');
            $('#dateError').text('');
            $('#salaryError').text('');
            $('#bossError').text('');

            $.ajax({
                url: _url,
                type: "GET",
                success: function(response) {
                    if(response) {
                        $("#post_id").val(response.id);
                        $("#name").val(response.name);
                        $("#position").val(response.position);
                        $("#date").val(response.date);
                        $("#salary").val(response.salary);
                        $("#boss").val(response.boss);
                        $('#post-modal').modal('show');
                    }
                }
            });
        }

        function createPost() {
            var name = $('#name').val();
            var position = $('#position').val();
            var date = $('#date').val();
            var salary = $('#salary').val();
            var boss = $('#boss').val();
            var id = $('#post_id').val();
            var image='empty';

            let _url     = `/list`;
            let _token   = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: _url,
                type: "POST",
                data: {
                    id:id,
                    name:name,
                    position:position,
                    date:date,
                    salary:salary,
                    boss:boss,
                    image:image,
                    _token: _token
                },
                success: function(response) {
                    if(response.code == 200) {

                        if(id != ""){
                            $("#row_"+id+" td:nth-child(2)").html(response.data.name);
                            $("#row_"+id+" td:nth-child(3)").html(response.data.position);
                            $("#row_"+id+" td:nth-child(4)").html(response.data.date);
                            $("#row_"+id+" td:nth-child(5)").html(response.data.salary);
                            $("#row_"+id+" td:nth-child(6)").html(response.data.boss);
                        } else {
                            $('table tbody').prepend('<tr id="row_'+response.data.id+'"><td>'+response.data.id+'</td><td>'+response.data.name+'</td>' +
                                '<td>'+response.data.position+'</td><td>'+response.data.date+'</td><td>'+response.data.salary+'</td>' +
                                '<td>'+response.data.boss+'</td><td>'+response.data.image+'</td><td><a href="javascript:void(0)" data-id="'+response.data.id+'" onclick="editPost(event.target)" class="btn btn-info">Редактировать</a></td>' +
                                '<td><a href="javascript:void(0)" data-id="'+response.data.id+'" class="btn btn-danger" onclick="deletePost(event.target)">Удалить</a></td></tr>');

                        }
                        $('#name').val('');
                        $('#position').val('');
                        $('#date').val('');
                        $('#salary').val('');
                        $('#boss').val('');

                        $('#post-modal').modal('hide');
                    }
                },
                error: function(response) {
                    alert('error');
                    $('#nameError').text(response.responseJSON.errors.name);
                    $('#positionError').text(response.responseJSON.errors.position);
                    $('#dateError').text(response.responseJSON.errors.date);
                    $('#salaryError').text(response.responseJSON.errors.salary);
                    $('#bossError').text(response.responseJSON.errors.boss);
                }
            });
        }

        function deletePost(event) {
            var id  = $(event).data("id");
            let _url = `/list/${id}`;
            let _token   = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: _url,
                type: 'DELETE',
                data: {
                    _token: _token
                },
                success: function(response) {
                    $("#row_"+id).remove();
                }
            });
        }

        function addPhoto(event) {
            var id  = $(event).data("id");
            let _url = `/list`;
            let _token   = $('meta[name="csrf-token"]').attr('content');


            $.ajax({
                url: _url,
                type: 'POST',
                data: {
                    _token: _token
                },
                success: function(response) {
                    $("#row_"+id).remove();
                }
            });
        }


    </script>


@endsection
