<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Task;
use App\Models\User;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;

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
        try {
            $tasks = Task::orderBy('user_id')->get();

            return view('tasks/index', [
                'tasks' => $tasks,
            ]);
        } catch (\Throwable $e) {
            Log::error('Error TaskController in index: ' . $e->getMessage());
            abort(500);
        }
    }

    /**
     *  【タスク作成ページの表示機能】
     *
     *  GET /tasks/create
     *  @return \Illuminate\View\View
     */
    public function showCreateForm()
    {
        try {
            // ログインユーザーに紐づくタスクだけを取得
            $tasks = Auth::user()->tasks;

            return view('tasks/create', compact('tasks'));
        } catch (\Throwable $e) {
            Log::error('Error TaskController in showCreateForm: ' . $e->getMessage());
            abort(500);
        }
        
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
        try {
            $task = new Task();
            $task->title = $request->title;
            $task->description = $request->description;
            $task->status = $request->status;
            $task->due_date = $request->due_date;
    
            // （ログイン）ユーザーに紐づけて保存する
            Auth::user()->tasks()->save($task);
    
            return redirect()->route('tasks.index');
        } catch (\Throwable $e) {
            Log::error('Error TaskController in create: ' . $e->getMessage());
            abort(500);
        }
    }

    /**
     *  【タスク編集ページの表示機能】
     *  機能：タスクIDを編集ページに渡して表示する
     *  
     *  GET /tasks/{task}/edit
     *  @param Task $task
     *  @return \Illuminate\View\View
     */
    public function showEditForm(Task $task)
    {
        try {
            /** @var App\Models\User **/
            $user = Auth::user();
            $task = $user->tasks()->findOrFail($task->id);
    
            return view('tasks/edit', ['task' => $task]);
        } catch (\Throwable $e) {
            Log::error('Error TaskController in showEditForm: ' . $e->getMessage());
            abort(500);
        }
    }

    /**
     *  【タスクの編集機能】
     *
     *  POST /tasks/{task}/edit
     *  @param Task $task
     *  @param EditTask $request
     *  @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Task $task, EditTask $request)
    {
        try {
            /** @var App\Models\User **/
            $user = Auth::user();
            $task = $user->tasks()->findOrFail($task->id);
    
            $task->title = $request->title;
            $task->description = $request->description;
            $task->status = $request->status;
            $task->due_date = $request->due_date;

            $task = DB::transaction(function () use ($task) {
                $task->save();
                return $task;
            });
    
            return redirect()->route('tasks.index');
        } catch (\Throwable $e) {
            Log::error('Error TaskController in edit: ' . $e->getMessage());
            abort(500);
        }
    }

    /**
     *  【タスク削除ページの表示機能】
     *  機能：タスクIDを削除ページに渡して表示する
     *  
     *  GET /tasks/{task}/edit
     *  @param Task $task
     *  @return \Illuminate\View\View
     */
    public function showDeleteForm(Task $task)
    {
        try {
            /** @var App\Models\User **/
            $user = Auth::user();
            $task = $user->tasks()->findOrFail($task->id);
    
            return view('tasks/delete', ['task' => $task]);
        } catch (\Throwable $e) {
            Log::error('Error TaskController in showDeleteForm: ' . $e->getMessage());
            abort(500);
        }
    }

    /**
     *  【タスクの削除機能】
     *
     *  POST /tasks/{task}/delete
     *  @param Task $task
     *  @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Task $task)
    {
        try {
            /** @var App\Models\User **/
            $user = Auth::user();
            $task = $user->tasks()->findOrFail($task->id);

            $task = DB::transaction(function () use ($task) {
                $task->delete();
                return $task;
            });
    
            return redirect()->route('tasks.index');
        } catch (\Throwable $e) {
            Log::error('Error TaskController in delete: ' . $e->getMessage());
            abort(500);
        }
    }
}
