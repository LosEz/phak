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

    public function pageAdd()
    {
        Log::info('[' . __METHOD__ . ']');

        return view('contactAdd');
    }

    public function pageEdit($id = 0)
    {
        Log::info('[' . __METHOD__ . ']');

        $contact = DB::select("SELECT * FROM contacts WHERE id = $id");
        if(empty($contact)) {
            return view('404');
        }
        return view('contactEdit', ["contact" => $contact[0]]);
    }

    public function searchData(Request $request)
    {

        try {
            $conCode = $request->input('conCodeSearch');
            $conName = $request->input('conNameSearch');
            $conTaxId = $request->input('conTaxIdSearch');

            $contacts = $this->getContacts($conCode, $conName, $conTaxId );

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
            $sql = "select
                        c.id as conId,
                        c.ct_contact_code as conCode,
                        case when c.ct_bus_type = 'H' then c.ct_bus_name else concat(c.ct_addr_contact_name) end as conName,
                        case when c.ct_bus_cate_type = 'N' then 'นิติบุคคล' else 'บุคคลธรรมดา' end as contactType,
                        c.ct_contact_phone as conPhone,
                        case when c.ct_updated_date != null then DATE_FORMAT(c.ct_updated_date, '%d/%m/%Y') else DATE_FORMAT(c.ct_created_date , '%d/%m/%Y') end as lastDate,
                        case when c.ct_updated_by != null then c.ct_updated_by else c.ct_created_by  end as lastBy
                    from
                        contacts c";

            if ($conCode != null || $conCode != "") {
                $sql .= " AND c.ct_contact_code = '$conCode'";
            }

            if ($conName != null || $conName != "") {
                $sql .= " AND (c.ct_bus_name like '%$conName%' OR c.ct_addr_contact_name like '%$conName%')";
            }

            if ($conTaxId != null || $conTaxId != "") {
                $sql .= " AND c.ct_bus_tax_id = '$conTaxId'";
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
            $conId = $request->input('contactId');
            $contactType = $request->input('contactType');
            $conCode = $request->input('contactCode');
            $conNation = $request->input('nation');
            $taxId = $request->input('taxId');
            $busType = $request->input('busType');
            $busCateType = $request->input('busCateType');
            $busBranch = $request->input('busBranch');
            $businessType = $request->input('businessType');
            $busName = $request->input('busName');
            $titleName = $request->input('titleName');
            $firstName = $request->input('firstName');
            $lastName = $request->input('lastName');
            $individualType = $request->input('individualType');
            $conName = $request->input('contactName');
            $conAddress = $request->input('contactAddress');
            $conSubDistrict = $request->input('contactSubDistrict');
            $conDistrict = $request->input('contactDistrict');
            $conProvince = $request->input('contactProvince');
            $conPostalCode = $request->input('contactPost');
            $conEmail = $request->input('contactEmail');
            $conPhone = $request->input('contactPhone');
            $conWeb = $request->input('contactWeb');
            $conFax = $request->input('contactFax');
            $conBank = $request->input('contactBank');
            $conBankAccName = $request->input('contactBankName');
            $conBankAccNumber = $request->input('contactBankNumber');
            $conBankBranch = $request->input('contactBankBranch');
            $type = $request->input('type');

            $now = Carbon::now()->setTimezone("Asia/Bangkok");

            $userId = Session::get('userId');

            if ($type == "add") {
                $data = array(
                    "ct_nation" => $conNation,
                    "ct_contact_type" => $contactType,
                    "ct_contact_code" => $conCode,
                    "ct_bus_tax_id" => $taxId,
                    "ct_bus_type" => $busType,
                    "ct_bus_branch" => $busBranch,
                    "ct_bus_cate_type" => $busCateType,
                    "ct_business_type" => $businessType,
                    "ct_bus_name" => $busName,
                    "ct_individual_type" => $individualType,
                    "ct_title_name" => $titleName,
                    "ct_first_name" => $firstName,
                    "ct_last_name" => $lastName,
                    "ct_addr_contact_name" => $conName,
                    "ct_addr_address" => $conAddress,
                    "ct_addr_sub_district" => $conSubDistrict,
                    "ct_addr_district" => $conDistrict,
                    "ct_addr_province" => $conProvince,
                    "ct_addr_postcode" => $conPostalCode,
                    "ct_contact_email" => $conEmail,
                    "ct_contact_phone" => $conPhone,
                    "ct_contact_website" => $conWeb,
                    "ct_contact_fax" => $conFax,
                    "ct_bank_name" => $conBank,
                    "ct_bank_account_name" => $conBankAccName,
                    "ct_bank_account_number" => $conBankAccNumber,
                    "ct_bank_branch" => $conBankBranch,
                    "ct_created_date" => $now,
                    "ct_created_by" => $userId
                );

                $result = DB::table("contacts")->insertGetId($data);
            } else if ($type == "edit") {
                $data = array(
                    "ct_bus_type" => $busType,
                    "ct_bus_branch" => $busBranch,
                    "ct_bus_cate_type" => $busCateType,
                    "ct_business_type" => $businessType,
                    "ct_bus_name" => $busName,
                    "ct_individual_type" => $individualType,
                    "ct_title_name" => $titleName,
                    "ct_first_name" => $firstName,
                    "ct_last_name" => $lastName,
                    "ct_addr_contact_name" => $conName,
                    "ct_addr_address" => $conAddress,
                    "ct_addr_sub_district" => $conSubDistrict,
                    "ct_addr_district" => $conDistrict,
                    "ct_addr_province" => $conProvince,
                    "ct_addr_postcode" => $conPostalCode,
                    "ct_contact_email" => $conEmail,
                    "ct_contact_phone" => $conPhone,
                    "ct_contact_website" => $conWeb,
                    "ct_contact_fax" => $conFax,
                    "ct_bank_name" => $conBank,
                    "ct_bank_account_name" => $conBankAccName,
                    "ct_bank_account_number" => $conBankAccNumber,
                    "ct_bank_branch" => $conBankBranch,
                    "ct_updated_date" => $now,
                    "ct_updated_by" => $userId
                );

                $result = DB::table("contacts")->where('id', $conId)->update($data);
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
