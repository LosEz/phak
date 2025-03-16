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

class OrganizationController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    private $funcId = 0203;

    public function index()
    {
        Log::info('[' . __METHOD__ . ']');
        $organization = $this->getOrganization(1)[0];
        return view('organize', ['org' => $organization]);
    }

    public function editData()
    {
        Log::info('[' . __METHOD__ . ']');
        return view('organizeAdd');
    }



    public function searchData()
    {
        try {
            $contacts = $this->getOrganization(1);

            Log::info('[' . __METHOD__ . '] finish ');
            return response()->json(['message' => "Success", 'contacts' => $contacts], 200);
        } catch (Exception $ex) {

            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }

    private function  getOrganization($id)
    {
        try {
            $result = DB::select("select
                                            o.*,
                                            concat(o.org_add_house_th, ' ', o.org_add_road_th, ' ', o.org_add_country_th, ' ', o.org_add_sub_district_th, ' ', o.org_add_city_th, o.org_add_province_th,' ', o.org_add_postal_code_th) as addressTH,
                                            concat(o.org_add_house_no_en, ' ', o.org_add_road_en, ' ', o.org_add_country_en, ' ', o.org_add_sub_district_en, ' ', o.org_add_city_en, o.org_add_province_en,' ', o.org_add_postal_code_en) as addresEN,
                                            concat(o.org_send_house_no, ' ', o.org_send_road, ' ', o.org_send_country, ' ', o.org_send_sub_district, ' ', o.org_send_city, o.org_send_province,' ', o.org_send_postal_code) as sendDoc
                                        from
                                            organization o");
            return $result;
        } catch (Exception $ex) {
            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            throw new Exception($ex->getMessage());
        }
    }

    public function saveData(Request $request)
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
