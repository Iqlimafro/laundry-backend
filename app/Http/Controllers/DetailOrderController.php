<?php

namespace App\Http\Controllers;

use App\Models\DetailOrder;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use Exception;

class DetailOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DetailOrder::with('items','orders')->get;
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
            'nama' => 'required',
            'harga' => 'required',
            'qty' => 'required',
            'items_id' => 'required',
            'order_id' => 'required',
            ]);

            $createDetail = $request->all();
            // $createOrder['user_id'] = Auth::user()->id;

            $detail = DetailOrder::create($createDetail);

            if($detail){
                return ApiFormatter::createApi(200, 'Success', $detail);
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
    public function show($order_id)
    {
        $order = DetailOrder::where('order_id', $order_id)->get();
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
                'nama' => 'required',
                'harga' => 'required',
                'qty' => 'required',
                'items_id' => 'required',
                'order_id' => 'required',
            ]);

            $detail = DetailOrder::findOrFail($id);
            $detail->update($request->all());

            return ApiFormatter::createApi(200, 'Success', $detail);
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
            $detail = DetailOrder::findOrFail($id);
            $detail->delete();

            return ApiFormatter::createApi(200, 'Success');
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'Failed', $error);
        }
    }
}
