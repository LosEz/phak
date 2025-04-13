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

        $unit = DB::select("select * from unit_type");
        $productGroup = DB::select("select * from products_group");

        return view('product', ['unit' => $unit, 'productGroup' => $productGroup]);
    }

    public function pageAdd(){
        Log::info('['.__METHOD__.']');

        $accSale = DB::select("select * from account a where SUBSTR(a.acc_code, 1,3) in ('420', '410') or SUBSTR(a.acc_code, 1,2) in ('22', '21')");
        $accPurchase = DB::select("select * from account a where SUBSTR(a.acc_code, 1,3) in ('510', '114');");
        $unit = DB::select("select * from unit_type");

        return view('productAdd', ['accSale' => $accSale, 'accPurchase' => $accPurchase, 'unit' => $unit]);
    }

    public function pageEdit($id){
        Log::info('['.__METHOD__.']');

        $product = DB::select("select * from products p where p.p_id = $id")[0];
        $accSale = DB::select("select * from account a where SUBSTR(a.acc_code, 1,3) in ('420', '410') or SUBSTR(a.acc_code, 1,2) in ('22', '21')");
        $accPurchase = DB::select("select * from account a where SUBSTR(a.acc_code, 1,3) in ('510', '114');");
        $unit = DB::select("select * from unit_type");

        return view('productEdit', ['product' => $product, 'accSale' => $accSale, 'accPurchase' => $accPurchase, 'unit' => $unit]);
    }

    public function generateCode(Request $request) {
        Log::info('[' . __METHOD__ . '] start ');

        try {

            $pgId = $request->input('pgId');

            $sql = "SELECT MAX(substr( p.p_code , 2, 5)) as maxCode FROM products p where pg_id = $pgId";
            $result = DB::select($sql);
            $maxCode = $result[0]->maxCode;

            if ($maxCode == null) {
                if($pgId == 1) {
                    $maxCode = "P00001";
                } else {
                    $maxCode = "S00001";
                }
            } else {

                $maxCode = $maxCode + 1;

                if($pgId == 1) {
                    $maxCode = "P" . str_pad($maxCode, 5, "0", STR_PAD_LEFT);
                } else {
                    $maxCode = "S" . str_pad($maxCode, 5, "0", STR_PAD_LEFT);
                }
            }

            Log::info('[' . __METHOD__ . '] finish ');
            return response()->json(['message' => "Success", 'code' => $maxCode], 200);

        } catch (Exception $ex) {
            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }

    public function searchData(Request $request) {

        try {
                $proCode = $request->input('proCodeSearch');
                $proName = $request->input('proNameSearch');
                $proGroupCode = $request->input('productGroupSearch');
                $unitId = $request->input('unitSearch');

                $products = $this->getProducts($proCode, $proName, $proGroupCode, $unitId);

                Log::info('[' . __METHOD__ . '] finish ');
                return response()->json(['message' => "Success", 'products' => $products], 200);

        } catch (Exception $ex) {

            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);
            
        }
 
    }

    private function  getProducts($proCode, $proName, $proGroupCode, $unitId) {
        try {

            $sql = "SELECT
                        p.p_id as pId,
                        p.p_code as proCode,
                        p.p_name as proName,
                        pg.pg_name as pgName,
                        ut.unit_type as unitType
                    FROM
                        products p
                        INNER JOIN products_group pg ON p.pg_id = pg.pg_id
                        INNER JOIN unit_type ut ON p.unit_id = ut.unit_id";

            if($proCode != null || $proCode != "") {
                $sql .= " AND p.product_code like '%$proCode%'";
            }

            if($proName != null || $proName != "") {
                $sql .= " AND p.product_name like '%$proName%'";
            }

            if($proGroupCode != null || $proGroupCode != "") {
                $sql .= " AND p.pg_id = '$proGroupCode'";
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
                $pId = $request->input('pId');
                $pgId   = $request->input('pgId');
                $pName = $request->input('productName');
                $pCode = $request->input('productCode');
                $productDesc = $request->input('productDesc');
                $unitId = $request->input('productUnit');
                $pSalePrice = $request->input('pSalePrice');
                $pSaleVatRate = $request->input('pSaleVatRate');
                $pBuyPrice = $request->input('pBuyPrice');
                $pBuyVatRate = $request->input('pBuyVatRate');
                $pSaleAcc = $request->input('pSaleAcc');
                $pBuyAcc = $request->input('pBuyAcc');
                $type = $request->input('type');

                $now = Carbon::now()->setTimezone("Asia/Bangkok");

                $userId = Session::get('userId');

                if($type == "add") {
                    $data = array(
                        "pg_id" => $pgId,
                        "p_code" => $pCode,
                        "p_name" => $pName,
                        "p_desc" => $productDesc,
                        "p_sale_price" => $pSalePrice,
                        "p_sale_vat_rate" => $pSaleVatRate,
                        "p_purchase_price" => $pBuyPrice,
                        "p_purchase_vat_rate" => $pBuyVatRate,
                        "p_acc_sale" => $pSaleAcc,
                        "p_acc_purchase" => $pBuyAcc,
                        "unit_id" => $unitId,
                        "p_created_date" => $now,
                        "p_created_by" => $userId
                    );
                    $result = DB::table("products")->insertGetId($data);
                } else if($type == "edit"){
                    $data = array(
                        "p_name" => $pName,
                        "p_desc" => $productDesc,
                        "p_sale_price" => $pSalePrice,
                        "p_sale_vat_rate" => $pSaleVatRate,
                        "p_purchase_price" => $pBuyPrice,
                        "p_purchase_vat_rate" => $pBuyVatRate,
                        "p_acc_sale" => $pSaleAcc,
                        "p_acc_purchase" => $pBuyAcc,
                        "unit_id" => $unitId,
                        "p_updated_date" => $now,
                        "p_updated_by" => $userId
                    );

                    $result = DB::table("products")->where('p_id', $pId)->update($data);
                } else {
                    throw new Exception("Wrong mode");
                }

                $act = new ActivityLogController();
                $act->insert( $this->funcId, $type . " product " . $pName, $type, $userId);

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