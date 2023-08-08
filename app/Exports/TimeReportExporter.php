<?php

namespace App\Exports;

use App\Http\Helper\Helper;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TimeReportExporter implements FromView, ShouldAutoSize
{
    private $projectId;

    public function __construct($projectId)
    {
        $this->projectId = $projectId;
    }

    public function view(): View
    {
        $rows = Helper::loadTimeTrackingDetailsForReport($this->projectId);

        return view('time-report-xls', compact('rows'));
    }
}
