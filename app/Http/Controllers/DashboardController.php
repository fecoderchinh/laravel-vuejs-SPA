<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Task;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $tasksCount = Task::count();
        $commentsCount = Comment::count();
        $viewsCount = Task::sum('visits');

        $popularTasks = Task::with('category')->orderBy('visits', 'DESC')->take(5)->get();
        $latestComments = Comment::with('task')->take(5)->get();
//        $lastestUsers = User::take(5)->get();
        $lastestUsers = 'list new users';

        return response()->json([
            'data' => compact('tasksCount', 'commentsCount', 'viewsCount', 'popularTasks', 'latestComments', 'lastestUsers')
        ]);

    }
}
