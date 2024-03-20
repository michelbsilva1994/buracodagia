<?php

namespace App\Http\Controllers\PdfReports;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfReportsController extends Controller
{
    public function receipt($id_receipt){
        //dd($id_receipt);
        $data = ['title' => 'Recebido'];
        $pdfReceipt = Pdf::loadView('pdf_reports.receipt', $data);
        return $pdfReceipt->stream('receibo.pdf');
    }
}
