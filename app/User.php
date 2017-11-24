<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function rememberword(){
        return $this->hasMany('App\RememberWord','user_id','id');
    }
    public function course(){
        return $this->hasMany('App\Course','user_id','id');
    }

    public static function loginHash($email, $password)
    {

        if (Auth::attempt(array('email' => $email, 'password' => $password))){
            $user = Auth::user();
            Auth::login($user);
            @session_start();
            return true;
            /*if ($user->status && $user->email_verified) {
                Auth::login($user);
                @session_start();

                return true;
            } else if (!$user->email_verified) {
                dflash(__('Your account has been not activated yet'), 'danger');

                return false;
            } else if (!$user->status) {
                dflash(__('Your account was disabled.'), 'danger', false);

                return false;
            }*/
        } else {
            dflash(__('Email or password is wrong, please try again'), 'danger');

            return false;
        }
    }


    public static function logout()
    {
        @session_start();
        $_SESSION['CKFinder_isAuthorized'] = false;
        Auth::logout();
    }
    
}
