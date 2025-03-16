<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use FFI\Exception;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ActivityLogController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(){
        Log::info('['.__METHOD__.']');
        return view('actLog', ['data' => array()]);
    }

    public function searchData(Request $request) {

        try {
             $proCode = $request->input('proCode');
             $proName = $request->input('proName');

            $products = $this->getProducts($proCode, $proName);

            Log::info('[' . __METHOD__ . '] finish ');
            return view('product',['data' => $products]);

        } catch (Exception $ex) {

            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);
            
        }
 
    }

    public function insert($funcId, $actDesc, $actType, $actBy)
    {
        try {
           $data = array(
            "func_id" => $funcId,
            "act_desc" => $actDesc,
            "act_type" => $actType,
            "act_date" => Carbon::now()->setTimezone("Asia/Bangkok")->format("Y-m-d H:i:s"),
            "act_by" => $actBy
            );

            DB::table("activity_log")->insert($data);
 
            Log::info('[' . __METHOD__ . '] finish ');
            return response()->json(['message' => "insert success"], 200);

        } catch (Exception $ex) {

            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);

        }

    }
}