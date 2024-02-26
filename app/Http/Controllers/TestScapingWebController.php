<?php

namespace App\Http\Controllers;

use DOMDocument;
use DOMXPath;
use Exception;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Log;
use Request;

class TestScapingWebController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(){
        Log::info('['.__METHOD__.']');

        $httpClient = new \GuzzleHttp\Client(['verify' => false]);
        $response = $httpClient->get('https://www.market-organization.or.th/price/pages/lamphun/page.php');
        $htmlString = (string) $response->getBody();
        //add this line to suppress any warnings
        libxml_use_internal_errors(true);
        $doc = new DOMDocument();
        $doc->loadHTML($htmlString);
        $xpath = new DOMXPath($doc);
        Log::info('[' . __METHOD__ . '] xpath ' . $xpath);
        $arrs = array();

        $data = $xpath->evaluate('//div[@id="Tabs"]//div//table[@id="table"]//tbody//tr/td[1]');
        $prices = $xpath->evaluate('//div[@id="Tabs"]//div//table[@id="table"]//tbody//tr/td[3]');
        foreach ($data as $key => $phak) {
            //echo $phak->textContent . " " . $prices[$key]->textContent . '<br/>';

            $arrs[$key]['phak'] = $phak->textContent;
            $arrs[$key]['price'] = explode(" ", $prices[$key]->textContent)[0];
        }

        //var_dump($arr);

        return view('scapping', ['phaks' => $arrs]);
    }


    public function genData(Request $request) {

        try {

            $strReturn = "success";

            Log::info('[' . __METHOD__ . '] finish ');
            return response()->json(['message' => $strReturn], 200);

        } catch (Exception $ex) {

            Log::error('[' . __METHOD__ . '][' . $ex->getFile() . '][line : ' . $ex->getLine() . '][' . $ex->getMessage() . ']');
            return response()->json(['message' => $ex->getMessage()], 500);
            
        }
 
    }
}