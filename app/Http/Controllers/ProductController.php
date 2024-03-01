<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Carbon;
use Log;
use Illuminate\Http\Request;
use App\Http\Controllers\ActivityLogController;

class ProductController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(){
        Log::info('['.__METHOD__.']');

        $category = DB::select("SELECT cate_id as cateCode, cate_type as cateName FROM category");
        $productGroup = DB::select("SELECT product_group_code as prodGroupCode, product_group_name as prodGroupName FROM product_group");
        $unit = DB::select("SELECT unit_id as id, unit_type as unitType FROM unit_type");

        return view('product', ['category' => $category,'productGroup'=> $productGroup, "unit" => $unit]);
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
                        p.product_price as proPrice,
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

    public function createProduct(Request $request)
    {

        try {
            Log::info('[' . __METHOD__ . '] finish ');
            return view('productDetail');

        } catch (Exception $ex) {

            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);

        }

    }

    public function addEditData(Request $request) {

        try {
            DB::beginTransaction();

                $proCode = $request->input('proCode');
                $proName = $request->input('proName');
                $proPrice = $request->input('proPrice');
                $proGroupCode = $request->input('proGroupCode');
                $cateId = $request->input('proCate');
                $unitId = $request->input('proUnit');
                $type = $request->input('type');

                $data = array(
                    "product_code" => $proCode,
                    "product_name" => $proName,
                    "product_price" => $proPrice,
                    "product_group_code" => $proGroupCode,
                    "cate_id"=> $cateId,
                    "unit_id"=> $unitId
                );

                $result = DB::table("products")->insert($data);
                
                $now = Carbon::now()->setTimezone("Asia/Bangkok");

                $act = new ActivityLogController();
                $act->insert("1", $type . " product " . $proName, $now, "koon");

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