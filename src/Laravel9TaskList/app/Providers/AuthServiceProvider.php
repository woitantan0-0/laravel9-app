<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Task;
use App\Policies\TaskPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     * ポリシーとモデルを紐づけるプロパティ
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // タスクモデルとタスクポリシーを紐づける
        Task::class => TaskPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     * サービスプロバイダが起動される際に呼び出されるメソッド
     * 機能：ポリシーを AuthServiceProvider に登録する
     *
     * @return void
     */
    public function boot()
    {
        // $policies プロパティに登録されたポリシーを有効にする
        $this->registerPolicies();

        //
    }
}
