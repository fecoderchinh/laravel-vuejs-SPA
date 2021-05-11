<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Category;
use App\Models\Tag;
use App\Task;
use Illuminate\Http\Request;
use App\Filters\TasksFilter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class TasksController extends Controller
{
    protected $filter;

    public function __construct(TasksFilter $filter)
    {
        $this->filter = $filter;
    }

    public function index()
    {
        $filteredTasks  = $this->filter->apply(
            request()->all(),
            Task::online()->latest()
        );

        $posts = $filteredTasks->paginate(10)->withQueryString();

        return TaskResource::collection($posts);
    }

    public function all()
    {
        $filteredTasks  = $this->filter->apply(
            request()->all(),
            (\Auth::user()->id !== 1) ? Task::where('user_id', '=', \Auth::user()->id)->latest() : Task::latest()
        );

        $posts = $filteredTasks->paginate(10);

        return TaskResource::collection($posts);
    }

    public function show(Category $category, Task $task)
    {
        if(! auth()->user()) {
            $task->increment("visits");
        }

        $task->load(["category", "creator", "comments"]);

        return new TaskResource($task);
    }

    private function uploadCover(UploadedFile $file) : string
    {
        $filename = time() . "." . $file->getClientOriginalExtension();

        $file->storeAs("public/covers", $filename);

        return "/storage/covers/". $filename;
    }

    public function store(TaskRequest $request)
    {
        $data = $request->data();
        $data["cover_path"] = $this->uploadCover($request->file("cover"));
        $data["visits"] = 0;

        $task = Task::create($data);

        $tags = explode(",", $request->tags);

        if(count(array_filter($tags)) !== count($tags))
        {
            return response([
                'status' => false,
                'message' => 'Insert tag with Whitespace or Empty string is not allowed.'
            ], 400);
        }

        $tagsId = Tag::add($tags);

        $task->tags()->attach($tagsId);

        return new TaskResource($task);
    }

    public function update(TaskRequest $request, Task $task)
    {
        $data = $request->data();

        if($request->file("cover")) {
            Storage::delete("public/covers/" . $task->cover);

            $data["cover_path"] = $this->uploadCover($request->file("cover"));
        }

        $task->update($data);

        $tags = explode(",", $request->tags);

        if(count(array_filter($tags)) !== count($tags))
        {
            return response()->json([
                'status' => false,
                'message' => 'Insert tag with Whitespace or Empty string is not allowed.'
            ], 400);
        }

        $tagsId = Tag::add($tags);
        $task->tags()->sync($tagsId);

        return new TaskResource($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        Storage::delete("public/covers/{$task->cover}");

        return response()->json([], 204);
    }
}
