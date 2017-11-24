<?php
/**
 * Created by PhpStorm.
 * User: kaopizadmin
 * Date: 16/11/2017
 * Time: 09:39
 */

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Socialite;

class LoginSocialController extends Controller
{
    /**
     * Redirect the user to the FaceBook authentication page.
     *
     * @return Response
     */
    public function redirectToProviderFB()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from FaceBook.
     *
     * @return Response
     */
    public function handleProviderCallbackFB(Request $request)
    {
        $user_face = Socialite::driver('facebook')->user();
        dd($user_face);
        $user = '';
        if($user_face->email){
            $user = User::where('fb_id',$user_face->id)
                ->orWhere('email',$user_face->email)->first();
        }
        else{
            $user = User::where('fb_id',$user_face->id)->first();
        }

        if(!$user){
            $user = new User();
            $user->name = $user_face->name;
            $user->fb_id = $user_face->id;
            $user->email = $user_face->email;
            /*$user->phone = $user_face->phone;*/
            $user->avatar =  $user_face->avatar;
            $user->gender = $user_face->user['gender'];
            $user->role_id = 'user';
            $user->save();
        }

        else{
            $user->fb_id = $user_face->id;
            if($user_face->email){
                $user->email = $user_face->email;
            }
            if($user->avatar =  ''){
                $user->avatar =  $user_face->avatar;
            }

            $user->save();
        }

        return redirect()->route('home');
    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return Response
     */
    public function redirectToProviderGG(Request $request)
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return Response
     */
    public function handleProviderCallbackGG(Request $request)
    {
        $user_gg = Socialite::driver('google')->user();
        /*dd($user_gg);*/
        if($user_gg->email){
            $user = User::where('gg_id',$user_gg->id)
                ->orWhere('email',$user_gg->email)->first();
        }

        if(!$user){
            $user = new User();
            $user->name = $user_gg->name;
            $user->email = $user_gg->email;
            /*$user->phone = $user_face->phone;*/
            $user->avatar =  $user_gg->avatar_original;
            $user->role_id = 'user';
            $user->save();
        }

        else{
            $user->gg_id = $user_gg->id;
            if($user_gg->email){
                $user->email = $user_gg->email;
            }
            if($user->avatar =  ''){
                $user->avatar =  $user_gg->avatar_original;
            }
            $user->save();
        }

        return redirect()->route('home');
    }
}