<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bills;
use Barryvdh\DomPDF\Facade\Pdf;

class BillController extends Controller
{
    public function exportPdf($id)
    {
        $bill = Bills::where('order_id', $id)->first();

        $pdf = Pdf::loadView('pdf.bill', compact('bill'));

        return $pdf->stream('hoa-don-order-' . $id . '.pdf');
    }
}
