<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\ActivityLogController;
use App\Mail\MyEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class UsersController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    private $funcId = 0204;

    public function index()
    {
        Log::info('[' . __METHOD__ . ']');

        return view('user');
    }

    public function pageAdd()
    {
        Log::info('[' . __METHOD__ . ']');
        $roles = DB::select("SELECT role_id, role_name FROM roles");
        return view('userAdd', [ 'roles' => $roles ]);
    }

    public function pageEdit($id = 0)
    {
        Log::info('[' . __METHOD__ . ']');

        $users = DB::select("SELECT * FROM users WHERE id = $id");

        if(empty($users)) {
            return view('404');
        }

        $roles = DB::select("SELECT role_id, role_name FROM roles");

        return view('userEdit', ["user" => $users[0], "roles" => $roles]);
    }

    public function searchData(Request $request)
    {

        try {
            $usrName = $request->input('usrName');
            $usrCode = $request->input('usrCode');

            $users = $this->getUsers($usrName, $usrCode);

            Log::info('[' . __METHOD__ . '] finish ');
            return response()->json(['message' => "Success", 'users' => $users], 200);
        } catch (Exception $ex) {

            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }

    private function  getUsers($usrName, $usrCode)
    {
        try {
            $sql = " SELECT u.*, concat( u.usr_firstname,' ', u.usr_lastname ) as fullname, r.role_name as roleName FROM users u ";
            $sql .= " INNER JOIN roles r on u.role_id = r.role_id";

            if($usrName != null && $usrName != "") {
                $sql .= " AND u.usr_firstname like %'" .$usrName . "'%";
                $sql .= " AND u.usr_lastname like %'" .$usrName ."'%";
            }

            if($usrCode != null && $usrCode != "") {
                $sql .= " AND u.id = $usrCode ";
            }

            $sql = preg_replace("/AND/","WHERE", $sql,1);
            $result = DB::select($sql);
            return $result;
        } catch (Exception $ex) {
            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            throw new Exception($ex->getMessage());
        }
    }

    public function addEditData(Request $request)
    {
        Log::info('[' . __METHOD__ . '] start ');
        try {
            DB::beginTransaction();
            $usrId = $request->input('usrId');
            $usrFirstname = $request->input('usrFirstname');
            $usrLastname = $request->input('usrLastname');
            $usrEmail = $request->input('usrEmail');
            $usrPhone = $request->input('usrPhone');
            $roleId = $request->input('roleId');
            $type = $request->input('type');
            $now = Carbon::now()->setTimezone("Asia/Bangkok");
            $userId = Session::get('userId');

            if ($type == "add") {
                $data = array(
                    "usr_firstname" => $usrFirstname,
                    "usr_lastname" => $usrLastname,
                    "usr_email" => $usrEmail,
                    "usr_phone" => $usrPhone,
                    "role_id" => $roleId,
                    "create_date" => $now,
                    "create_by" => $userId
                );

                $usrId = DB::table("users")->insertGetId($data);

                $password = $this->randomPassword();

                $webUser = array("username" => $usrEmail, "password" => $password, "user_id" => $usrId);
                DB::table("web_user")->insert($webUser);

                $data = ['username' => $usrEmail, 'password' => $password];
                Mail::to($usrEmail)->send(new MyEmail($data));

            } else if ($type == "edit") {
                $data = array(
                    "usr_firstname" => $usrFirstname,
                    "usr_lastname" => $usrLastname,
                    "usr_email" => $usrEmail,
                    "usr_phone" => $usrPhone,
                    "role_id" => $roleId,
                    "update_date" => $now,
                    "update_by" => $userId
                );

                $result = DB::table("users")->where('id', "=",$usrId)->update($data);
            } else {
                throw new Exception("Wrong mode");
            }

            $act = new ActivityLogController();
            $act->insert($this->funcId, $type . " users " . $usrFirstname, $type, $userId);

            Log::info('[' . __METHOD__ . '] finish ');
            DB::commit();
            return response()->json(['message' => "Success"], 200);
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }

    private function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}
