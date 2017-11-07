<?php
/**
 * Created by PhpStorm.
 * User: baotr
 * Date: 9/26/2017
 * Time: 8:56 AM
 */
/*
|--------------------------------------------------------------------------
| ADMIN Routes
|--------------------------------------------------------------------------
|
| Here is where you can ...
|
*/

Route::group(['namespace' => 'Admin','middleware' => 'web'],function (){
    /*
     * login
     */
    Route::get('/login', 'AuthController@loginView')->name('admin.login-view');
    Route::post('/login', 'AuthController@loginHandle')->name('admin.login-handle');

    /*
     * Middleware CheckPermission
     * */
    Route::group(['middleware' => 'permission'],function (){
        Route::get('/', [
            'as' => 'admin.index',
            'uses' => 'HomeController@index'
        ]);
        Route::get('/logout', [
            'uses' => 'AuthController@logout',
            'as' => 'admin.logout'
        ]);

        Route::group(['prefix' => 'user'], function () {

        });

        //Role_and_permission
        Route::group(['prefix' => 'role_and_permission'],function (){
            //role
            Route::group(['prefix' => 'role'],function (){
                Route::get('','RoleAndPermissionController@showRole')->name('admin.role.index');
                Route::post('add','RoleAndPermissionController@addRole')->name('admin.role.add');
                Route::any('edit','RoleAndPermissionController@editRole')->name('admin.role.edit');
                Route::get('delete','RoleAndPermissionController@deleteRole')->name('admin.role.delete');
            });
            //permission
            Route::group(['prefix' => 'permission'],function (){
                Route::get('','RoleAndPermissionController@showPermission')->name('admin.permission.index');
                Route::post('add','RoleAndPermissionController@addPermission')->name('admin.permission.add');
                Route::any('edit','RoleAndPermissionController@editNameViewPermission')->name('admin.permission.edit-name-view');
                Route::get('delete','RoleAndPermissionController@deletePermission')->name('admin.permission.delete');
                Route::post('sort','RoleAndPermissionController@sortPermission')->name('admin.permission.sort');
            });
            //add permission for role
            Route::any('add_permission_for_role','RoleAndPermissionController@addPermissionForRole')->name('admin.add-permission-for-role');
        });

        //User
        Route::group(['prefix' => 'user'], function () {
            Route::get('/list', 'UserController@listUser')->name('admin.user.list');
            Route::group([],function (){
                Route::any('add', 'UserController@add')->name('admin.user.add');
                Route::any('edit', 'UserController@edit')->name('admin.user.edit');
                Route::get('status', 'UserController@changeStatus')->name('admin.user.status');
                Route::get('delete', 'UserController@delete')->name('admin.user.delete');
                /*Route::post('change-vip', 'UserController@changeVip')->name('admin.user.change-vip');*/
                /*Route::any('check-vip', 'UserController@checkVip')->name('admin.user.check-vip');*/
            });

        });
    });


});