<?php

namespace App\Http\Controllers;

use App\Models\Request as ModelsRequest;
use App\Models\RequestList;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RequestController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $requestsItems = ModelsRequest::all();

            $requestsList = [];

            foreach ($requestsItems as $requestsItem) {
                $requestsList[] = $requestsItem->requestList;
            }



            return $this->successResponse($requestsItems, 'Success', 200);
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

            $requestNumberMax = ModelsRequest::max('request_number');

            if (!$requestNumberMax) {
                $requestNumberMax = 1; //if order table is empty
            }

            // Create a new request
            $requestsItems = ModelsRequest::create([
                'request_id' => Str::uuid()->toString(),
                'request_number' => $requestNumberMax + 1,
                'qr_code' => $this->generateUniqueCode(),
                'from' => $request->from,
                'to' => $request->to,
                'from_message' => $request->from_message,
                'to_message' => $request->to_message,

            ]);

            // Create request items
            foreach ($request->items as $item) {


                RequestList::create([
                    'request_list_id' => Str::uuid()->toString(),
                    'request_id' => $requestsItems->request_id,
                    'item_id' => $item['item_id'],
                    'request_quantity' => $item['count'],
                    'status' => 'pending'

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
            $user = ModelsRequest::findOrFail($id);
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
                $requestItem = RequestList::where('request_list_id', $item['request_list_id'])->first();

                // Update quantity_approved and quantity_disapproved
                $requestItem->request_approved = $item['request_approved'];
                $requestItem->request_disapproved = $item['request_quantity'] - $item['request_approved'];
                $requestItem->status = $item['status'];

                // Save the changes
                $requestItem->save();
            }




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
            $category = ModelsRequest::findOrFail($id);

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

                $requestsItems = ModelsRequest::whereDate('created_at', $dateFromString)->get();
            } else {

                $requestsItems = ModelsRequest::whereBetween('created_at', [$dateFromString, $dateToString])->get();
            }



            $requestsList = [];

            foreach ($requestsItems as $requestsItem) {
                $requestsList[] = $requestsItem->requestList;
            }

            return $this->successResponse($requestsItems, 'Success', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    function generateUniqueCode($length = 12)
    {
        $code = Str::random($length);
        while (ModelsRequest::where('qr_code', $code)->exists()) {
            $code = Str::random($length);
        }

        return $code;
    }
}
