<?php

namespace App\Service;

use App\Models\Task;
use Carbon\Carbon;

class SampleService
{

    /**
     * sample method
     * ユニットテスト用に作成した関数
     * 期限が切れている未完了タスクを取得する
     * 
     * @param int userId
     * @return object
     */
    public function getTaskDeadline(int $userId)
    {
        // 対象ユーザーのタスクを取得
        $tasks = Task::where('user_id', $userId)->get();
        foreach($tasks as $key => $task) {
            // 完了したタスクは含めない
            if ($task->status == 3) {
                unset($tasks->{$key});
                continue;
            }
            // 現在日時を取得
            $today = Carbon::today();
            // 対象の日付が今日よりも後なら含めない
            if ($task->due_date >= $today) {
                unset($tasks->{$key});
                continue;
            }
        }
        
        return $tasks;
    }
}
