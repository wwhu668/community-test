@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">消息通知</div>
                        @foreach($messages as $messageGroup)
                            <div class="media {{ $messageGroup->shouldAddUnreadClass() ? 'unread' : '' }}">
                                <div class="media-left">
                                    <a href="#">
                                        @if(Auth::id() == $messageGroup->toUser->id)
                                            <img width="42" src="{{ $messageGroup->fromUser->avatar }}">
                                        @else
                                            <img width="42" src="{{ $messageGroup->toUser->avatar }}">
                                        @endif
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="/inbox/{{ $messageGroup->dialog_id }}">
                                            @if(Auth::id() == $messageGroup->toUser->id)
                                                {{ $messageGroup->fromUser->name }}
                                            @else
                                                {{ $messageGroup->toUser->name }}
                                            @endif
                                        </a>
                                    </h4>
                                    <p>
                                        <a href="/inbox/{{ $messageGroup->dialog_id }}">
                                            {{ $messageGroup->body }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    <div class="panel-body"></div>
                </div>
            </div>
        </div>
    </div>
@endsection