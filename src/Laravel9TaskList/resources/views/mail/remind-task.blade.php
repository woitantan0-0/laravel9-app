{{ $toUser->name }}さん、こんにちは！<br>
期限が切れているタスクをお知らせします。<br>
<br>
@if (count($tasks))
    @foreach($tasks as $task)
        ・{{ $task->format_due_date }} まで<br>
        　{{ $task->title }}{{ $task->description ? ' : ' . $task->description : '' }} → {{ $task->status_label ? $task->status_label : '指定なし' }}<br>
    @endforeach
@else
    期限が過ぎているタスクはありませんでした。
@endif
