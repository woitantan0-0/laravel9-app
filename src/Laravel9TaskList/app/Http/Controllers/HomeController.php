<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     *  【ホームページの表示機能】
     *
     *  GET /
     *  @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            /** @var App\Models\User **/
            $user = Auth::user();
            $tasks = $user->tasks();

            if ($tasks->count() > 0) {
                return redirect()->route('tasks.index');
            }

            return view('home');
        } catch (\Throwable $e) {
            Log::error('Error HomeController in index: ' . $e->getMessage());
            abort(500);
        }
        
    }
}
