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

class RoleController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    private $funcId = 0206;

    public function index()
    {
        Log::info('[' . __METHOD__ . ']');

        return view('role');
    }

    public function pageAdd()
    {
        Log::info('[' . __METHOD__ . ']');

        $func = DB::select("SELECT * FROM func");

        return view('roleAdd', ['func' => $func]);
    }

    public function pageEdit($id = 0)
    {
        Log::info('[' . __METHOD__ . ']');

        $roles = DB::select("SELECT * FROM roles WHERE role_id = $id");
        $permission = DB::select("Select f.func_name as funcName, f.func_id, 
                                            IF( p.is_view is not null, p.is_view, 0) as is_view ,
                                            IF( p.is_add is not null, p.is_add, 0) as is_add ,
                                            IF( p.is_edit is not null, p.is_edit, 0) as is_edit ,
                                            IF( p.is_delete is not null, p.is_delete, 0) as is_delete ,
                                            IF( p.is_import is not null, p.is_import, 0) as is_import ,
                                            IF( p.is_export is not null, p.is_export, 0) as is_export
                                         from func f 
                                            left join permissions p on f.func_id = p.func_id and p.role_id = $id
                                            order by func_id asc");
        if(empty($roles)) {
            return view('404');
        }
        return view('roleEdit', ["roles" => $roles[0], "permissions" => $permission]);
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
            $sql = ' SELECT role_name as roleName, role_id as roleId FROM roles r ';

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

    public function addData(Request $request)
    {
        Log::info('[' . __METHOD__ . '] start ');
        try {
            DB::beginTransaction();
            $roleName = $request->input('roleName');
            $roleStatus = $request->input('roleStatus');
            $funcIdAll = $request->input('funcId');
            $perView = $request->input('perView');
            $perAdd = $request->input('perAdd');
            $perEdit = $request->input('perEdit');
            $perDelete = $request->input('perDelete');
            $perImport = $request->input('perImport');
            $perExport = $request->input('perExport');
            $now = Carbon::now()->setTimezone("Asia/Bangkok");
            $userId = Session::get('userId');

            
            $roles = DB::select("select * from roles where role_name = '$roleName'");

            if(!empty($roles)) {
                throw new Exception("Role Name : " . $roleName . " is duplicate.");
            }

            $roleArr = array("role_name" => $roleName, "role_status" => $roleStatus, "create_date" => $now, "create_by" => $userId);

            $roleId = DB::table('roles')->insertGetId( $roleArr );


            for($i = 0; $i < count($funcIdAll); $i++) {

                $data = array("role_id" => $roleId,
                            "func_id" => $funcIdAll[$i],
                            "is_view" => $perView[$i] === 'true' ? true : false,
                            "is_add" => $perAdd[$i] === 'true' ? true : false,
                            "is_edit" => $perEdit[$i] === 'true' ? true : false,
                            "is_delete" => $perDelete[$i] === 'true' ? true : false,
                            "is_import" => $perImport[$i] === 'true' ? true : false,
                            "is_export" => $perExport[$i] === 'true' ? true : false);

                DB::table('permissions')->insert($data);
            }

            $act = new ActivityLogController();
            $act->insert($this->funcId,  "Add roles " . $roleName, "Add", $userId);

            Log::info('[' . __METHOD__ . '] finish ');
            DB::commit();
            return response()->json(['message' => "Success"], 200);
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }

    public function editData(Request $request)
    {
        Log::info('[' . __METHOD__ . '] start ');
        try {
            DB::beginTransaction();
            $roleId = $request->input('roleId');
            $roleName = $request->input('roleName');
            $roleStatus = $request->input('roleStatus');
            $funcId = $request->input('funcId');
            $perView = $request->input('perView');
            $perAdd = $request->input('perAdd');
            $perEdit = $request->input('perEdit');
            $perDelete = $request->input('perDelete');
            $perImport = $request->input('perImport');
            $perExport = $request->input('perExport');
            $now = Carbon::now()->setTimezone("Asia/Bangkok");
            $userId = Session::get('userId');

            
            $roles = DB::select("select * from roles where role_name = '$roleName' AND role_id != $roleId");

            if(!empty($roles)) {
                throw new Exception("Role Name : " . $roleName . " is duplicate.");
            }

            $roleArr = array("role_name" => $roleName, "role_status" => $roleStatus, "update_date" => $now, "update_by" => $userId);
            $roleId = DB::table('roles')->where('role_id',"=",$roleId)->update( $roleArr );



            for($i = 0; $i < count($funcId); $i++) {

                $check = DB::select("SELECT * FROM permissions WHERE role_id = $roleId AND func_id = $funcId[$i]");
                if(empty($check)) {
                    $data = array("role_id" => $roleId,
                                "func_id" => $funcId[$i],
                                "is_view" => $perView[$i] === 'true' ? true : false,
                                "is_add" => $perAdd[$i] === 'true' ? true : false,
                                "is_edit" => $perEdit[$i] === 'true' ? true : false,
                                "is_delete" => $perDelete[$i] === 'true' ? true : false,
                                "is_import" => $perImport[$i] === 'true' ? true : false,
                                "is_export" => $perExport[$i] === 'true' ? true : false);

                    DB::table('permissions')->insertGetId($data);
                } else {
                    $data = array(
                        "is_view" => $perView[$i] === 'true' ? true : false,
                        "is_add" => $perAdd[$i] === 'true' ? true : false,
                        "is_edit" => $perEdit[$i] === 'true' ? true : false,
                        "is_delete" => $perDelete[$i] === 'true' ? true : false,
                        "is_import" => $perImport[$i] === 'true' ? true : false,
                        "is_export" => $perExport[$i] === 'true' ? true : false);

                    DB::table('permissions')
                    ->where('role_id',"=",$roleId)
                    ->where('func_id',"=", $funcId[$i])->update($data);
                }
            }

            $act = new ActivityLogController();
            $act->insert($this->funcId,  "Edit roles " . $roleName, "Edit", $userId);

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
