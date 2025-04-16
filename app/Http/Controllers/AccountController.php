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

class AccountController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $funcId = "0208";

    public function index(){
        Log::info('['.__METHOD__.']');
        return view('account');
    }

    public function pageAdd(){
        Log::info('['.__METHOD__.']');

        $pri = DB::table('account_primary_type')->where('apt_code', '=', '5')->get();
        $sec = DB::table('account_secondary_type')->where('apt_id', '=',  $pri->id)->get();
        $third = DB::table('account_third_type')->where('ast_id', '=', $sec->id)->get();
        
        $accountCode = $this->generateAccountCode($pri, $sec, $third);
        
        return view('accountAdd', ['pri' => $pri, 'sec' => $sec, 'third' => $third, 'accountCode' => $accountCode]);
    }


    public function generateAccountCode($pri, $sec, $third) {
        Log::info('['.__METHOD__.']');

        $thirdCode = $third->ast_code;


        $accountCode = $thirdCode;



        return $accountCode;
    }

    public function pageEdit(){
        Log::info('['.__METHOD__.']');
        return view('accountEdit');
    }

    public function primaryDropdownList() {
        Log::info('[' . __METHOD__ . '] start ');
        try {
            $primary = DB::select("select ast.ast_code, CONCAT(ast.ast_code, ' ', ast.ast_name) as label 
                                        from account_secondary_type ast where id in (1,2,3,4)
                                    union 
                                        select apt.apt_code, concat(id,' ', apt.apt_name) as label  
                                        from account_primary_type apt where id in (3,4,5)");
            return response()->json(['message' => "Success", 'primary' => $primary], 200);
        } catch (Exception $ex) {
            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }

    public function secondaryDropdownList(Request $request) {
        Log::info('[' . __METHOD__ . '] start ');
        try {
            $priCode = $request->input('priCode');

            $sql = "select
                        ast.id,
                        ast.apt_id ,
                        ast_code as code,
                        CONCAT( SUBSTR(ast.ast_code, 2), ' ', ast.ast_name, ' (', ast.ast_code, ')') as label
                        from account_secondary_type ast where ast.apt_id in (3,4,5) and ast.apt_id  = '$priCode'
                    UNION 
                        SELECT 
                        att.id,
                        att.ast_id,
                        att.att_code as code,
                        CONCAT( substr(att_code, 3), ' ', att.att_name ) as label
                        from account_third_type att where ast_id in (1,2,3,4) 
                        and att_code != '111' and substr(att.att_code, 1, 2) = '$priCode';";

            $secondary = DB::select($sql);
            Log::info('[' . __METHOD__ . '] finish ');
            return response()->json(['message' => "Success", 'secondary' => $secondary], 200);
        } catch (Exception $ex) {
            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }

    public function thirdDropdownList(Request $request) {
        Log::info('[' . __METHOD__ . '] start ');
        try {
            $priCode = $request->input('priCode');
            $secCode = $request->input('secCode');

            $thirdCode = $priCode . $secCode;

            Log::info('[' . __METHOD__ . '] finish ');
            return response()->json(['message' => "Success"], 200);
        } catch (Exception $ex) {
            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }

    public function searchData(Request $request) {

        try {
                $proCode = $request->input('proCodeSearch');
                $proName = $request->input('proNameSearch');
                $proGroupCode = $request->input('prodGroupSearch');
                $cateId = $request->input('cateSearch');
                $unitId = $request->input('unitSearch');


                $products = $this->getProducts($proCode, $proName, $proGroupCode, $cateId, $unitId);

                Log::info('[' . __METHOD__ . '] finish ');
                return response()->json(['message' => "Success", 'products' => $products], 200);

        } catch (Exception $ex) {

            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);
            
        }
 
    }

    private function  getProducts($proCode, $proName, $proGroupCode, $cateId, $unitId) {
        try {

            $sql = "SELECT
                        p.product_code as proCode,
                        p.product_name as proName,
                        pg.product_group_name as proGroupName,
                        cate.cate_type as cateType,
                        ut.unit_type as unitType,
                        p.unit_id as unitId,
                        p.cate_id as cateId

                    FROM
                        products p
                        INNER JOIN category cate ON p.cate_id = cate.cate_id
                        INNER JOIN unit_type ut ON p.unit_id = ut.unit_id";

            if($proCode != null || $proCode != "") {
                $sql .= " AND p.product_code = '$proCode'";
            }

            if($proName != null || $proName != "") {
                $sql .= " AND p.product_name like '%$proName%'";
            }

            if ($cateId != null || $cateId != "") {
                $sql .= " AND p.cate_id = '$cateId'";
            }

            if ($unitId != null || $unitId != "") {
                $sql .= " AND p.unit_id = '$proCode'";
            }

            $sql = preg_replace("/AND/", "WHERE", $sql, 1);
            
            $result = DB::select($sql);
            return $result;

        } catch (Exception $ex) {
            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
           throw new Exception($ex->getMessage());
        }
    }

    public function addEditData(Request $request) {
        Log::info('[' . __METHOD__ . '] start ');
        try {
            DB::beginTransaction();

                $proCode = $request->input('proCode');
                $proName = $request->input('proName');
                $proGroupCode = $request->input('proGroupCode');
                $cateId = $request->input('proCate');
                $unitId = $request->input('proUnit');
                $type = $request->input('type');

                $now = Carbon::now()->setTimezone("Asia/Bangkok");

                $userId = Session::get('userId');

                if($type == "add") {
                    $data = array(
                        "product_code" => $proCode,
                        "product_name" => $proName,
                        "cate_id"=> $cateId,
                        "unit_id"=> $unitId,
                        "create_date" => $now,
                        "create_by" => $userId
                    );

                    $result = DB::table("products")->insert($data);
                } else if($type == "edit"){
                    $data = array(
                        "product_name" => $proName,
                        "cate_id"=> $cateId,
                        "unit_id"=> $unitId,
                        "update_date" => $now,
                        "update_by" => $userId
                    );

                    $result = DB::table("products")->where('product_code', $proCode)->update($data);
                } else {
                    throw new Exception("Wrong mode");
                }

                $act = new ActivityLogController();
                $act->insert( $this->funcId, $type . " product " . $proName, $type, $userId);

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