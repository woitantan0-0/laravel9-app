<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use Illuminate\Support\Facades\Auth;

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
        $tasks = Task::all()->sortBy('user_id');
        $users = User::all();
        foreach($tasks as $task) {
            foreach($users as $user) {
                if ($task->user_id === $user->id) {
                    $task->user_name = $user->name;
                }
            }
        }

        return view('tasks/index', [
            'tasks' => $tasks,
            'users' => $users,
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
        // ログインユーザーに紐づくタスクだけを取得
        $tasks = Auth::user()->tasks;

        return view('tasks/create', compact('tasks'));
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

        // （ログイン）ユーザーに紐づけて保存する
        Auth::user()->tasks()->save($task);

        return redirect()->route('tasks.index');
    }

    /**
     *  【タスク編集ページの表示機能】
     *  機能：タスクIDを編集ページに渡して表示する
     *  
     *  GET /tasks/{task_id}/edit
     *  @param int $task_id
     *  @return \Illuminate\View\View
     */
    public function showEditForm(int $task_id)
    {
        /** @var App\Models\User **/
        $user = Auth::user();
        $task = $user->tasks()->findOrFail($task_id);

        return view('tasks/edit', ['task' => $task]);
    }

    /**
     *  【タスクの編集機能】
     *
     *  POST /tasks/{task_id}/edit
     *  @param int $task_id
     *  @param EditTask $request
     *  @return \Illuminate\Http\RedirectResponse
     */
    public function edit(int $task_id, EditTask $request)
    {
        /** @var App\Models\User **/
        $user = Auth::user();
        $task = $user->tasks()->findOrFail($task_id);

        $task->title = $request->title;
        $task->description = $request->description;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();

        return redirect()->route('tasks.index');
    }

    /**
     *  【タスク削除ページの表示機能】
     *  機能：タスクIDを削除ページに渡して表示する
     *  
     *  GET /tasks/{task_id}/edit
     *  @param int $task_id
     *  @return \Illuminate\View\View
     */
    public function showDeleteForm(int $task_id)
    {
        /** @var App\Models\User **/
        $user = Auth::user();
        $task = $user->tasks()->findOrFail($task_id);

        return view('tasks/delete', ['task' => $task]);
    }

    /**
     *  【タスクの削除機能】
     *
     *  POST /tasks/{task_id}/delete
     *  @param int $task_id
     *  @return \Illuminate\Http\RedirectResponse
     */
    public function delete(int $task_id)
    {
        /** @var App\Models\User **/
        $user = Auth::user();
        $task = $user->tasks()->findOrFail($task_id);

        $task->delete();

        return redirect()->route('tasks.index');
    }
}
