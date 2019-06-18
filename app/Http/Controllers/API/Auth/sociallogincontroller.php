<?php
 
namespace App\Http\Controllers\API\Auth;
use Illuminate\Routing\Controller;
use App\socialprovider;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Contracts\JWTSubject; 

use Socialite;

class SocialloginController extends Controller
{
    /**
     * Redirect the user to the {Provider} authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from {Provider}.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();

        // $user->token;
        /*
         * $user->getId();
            $user->getNickname();
            $user->getName();
            $user->getEmail();
            $user->getAvatar();
         */

        $selectProvider = socialprovider::where('provider_id' ,  $user->getId())->first();

        if(!$selectProvider){
            //new user

            $userGetReal = User::where('email' , $user->getEmail())->first();

            if(!$userGetReal){
                $userGetReal = new User();
                $userGetReal->name =  $user->getNickname();
                $userGetReal->email = $user->getEmail();
                $userGetReal->save();
                $userGetReal->api_token =  JWTAuth::fromUser($userGetReal);
                $userGetReal->save();
            }

            $newprovider = new socialprovider();
            $newprovider->provider_id = $user->getId();
            $newprovider->provider = $provider;
            $newprovider->user_id = $userGetReal->id;
            $newprovider->save();

        }else{
            //login user
            $userGetReal  = User::find($selectProvider->user_id);
        }

        auth()->login($userGetReal);

        return responsejson(1 , 'OK' , ['Api_Token' => $userGetReal->api_token, 'User' => $userGetReal]); 
    } 
}