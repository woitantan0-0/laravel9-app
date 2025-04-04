<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Task;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * タスクの閲覧権限をチェックするポリシークラス
     * 機能：認可処理を真偽値で返す 認可処理を定義する
     * 用途：ユーザーとタスクが紐づいているときのみ閲覧を許可する
     * 
     * @param User $user
     * @param Task $task
     * @return bool
     */
    public function view(User $user, Task $task)
    {
        // ユーザーとタスクを比較して真偽値を返す
        return $user->id === $task->user_id;
    }
}
