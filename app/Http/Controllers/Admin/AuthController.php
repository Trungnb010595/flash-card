<?php
/**
 * Created by PhpStorm.
 * User: baotr
 * Date: 9/29/2017
 * Time: 4:02 PM
 */

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends AdminBaseController
{
    public function loginView(){
        return view('admin/login');
    }
    public function loginHandle(Request $request){
        $email = $request->get('email');
        $password = $request->get('password');
        if (User::loginHash($email, $password)) {

            return redirect()->route('admin.index');
        }

        return view('admin.login');
    }
    public function logout()
    {
        User::logout();
        return redirect()->route('admin.login-view');
    }

}