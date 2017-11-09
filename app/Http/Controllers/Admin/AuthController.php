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

class AuthController extends AdminBaseController
{
    public function loginView(){
        return view('admin/login');
    }
    public function loginHandle(Request $request){
        $email = $request->get('email');
        $password = $request->get('password');
        dd(User::loginHash($email, $password));
        dd($email.'/'.$password);
        if (User::loginHash($email, $password)) {
            return redirect()->route('admin.index');
        }

        return view('admin.login');
    }
    public function logout()
    {
        User::logout();
        return redirect()->route('admin.login');
    }

}