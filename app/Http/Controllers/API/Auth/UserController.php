<?php

namespace App\Http\Controllers\API\Auth;
 
use Mail; 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Validator; 
use jeremykenedy\LaravelRoles\Models\Role;

class UserController extends Controller
{
   
    /**
     * @param Request $request
     * @return Response
     * 
     * @SWG\Post(
     *      path="/Auth/register",
     *      summary="register a newly User",
     *      tags={"User"},
     *      description="Store User",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="name",
     *          in="body",
     *          description="User that should be stored",
     *          required=true,
     *          @SWG\Schema(ref="#/definitions/User")
     *      ),
     *      @SWG\Parameter(
     *          name="first_name",
     *          in="body",
     *          description="User that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/User")
     *      ),
     *      @SWG\Parameter(
     *          name="last_name",
     *          in="body",
     *          description="User that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/User")
     *      ),
     *      @SWG\Parameter(
     *          name="email",
     *          in="body",
     *          description="User that should be stored",
     *          required=true,
     *          @SWG\Schema(ref="#/definitions/User")
     *      ),
     *      @SWG\Parameter(
     *          name="password",
     *          in="body",
     *          description="User that should be stored",
     *          required=true,
     *          @SWG\Schema(ref="#/definitions/User")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/User"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function register(Request $request)
    {
        $data = $request->all(); 
        $validator = validator()->make($data, [
            'name'                 => 'required|min:6',
            'first_name'           => '',
            'last_name'            => '',
            'email'                => 'required|email|unique:users',   
            'password'             => 'required|confirmed|min:6|max:60|alpha_num',   
            'city_id'              => 'numeric',  
            'branch_id'            => 'numeric',   
        ]); 
        if ($validator->fails()) 
        {
            return responsejson(1 , $validator->errors()->first() , $validator->errors()); 
        } 
        $request->merge(['password' => bcrypt($request->password)]);
        $user = User::create($request->all()); 
        $user->api_token = str_random(60);
        
        $role = config('roles.models.role')::where('name', '=', 'ShopManager')->first();  
        $user->attachRole($role);
        
        $user->save(); 
          
        return responsejson(1 , 'OK' ,
                                      [
                                         'Token' => $user->api_token,
                                         'User'      => $user
                                       ]); 
    }
 

    /**
     * @param Request $request
     * @return Response
     * 
     * @SWG\Post(
     *      path="/Auth/login",
     *      summary="login User",
     *      tags={"User"},
     *      description="login User",
     *      produces={"application/json"}, 
     *      @SWG\Parameter(
     *          name="email",
     *          in="body",
     *          description="User that should be login",
     *          required=true,
     *          @SWG\Schema(ref="#/definitions/User")
     *      ),
     *      @SWG\Parameter(
     *          name="password",
     *          in="body",
     *          description="User that should be login",
     *          required=true,
     *          @SWG\Schema(ref="#/definitions/User")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/User"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function login (Request $request)
    {  
        $validator = validator()->make($request->all(), [ 
            'email'              => 'required', 
            'password'           => 'required',
        ]); 
        if ($validator->fails()) 
        {
            return responsejson(0 , $validator->errors()->first() , $validator->errors()); 
        }   
        $user = User::where('email' , $request->email)->first();  
        if($user)
        {
            if(Hash::check($request->password , $user->password)) 
            {
                return responsejson(1 , 'OK' , $user); 
            }
            else 
            { 
                return responsejson(0 , 'fails' , 'password is wrong'); 
            }
        } 
        return responsejson(0 , 'fails' , 'email is wrong');  
    }
  
 
    /**
        * return user profile
        *        
    */
    public function profile ()
    {   
        $user = api_user();   
        return responsejson(1 , 'OK' ,  $user);    
    }  


    /**
        * update user
        *     
        * @bodyParam name string required The name of the user. 
        * @bodyParam email string required The email of the user. 
        * @bodyParam phone int required The phone of the user. 
        * @bodyParam password string The password of the user.    
    */ 
    public function update(request $request)
    {
        // $user = $request->user();  

        $user = api_user();  
        $data = $request->all(); 
        $validator = validator()->make($data, [   
            'name'               => 'required|min:6',
            'email'              => 'required|email|unique:users,email,'.$user->id, 
            'phone'              => 'required|numeric|unique:users,phone,'.$user->id, 
        ]); 
        if ($validator->fails()) 
        {
            return responsejson(0 , $validator->errors()->first() , $validator->errors()); 
        }  
        if ( ! $request->password == '')
        {
            $data['password'] = bcrypt($request->password);
        } 
        else
        {
            $data['password'] = $user->password;
        } 
        $user->update($data); 
        return responsejson(1 , 'OK' , $user); 
    }   
 
    
    /**
        * reset password
        *      
        * @bodyParam phone int required The phone of the user.     
    */  
    public function reset(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'phone' => 'required'
        ]);

        if ($validation->fails()) 
        { 
            return responseJson(0 , $validation->errors()->first() , $validator->errors());
        }

        $user = User::where('phone',$request->phone)->first();
        if ($user)
        {
            $code = rand(1111,9999);
            $update = $user->update(['pin_code' => $code]);
            if ($update)
            { 
                // send email
                Mail::send('emails.reset', ['code' => $code], function ($mail) use($user) {
                    $mail->from('no-reply@my-site.com', 'Our Application');

                    $mail->to($user->email, $user->name)->subject('Password Reset');
                });

                return responseJson(1,'please check your phone' ,['pin_code' => $code]);
            }
            else
            {
                return responseJson(0, 'an error has occurred please, try again later');
            }
        }
        else
        {
            return responseJson(0,'There is no account associated with this phone');
        }
    } 


    /**
        * set new password
        *      
        * @bodyParam pin_code int required The pin_code of the user.  
        * @bodyParam new password string The password of the user.    
    */  
    public function password(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'pin_code' => 'required',
            'password' => 'required|confirmed|min:6|max:60|alpha_num',  
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }

        $user = User::where('pin_code',$request->pin_code)->where('pin_code', '!=', 0)->first();

        if ($user)
        {
            $user->password = bcrypt($request->password);
            $user->pin_code = null;

            if ($user->save())
            {
                return responseJson(1,'Password changed successfully');
            }
            else
            {
                return responseJson(0, 'an error has occurred please, try again later');
            }
        }
        else
        {
            return responseJson(0,'This code is invalid');
        }
    }

    

    public function logout()
    {
        auth()->logout();
        return responseJson()->json(['message' => 'Successfully logged out']);
    }


} 
