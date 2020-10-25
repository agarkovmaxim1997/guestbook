@extends('index')
@section('content')
    <div class="container">
        @auth
            <div class="text-right">
                @if(Auth::user()->admin == 1)
                    Администратор:
                @else
                    Пользователь:
                @endif
                    {{ Auth::user()->name }}
                <a class="btn btn-primary" href="{{ route('logout-get') }}">Выйти</a>
            </div>
            <hr>
        @endauth
        <h1 class="text-center">{{$title}}</h1>
        <hr>
        @guest
            <p class="text-center">
                Для того чтобы добавлять записи на сайт, вам нужно авторизоваться или зарегистрироваться на сайте.<br>
                <a class="btn btn-primary" href="{{ route('login') }}">Авторизация</a>
                <a class="btn btn-primary" href="{{ route('register') }}">Регистрация</a>
            </p>
        @endguest
        @auth
            <form action="{{ route('index-post') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Текст сообщения: </label>
                    <input class="form-control" type="text" name="text" value="@if(isset($text)){{ $text }}@endif" required>
                </div>
                @if(isset($warning))
                    <span class="text-danger">{{ $warning }}</span>
                    <br>
                @endif
                <input class="btn btn-primary" type="submit" name="Отправить">
            </form>
        @endauth
        <hr>
        <div class="text-right"><b>Всего записей:</b> <i class="badge badge-dark">{{ $count }}</i></div><br>
        @if( !$messages->isEmpty() )
            @foreach($messages as $message)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <span><b>
                                №{{ $message->id }}
                                <a href="mailto:{{ $message->email }}">{{ $message->name }}</a>
                            </b></span>

                            <span class="pull-right label label-info">
                                {{ date('H:i:s / d.m.Y', strtotime($message->created_at)) }}
                            </span>
                        </h3>
                    </div>
                    <div class="panel-body">
                        {{ $message->message }}
                        <hr>
                        @auth
                            @if($message->email == Auth::user()->email || Auth::user()->admin == 1)
                            <div class="pull-right">
                                <a class="btn btn-info" href="/{{ $message->id }}/edit">
                                    <i class="glyphicon glyphicon-pencil"></i>
                                </a>
                                <a class="btn btn-danger" href="/{{ $message->id }}/delete">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </a>
                            </div>
                            @endif
                        @endauth
                        @if(isset($warningdel) && $message->id == $id)
                            <div class="text-center">
                                <span class="text-danger">{{ $warningdel }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
            <div class="text-center">
                {{ $messages->render() }}
            </div>
        @endif
    </div>
@endsection
