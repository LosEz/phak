<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use FFI\Exception;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\ActivityLogController;
use Illuminate\Support\Facades\Session;

class SupplierController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    private $funcId = "0203";

    public function index()
    {
        Log::info('[' . __METHOD__ . ']');
        return view('supplier');
    }


    public function searchData(Request $request)
    {

        try {
            Log::info('[' . __METHOD__ . '] start ');
            $suppCode = $request->input('suppCodeSearch');
            $suppName = $request->input('suppNameSearch');
            $suppliers = $this->getSuppliers($suppCode, $suppName);

            Log::info('[' . __METHOD__ . '] finish ');
            return response()->json(['message' => "Success", 'suppliers' => $suppliers], 200);
        } catch (Exception $ex) {
            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }

    private function  getSuppliers($suppCode, $suppName)
    {
        Log::info('[' . __METHOD__ . '] start');
        try {
            $sql = "SELECT 
                    s.supp_code as suppCode,
                    s.supp_name as suppName,
                    s.firstname,
                    s.lastname,
                    DATE_FORMAT(s.gap_approve_date, '%Y-%m-%d') as gapAppDate,
                    DATE_FORMAT(s.gap_expire_date, '%Y-%m-%d') as gapExpireDate,
                    s.chemicals,
                    s.vet_plot as vetPlot,
                    s.original_soil as originalSoil,
                    s.gap_type as gapType,
                    s.source_product as sourceProduct,
                    s.earth_history as earthHistory
             FROM suppliers s";

            if ($suppCode != null || $suppCode != "") {
                $sql .= " AND s.supp_code = '$suppCode'";
            }

            if ($suppName != null || $suppName != "") {
                $sql .= " AND s.supp_name like '%$suppName%'";
            }

            $sql = preg_replace("/AND/", "WHERE", $sql, 1);

            $result = DB::select($sql);
            Log::info('[' . __METHOD__ . '] end');
            return $result;
        } catch (Exception $ex) {
            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            throw new Exception($ex->getMessage());
        }
    }

    public function createSupplier()
    {
        try {
            Log::info('[' . __METHOD__ . '] finish ');
            return view('supplierAdd');
        } catch (Exception $ex) {
            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }

    public function editSupplier($suppCode)
    {
        try {
            Log::info('[' . __METHOD__ . '] finish ');
            $supp = $this->getSuppliers($suppCode, "");
            if (count($supp) == 1) {
                return view('supplierEdit', ['supp' => $supp[0]]);
            } else {
                throw new Exception("cannot search supplier : " . $supp);
            }
        } catch (Exception $ex) {
            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }


    public function addEditData(Request $request)
    {
        Log::info('[' . __METHOD__ . '] start');
        try {
            DB::beginTransaction();
            $suppCode = $request->input('suppCode');
            $suppName = $request->input('suppName');
            $suppFirstname = $request->input('firstname');
            $suppLastname = $request->input('lastname');
            $gapApproveDate = $request->input('gapAppDate');
            $gapExpireDate = $request->input('gapExpireDate');
            $chemicals = $request->input('chemicals');
            $vetPlot = $request->input('vetPlot');
            $earthHistory = $request->input('earthHistory');
            $originalSoil = $request->input('originalSoil');
            $gapType = $request->input('gapType');
            $sourceProduct = $request->input('sourceProduct');
            $type = $request->input('type');

            $today = Carbon::now()->setTimezone("Asia/Bangkok");

            $userId = Session::get('userId');

            if ($type == "add") {
                $data = array(
                    "supp_code" => $suppCode,
                    "supp_name" => $suppName,
                    "firstname" => $suppFirstname,
                    "lastname" => $suppLastname,
                    "gap_approve_date" => $gapApproveDate,
                    "gap_expire_date" => $gapExpireDate,
                    "chemicals" => $chemicals,
                    "vet_plot" => $vetPlot,
                    "earth_history" => $earthHistory,
                    "original_soil" => $originalSoil,
                    "gap_type" => $gapType,
                    "source_product" => $sourceProduct,
                    "create_date" => $today,
                    "create_by" => $userId
                );
                $result = DB::table("suppliers")->insert($data);
            } else if ($type == "edit") {
                $data = array(
                    "supp_name" => $suppName,
                    "firstname" => $suppFirstname,
                    "lastname" => $suppLastname,
                    "gap_approve_date" => $gapApproveDate,
                    "gap_expire_date" => $gapExpireDate,
                    "chemicals" => $chemicals,
                    "vet_plot" => $vetPlot,
                    "earth_history" => $earthHistory,
                    "original_soil" => $originalSoil,
                    "gap_type" => $gapType,
                    "source_product" => $sourceProduct,
                    "update_date" => $today,
                    "update_by" => $userId
                );
                $result = DB::table("suppliers")->where('supp_code', $suppCode)->update($data);
            } else {
                throw new Exception("fail");
            }



            $act = new ActivityLogController();
            $act->insert($this->funcId, $type . " suppliers " . $suppName, $type, $userId);

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
