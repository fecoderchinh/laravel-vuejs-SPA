<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Category;
use App\Models\Comment;
use App\Task;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware("api")->only(["index"]);
    }

    public function index()
    {
        $comments = Comment::latest()->get();

        return response()->json(["data" => $comments]);
    }

    public function all()
    {
        $comments = (\Auth::user()->id !== 1) ? Comment::where('user_id', '=', \Auth::user()->id)->latest()->get() : Comment::latest()->get();

        return response()->json(["data" => $comments]);
    }

    public function show(Comment $comment)
    {
//        $comment->load(['task', 'user']);
//        return response()->json(["data" => $comment], 200);
        return new CommentResource($comment);
    }

    public function store(Category $category, Task $task)
    {
        $data  = request()->validate([
            "author_name" => "required|min:1",
            "author_email" => "required|email",
            "content"       => "required|min:2",
            "user_id" => "required"
        ]);

        $comment = $task->comments()->create($data);

        return new CommentResource($comment);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json([], 200);
    }
}
