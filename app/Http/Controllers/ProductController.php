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

class ProductController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $funcId = "0202";

    public function index(){
        Log::info('['.__METHOD__.']');

        $unit = DB::select("SELECT unit_id as id, unit_type as unitType, unit_type_en as unitTypeEn FROM unit_type");

        return view('product', ["unit" => $unit]);
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
                        p.product_group_code as proGroupCode,
                        p.unit_id as unitId,
                        p.cate_id as cateId

                    FROM
                        products p
                        INNER JOIN product_group pg ON p.product_group_code = pg.product_group_code
                        INNER JOIN category cate ON p.cate_id = cate.cate_id
                        INNER JOIN unit_type ut ON p.unit_id = ut.unit_id";

            if($proCode != null || $proCode != "") {
                $sql .= " AND p.product_code = '$proCode'";
            }

            if($proName != null || $proName != "") {
                $sql .= " AND p.product_name like '%$proName%'";
            }

            if ($proGroupCode != null || $proGroupCode != "") {
                $sql .= " AND p.product_group_code = '$proGroupCode'";
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
                        "product_group_code" => $proGroupCode,
                        "cate_id"=> $cateId,
                        "unit_id"=> $unitId,
                        "create_date" => $now,
                        "create_by" => $userId
                    );

                    $result = DB::table("products")->insert($data);
                } else if($type == "edit"){
                    $data = array(
                        "product_name" => $proName,
                        "product_group_code" => $proGroupCode,
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