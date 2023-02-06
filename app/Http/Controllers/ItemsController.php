<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ItemsController extends Controller {
    protected $limit = 10;

    public function index() {
        $items = Item::paginate($this->limit);
        return response()->json([
            'data' => $items->items(),
            'meta' => [
                'total' => $items->total(),
                'count' => $items->count(),
                'per_page' => $items->perPage(),
                'current_page' => $items->currentPage(),
                'total_pages' => $items->lastPage(),
                'links' => [
                    'next' => $items->nextPageUrl(),
                    'previous' => $items->previousPageUrl(),
                ],
            ],
        ], 200);
    }

    public function showAllItems(Request $request): \Illuminate\Http\JsonResponse
    {
        $items = Item::all();
        return response()->json([
            'data' => $items,
        ], 200);
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
        ]);

        $item = new Item();
        $item->name = $request->name;
        $item->price = $request->price;
        $item->save();

        return response()->json([
            'message' => 'Item created successfully',
            'data' => $item,
        ], 201);
    }

    public function getByID(Request $request): \Illuminate\Http\JsonResponse
    {
        $item = Item::All()->where('id', $request->id)->first();
        return response()->json([
            'data' => $item,
        ], 200);
    }

    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $item = Item::All()->where('id', $id)->first();
        $item->name = $request->name ? $request->name : $item->name;
        $item->price = $request->price ? $request->price : $item->price;
        $item->save();

        return response()->json([
            'message' => 'Item updated successfully',
            'data' => $item,
        ], 200);
    }
}
