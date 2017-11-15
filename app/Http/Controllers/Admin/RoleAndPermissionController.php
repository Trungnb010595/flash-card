<?php
/**
 * Created by PhpStorm.
 * User: baotr
 * Date: 10/1/2017
 * Time: 9:38 PM
 */

namespace App\Http\Controllers\Admin;

use App\RoleHasPermission;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RoleAndPermissionController extends AdminBaseController
{
    //Role
    public function showRole(){
        $roles = Role::all();
        $role_edit = '';
        return $this->render('admin.role_and_permission.manage_role',['roles'=>$roles,'role_edit'=>$role_edit]);
    }
    public function addRole(Request $request){
        $name = $request->get('name');
        $desc = $request->get('desc');
        $role_exist = Role::where('name',$name)->get();
        if(count($role_exist)){
            dflash('Tên đã được sử dụng','warning');
            return back();
        }
        else{
            Role::create(['name' => $name, 'desc' => $desc]);
            return back();
        }

    }
    public function editRole(Request $request){
        if($request->isMethod('GET')){
            $role_edit = Role::find($request->get('id'));
            $roles = Role::all();
            return $this->render('admin.role_and_permission.manage_role',['roles'=>$roles, 'role_edit' => $role_edit]);
        }
        else{
            $role_edit = Role::find($request->get('id'));
            $name = $request->get('name');
            $desc = $request->get('desc');
            $role_edit->name = $name;
            $role_edit->desc = $desc;
            $role_edit->save();
            return back();
        }
    }
    public function deleteRole(Request $request){
        $id = $request->get('id');
        Role::destroy($id);
        return back();
    }

    //Permission
    public function showPermission(Request $request){
        $permissions = Permission::orderBy('seq','asc')->get();
        $permission_edit = '';
        return $this->render('admin.role_and_permission.manage_permission',['permissions' => $permissions,'permission_edit'=>$permission_edit]);
    }
    public function addPermission(Request $request){
        $name = $request->get('name');
        $desc = $request->get('desc');
        $permission_exist = Permission::where('name',$name)->get();
        if(count($permission_exist)){
            dflash('Tên đã được sử dụng','warning');
            return back();
        }
        else{
            $per = Permission::create(['name' => $name, 'desc' => $desc]);
            return back();
        }
    }
    public function deletePermission(Request $request){
        $id = $request->get('id');
        Permission::destroy($id); //Xóa bản ghi trong permission, đồng thời các bản ghi có liên quan trong các bảng khác cũng bị xóa
        return back();
    }
    public function editNameViewPermission(Request $request){
        if($request->isMethod('GET')){
            $permissions = Permission::all();
            $permission_edit = Permission::find($request->get('id'));
            return $this->render('admin.role_and_permission.manage_permission',['permissions' => $permissions,'permission_edit'=>$permission_edit]);
        }
        else{
            $id = $request->get('id');
            $desc = $request->get('desc');
            $per = Permission::find($id);
            $per->desc = $desc;
            $per->save();
            return back();
        }
    }
    public function sortPermission(Request $request){
        $arrs = json_decode($request->get('arr_sort'));
        foreach ($arrs as $arr){
            $permission = Permission::find($arr->id);
            $permission->seq = $arr->seq;
            $permission->save();
        }
        return back();
    }

    //Add Permission For Route
    public function addPermissionForRole(Request $request){
        if($request->isMethod('GET')){
            $role_id = $request->get('role_id');
            $role_has_permissions = RoleHasPermission::where('role_id',$role_id)->get();
            $roles = Role::all();
            $permissions = Permission::all();
            return $this->render('admin.role_and_permission.add_permission_for_role',['roles'=>$roles,'permissions'=>$permissions, 'role_has_permissions'=>$role_has_permissions]);
        }
        else{
            $arr_checkbox = json_decode($request->get('arr_checkbox'));
            $role_id = $request->get('role_id');
            $role = Role::find($role_id);
            /*dd($arr_checkbox);*/
            /*$role->hasPermissionTo('admin');*/ //sao lai ko co? xem trong doc la co ma???
            foreach ($arr_checkbox as $item){
                $per = RoleHasPermission::where([['role_id',$role_id],['permission_id',$item->per_id]])->get();
                if ($item->status == 1){
                    if(count($per) == 0){
                        $role->givePermissionTo($item->per_name);
                    }
                }
                else{
                    if(count($per) > 0){
                        $role->revokePermissionTo($item->per_name);
                    }
                }
            }
            return back();
        }
    }
}