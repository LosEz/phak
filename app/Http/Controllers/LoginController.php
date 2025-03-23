<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class LoginController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(){
        Log::info('['.__METHOD__.']');
        try{
            //Session::put('hasLogin', 0);
            return view("login");
        } catch (\Exception $ex) {
            Log::error('['.__METHOD__.']['.$ex->getFile().'][line : '.$ex->getLine().']['.$ex->getMessage().']');
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }

    public function loginWeb(Request $request) {

        $username = $request->input('username');
        $password = $request->input('password');
        try {

            $result = DB::table('web_user')->where(['username' => $username, 'password' => $password])->first();

            if(!empty($result)) {
                Session::put('hasLogin', 1);
                Session::put('userId', $username);

                $func = DB::select("SELECT * FROM func");
                Session::put('func',$func);
                return redirect('products');
            } else {
                return Redirect::back()->withErrors(['msg' => 'Login Fail']);
            }
        } catch (\Exception $ex){
            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message'=> $ex->getMessage()], 500);
        }
    }

}