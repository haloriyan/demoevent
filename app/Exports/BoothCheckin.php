<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BoothCheckin implements FromView, ShouldAutoSize
{
    protected $role; // ADMIN, BOOTH
    protected $checkins;

    public function __construct($props)
    {
        $this->role = $props['role'];
        $this->checkins = $props['checkins'];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('excel.booth_checkins', [
            'role' => $this->role,
            'checkins' => $this->checkins,
        ]);
    }
}
