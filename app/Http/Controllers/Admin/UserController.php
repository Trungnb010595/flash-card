<?php
/**
 * Created by PhpStorm.
 * User: kaopizadmin
 * Date: 09/11/2017
 * Time: 08:40
 */

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Validator;

class UserController extends AdminBaseController
{
    public function listUser(Request $request){
        $users = User::all();
        return $this->render('admin.users.list',['users' => $users]);
    }

    public function add(Request $request){
        if($request->isMethod('GET')){
            return $this->render('admin.users.add');
        }
        else{
            $request->flash();

            $messages = array(
                'name.required' => 'Chưa điền tên',
                'email.required' => 'Chưa điền email',
                'password.required' => 'Chưa điền password',
                'repassword.required' => 'Chưa điền nhập lại mật khẩu',
            );

            $this->validate($request, [
                'name' => 'required',
                'email' => 'required',
                'password' => 'required',
                'repassword' => 'required',
            ], $messages);

            $isset_user = User::where('email',$request->get('email'))->first();
            if ($isset_user){
                dflash('Email đã tồn tại!','warning');
                return back();
            }
            $user = new User();
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->password = Hash::make($request->get('password'));
            $user->birthday = $request->get('birthday');
            $user->phone = $request->get('phone');
            $user->role_id = $request->get('role_id');

            $user->save();
            $user->assignRole(Role::find($request->get('role_id'))->name);

            return redirect()->route('admin.user.list');

        }
    }

    public function edit(Request $request){
        $id = $request->get('id');
        $user = User::find($id);
        if ($user){
            if($request->isMethod('GET')){

                return $this->render('admin.users.edit', [
                    'user' => $user
                ]);
            }
            else {

                $request->flash();
                $messages = array(
                    'name.required' => 'Chưa điền tên',
                    'email.required' => 'Chưa điền email',
                    'password.required' => 'Chưa điền password',
                );

                $this->validate($request, [
                    'name' => 'required',
                    'email' => 'required',
                    'password' => 'required',
                ], $messages);

                if ($request->get('email') != $user->email && User::where('email',$request->get('email'))){
                    dflash('Email đã tồn tại!!','warning');
                    return back();
                }
                $user->name = $request->get('name');
                $user->email = $request->get('email');
                $user->password = Hash::make($request->get('password'));
                $user->birthday = $request->get('birthday');
                $user->phone = $request->get('phone');
                $user->role_id = $request->get('role_id');
                $user->save();
                $user->removeRole(Role::all());
                $user->assignRole(Role::find($request->get('role_id'))->name);

                dflash('Insert success','success');
                return redirect()->route('admin.user.list');
            }
        }
        dflash('User not found!!','danger');
        return back();

    }

    public function delete(Request $request){
        $id = $request->get('id');
        $user = User::find($id);
        if(!$user){
            dflash('User not found!!','danger');
            return back();
        }
        else{
            $user->delete();
            dflash('Delete Success!!','success');
            return back();
        }

    }
}