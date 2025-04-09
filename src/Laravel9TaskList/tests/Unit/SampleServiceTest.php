<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
// use Tests\TestCase;// こちらを追加
use App\Service\SampleService;
use Mockery;
use Carbon\Carbon;

class SampleServiceTest extends TestCase
{
    /**
     * SampleServiceの期限切れ未完了タスク取得関数のテスト(データある時)
     *
     * @return void
     */
    public function test_get_task_deadline()
    {
        $sampleService = new SampleService();

        $mock = Mockery::mock('alias:App\Models\Task');
        $mock->shouldReceive('where->get')->andReturn((object)[
            (object)[
                'id' => 1,
                'title' => "サンプルタスク1",
                'description' => "サンプル説明文 サンプル1を実施する。",
                'status' => 1,
                'due_date' => Carbon::yesterday(),
                'user_id' => 1,
                'created_at' => Carbon::today(),
                'updated_at' => Carbon::today(),
            ],
        ]);

        $deadlineTask = $sampleService->getTaskDeadline(1);

        $count = 0;
        foreach($deadlineTask as $key => $task) {
            $count++;
        }
        $this->assertSame(1, $count);

        Mockery::close();
    }

    /**
     * SampleServiceの期限切れ未完了タスク取得関数のテスト(空の時)
     *
     * @return void
     */
    public function test_get_task_deadline_empty()
    {
        $sampleService = new SampleService();

        $mock = Mockery::mock('alias:App\Models\Task');
        $mock->shouldReceive('where->get')->andReturn((object)[
            (object)[
                'id' => 2,
                'title' => "サンプルタスク12",
                'description' => "サンプル説明文 サンプル2を実施する。",
                'status' => 2,
                'due_date' => Carbon::today(),
                'user_id' => 2,
                'created_at' => Carbon::today(),
                'updated_at' => Carbon::today(),
            ],
        ]);

        $deadlineTask = $sampleService->getTaskDeadline(2);

        $count = 0;
        foreach($deadlineTask as $key => $task) {
            $count++;
        }
        $this->assertSame(0, $count);

        Mockery::close();
    }
}
