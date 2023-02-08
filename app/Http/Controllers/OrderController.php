<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller {
    public function getAllOrders(Request $request): \Illuminate\Http\JsonResponse{

        $orders = Order::all();
        return response()->json([
            'data' => $orders,
        ], 200);
    }

    /**
     * @throws ValidationException
     */
    public function createOrder(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->validate($request, [
            'user_id' => 'required',
            'products_id' => 'required',
        ]);

        $order = new Order();
        $order->user_id = $request->user_id;

        $order->save();


        return response()->json([
            'message' => 'Order created successfully',
            'data' => $order,
        ], 201);

    }
    //TODO: Fix many to many relationships
    public function addProductToOrder(Request $request){
        $order = Order::All()->where('id', $request->order_id)->first();
        $order->save();
        return response()->json([
            'message' => 'Product added to order successfully',
            'data' => $order,
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
