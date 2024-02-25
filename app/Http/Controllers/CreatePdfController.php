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

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf::setHeaderCallback(function ($pdf) {
            $img = base_path() . '/public/images/header.png';
            $pdf->Image($img, 5, 0, 0, 20, 'PNG');

            if ($pdf->getPage() == 1) {
            
            } else {
                $pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
            }

            $pdf->SetFont('helvetica', 'I', 10);
            $pdf->Cell(35, 0, '', 0, false, 'C', 0, '', 0, false, 'T', 'M');
        });
        $pdf::setFooterCallback(function ($pdf) {
            $footertext = "Version 0.1" . date('Y-m-d H:i:s');
            $pdf->SetY(-15);
            $pdf->SetFont('helvetica', 'I', 10);
            $pdf->Cell(0, 10, 'Page ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        });


        $pdf::SetFont('THSarabunNew');
        $pdf::SetTitle('Baanphak');
        $pdf::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf::AddPage('P', 'A4');
        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::lastPage();


        $html = view()->make('table2', $data)->render();
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