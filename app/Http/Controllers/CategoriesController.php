<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\TaskResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware("api")->only(["store", "update", "destroy"]);
    }

    public function index()
    {
//        $categories = Category::whereHas('tasks', function ($query) {
//            $query->where('user_id', '=', \Auth::id());
//        })->latest()->paginate(10);
        $categories = \Auth::id() != 1 ? Category::whereHas('tasks', function ($query) {
            $query->where('user_id', '=', \Auth::id());
        })->latest()->paginate(10) : Category::latest()->paginate(10);
        return CategoryResource::collection($categories);
//        $categories = \DB::table('categories')
//            ->join('tasks', 'tasks.category_id', 'categories.id')
//            ->where('tasks.user_id', '=', \Auth::user()->id)
//            ->paginate(10);
//
//        return response()->json(["data" => $categories]);
    }

    public function all()
    {
//        $categories = Category::latest()->get()->each(function ($category, $key) {
//            $category->with('tasks')->where('category_id')->get();
//        });
        $categories = Category::whereHas('tasks', function ($query){
            $query->whereNotNull('category_id');
        })->latest()->get();
        return CategoryResource::collection($categories);
    }

    public function store(Request $request)
    {
        $request->validate([ "names" => "required" ]);

        $categoriesNames = explode(",", $request->get("names"));

        if(count(array_filter($categoriesNames)) !== count($categoriesNames))
        {
            return response([
                'status' => false,
                'message' => 'Whitespace or Empty string is not allowed.'
            ], 400);
        }

        if( Category::whereIn('slug', $categoriesNames)->exists() )
        {
            return response([
                'status' => false,
                'message' => 'One or more data already exists.'
            ], 400);
        } else {
            $categoriesSaved = Category::register($categoriesNames);

            return CategoryResource::collection($categoriesSaved);
        }
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([ "name" => "required|max:255"]);

        if($request->name !== $category->name && $category->slug !== 'uncategorized') {
            $request->validate(["name" => "unique:categories"]);
        } else {
            return response()->json(['msg'=> 'The default record can not be changed.'], 500);
        }

        $category->update([
            "name" => $request->name,
            "slug" => Str::slug($request->name)
        ]);

        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        if(\Auth::id() === 1) {
            if($category->slug !== 'uncategorized')
            {
                $category->delete();
//                $category->tasks()->with('categories')->where('slug', '=', $category->slug)->update(['slug' => 'uncategorized']);
                return response()->json([], 204);
            } else {
                return response()->json(['msg'=> 'The default record can not be removed.'], 500);
            }
        } else {
            return response()->json(['msg'=> 'You don\'t have permission to delete category.'], 500);
        }
    }

    public function getTasks(Category $category)
    {
        return TaskResource::collection($category->tasks()->where('online', '=', 1)->with('category')->latest()->paginate(10));
    }
}
