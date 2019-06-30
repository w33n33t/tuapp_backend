<?php

namespace Modules\City\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\City\Entities\City;

class CityController extends Controller
{ 
    /**
        * Display a listing of City.  
    */
    public function index()
    {  
        $city = City::get(); 
        return responsejson(1 , 'ok' , $city); 
    }
 
    /**
        * Store a newly City. 
        * @bodyParam name string required The name of the City.    
    */
    public function store(Request $request)
    { 
        $data = $request->all(); 
        $validator = validator()->make($data, [
            'name'               => 'required|min:6',  
        ]); 
        if ($validator->fails()) 
        {
            return responsejson(1 , $validator->errors()->first() , $validator->errors()); 
        }  
        $city = City::create($request->all());   
        $city->save();  
        return responsejson(1 , 'OK' ,$city);
    }


    /**
         * Show the City.
         * @bodyParam  int $id required
     */ 
    public function show($id)
    {   
        $city = City::find($id); 
        if(! $city)
        {
            return responsejson( 0 , 'OPPs' , 'There Is No City Request');
        } 
        return responsejson(1 , 'OK' , $city);  
    }  
   
 
    /**
        * Update City. 
        * @bodyParam name string required The name of the City.     
    */  
    public function update(request $request , $id)
    { 
        $city = City::find($id);
        $data = $request->all(); 
        $validator = validator()->make($data, [   
            'name'               => 'required|min:6' 
        ]); 
        if ($validator->fails()) 
        {
            return responsejson(0 , $validator->errors()->first() , $validator->errors()); 
        }    
        $city->update($data); 
        return responsejson(1 , 'OK' , $city); 
    }   


    /**
         * Remove the City.
         * @bodyParam  int $id required
     */
    public function destroy($id)
    {
        $city = City::find($id);
        if (!$city)
        {
            return responseJson(0 , 'OPPs' , 'There Is No City Request');
        } 
        $city->delete();
        return responseJson(1 , 'OK' , 'Deleted done successfully');
    } 


}
