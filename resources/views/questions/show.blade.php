@extends('layouts.app')
@section('content')
    @include('vendor.ueditor.assets')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ $question->title }}
                        @foreach($question->topics as $topic)
                            <a class="topic" href="/topic/{{ $topic->id }}">{{ $topic->name }}</a>
                        @endforeach
                    </div>

                    <div class="panel-body content">
                        {!! $question->body !!}
                    </div>
                    <div class="actions">
                        @if(Auth::check() && Auth::user()->owns($question))
                            <span class="edit"><a href="/questions/{{ $question->id }}/edit">编辑</a></span>
                            <form action="/questions/{{ $question->id }}" method="POST" class="delete-form">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button class="button is-naked delete-button">删除</button>
                            </form>
                        @endif
                        <comments
                                type="question"
                                model="{{$question->id}}"
                                count="{{$question->comments()->count()}}"
                        ></comments>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading question-follow">
                        <h2>{{ $question->followers_count }}</h2>
                        <span>关注者</span>
                    </div>
                    @if(Auth::check())
                        <div class="panel-body">
                            <question-follow-button question="{{ $question->id }}"></question-follow-button>
                            <a href="#editor" class="btn btn-primary">撰写答案</a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ $question->answers_count }} 个答案
                    </div>
                    <div class="panel-body">
                        @foreach($question->answers as $answer)
                            <div class="media">
                                <div class="media-left">
                                    {{--@if(Auth::check())--}}
                                    <user-vote-button answer="{{$answer->id}}" count="{{$answer->votes_count}}"></user-vote-button>
                                    {{--@endif--}}
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="/questions/{{ $question->user->name }}">
                                            {{ $question->user->name }}
                                        </a>
                                    </h4>
                                    {!! $answer->body !!}
                                </div>
                                <comments
                                        type="answer"
                                        model="{{$answer->id}}"
                                        count="{{$answer->comments()->count()}}"
                                ></comments>
                            </div>
                        @endforeach

                        @if(Auth::check())
                        <form action="/questions/{{ $question->id }}/answer" method="post">
                            {!! csrf_field() !!}
                            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                                <script id="container" name="body" type="text/plain">
                                    {!! old('body') !!}
                                </script>
                                @if ($errors->has('body'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button class="btn btn-success pull-right" type="submit">提交答案</button>
                        </form>
                        @else
                            <a href="{{ url('login') }}" class="btn btn-success btn-block">登陆提交答案</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading question-follow">
                        <h5>关于作者</h5>
                    </div>
                    @if(Auth::check())
                        <div class="panel-body">
                            <div class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <img width="36" src="{{$question->user->avatar}}" alt="{{$question->user->name}}">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="#">{{ $question->user->name }}</a>
                                    </h4>
                                </div>
                                <div class="user-statics">
                                    <div class="statics-item text-center">
                                        <div class="statics-text">问题</div>
                                        <div class="statics-count">{{ $question->user->questions_count }}</div>
                                    </div>
                                    <div class="statics-item text-center">
                                        <div class="statics-text">回答</div>
                                        <div class="statics-count">{{ $question->user->answers_count }}</div>
                                    </div>
                                    <div class="statics-item text-center">
                                        <div class="statics-text">关注者</div>
                                        <div class="statics-count">{{ $question->user->followers_count }}</div>
                                    </div>
                                </div>
                            </div>
                            <user-follow-button user="{{ $question->user_id }}"></user-follow-button>
                            <send-message user="{{$question->user_id}}"></send-message>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container');
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>
@endsection
