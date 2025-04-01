<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    // テーブル名を明示的に指定する
    protected $table = 'tasks';

    /**
     * Run the migrations.
     * tasksテーブルと各列を作成する
     *
     * @return void
     */
    public function up()
    {   
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->string('description', 500);
            $table->integer('status')->default(1);
            $table->date('due_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
