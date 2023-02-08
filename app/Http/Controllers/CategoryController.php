<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller {
    protected $limit = 10;

    public function getAllCategories(Request $request): \Illuminate\Http\JsonResponse{
        $categories = Category::all();
        return response()->json([
            'data' => $categories,
        ], 200);
    }

    /**
     * @throws ValidationException
     */
    public function createCategory(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->save();

        return response()->json([
            'message' => 'Category created successfully',
            'data' => $category,
        ], 201);
    }

    public function getByID(Request $request): \Illuminate\Http\JsonResponse
    {
        $item = Category::All()->where('id', $request->id)->first();
        return response()->json([
            'data' => $item,
        ], 200);
    }

    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $category = Category::All()->where('id', $id)->first();
        $category->name = $request->name ? $request->name : $category->name;
        $category->save();

        return response()->json([
            'message' => 'Item updated successfully',
            'data' => $category,
        ], 200);
    }
}
