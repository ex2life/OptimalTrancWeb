@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Ваш профиль</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4 align-content-center">
                                <img src="{{ URL::asset($avatar)}}" class="rounded-circle img-fluid" ><p>
                                <button type="button" class="btn btn-secondary container-fluid mt-3" data-toggle="modal"
                                        data-target="#myModal">Сменить фото</button>
                            </div>
                            <div class="col my-auto">
                                <form action="{{ url('update_user')}}" method="POST"
                                      class="form-horizontal">
                                    @csrf
                                <div class="form-group">
                                    <label for="name">Имя</label>
                                    <input type="text" class="form-control" name="name" required
                                           id="name"
                                           placeholder="Введите свое имя" value="{{$user->name}}">
                                </div>
                                <div class="form-group">
                                    <label for="mobile">Телефон</label>
                                    <input type="tel" class="form-control" name="mobile" required
                                           id="mobile-shop"
                                           placeholder="0" value="{{$mobile}}">
                                    <small id="mobilehelp" class="form-text text-muted">в формате 7ХХХХХХХХХХ
                                    </small>
                                </div>
                                <div class="btn-group container-fluid" role="group" aria-label="Basic example">
                                    <button type="submit" class="btn btn-primary container-fluid">Сохранить</button>
                                    <button type="button" class="btn btn-secondary container-fluid" data-toggle="modal"
                                            data-target="#myModal2">Изменить пароль</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Изменение фото</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('uploadfile')}}" method="POST"
                      class="form-horizontal"  enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        {{ csrf_field() }}
                        <script>
                            $(document).ready(function() {
                                $('input[type="file"]').on("change", function() {
                                    let filenames = [];
                                    let files = document.getElementById("image").files;
                                    if (files.length > 1) {
                                        filenames.push("Total Files (" + files.length + ")");
                                    } else {
                                        for (let i in files) {
                                            if (files.hasOwnProperty(i)) {
                                                filenames.push(files[i].name);
                                            }
                                        }
                                    }
                                    $(this)
                                        .next(".custom-file-label")
                                        .html(filenames.join(","));
                                });
                            });
                        </script>
                        <div class="input-group">

                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon01">Фото</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" required class="custom-file-input" id="image" name="image"
                                       aria-describedby="image">
                                <label class="custom-file-label" for="image">Выберите файл</label>
                            </div>
                        </div>

                        <small id="imagehelp" class="form-text text-muted">фото должно быть квадратное. да. знаю.
                            ну че теперь. обрежьте.
                        </small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">Закрыть
                        </button>
                        <button type="submit" class="btn btn-primary">Загрузить фото
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Изменение пароля</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('updatepass')}}" method="POST"
                      class="form-horizontal"  enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <script type="text/javascript">
                            function validatePassword(){
                                var pass2=document.getElementById("confnewpass").value;
                                var pass1=document.getElementById("newpass").value;
                                if(pass1!=pass2) {
                                    document.getElementById("confnewpass").classList.add('is-invalid');
                                    document.getElementById("newpass").classList.add('is-invalid');
                                    document.getElementById("subbut").setAttribute('disabled', true);
                                }
                                else {
                                    document.getElementById("confnewpass").classList.remove('is-invalid');
                                    document.getElementById("newpass").classList.remove('is-invalid');
                                    document.getElementById("subbut").removeAttribute('disabled');
                                }
                                //empty string means no validation error
                            }
                        </script>
                        <div class="form-group">
                            <label for="inputPassword" class="control-label col-xs-2">Старый пароль</label>
                            <div class="col-xs-10">
                                <input type="password" class="form-control" id="oldpass" name="oldpass"
                                       required placeholder="Пароль">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="control-label col-xs-2">Новый пароль</label>
                            <div class="col-xs-10">
                                <input type="password" class="form-control" id="newpass" name="newpass" required
                                       placeholder="Пароль" onchange="return validatePassword()">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="control-label col-xs-2">Подтверждение нового пароля</label>
                            <div class="col-xs-10">
                                <input type="password" class="form-control" id="confnewpass" name="confnewpass" required
                                       placeholder="Пароль" onchange="return validatePassword()">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">Закрыть
                        </button>
                        <button type="submit" id="subbut" class="btn btn-primary">Изменить
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection