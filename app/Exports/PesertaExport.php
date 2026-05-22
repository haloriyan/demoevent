<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Override;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PesertaExport implements FromView, ShouldAutoSize, WithMapping
{
    protected $peserta;
    protected $filters;

    public function __construct($props)
    {
        $this->peserta = $props['peserta'];
        $this->filters = $props['filters'] ?? [];
    }

    public function map($row): array
    {
        return [
            (string) $row->nik,
            (string) $row->whatsapp,
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('excel.peserta', [
            'peserta' => $this->peserta,
            'filters' => $this->filters,
        ]);
    }
}
