<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PesertaExport implements FromView, ShouldAutoSize
{
    protected $peserta;

    public function __construct($props)
    {
        $this->peserta = $props['peserta'];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('excel.peserta', [
            'peserta' => $this->peserta
        ]);
    }
}
