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
use stdClass;

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

                $users = DB::select("SELECT * FROM users where id = $result->user_id")[0];

                $func = DB::select("select p.func_id, f.func_name, f.menu_id, f.func_url , p.is_add, p.is_edit
                                            , p.is_delete, p.is_import, p.is_export  from permissions p 
                                inner join function_tb f on p.func_id = f.func_id
                                WHERE p.is_view = true and p.role_id = $users->role_id 
                                Order by f.func_id, f.func_seq asc");

                Session::put('func',$func);
                return redirect('dashboard');
            } else {
                return Redirect::back()->withErrors(['msg' => 'Login Fail']);
            }
        } catch (\Exception $ex){
            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message'=> $ex->getMessage()], 500);
        }
    }

}