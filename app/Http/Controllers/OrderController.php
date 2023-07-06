<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderList;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

            $orderNumberMax = Order::max('order_number');

            if (!$orderNumberMax) {
                $orderNumberMax = 1; //if order table is empty
            }

            // Create a new request
            $order = Order::create([
                'order_id' => Str::uuid()->toString(),
                'company_id' => Auth::user()->company_id,
                'order_number' => $orderNumberMax + 1, // plus 1 to max order_number
                'qr_code' => $this->generateUniqueCode(),
                'request_id' => $request->request_id,
                'delivery_location' => Auth::user()->company->company_address,
                'transaction_type' => $request->transaction_type,
                'date_needed' => $request->date_needed,
                'is_bidding' => true,
                'bidding_start' => now()


            ]);

            // Create request items
            foreach ($request->data as $item) {
                OrderList::create([

                    'order_list_id' => Str::uuid()->toString(),
                    'order_id' => $order->order_id,
                    'item_id' => $item['item_id'],
                    'status' => 'pending',
                    'order_quantity' => $item['request_approved'],

                ]);
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

            $order = Order::findOrFail($id);

            $order->update($request->all());

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


    public function showOrderUsingQRCode($qrcode)
    {
        try {
            $orders = Order::where('qr_code', $qrcode)->first();

            $orders = $orders->orderList;

            // $orderList = [];

            // foreach ($orders as $order) {
            //     $orderList[] = $order->orderList;
            // }

            return $this->successResponse($orders, 'Order Find Successfuly', 204);
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
