<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\BidList;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class BiddingController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $bid = Bid::all();
            return $this->successResponse($bid, 'success', 200);
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
            $bid = Bid::create([
                'bid_id' => Str::uuid()->toString(),
                'order_id' => $request->order_id,
                'supplier_id' => Auth::user()->id,
                'total_bid_price' => $request->order_total_price,
            ]);

            foreach ($request->order_list as $list) {
                BidList::create([
                    'bid_list_id' => Str::uuid()->toString(),
                    'bid_id' => $bid->bid_id,
                    'order_list_id' => $list['order_list_id'],
                    'price_per_item' => $list['price_per_item'],
                    'total_price' => $list['total_price'],
                ]);
            }
            return $this->successResponse(null, 'Item created successfully', 201);
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
            $bid = Bid::findOrFail($id);
            return $this->successResponse($bid, 'success', 200);
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
            $bid = Bid::findOrFail($id);
            $bid->update($request->validated());
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
            $bid = Bid::findOrFail($id);

            $bid->delete();

            return $this->successResponse(null, 'Item deleted successfully', 204);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function getAlreadyBidder(Request $request)
    {
        try {

            $dateFrom = $request->input('date_from');
            $dateTo = $request->input('date_to');

            $dateFromString = date('Y-m-d', strtotime($dateFrom));
            $dateToString = date('Y-m-d', strtotime($dateTo));

            if ($dateFromString === $dateToString) {

                $orders = Auth::user()->orderBidding->whereDate('created_at', $dateFromString)->get();
            } else {

                $orders = Auth::user()->orderBidding->whereBetween('created_at', [$dateFromString, $dateToString])->get();
            }

            $orders = Auth::user()->orderBidding;
            $orderItems = [];

            foreach ($orders as $order) {
                $orderItems[] = $order->orderList;
            }
            return $this->successResponse($orders, 'success', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function getNotYetBidder(Request $request)
    {
        try {

            $dateFrom = $request->input('date_from');
            $dateTo = $request->input('date_to');

            $dateFromString = null;
            $dateToString = null;



            if ($dateFrom && $dateTo) {
                $dateFromString = date('Y-m-d', strtotime($dateFrom));
                $dateToString = date('Y-m-d', strtotime($dateTo));
            }
            // dd($dateFromString, $dateToString);
            if (($dateFromString === $dateToString) && ($dateFromString && $dateToString)) { //have value and same

                $orders = Order::whereDate('created_at', $dateFromString)->whereNotIn('supplier_id', Auth::user()->id)->get();
            } elseif ($dateFromString === null && $dateToString === null) { // if null
                dd(Auth::user()->id);
                $orders = Order::where('supplier_id', Auth::user()->id)->get();
            } else {

                $orders = Order::whereBetween('created_at', [$dateFromString, $dateToString])->whereNotIn('supplier_id', Auth::user()->id)->get();
            }

            // dd($orders);

            $orderItems = [];

            foreach ($orders as $order) {
                $orderItems[] = $order->orderList;
            }
            return $this->successResponse($orders, 'success', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
