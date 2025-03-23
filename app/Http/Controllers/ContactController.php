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

class ContactController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    private $funcId = 0203;

    public function index()
    {
        Log::info('[' . __METHOD__ . ']');
        return view('contact');
    }


    public function searchData(Request $request)
    {

        try {
            $conCode = $request->input('contactCode');
            $conName = $request->input('contactName');
            $conTaxId = $request->input('contactTaxId');

            $contacts = $this->getcontomers($conCode, $conName, $conTaxId );

            Log::info('[' . __METHOD__ . '] finish ');
            return response()->json(['message' => "Success", 'contacts' => $contacts], 200);
        } catch (Exception $ex) {

            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }

    private function  getContacts($conCode, $conName, $conTaxId)
    {
        try {
            $sql = "SELECT c.contact_id as conId,
                        c.contact_code as conCode,
                        c.contact_type as conType,
                        c.contact_tax_id as conTaxId,
                        c.contact_name as conName,
                        c.contact_sub_type as conSubType,
                        c.contact_bussiness_type as conBusType,
                        c.contact_category_type as conCateType,
                        c.contact_address as conAddress,
                        c.contact_person as conPerson,
                        c.contact_number as conNumber,
                        c.contact_bank as conBank,
                        c.contact_bank_account_name as conBackAccName,
                        c.contact_bank_account_number as conBackAccNumber,
                        c.contact_created_Date as conCreatedDate,
                        c.contact_created_by as conCreatedBy,
                        c.contact_updated_date as conUpdatedDate,
                        c.contact_update_by as conUpdateBy
                    FROM contact c";

            if ($conCode != null || $conCode != "") {
                $sql .= " AND c.contact_code = '$conCode'";
            }

            if ($conName != null || $conName != "") {
                $sql .= " AND c.contact_name like '%$conName%'";
            }

            if ($conTaxId != null || $conTaxId != "") {
                $sql .= " AND c.contact_tax_id = '$conTaxId'";
            }

            $sql = preg_replace("/AND/", "WHERE ", $sql, 1);

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
            $conId = $request->input('conId');
            $conCode = $request->input('conCode');
            $conName = $request->input('conName');
            $conType = $request->input('conType');
            $conTaxId = $request->input('conTaxId');
            $conSubType = $request->input('conSubType');
            $conBusType = $request->input('conBusType');
            $conCateType = $request->input('conCateType');
            $conAddress = $request->input('conAddress');
            $conPerson = $request->input('conPerson');
            $conNumber = $request->input('conNumber');
            $conBank = $request->input('conBank');
            $conBankAccName = $request->input('conBankAccName');
            $conBankAccNumber = $request->input('conBankAccNumber');
            $type = $request->input('type');

            $now = Carbon::now()->setTimezone("Asia/Bangkok");

            $userId = Session::get('userId');

            if ($type == "add") {
                $data = array(
                    "contact_code" => $conCode,
                    "contact_name" => $conName,
                    "contact_type" => $conType,
                    "contact_tax_id" => $conTaxId,
                    "contact_sub_type" => $conSubType,
                    "contact_business_type" => $conBusType,
                    "contact_category_type" => $conCateType,
                    "contact_address" => $conAddress,
                    "contact_person" => $conPerson,
                    "contact_number" => $conNumber,
                    "contact_bank" => $conBank,
                    "contact_bank_account_name" => $conBankAccName,
                    "contact_bank_account_number" => $conBankAccNumber,
                    "contact_created_date" => $now,
                    "contct_created_by" => $userId
                );

                $result = DB::table("contomers")->insert($data);
            } else if ($type == "edit") {
                $data = array(
                    "contact_code" => $conCode,
                    "contact_name" => $conName,
                    "contact_type" => $conType,
                    "contact_tax_id" => $conTaxId,
                    "contact_sub_type" => $conSubType,
                    "contact_business_type" => $conBusType,
                    "contact_category_type" => $conCateType,
                    "contact_address" => $conAddress,
                    "contact_person" => $conPerson,
                    "contact_number" => $conNumber,
                    "contact_bank" => $conBank,
                    "contact_bank_account_name" => $conBankAccName,
                    "contact_bank_account_number" => $conBankAccNumber,
                    "contact_updated_date" => $now,
                    "contact_updated_by" => $userId
                );

                $result = DB::table("contomers")->where('contact_id', $conId)->update($data);
            } else {
                throw new Exception("Wrong mode");
            }

            $act = new ActivityLogController();
            $act->insert($this->funcId, $type . " contacts " . $conName, $type, $userId);

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
