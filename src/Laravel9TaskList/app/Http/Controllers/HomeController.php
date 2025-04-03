<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        /** @var App\Models\User **/
        $user = Auth::user();
        $tasks = $user->tasks();

        if ($tasks->count() > 0) {
            return redirect()->route('tasks.index');
        }

        return view('home');
    }
}
