<!--
*   extends：親ビューを継承する（読み込む）
*   親ビュー名：layout を指定
-->
@extends('layout')

<!--
*   section：子ビューにsectionでデータを定義する
*   セクション名：content を指定
*   用途：ホームページをHTMLで表示する
-->
@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-md-offset-3 col-md-6">
                <nav class="panel panel-default">
                    <div class="panel-heading">
                        まずはタスクを作成しましょう
                    </div>
                    <div class="panel-body">
                        <div class="text-center">
                            <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                                タスク作成ページへ
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
@endsection