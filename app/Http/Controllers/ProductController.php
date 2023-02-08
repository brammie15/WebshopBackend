<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller {
    protected $limit = 10;

    public function getAllProducts(Request $request): \Illuminate\Http\JsonResponse{
        $products = Product::all();
        $categories = Category::all();
        foreach ($products as $product){
            foreach ($categories as $category){
                if ($product->category_id == $category->id){
                    $product->category = $category;
                }
            }
            unset($product->category->created_at);
            unset($product->category->updated_at);
        }
        return response()->json([
            'data' => $products,
        ], 200);
    }

    /**
     * @throws ValidationException
     */
    public function createProduct(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
            'category_id' => 'required',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description ? $request->description : '';
        $product->image = $request->image ? $request->image : '';
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->save();

        return response()->json([
            'message' => 'Product created successfully',
            'data' => $product,
        ], 201);
    }

    public function getProductByID(Request $request): \Illuminate\Http\JsonResponse
    {
        $item = Product::All()->where('id', $request->id)->first();
        return response()->json([
            'data' => $item,
        ], 200);
    }

    public function updateProduct(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $category = Product::All()->where('id', $id)->first();
        $category->name = $request->name ? $request->name : $category->name;
        $category->description = $request->description ? $request->description : $category->description;
        $category->image = $request->image ? $request->image : $category->image;
        $category->price = $request->price ? $request->price : $category->price;
        $category->category_id = $request->category_id ? $request->category_id : $category->category_id;
        $category->save();

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => $category,
        ], 200);
    }
}
