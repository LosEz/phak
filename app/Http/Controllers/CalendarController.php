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

class calendarController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(){
        Log::info('['.__METHOD__.']');
        return view('supplier');
    }

   

    public function createSupplier()
    {
        try {
            Log::info('[' . __METHOD__ . '] finish ');
            return view('supplierEdit');

        } catch (Exception $ex) {

            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);

        }

    }
}