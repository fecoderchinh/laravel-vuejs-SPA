<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Task;
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

        return response()->json([
            'data' => compact('tasksCount', 'commentsCount', 'viewsCount', 'popularTasks', 'latestComments')
        ]);

    }
}
