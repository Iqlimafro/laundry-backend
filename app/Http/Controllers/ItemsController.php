<?php

namespace App\Http\Controllers;

use App\Models\Items;
use Illuminate\Http\Request;
use Exception;
use App\Helpers\ApiFormatter;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $item = Items::with(['laundries','detailOrder'])->get();
        if($item){
            return ApiFormatter::createApi(200, 'Success', $item);
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
            'name' => 'required',
            'price_pcs' => 'required',
            'laundry_id' => 'required'
            ]);

            return $createItems = $request->all();
            // $createOrder['user_id'] = Auth::user()->id;

            $items = Items::create($createItems);

            if($items){
                return ApiFormatter::createApi(200, 'Success', $items);
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
    public function show($laundry_id)
    {
        $items = Items::where('laundry_id', $laundry_id)->get();
        if($items){
            return ApiFormatter::createApi(200, 'Success', $items);
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
                'name' => 'required',
                'price_pcs' => 'required',
                'laundry_id' => 'required'
            ]);

            $items = Items::findOrFail($id);
            $items->update($request->all());

            return ApiFormatter::createApi(200, 'Success', $items);
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
            $items = Items::findOrFail($id);
            $items->delete();

            return ApiFormatter::createApi(200, 'Success');
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'Failed', $error);
        }
    }
}
