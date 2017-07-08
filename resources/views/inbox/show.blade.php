@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">对话列表</div>
                    <form action="/inbox/{{$dialogId}}/store" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea name="body" class="form-control"></textarea>
                        </div>
                        <div class="form-group pull-right">
                            <button class="btn btn-success">发送私信</button>
                        </div>
                    </form>
                    <div class="messages-list">
                        @foreach($messages as $key => $message)
                            <div class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <img width="42" src="{{ $message->fromUser->avatar }}">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="#">
                                            {{ $message->fromUser->name }}
                                        </a>
                                    </h4>
                                    <p>{{ $message->body }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="panel-body"></div>
                </div>
            </div>
        </div>
    </div>
@endsection