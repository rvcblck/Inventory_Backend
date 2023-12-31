<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ApiController;
use App\Http\Requests\ItemRequest;
use Illuminate\Support\Facades\Auth;

class ItemController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $items = Item::all();

            foreach ($items as $item) {
                $item->item_image_url = $item->item_image ? asset('storage/item/' . $item->item_image) : asset('storage/item/sample-item.png');
                // $item->item_image_url = $item->item_image ? asset('storage/item/' . $item->item_id . '/' . $item->logo) : asset('storage/item/sample-item.png');
                $item->unit->unit;
            }

            return $this->successResponse($items, 'success', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemRequest $request)
    {
        try {
            $fields = $request->except('item_image');
            $item_image = ['item_image' => null];

            // check if ImagePic is available in payload
            if ($request->hasFile('item_image')) {
                $filename = time() . '.' . $request->file('item_image')->getClientOriginalExtension();
                Storage::putFileAs('public/item', $request->file('item_image'), $filename);
                $item_image['item_image'] = $filename;
            }

            $item = Item::create([...$fields, ...$item_image]);
            return $this->successResponse($item, 'Item created successfully', 201);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $item = Item::findOrFail($id);

            $item->item_image_url = $item->item_image ? asset('storage/item/' . $item->item_image) : asset('storage/item/sample-item.png');

            return $this->successResponse($item, 'success', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemRequest $request, string $id)
    {
        try {

            $new_filename = '';
            $item_image = $request->file('item_image');

            // check if item_image is available in payload
            if ($request->hasFile('item_image')) {
                $userDir = 'item';

                // Get all files in the program directory
                $file = Storage::files($userDir);
                Storage::delete($file);

                $filename = $item_image->getClientOriginalName();
                $new_filename = $filename;
                Storage::putFileAs('public/item', $item_image, $new_filename);
            }

            $item = Item::findOrFail($id);

            $item->update($request->all());
            if ($new_filename) {
                $item->update(['item_image' => $new_filename]);
            }

            return $this->successResponse($item, 'Item updated successfully', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $item = Item::findOrFail($id);

            $item->delete();

            return $this->successResponse(null, 'Item deleted successfully', 204);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function getInvetoryPerCompany()
    {
        try {
            $quantities = Auth::user()->company->quantity; // get item quantity per company

            $data = [];

            foreach ($quantities as $quantity) {
                $items = $quantity->items; // get item detail

                $itemData = [
                    'item_id' => $items->item_id,
                    'item_name' => $items->item_name,
                    'item_description' => $items->item_description,
                    'unit_id' => $items->unit_id,
                    'item_image' => $items->item_image,
                    'category_id' => $items->category_id,
                    'created_at' => $items->created_at,
                    'updated_at' => $items->updated_at,
                    'item_image_url' => $items->item_image ? asset('storage/item/' . $items->item_image) : asset('storage/item/sample-item.png'),
                    'item_quantity' => $quantity->item_quantity,
                    'unit' => $items->unit,
                ];

                $data[] = $itemData;
            }


            return $this->successResponse($data, 'success', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
