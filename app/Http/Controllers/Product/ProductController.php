<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductCollectionResource;
use App\Http\Resources\Product\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->middleware('role:admin')->except(['index', 'show']);
    }
    
    /**
     * Display A Product Given A Category
     * 
     *  @param \App\Models\Category.
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        return response()->returnResult(data: new ProductCollectionResource(Product::paginate(5)));
    }

    /**
     * Store A Product For A Specific Category.
     *
     * @param  \App\Http\Requests\Product\CreateProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request, Category $category)
    {
        $product = Product::create(collect($request->validated())->put('category_id',$category->id)->toArray());
        return response()->returnResult(data: new ProductResource($product), response_code: Response::HTTP_CREATED);
    }

    /**
     * Display A Product
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->returnResult(data: new ProductResource($product));
    }

    /**
     * Update A Product
     *
     * @param  \App\Http\Requests\Product\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request,Product $product)
    {
        $product->update($request->validated());
        return response()->returnResult(data: new ProductResource($product));
    }

    /**
     * Remove A Product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->returnResult();
    }
}
