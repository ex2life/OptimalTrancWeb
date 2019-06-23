@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Административная панель</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div>
                            <!-- Навигация -->
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link @if($tab=="def") active @endif" href="#city" data-toggle="tab">Города присутствия</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if($tab=="users") active @endif" href="#employee" data-toggle="tab">Сотрудники</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if($tab=="routs") active @endif" href="#rout" data-toggle="tab">Маршруты</a>
                                </li>
                                @if(auth()->user()->roles()->first()->name=='manager')
                                    <li class="nav-item">
                                        <a class="nav-link @if($tab=="problems") active @endif" href="#problem" data-toggle="tab">Проблемы</a>
                                    </li>
                                @endif
                            </ul>
                            <!-- Содержимое вкладок -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane  @if($tab=="def") active @endif" id="city">
                                    @if(count($cities)>0)
                                        <table class="table table-striped note-table">
                                            <tbdoy>
                                                <tr>
                                                    <td>
                                                        Название
                                                    </td>
                                                    <td>
                                                        Кол-во подразделений
                                                    </td>
                                                    <td>
                                                        Средняя выручка
                                                    </td>
                                                </tr>
                                                @foreach($cities as $сity)
                                                    <tr>
                                                        <td>
                                                            <div>{{ $сity -> name }}</div>
                                                        </td>
                                                        <td>
                                                            <div>{{ $сity -> count_shops }}</div>
                                                        </td>
                                                        <td>
                                                            <div>{{ number_format($сity -> money, 0, ',', ' ')}} тыс.
                                                                руб.
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbdoy>
                                        </table>
                                    @endif
                                    @if(auth()->user()->roles()->first()->name=='manager')
                                        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal"
                                                data-target="#myModal">
                                            Добавить город.
                                        </button>
                                    @endif
                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
                                         aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">Добавление города</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ url('city_add') }}" method="POST"
                                                      class="form-horizontal">
                                                    <div class="modal-body">
                                                        {{ csrf_field() }}
                                                        <div class="form-group">
                                                            <label for="city">Название</label>
                                                            <input type="text" class="form-control" name="name"
                                                                   id="city"
                                                                   placeholder="Введите название города">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="city-shop">Название</label>
                                                            <input type="number" class="form-control" name="count_shops"
                                                                   id="city-shop"
                                                                   placeholder="0">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="money">Средняя выручка*</label>
                                                            <input type="number" class="form-control" name="money"
                                                                   id="city-money" aria-describedby="moneyhelp"
                                                                   aria-describedby="basic-addon2"
                                                                   placeholder="0">
                                                            <small id="moneyhelp" class="form-text text-muted">в тыс.
                                                                руб. за месяц,
                                                                на момент заполнения
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Закрыть
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">Сохранить город
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane  @if($tab=="users") active @endif" id="employee">
                                    @if(count($users)>0)
                                        <table class="table table-striped note-table">
                                            <tbdoy>
                                                <tr>
                                                    <td>
                                                        Фото
                                                    </td>
                                                    <td>
                                                        Имя и связь
                                                    </td>
                                                    <td>
                                                        Должность
                                                    </td>
                                                </tr>
                                                @foreach($users as $user)
                                                    <tr>
                                                        <td>
                                                            <div><img src="{{ URL::asset($user->avatars()->first()->path)}}" class="rounded-circle img-fluid" width="60px"><p></div>
                                                        </td>
                                                        <td>
                                                            <div>{{ $user -> name }}</div>
                                                            <div>{{ $user -> email }}</div>
                                                            <div>
                                                                @if($user ->mobiles()->first()->number==0)
                                                                    Нет номера
                                                                @else
                                                                    +{{$user -> mobiles()->first()->number}}
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <form action="{{url('role_upd/'.$user->id)}}" method="post">
                                                                @csrf
                                                                @method('PATCH')
                                                                @if(auth()->user()->roles()->first()->name=='manager')
                                                                    <select class="form-control" name="roleselect"
                                                                            id="roleselect" onchange="this.form.submit()">
                                                                        @foreach($roles as $role)
                                                                            {{$role1=$role->id}}
                                                                            {{$role2=$user-> roles -> first() -> id}}
                                                                            @if($role1==$role2)
                                                                                <option selected
                                                                                        value="{{ $role -> id }}">{{ $role -> description }}</option>
                                                                            @else
                                                                                <option value="{{ $role -> id }}">{{ $role -> description }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>

                                                                @else
                                                                    {{$user->roles()->first() -> description}}
                                                                @endif

                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbdoy>
                                        </table>
                                    @endif
                                </div>
                                <div role="tabpanel" class="tab-pane  @if($tab=="routs") active @endif" id="rout">
                                    <form action="{{url('user_select')}}" method="post">
                                        @csrf
                                        @if((auth()->user()->roles()->first()->name=='manager')||(auth()->user()->roles()->first()->name=='loader'))
                                            <select class="form-control" name="userselect"
                                                    id="userselect" onchange="this.form.submit()">
                                                @foreach($drivers as $user)
                                                    @if($user -> id==$select->id)
                                                        <option selected
                                                                value="{{ $user -> id }}">{{ $user -> name }}</option>
                                                    @else
                                                        <option value="{{ $user -> id }}">{{ $user -> name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        @endif
                                        @if(count($routs)>0)
                                            <table class="table table-striped note-table">
                                                <tbdoy>
                                                    <tr>
                                                        <td>
                                                            #
                                                        </td>
                                                        <td>
                                                            Город
                                                        </td>
                                                    </tr>
                                                    @foreach($routs as $rout)
                                                        <tr>
                                                            <td>
                                                                <div>{{ $rout -> shag_id }}</div>
                                                            </td>
                                                            <td>
                                                                <div>г. {{ $rout->cities[0]->name}}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbdoy>
                                            </table>
                                        @else
                                            <div>Пока нет маршрутов((</div>
                                        @endif
                                    </form>
                                    @if((auth()->user()->roles()->first()->name=='manager')||(auth()->user()->roles()->first()->name=='driver'))
                                        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal"
                                                data-target="#myModal2">
                                            Заменить маршрут на новый
                                        </button>
                                    @endif
                                    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog"
                                         aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">Новый маршрут</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ url('upd_rout/'.$select->id)}}" method="POST"
                                                      class="form-horizontal">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-body">
                                                        {{ csrf_field() }}
                                                        <div class="form-group">
                                                            <label for="exampleFormControlSelect2">Выберете нужные города (надо ctrl держать)</label>
                                                            <select size="{{count($cities)}}" multiple class="form-control" id="selectcity[]" name="selectcity[]">
                                                                @foreach($cities as $city)
                                                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Закрыть
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">Сохранить маршрут
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane  @if($tab=="problems") active @endif" id="problem">
                                    <form action="{{url('')}}" method="post">
                                        @csrf
                                        @if(count($problems)>0)
                                            <table class="table table-striped note-table">
                                                <tbdoy>
                                                    <tr>
                                                        <td>
                                                            Автор
                                                        </td>
                                                        <td>
                                                            Описание
                                                        </td>
                                                        <td>
                                                            Дата
                                                        </td>
                                                    </tr>
                                                    @foreach($problems as $problem)
                                                        <tr>
                                                            <td>
                                                                <div>{{ $problem -> users()->first()->name }}</div>
                                                            </td>
                                                            <td>
                                                                <div>{{ $problem -> description}} </div>
                                                            </td>
                                                            <td>
                                                                <div>{{ $problem -> created_at}} </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbdoy>
                                            </table>
                                        @else
                                            <div>Пока нет сообщений о проблемах</div>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
