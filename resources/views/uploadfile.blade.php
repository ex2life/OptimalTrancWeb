@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="post" action="{{ url('uploadfile')}}" enctype="multipart/form-data">
            @csrf
            <input type="file" name="image">
            <button type="submit">Отп</button>

            <img src="{{ URL::asset(auth()->user()->avatars()->first()->path) }}" alt="Italian Trullie" width="250px">
        </form>
    </div>
@endsection