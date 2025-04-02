<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Requests\CreateTask;

class TaskController extends Controller
{
    /**
     * ステータス（状態）定義
     * 
     */
    const STATUS = [
        [ 'label' => '指定なし', 'value' => '' ],
        [ 'label' => '未対応', 'value' => '1' ],
        [ 'label' => '対応中', 'value' => '2' ],
        [ 'label' => '完了', 'value' => '3' ],
    ];

    /**
     *  【タスク一覧ページの表示機能】
     *
     *  GET /tasks
     *  @return \Illuminate\View\View
     */
    public function index()
    {
        $tasks = Task::all();

        return view('tasks/index', [
            'tasks' => $tasks,
        ]);
    }

    /**
     *  【タスク作成ページの表示機能】
     *
     *  GET /tasks/create
     *  @return \Illuminate\View\View
     */
    public function showCreateForm()
    {
        return view('tasks/create', ['status' => self::STATUS]);
    }

    /**
     *  【タスクの作成機能】
     *
     *  POST /tasks/create
     *  @param CreateTask $request
     *  @return \Illuminate\Http\RedirectResponse
     */
    public function create(CreateTask $request)
    {
        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();

        return redirect()->route('tasks.index');
    }
}
