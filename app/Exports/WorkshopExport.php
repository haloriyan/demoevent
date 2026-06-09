<?php

namespace App\Exports;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class WorkshopExport implements FromView, ShouldAutoSize
{
    public $workshops;

    public function __construct($props)
    {
        $this->workshops = $props['workshops'];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('excel.workshop', [
            'workshops' => $this->workshops,
        ]);
    }
}
