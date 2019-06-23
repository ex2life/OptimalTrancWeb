@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Сообщить о проблеме, возникшей во время рабочего процесса</div>

                    <div class="card-body">
                        <form action="{{ url('problems') }}" method="POST"
                              class="form-horizontal">
                            @csrf
                            <div class="form-group">
                                <label for="problem">Описание проблемы</label>
                                <textarea id="problem" name="problem" class="container-fluid" rows="15"
                                          placeholder="Что случилось?" required></textarea>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Отправить
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
