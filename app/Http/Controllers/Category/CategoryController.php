<?php

namespace App\Http\Controllers\Category;

use App\Http\Resources\Category\CategoryResource;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Models\Category;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryCollectionResource;

class CategoryController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->middleware('role:admin')->except(['index', 'show']);
    }
    /**
     * Display All Categories
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(5);

        return response()->returnResult(data: new CategoryCollectionResource($categories));
    }

    /**
     * Store A New Category.
     *
     * @param  \App\Http\Requests\CreateCategoryRequest
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return response()->returnResult(data: new CategoryResource($category), response_code: Response::HTTP_CREATED);
    }

    /**
     * Display A Category
     *
     * @param  \App\Models\Category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return response()->returnResult(data: new CategoryResource($category));
    }

    /**
     * Update A Category.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return response()->returnResult(data: new CategoryResource($category));
    }

    /**
     * Remove A Category.
     *
     * @param  \App\Models\Category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->returnResult();
    }
}
