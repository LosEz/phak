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
}
