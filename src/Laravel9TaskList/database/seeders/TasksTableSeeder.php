<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * tasksTable用テストデータ
     *
     * @return void
     */
    public function run()
    {
        $users = DB::table('users')->get();

        foreach ($users as $user) {
            foreach (range(1, 3) as $num) {
                if ($user->id != 3) {
                    DB::table('tasks')->insert([
                        'title' => "サンプルタスク {$num}({$user->name})",
                        'description' => "サンプル説明文 サンプル{$num}を実施する。({$user->name})",
                        'status' => $num,
                        'due_date' => Carbon::now()->addDay($num),
                        'user_id' => $user->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }
        }
    }
}
