<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Http\Requests\CreateTask;
use Carbon\Carbon;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 各テストメソッドの実行前に呼ばれるメソッド
     * 用途：タスクのテストに必要な TasksTableSeeder を実行する
     * 
     */
    public function setUp():void
    {
        parent::setUp();

        $this->seed('TasksTableSeeder');

        $user = User::factory()->create();
        $this->actingAs($user);
    }

    /**
     * 期限日が日付ではない場合はバリデーションエラーにするメソッド
     * 用途：期限日に日付以外のデータを入力してエラーをテストする
     * 
     * @test
     */
    public function due_date_should_be_date()
    {
        $response = $this->post('/tasks/create', [
            'title' => 'Sample task',
            'description' => '',
            'status' => '',
            'due_date' => 123,
        ]);

        $response->assertSessionHasErrors([
            'due_date' => '期限日 には今日以降の日付を入力してください。',
        ]);
    }

    /**
     * 期限日が過去日付の場合はバリデーションエラーにするメソッド
     * 用途：期限日にバリデーションルール違反の過去日付を入力してエラーをテストする
     * 
     * @test
     */
    public function due_date_should_not_be_past()
    {
        $response = $this->post('/tasks/create', [
            'title' => 'Sample task',
            'description' => '',
            'status' => '',
            'due_date' => Carbon::yesterday()->format('Y/m/d'),
        ]);

        $response->assertSessionHasErrors([
            'due_date' => '期限日 には今日以降の日付を入力してください。',
        ]);
    }

    /**
     * 状態（セレクトボックスの値）が定義された値ではない場合はバリデーションエラーにするメソッド
     * 用途：状態（'status'）に不正な値（1,2,3以外）を入力してエラーをテストする
     * 
     * @test
     */
    public function status_should_be_within_defined_numbers()
    {
        $response = $this->post('/tasks/create', [
            'title' => 'Sample task',
            'description' => '',
            'status' => 4,
            'due_date' => Carbon::today()->format('Y/m/d'),
        ]);
    
        $response->assertSessionHasErrors([
            'status',
        ]);
    }
}
