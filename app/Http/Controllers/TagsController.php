<?php

namespace App\Http\Controllers;

use App\Http\Resources\TagResource;
use App\Http\Resources\TaskResource;
use App\Models\Tag;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagsController extends Controller
{
    public function __construct()
    {
        $this->middleware('api')->only(["update", "destroy"]);
    }

    public function index()
    {
//        return TagResource::collection(
//            Tag::withCount('tasks')->get()
//        );
        $tags = \DB::table('tag_task')
            ->join('tasks', 'tasks.id', '=', 'tag_task.task_id')
            ->join('tags', 'tags.id', '=', 'tag_task.tag_id')
            ->where('tasks.online', '=', '1')
            ->get();
        return response()->json(["data" => $tags]);
    }

    public function all()
    {
        if(\Auth::user()->id !== 1) {
            $tags = \DB::table('tag_task')
                ->join('tasks', 'tasks.id', '=', 'tag_task.task_id')
                ->join('tags', 'tags.id', '=', 'tag_task.tag_id')
                ->where('tasks.user_id', '=', \Auth::user()->id)
                ->get();
        } else {
            $tags = \DB::table('tag_task')
                ->join('tasks', 'tasks.id', '=', 'tag_task.task_id')
                ->join('tags', 'tags.id', '=', 'tag_task.tag_id')
                ->get();
        }
        return response()->json(["data" => $tags]);
    }

    public function show(Tag $tag)
    {
        return new TagResource($tag);
    }

    public function update(Request $request, Tag $tag)
    {
        $request->validate(["name" => "required"]);
        if($request->name !== $tag->name) {
            $request->validate(["name" => "unique:tags"]);
        }

        $tag->update([
            "name" => $request->name,
            "title" => Str::slug($request->name)
        ]);

        return new TagResource($tag);
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return response()->json([], 204);
    }

    public function getTasks(Tag $tag)
    {
        return TaskResource::collection($tag->tasks()->where('online', '=', 1)->with('tags')->latest()->paginate(10));
    }
}
