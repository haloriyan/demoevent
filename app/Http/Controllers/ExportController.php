<?php

namespace App\Http\Controllers;

use App\Exports\PesertaExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function peserta() {
        $filename = "Sales_Report-Exported_at_" . Carbon::now()->isoFormat('DD-MMM-Y') . ".xlsx";

        return Excel::download(
            new PesertaExport([
                'peserta' => $peserta
            ]),
            $filename
        );
    }
}
