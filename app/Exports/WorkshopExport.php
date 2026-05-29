<?php

namespace App\Exports;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class WorkshopExport implements FromView
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
