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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UsersController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    private $funcId = 0206;

    public function index()
    {
        Log::info('[' . __METHOD__ . ']');

        return view('users');
    }

    public function pageAdd()
    {
        Log::info('[' . __METHOD__ . ']');

        return view('roleAdd');
    }

    public function pageEdit($id = 0)
    {
        Log::info('[' . __METHOD__ . ']');

        $roles = DB::select("SELECT * FROM roles WHERE role_id = $id");

        if(empty($roles)) {
            return view('404');
        }

        return view('roleEdit', ["role" => $roles]);
    }

    public function searchData(Request $request)
    {

        try {
            $roleName = $request->input('roleName');

            $roles = $this->getRoles($roleName);

            Log::info('[' . __METHOD__ . '] finish ');
            return response()->json(['message' => "Success", 'roles' => $roles], 200);
        } catch (Exception $ex) {

            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }

    private function  getRoles($roleName)
    {
        try {
            $sql = ' SELECT * FROM role r ';

            if($roleName != null && $roleName != "") {
                $sql .= ' WHERE role_name like "%' .$roleName .'%"';
            }

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
            $roleId = $request->input('roleId');
            $roleName = $request->input('roleName');
            $type = $request->input('type');
            $now = Carbon::now()->setTimezone("Asia/Bangkok");
            $userId = Session::get('userId');

            if ($type == "add") {
                $data = array(
                    "role_name" => $roleName,
                    "create_date" => $now,
                    "create_by" => $userId
                );

                $result = DB::table("roles")->insert($data);
            } else if ($type == "edit") {
                $data = array(
                    "role_name" => $roleName,
                    "contact_updated_date" => $now,
                    "contact_updated_by" => $userId
                );

                $result = DB::table("contomers")->where('role_id', $roleId)->update($data);
            } else {
                throw new Exception("Wrong mode");
            }

            $act = new ActivityLogController();
            $act->insert($this->funcId, $type . " roles " . $roleName, $type, $userId);

            Log::info('[' . __METHOD__ . '] finish ');
            DB::commit();
            return response()->json(['message' => "Success"], 200);
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }
}
