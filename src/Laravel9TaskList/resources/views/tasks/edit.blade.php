@extends('layout')

@section('styles')
  @include('share.flatpickr.styles')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-md-offset-3 col-md-6">
                <nav class="panel panel-default">
                    <div class="panel-heading">タスクを編集する</div>
                    <div class="panel-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $message)
                                        <li>{{ $message }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('tasks.edit', ['task' => $task->id]) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="title">タイトル</label>
                                <input type="text" class="form-control" name="title" id="title"
                                    value="{{ old('title') ?? $task->title }}"
                                />
                            </div>
                            <div class="form-group">
                                <label for="description">説明文</label>
                                <input type="text" class="form-control" name="description" id="description"
                                    value="{{ old('description') ?? $task->description }}"
                                />
                            </div>
                            <div class="form-group">
                                <label for="status">状態</label>
                                <select name="status" id="status" class="form-control">
                                    @foreach(\App\Http\Controllers\TaskController::STATUS as $val)
                                        <option value="{{ $val['value'] }}" {{ $val['value'] == old('status', $task->status) ? 'selected' : '' }}>
                                            {{ $val['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="due_date">期限</label>
                                <input type="text" class="form-control" name="due_date" id="due_date" value="{{ old('due_date') ?? $task->format_due_date }}" />
                            </div>
                            <div class="text-right">
                                <button type="button" class="btn btn-primary" onclick="window.location='{{ route('tasks.index') }}'">キャンセル</button>
                                <button type="submit" class="btn btn-primary">送信</button>
                            </div>
                        </form>
                    </div>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
  @include('share.flatpickr.scripts')
@endsection
