<?php
/**
 * Created by PhpStorm.
 * User: baotr
 * Date: 9/26/2017
 * Time: 9:16 AM
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminBaseController extends Controller
{
    protected $firebase;
    protected $fbdatabase;

    protected $language;
    protected $defaultLanguage;
    protected $allLanguages;

    public function __construct()
    {
        /*$this->defaultLanguage = defaultLanguage();
        $this->allLanguages = allLanguages();*/

        //Firebase
        /*$this->firebase = (new Factory())->withCredentials(app_path() . '/../config/firebase-config.json')
            ->withDatabaseUri('https://zindo-ef778.firebaseio.com')->create();
        $this->fbdatabase = $this->firebase->getDatabase();*/
    }

    function render($view = null, $data = [], $mergeData = [])
    {
        /*$this->language = session('language');
        $data['current_language'] = $this->language;
        $data['allLanguages'] = $this->allLanguages;
        $data['defaultLanguage'] = $this->defaultLanguage;*/
        $data['auth'] = Auth::user();
        return view($view, $data, $mergeData);
    }
}