<?php



if(!function_exists('responsejson')){

	function responsejson($status , $message , $date=null){     	
 
        $response = [ 
			'status'  => $status,
			'message' => $message,
			'date'    => $date,
        ];

        return response()->json($response); 
    }  

    
if(!function_exists('api_user')){ 
    function api_user(){     	 
        return Auth::guard('api_user')->user();
        }  
    }

}

  