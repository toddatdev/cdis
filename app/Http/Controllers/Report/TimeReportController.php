<?php

namespace App\Http\Controllers\Report;

use App\Exports\TimeReportExporter;
use App\Http\Controllers\Controller;
use App\Http\Helper\Helper;
use Maatwebsite\Excel\Excel;
use Mpdf\Mpdf;

class TimeReportController extends Controller
{
    private $excel;
    private $mpdf;

    public function __construct(Excel $excel, Mpdf $mpdf)
    {
        $this->excel = $excel;
        $this->mpdf = $mpdf;
    }

    public function downloadXLSReport($projectId)
    {
        $fileName = 'Plan Entry ' . $projectId . ' - View All Recorded Time as of ' . date('Y-m-d') . '.xlsx';

        return $this->excel->download(new TimeReportExporter($projectId), $fileName);
    }


    public function downloadPDFReport($projectId)
    {

        $fileName = 'Plan Entry Number ' . $projectId . ' - View All Recorded Time As Of ' . date('Y-m-d') . '.pdf';

        //gets all the report data
        $rows = Helper::loadTimeTrackingDetailsForReport($projectId);

        $this->mpdf->WriteHTML(view('time-report-pdf', compact('rows')));

        return $this->mpdf->Output($fileName, 'I');
    }
}
