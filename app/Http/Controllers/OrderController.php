<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderList;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class OrderController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $orders = Order::all();
            $orderItems = [];

            foreach ($orders as $order) {
                $orderItems[] = $order->orderList;
            }



            return $this->successResponse($orders, 'Success', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $user = User::where('id', $request->from)->first();

            $isAdmin = $user->role->role;

            $orderNumberMax = Order::max('order_number');

            if (!$orderNumberMax) {
                $orderNumberMax = 1; //if order table is empty
            }


            // Create a new request
            $order = Order::create([
                'order_id' => Str::uuid()->toString(),
                'order_number' => $orderNumberMax + 1, // plus 1 to max order_number
                'qr_code' => $request->qr_code,
                'from' => $request->from,
                'to' => $request->to,
                'release_date' => now(),
                'delivery_location' => $user->delivery_location,
                'order_status' => "Out For Delivery"


            ]);

            // Create request items
            foreach ($request->data as $item) {

                $totalPrice = $item['request_approved'] * $item['item_price'];
                OrderList::create([


                    'order_list_id' => Str::uuid()->toString(),
                    'order_id' => $order->order_id,
                    'item_id' => $item['item_id'],
                    'order_quantity' => $item['request_approved'],
                    'order_price' => $totalPrice

                ]);


                $itemInventory = Item::find($item['item_id']);
                if ($itemInventory) {
                    if ($isAdmin == "Admin") {
                        //subtract the order quntity to inventory
                        $itemInventory->item_quantity -= $item['request_approved'];
                        $itemInventory->save();
                    } else {
                        // dd($item['request_approved']);
                        $itemInventory->item_quantity += $item['request_approved'];
                        $itemInventory->save();
                    }
                }
            }



            return $this->successResponse(null, 'Order created successfully', 201);
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
            $user = OrderList::findOrFail($id);
            return $this->successResponse($user, 'success', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {


            foreach ($request->data as $item) {
                // Find the corresponding request_item in the database by request_item_id
                $requestItem = OrderList::where('request_item_id', $item['request_item_id'])->first();

                // Update quantity_approved and quantity_disapproved
                $requestItem->quantity_approved = $item['quantity_approved'];
                $requestItem->quantity_disapproved = $item['request_item_quantity'] - $item['quantity_approved'];

                // Save the changes
                $requestItem->save();
            }

            $requestorRequest = Order::where('request_id', $id)->first();

            $requestorRequest->request_status = $request->request_status;

            $requestorRequest->save();




            return $this->successResponse(null, 'updated successfully');
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
            $category = OrderList::findOrFail($id);

            $category->delete();

            return $this->successResponse(null, 'Item deleted successfully', 204);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function requestFiltered(Request $request)
    {

        $rules = [
            'date_from' => 'required',
            'date_to' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 400);
        }

        try {
            $dateFrom = $request->input('date_from');
            $dateTo = $request->input('date_to');

            $dateFromString = date('Y-m-d', strtotime($dateFrom));
            $dateToString = date('Y-m-d', strtotime($dateTo));

            if ($dateFromString === $dateToString) {

                $orders = Order::whereDate('created_at', $dateFromString)->get();
            } else {

                $orders = Order::whereBetween('created_at', [$dateFromString, $dateToString])->get();
            }



            $orderList = [];

            foreach ($orders as $order) {
                $orderList[] = $order->orderList;
            }

            return $this->successResponse($orders, 'Success', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    function generateUniqueCode($length = 12)
    {
        $code = Str::random($length);
        while (Order::where('qr_code', $code)->exists()) {
            $code = Str::random($length);
        }

        return $code;
    }
}
