@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Тест авторизации с андроид</div>
                    <form action="{{ url('unprotected/testand') }}" method="POST"
                          class="form-horizontal">
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="text" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email">
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="pass" name="pass" placeholder="Password">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <div>
                    <div class="card-header">Тест проверки токена</div>
                    <form action="{{ url('unprotected/checktoken') }}" method="POST"
                          class="form-horizontal">
                        <div class="form-group">
                            <label for="email">email</label>
                            <input type="text" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">token</label>
                            <input type="password" class="form-control" id="pass" name="token" placeholder="token">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>
        </div>
@endsection
