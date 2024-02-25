<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Session;

use Log;
use Illuminate\Http\Request;
use Elibyy\TCPDF\Facades\TCPDF;
use DB;

class CreatePdfController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(Request $request)
    {
        $filename = 'demo.pdf';

        $data = [
            'title' => 'Generate PDF using Laravel TCPDF - ItSolutionStuff.com!'
        ];

        $html = view()->make('table', $data)->render();

        $pdf = new \MY_TCPDF;

        // Custom Header
        $pdf::setHeaderCallback(function ($pdf) {

            // Set font
            
            $img = base_path() . '/public/images/header.png';
            $pdf->Image($img, 5, 0, 0, 20, 'PNG');
            $pdf->SetY(10);
            $pdf->SetFont('helvetica', 'B', 20);
            // Title
            //$pdf->Cell(0, 15, 'Something new right here!!!', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        });

        // Custom Footer
        $pdf::setFooterCallback(function ($pdf) {

            // Position at 15 mm from bottom
            $pdf->SetY(-15);
            // Set font
            $pdf->SetFont('helvetica', 'I', 8);
            // Page number
            $pdf->Cell(0, 10, 'Page ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

        });

        $pdf::SetFont('THSarabunNew');
        $pdf::SetTitle('Baanphak');
        $pdf::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf::AddPage('P', 'A4');
        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::lastPage();

        $pdf::Output(public_path($filename), 'F');
        $pdf::Close();
        return response()->download(public_path($filename));
    }


    public function generateTable() {

        


    }
}