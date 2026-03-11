<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RamayanaPurchase implements FromView, ShouldAutoSize
{
    protected $transactions;

    public function __construct($props)
    {
        $this->transactions = $props['transactions'];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('excel.ramayana', [
            'transactions' => $this->transactions,
        ]);
    }
}
