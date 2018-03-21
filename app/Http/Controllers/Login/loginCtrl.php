<?php

namespace App\Http\Controllers\Login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use DB;

class loginCtrl extends Controller
{
    //
    public function checkLogin(Request $request){
    	/*DB::enableQueryLog();*/
    	$remember = $request->get('remember');
    	$username = $request->get('username');
    	$password = $request->get('password');
    	$check = Auth::attempt(['username' => $username, 'password' => $password],$remember);
/*    	echo "<pre>".print_r(
            DB::getQueryLog()
        ,true)."</pre>";*/
        //die();
    	if ($check) {
		    return response()->json(route('dashboard.index'));
		} else {
			return response()->json($check);
		}
    }
}
