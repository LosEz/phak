<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\ActivityLogController;
use Illuminate\Support\Facades\Session;
use Exception;

class OrderBuyController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    private $funcId = 0102;

    public function index()
    {
        Log::info('[' . __METHOD__ . ']');
        return view('orderBuy');
    }

    public function searchData(Request $request)
    {

        try {
            $orderIdSearch = $request->input('orderIdSearch');
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');

            $orderBuy = $this->getOrderBuy($orderIdSearch, $fromDate, $toDate);

            Log::info('[' . __METHOD__ . '] finish ');
            return response()->json(['message' => "Success", 'orderBuy' => $orderBuy], 200);
        } catch (Exception $ex) {

            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }

    private function  getOrderBuy($orderIdSearch, $fromDate, $toDate)
    {
        try {

            $sql = "SELECT
                        ob.order_buy_id as orderId,
                        DATE_FORMAT(ob.order_buy_date, '%d/%m/%Y' ) as createDate,
                        DATE_FORMAT(ob.order_delivery_date, '%d/%m/%Y' ) as deliveryDate

                    FROM
                        order_buy ob";

            if ($orderIdSearch != null || $orderIdSearch != "") {
                $sql .= " AND ob.order_buy_id = '$orderIdSearch'";
            }

            if ($fromDate != null || $fromDate != "") {
                $sql .= " AND ob.order_buy_date >= '$fromDate'";
            }

            if ($toDate != null || $toDate != "") {
                $sql .= " AND ob.order_buy_date <= '$toDate'";
            }

            $sql = preg_replace("/AND/", "WHERE", $sql, 1);

            $result = DB::select($sql);
            return $result;
        } catch (Exception $ex) {
            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            throw new Exception($ex->getMessage());
        }
    }

    public function createOrderBuy()
    {
        try {
            Log::info('[' . __METHOD__ . '] finish ');
            $supp = DB::select("SELECT supp_id as supId, supp_name as supName from suppliers");
            $prod = DB::select("SELECT product_code as prodId, product_name as prodName from products");
            return view('orderBuyAdd', ['supppliers' => $supp, 'products' => $prod]);
        } catch (Exception $ex) {
            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }

    public function editOrderBuy($orderId)
    {
        try {
            Log::info('[' . __METHOD__ . '] finish ');
            $orderId = $this->getOrderBuy($orderId, "", "", "");
            if (count($orderId) == 1) {
                $products = $this->getOrderBuyWithProducts($orderId);
                return view('orderBuyEdit', ['orderId' => $orderId[0], 'products' => $products]);
            } else {
                throw new Exception("cannot search order buy id : " . $orderId);
            }
        } catch (Exception $ex) {
            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }

    public function getOrderBuyWithProducts($orderId)
    {

        $sql = "SELECT * FROM order_buy_mapp_products where order_buy_id = $orderId";
        $products = DB::select($sql);
        return $products;
    }


    public function addData(Request $request)
    {

        try {
            DB::beginTransaction();
            $userId = Session::get('userId');
            $orderList = $request->input('orderList');
            $type = $request->input("type");

            $orderId = $this->generateBuyOrderID();
            $now = Carbon::now()->setTimezone("Asia/Bangkok");

            $data = array(
                "order_buy_id" => $orderId,
                "order_buy_date" => $now
            );

            DB::table("order_buy")->insert($data);

            for ($i = 0; $i < count($orderList); $i++) {

                $sub = array(
                    "order_buy_id" => $orderId,
                    "supp_id" => $orderList[$i]['supp'],
                    "product_code" => $orderList[$i]['prod'],
                    "product_price" => $orderList[$i]['price'],
                    "product_amount" => $orderList[$i]['amount'],
                    "create_date" => $now,
                    "create_by" => $userId,
                    "product_amount_update" => $orderList[$i]['amount']
                );

                DB::table("order_buy_mapp_products")->insert($sub);
            }

            $act = new ActivityLogController();
            $act->insert( $this->funcId, $type . " orderId " . $orderId, $now, $userId );

            Log::info('[' . __METHOD__ . '] finish ');
            DB::commit();
            return response()->json(['message' => "Success"], 200);
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }

    public function editData(Request $request)
    {

        try {
            DB::beginTransaction();
            $userId = Session::get('userId');
            $orderList = $request->input('orderList');
            $type = $request->input("type");
            $orderId = $request->input('orderId');
            $now = Carbon::now()->setTimezone("Asia/Bangkok");

            for ($i = 0; $i < count($orderList); $i++) {

                $sub = array(
                    "product_price" => $orderList[$i]['price'],
                    "product_amount" => $orderList[$i]['amount'],
                    "update_date" => $now,
                    "update_by" => $userId 
                );

                $result = DB::table("order_buy_mapp_products")
                            ->where('order_buy_id', $orderId)
                            ->where('supp_id', $orderList[$i]['supp'])
                            ->where('product_code', $orderList[$i]['prod'])
                            ->update($sub);
            }

            $act = new ActivityLogController();
            $act->insert( $this->funcId, $type . " orderId " . $orderId, $now, $userId );

            Log::info('[' . __METHOD__ . '] finish ');
            DB::commit();
            return response()->json(['message' => "Success"], 200);
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }

    public function generateBuyOrderID()
    {
        //BYYYYMMDDXXX
        $format = "";
        $now = Carbon::now()->setTimezone("Asia/Bangkok")->format("Ymd");

        $data = DB::select("SELECT * FROM order_buy where order_buy_id like 'B$now%' order by order_buy_id desc limit 1");

        if (empty($data)) {
            $format = "B" . $now . "001";
        } else {
            $running = substr($data[0]->order_buy_id, 9, 12);
            $format = "B" . $now . str_pad(($running + 1),3,"0",STR_PAD_LEFT);
        }

        return $format;
    }
}
