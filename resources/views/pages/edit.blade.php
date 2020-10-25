@extends('index')
@section('content')

        <div class="container">
            <div class="text-center">
                <h1>{{$title}}</h1>
                <a class="btn btn-primary" href="{{ route('index') }}">На главную</a>
            </div>
            <hr>
            @if ($message->email == Auth::user()->email || Auth::user()->admin == 1)
                <form action="/{{ $id }}/edit" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Текст сообщения: </label>
                        <input class="form-control" type="text" name="text" value="@if(isset($text)){{ $text }}@else{{$message->message}}@endif" required>
                    </div>
                    @if(isset($warning))
                        <span class="text-danger">{{ $warning }}</span>
                        <br>
                    @endif
                    <input class="btn btn-primary" type="submit" name="submit" value="Изменить">
                </form>
            @else
                Вы не можете редактировать данную запись!!!
            @endif
        </div>
@endsection
