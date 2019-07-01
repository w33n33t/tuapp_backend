<?php

namespace Modules\Shop\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Shop\Entities\Shop;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('shop::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('shop::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {  
        $data = $request->all(); 
        $validator = validator()->make($data, [
            'branch'      => 'required|min:6',  
            'city_id'     => 'required',   
        ]); 
        if ($validator->fails()) 
            {
                return responsejson(1 , $validator->errors()->first() , $validator->errors()); 
            }  
        $shop = Shop::create($request->all());   
        $shop->save();  

        $shop->app_id = ApplicationId();
        $shop->save(); 
        
        return responsejson(1 , 'OK' ,$shop);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('shop::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('shop::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
