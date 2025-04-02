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
                                <tr>
                                    <td class="title">{{ $task->title }}</td>
                                    <td class="description">{{ $task->description }}</td>
                                    <td>
                                        <span class="label {{ $task->status_class }}">{{ $task->status_label }}</span>
                                    </td>
                                    <td>{{ $task->format_due_date }}</td>
                                    <td><a href="#">編集</a></td>
                                    <td><a href="#">削除</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
