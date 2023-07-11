<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Laundries;
use App\Models\Order;
use App\Models\Reviews;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Reviews::with(['user','laundries','order'])->get();
        if($data){
            return ApiFormatter::createApi(200, 'Success', $data);
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
                'ulasan' => 'required',
                'user_id' => 'required',
                'order_id' => 'required',
                'laundries_id' => 'required',
            ]);

            $createReview = $request->all();
            // $createReview['user_id'] = Auth::user()->id;

            $review = Laundries::create($createReview);

            if($review){
                return ApiFormatter::createApi(200, 'Success', $review);
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
    public function show($id)
    {
        //
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
                'ulasan' => 'required',
                'user_id' => 'required',
                'order_id' => 'required',
                'laundries_id' => 'required',
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
            $review = Reviews::findOrFail($id);
            $review->delete();

            return ApiFormatter::createApi(200, 'Success');
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'Failed', $error);
        }
    }
}
