<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laundries;
use App\Models\Order;
use App\Models\User;
use App\Helpers\ApiFormatter;
use Exception;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $laundryId = $request->query('laundry_id');

        // $data = Order::with(['laundries']);

        // $data = $data->when($laundryId, function($q, $laundryId) {
        //     return $q->where('laundry_id', $laundryId);
        // });
        // $data = $data->orderBy('laundry_id')->get();

        $data = Order::with(['user','laundries'])->get();
        // $data = Order::with(['laundries'])->orderBy('laundry_id');
        if($data){
            return ApiFormatter::createApi(200, 'Success', $data);
        }else{
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    public function getByDate()
    {
        $data = Order::orderBy('created_at', 'desc')->get();
        if($data){
            return ApiFormatter::createApi(200, 'Success', $data);
        }else{
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    public function getByStatus($status)
    {
        $order = Order::where('status', $status)->get();
        if($order){
            return ApiFormatter::createApi(200, 'Success', $order);
        }else{
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    public function getHistoryOrder()
    {
        $status = 'Selesai';
        $order = Order::where('status', $status)
                    ->orderBy('created_at','desc')
                    ->get();
        if($order){
            return ApiFormatter::createApi(200, 'Success', $order);
        }else{
            return ApiFormatter::createApi(400, 'failed');
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
            'type' => 'required',
            'pickup' => 'required',
            'status' => 'required',
            'weight' => 'required',
            'total_amount' => 'required',
            'user_id' => 'required',
            'laundry_id' => 'required',
            ]);

            $createOrder = $request->all();
            $order = Order::create($createOrder);

            if($order){
                return ApiFormatter::createApi(200, 'Success', $order);
            }else{
                return ApiFormatter::createApi(400, 'Failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'Failed',$error);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        $order = Order::where('user_id', $user_id)->get();
        if($order){
            return ApiFormatter::createApi(200, 'Success', $order);
        }else{
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    public function getOrderByLaundryId($laundry_id)
    {
        $order = Order::where('laundry_id', $laundry_id)->get();
        if($order){
            return ApiFormatter::createApi(200, 'Success', $order);
        }else{
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'type' => 'required',
                'pickup' => 'required',
                'status' => 'required',
                'weight' => 'required',
                'total_amount' => 'required',
                'user_id' => 'required',
                'laundry_id' => 'required',
            ]);

            $order = Order::findOrFail($id);
            $order->update($request->all());

            return ApiFormatter::createApi(200, 'Success', $order);
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'Failed', $error);
        }
    }

    public function updateTotalAmount(Request $request, $id)
    {
        try
        {
            $request->validate([
                "weight" =>'required',
                "total_amount" =>'required',
            ]);

            $order = Order::findOrFail($id);
            $order->update($request->all());

            return ApiFormatter::createApi(200, 'Success', $order);
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'Failed', $error);
        }
    }

    public function ubahStatus(Request $request, $id)
    {
        try
        {
            $request->validate([
                'status' => 'required',
            ]);

            $order = Order::findOrFail($id);
            $order->update($request->all());

            return ApiFormatter::createApi(200, 'Success', $order);
            } catch (Exception $error) {
                return ApiFormatter::createApi(400, 'Failed', $error);
            }
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();

            return ApiFormatter::createApi(200, 'Success');
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'Failed', $error);
        }
    }
}
