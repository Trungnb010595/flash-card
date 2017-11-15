<?php
/**
 * Created by PhpStorm.
 * User: kaopizadmin
 * Date: 07/11/2017
 * Time: 15:14
 */

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(){
        return view('web.index');
    }
}