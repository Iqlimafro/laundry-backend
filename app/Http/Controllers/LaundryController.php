<?php

namespace App\Http\Controllers;

use Exception;
use App\Helpers\ApiFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Laundries;


class LaundryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Laundries::with('users')->get();
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
                'name' => 'required',
                'address' => 'required',
                'description' => 'required',
                'price_kilo' => 'required',
                'image' => 'required'
            ]);

            $createLaundry = $request->all();
            $createLaundry['user_id'] = Auth::user()->id;

            $path = $request->gambar->save('/gambar');
            $createLaundry['image'] = $path;

            $laundry = Laundries::create($createLaundry);

            if($laundry){
                return ApiFormatter::createApi(200, 'Success', $laundry);
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
        $laundry = Laundries::where('user_id', $user_id)->get();
        if($laundry){
            return ApiFormatter::createApi(200, 'Success', $laundry);
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
                'address' => 'required',
                'description' => 'required',
                'price_kilo' => 'required',
                'image' => 'required'
            ]);

            $laundry = Laundries::findOrFail($id);
            $laundry->update($request->all());

            return ApiFormatter::createApi(200, 'Success', $laundry);
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
            $laundry = Laundries::findOrFail($id);
            $laundry->delete();

            return ApiFormatter::createApi(200, 'Success');
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'Failed', $error);
        }
    }
}
