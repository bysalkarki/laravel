<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProductStoreRequest;
use App\Http\Requests\Api\ProductUpdateRequest;
use App\Http\Resources\product\ProductCollection;
use App\Http\Resources\product\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

       return  ProductCollection::collection(Product::all());


    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('product.create');
    }

    /**
     * @param \App\Http\Requests\Api\ProductStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        $product = Product::create($request->validated());

        $request->session()->flash('product.id', $product->id);

        return redirect()->route('product.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Product $product)
    {
        return view('product.edit', compact('product'));
    }

    /**
     * @param \App\Http\Requests\Api\ProductUpdateRequest $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $product->update($request->validated());

        $request->session()->flash('product.id', $product->id);

        return redirect()->route('product.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Product $product)
    {
        $product->delete();

        return redirect()->route('product.index');
    }
}
