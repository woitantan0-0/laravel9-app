@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="column col-md-11">
                <div class="panel panel-default">
                    <div class="panel-heading">タスク</div>
                    <div class="panel-body">
                        <div class="text-right">
                            <a href="/tasks/create" class="btn btn-default btn-block">
                                タスクを追加する
                            </a>
                        </div>
                    </div>
                    <div class="panel-body h4 pb-2 mb-4">あなたのタスク</div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>タイトル</th>
                                <th>説明文</th>
                                <th>状態</th>
                                <th>期限</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tasks as $task)
                                @if($task->user_id === Auth::user()->id)
                                    <tr>
                                        <td class="title">{{ $task->title }}</td>
                                        <td class="description">{{ $task->description }}</td>
                                        <td>
                                            <span class="label {{ $task->status_class }}">{{ $task->status_label }}</span>
                                        </td>
                                        <td>{{ $task->format_due_date }}</td>
                                        <td><a href="/tasks/{{ $task->id }}/edit">編集</a></td>
                                        <td><a href="/tasks/{{ $task->id }}/delete">削除</a></td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    <div class="panel-body h4 pb-2 mb-4">他人のタスク</div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>タイトル</th>
                                <th>説明文</th>
                                <th>状態</th>
                                <th>期限</th>
                                <th>ユーザー名</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tasks as $task)
                                @if($task->user_id !== Auth::user()->id)
                                    <tr>
                                        <td class="title">{{ $task->title }}</td>
                                        <td class="description">{{ $task->description }}</td>
                                        <td>
                                            <span class="label {{ $task->status_class }}">{{ $task->status_label }}</span>
                                        </td>
                                        <td>{{ $task->format_due_date }}</td>
                                        <td>{{ $task->user_name }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
