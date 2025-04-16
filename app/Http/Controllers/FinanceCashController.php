<?php

namespace App\Http\Controllers;

use App\Imports\ContactImport;
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

class FinanceCashController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    private $funcId = 0303;

    public function index()
    {
        Log::info('[' . __METHOD__ . ']');   
        
        $accCount = 0;
        
        $cashs = DB::select("select cash_code as code, concat(cash_name,' - ', cash_name) as headname, cash_name as subname, 'ank_logo/cash.png' as bankIcon from finance_cashs");
        $banks = DB::select("select fb.bank_code as code, concat(bat.type_name, ' - ', fb.bank_acc_number) as headname, fb.bank_acc_name as subname, b.bank_logo as bankIcon from finance_banks fb inner join banks b on fb.bank_id = b.id 
                                        inner join bank_acc_type bat on fb.bank_acc_type_id = bat.id");
        $ewallet = DB::select("select fe.ew_code as code, concat(ep.provider_name, ' - ', fe.ew_acc_number) as headname, fe.ew_acc_name as subname, ep.provider_icon as bankIcon from finance_ewallets fe 
                                        inner join ewallet_provider ep on fe.ew_provider_id = ep.id");

        $accCount += count($cashs);
        $accCount += count($banks);
        $accCount += count($ewallet);


        $data = array();

        $dataCash = array("head" => "เงินสด " . count($cashs) . " บัญชี", "sub" => $cashs);
        $dataBank = array("head" => "เงินฝากธนาคาร " . count($cashs) . " บัญชี", "sub" => $cashs);
        $dataEwallet = array("head" => "กระเป๋าเงินอิเล็กทรอนิกส์ " . count($cashs) . " บัญชี", "sub" => $ewallet);

        array_push($data, $dataCash);
        array_push($data, $dataBank);
        array_push($data, $dataEwallet);

        return view('financeCash', ["data" => $data]);
    }

    public function list() {
        Log::info('[' . __METHOD__ . ']');   
        
        $accCount = 0;
        
        $cashs = DB::select("select cash_code as code, concat(cash_name,' - ', cash_name) as headname, cash_name as subname, 'bank_logo/cash.png' as bankIcon from finance_cashs");
        $banks = DB::select("select fb.bank_code as code, concat(bat.type_name, ' - ', fb.bank_acc_number) as headname, fb.bank_acc_name as subname, b.bank_logo as bankIcon from finance_banks fb inner join banks b on fb.bank_id = b.id 
                                        inner join bank_acc_type bat on fb.bank_acc_type_id = bat.id");
        $ewallet = DB::select("select fe.ew_code as code, concat(ep.provider_name, ' - ', fe.ew_acc_number) as headname, fe.ew_acc_name as subname, ep.provider_icon as bankIcon from finance_ewallets fe 
                                        inner join ewallet_provider ep on fe.ew_provider_id = ep.id");

        $accCount += count($cashs);
        $accCount += count($banks);
        $accCount += count($ewallet);


        $data = array();

        $dataCash = array("head" => "เงินสด " . count($cashs) . " บัญชี", "sub" => $cashs);
        $dataBank = array("head" => "เงินฝากธนาคาร " . count($banks) . " บัญชี", "sub" => $banks);
        $dataEwallet = array("head" => "กระเป๋าเงินอิเล็กทรอนิกส์ " . count($ewallet) . " บัญชี", "sub" => $ewallet);

        
        array_push($data, $dataCash);
        array_push($data, $dataBank);
        array_push($data, $dataEwallet);
        return response()->json(['message' => "Success", 'data' => $data], 200);
    }

    public function pageAdd()
    {
        Log::info('[' . __METHOD__ . ']');

        $banks = DB::select("select * from banks");
        $banksType = DB::select("select * from bank_acc_type");

        $account = DB::select("SELECT * from account where acc_code in ( '111501','112201','113201','113202','113203','113301') ");
        $ew_provider = DB::select("SELECT * FROM ewallet_provider");

        return view('financeCashAdd',['banks' => $banks, 'bankTypes' => $banksType, 'accounts' => $account, 'provider' => $ew_provider]);
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

    public function cashSave(Request $request)
    {
        Log::info('[' . __METHOD__ . '] start ');
        try {
            DB::beginTransaction();
            $cashId = $request->input('cashId');
            $cashName = $request->input('cashName');
            $cashDesc = $request->input('cashDesc');
            $cashAccPayTo = $this->changeTrueFalse($request->input('cashAccPayTo'));
            $cashAccPayFrom = $this->changeTrueFalse($request->input('cashAccPayFrom'));
            $type = $request->input('type');
            
            $now = Carbon::now()->setTimezone("Asia/Bangkok");

            if($type == 'add') {
                $data = array(
                    "cash_code" => $this->generateCode("C"),
                    "cash_name" => $cashName,
                    "cash_description" => $cashDesc,
                    "cash_accept_pay_to" => $cashAccPayTo,
                    "cash_accept_pay_from" => $cashAccPayFrom,
                    "created_date" => $now,
                    "created_by" => Session::get('userId')
                );
                $resullt = DB::table('finance_cashs')->insertGetId($data);
            } else {
                $data = array(
                    "cash_name" => $cashName,
                    "cash_description" => $cashDesc,
                    "cash_accept_pay_to" => $cashAccPayTo,
                    "cash_accept_pay_from" => $cashAccPayFrom,
                    "updated_date" => $now,
                    "updated_by" => Session::get('userId')
                );

                $resullt = DB::table('finance_cashs')
                ->where('id',"=", $cashId)
                ->update($data);
            }

            $act = new ActivityLogController();
            $act->insert($this->funcId,  $type . " cash " . $cashName, $type, Session::get('userId'));

            Log::info('[' . __METHOD__ . '] finish ');
            DB::commit();
            return response()->json(['message' => "Success"], 200);
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }

    public function bankSave(Request $request)
    {
        Log::info('[' . __METHOD__ . '] start ');
        try {
            DB::beginTransaction();
            $id = $request->input('id');
            $bankId = $request->input('bankId');
            $bankType = $request->input('bankType');
            $bankAccName = $request->input('bankAccName');
            $bankAccNumber = $request->input('bankAccNumber');
            $bankAccBranchName = $request->input('bankAccBranchName');
            $bankAccBranchNumber = $request->input('bankAccBranchNumber');
            $bankDesc = $request->input('bankDesc');
            $bankAccPayTo = $this->changeTrueFalse($request->input('bankAccPayTo'));
            $bankAccPayFrom = $this->changeTrueFalse($request->input('bankAccPayFrom'));
            $type = $request->input('type');
            
            $now = Carbon::now()->setTimezone("Asia/Bangkok");

            if($type == 'add') {
                $data = array(
                    "bank_code" => $this->generateCode("B"),
                    "bank_id" => $bankId,
                    "bank_acc_type_id" => $bankType,
                    "bank_acc_name" => $bankAccName,
                    "bank_acc_number" => $bankAccNumber,
                    "bank_branch_name" => $bankAccBranchName,
                    "bank_branch_code" => $bankAccBranchNumber,
                    "bank_description" => $bankDesc,
                    "bank_accept_pay_to" => $bankAccPayTo,
                    "bank_accept_pay_from" => $bankAccPayFrom,
                    "created_date" => $now,
                    "created_by" => Session::get('userId')
                );

                $resullt = DB::table('finance_banks')->insertGetId($data);
            } else {
                $data = array(
                    "bank_acc_name" => $bankAccName,
                    "bank_acc_number" => $bankAccNumber,
                    "bank_branch_name" => $bankAccBranchName,
                    "bank_branch_code" => $bankAccBranchNumber,
                    "bank_description" => $bankDesc,
                    "bank_accept_pay_to" => $bankAccPayTo,
                    "bank_accept_pay_from" => $bankAccPayFrom,
                    "updated_date" => $now,
                    "updated_by" => Session::get('userId')
                );

                $resullt = DB::table('finance_banks')
                ->where('id',"=", $id)
                ->update($data);
            }

            $act = new ActivityLogController();
            $act->insert($this->funcId,  $type . " bank " . $bankAccName, $type, Session::get('userId'));


            Log::info('[' . __METHOD__ . '] finish ');
            DB::commit();
            return response()->json(['message' => "Success"], 200);
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }

    public function eWalletSave(Request $request)
    {
        Log::info('[' . __METHOD__ . '] start ');
        try {
            DB::beginTransaction();
            $ewId = $request->input('ewId');
            $gatewayType = $request->input('gatewayType');
            $providerId = $request->input('providerId');
            $ewAccName = $request->input('ewAccName');
            $ewAccNumber = $request->input('ewAccNumber');
            $ewAcc = $request->input('ewAcc');
            $ewDesc = $request->input('ewDesc');
            $ewAccPayTo = $this->changeTrueFalse($request->input('ewAccPayTo'));
            $ewAccPayFrom = $this->changeTrueFalse($request->input('ewAccPayFrom'));
            $type = $request->input('type');
            
            $now = Carbon::now()->setTimezone("Asia/Bangkok");

            if($type == 'add') {
                $data = array(
                    "ew_code" => $this->generateCode("E"),
                    "ew_gateway_type" => $gatewayType,
                    "ew_provider_id" =>  $providerId,
                    "ew_acc_name" => $ewAccName,
                    "ew_acc_number" => $ewAccNumber,
                    "ew_account" => $ewAcc,
                    "ew_description" => $ewDesc,
                    "ew_accept_pay_to" => $ewAccPayTo,
                    "ew_accept_pay_from" => $ewAccPayFrom,
                    "created_date" => $now,
                    "created_by" => Session::get('userId')
                );

                $resullt = DB::table('finance_ewallets')->insertGetId($data);
            } else {
                $data = array(
                    "ew_acc_name" => $ewAccName,
                    "ew_acc_number" => $ewAccNumber,
                    "ew_account" => $ewAcc,
                    "ew_description" => $ewDesc,
                    "ew_accept_pay_to" => $ewAccPayTo,
                    "ew_accept_pay_from" => $ewAccPayFrom,
                    "updated_date" => $now,
                    "updated_by" => Session::get('userId')
                );

                $resullt = DB::table('finance_ewallets')
                ->where('id',"=", $ewId)
                ->update($data);
            }

            $act = new ActivityLogController();
            $act->insert($this->funcId,  $type . " e-Wallet " . $ewAccName, $type, Session::get('userId'));

            Log::info('[' . __METHOD__ . '] finish ');
            DB::commit();
            return response()->json(['message' => "Success"], 200);
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }

    public function expenseClaimSave(Request $request)
    {
        Log::info('[' . __METHOD__ . '] start ');
        try {
            DB::beginTransaction();
            $exId = $request->input('exId');
            $exName = $request->input('exName');
            $exDesc = $request->input('exDesc');
            $exAccPayTo = $this->changeTrueFalse($request->input('exAccPayTo'));
            $exAccPayFrom = $this->changeTrueFalse($request->input('exAccPayFrom'));
            $type = $request->input('type');
            
            $now = Carbon::now()->setTimezone("Asia/Bangkok");

            if($type == 'add') {
                $data = array(
                    "ec_code" => $this->generateCode("X"),
                    "ec_emp_name" => $exName,
                    "ec_description" => $exDesc,
                    "ec_accept_pay_to" => $exAccPayTo,
                    "ec_accept_pay_from" => $exAccPayFrom,
                    "created_date" => $now,
                    "created_by" => Session::get('userId')
                );

                $resullt = DB::table('finance_expense_claims')->insertGetId($data);
            } else {
                $data = array(
                    "ec_emp_name" => $exName,
                    "ec_description" => $exDesc,
                    "ec_accept_pay_to" => $exAccPayTo,
                    "ec_accept_pay_from" => $exAccPayFrom,
                    "updated_date" => $now,
                    "updated_by" => Session::get('userId')
                );

                $resullt = DB::table('finance_expense_claims')
                ->where('id',"=", $exId)
                ->update($data);
            }

            $act = new ActivityLogController();
            $act->insert($this->funcId,  $type . " Expense Claims " . $exName, $type, Session::get('userId'));


            Log::info('[' . __METHOD__ . '] finish ');
            DB::commit();
            return response()->json(['message' => "Success"], 200);
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }

    function generateCode($cateType){

        $code = "";

        if($cateType == "C") {
            $sql = "SELECT MAX(substr( fc.cash_code , 4, 6)) as maxCode FROM finance_cashs fc";
            $code = "CSH";
        } else if($cateType == "B") {
            $sql = "SELECT MAX(substr( fb.bank_code , 4, 6)) as maxCode FROM finance_banks fb";
            $code = "BSV";
        } else if($cateType == "E") {
            $sql = "SELECT MAX(substr( fe.ew_code , 4, 6)) as maxCode FROM finance_ewallets fe";
            $code = "EWL";
        } else if($cateType == "X") {
            $sql = "SELECT MAX(substr( fec.ec_code , 4, 6)) as maxCode FROM finance_expense_claims fec";
            $code = "ADV";
        }

        $result = DB::select($sql);
        $maxCode = $result[0]->maxCode;

        if ($maxCode == null) {
            $maxCode = $code . "001";
        } else {
            $maxCode = $maxCode + 1;
            $maxCode = $code . str_pad($maxCode, 3, "0", STR_PAD_LEFT);
        }


        return $maxCode;
    }

    function changeTrueFalse($data) {
        $sum = 0;
        if($data == "true") {
            $sum = 1;
        } 

        return $sum;
    }
}
