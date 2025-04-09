<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Task;
use App\Mail\RemindMail;
use Illuminate\Console\Command;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class RemindTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remind-task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'タスクの期限が切れているか、リマインドメールを送ります';

    public Mailer $mailer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Mailer $mailer)
    {
        parent::__construct();
        $this->mailer = $mailer;
    }

    /**
     * Execute the console command.
     * タスクの期限が過ぎているものをメールでお知らせする
     *
     * @return int
     */
    public function handle()
    {
        $allUser = User::get();
        foreach($allUser as $user) {
            $tasks = Task::where('user_id', $user->id)->get();
            foreach($tasks as $key => $task) {
                // 完了したタスクは含めない
                if ($task->status == 3) {
                    unset($tasks->{$key});
                    continue;
                }
                // 現在日時を取得
                $today = Carbon::now();
                // 対象の日付が今日よりも後なら含めない
                if ($task->due_date >= $today) {
                    unset($tasks->{$key});
                    continue;
                }
            }
            if ($tasks->isNotEmpty()) {
                $this->mailer->to($user->email)->send(new RemindMail($user, $tasks));
            }
        }
        return Command::SUCCESS;
    }
}
