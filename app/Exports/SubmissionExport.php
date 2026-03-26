<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SubmissionExport implements FromView, ShouldAutoSize
{
    public $submissions;

    public function __construct($props)
    {
        $this->submissions = $props['submissions'];
    }

    public function view(): View
    {
        return view('excel.submission', [
            'submissions' => $this->submissions
        ]);
    }
}
