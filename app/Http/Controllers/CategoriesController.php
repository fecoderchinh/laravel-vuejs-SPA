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
        $categories = Category::latest()->paginate(10);
        return CategoryResource::collection($categories);
    }

    public function all()
    {
        $categories = Category::latest()->get();
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

        $categoriesSaved = Category::register($categoriesNames);

        return CategoryResource::collection($categoriesSaved);
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([ "name" => "required|max:255"]);

        if($request->name !== $category->name) {
            $request->validate(["name" => "unique:categories"]);
        }

        $category->update([
            "name" => $request->name,
            "slug" => Str::slug($request->name)
        ]);

        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([], 204);
    }

    public function getTasks(Category $category)
    {
        return TaskResource::collection($category->tasks()->where('online', '=', 1)->with('category')->latest()->paginate(10));
    }
}
