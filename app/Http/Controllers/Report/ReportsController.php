<?php

namespace App\Http\Controllers\Report;

use App\Exports\ReportsExporter;
use App\Http\Controllers\Controller;
use App\Http\Helper\Helper;
use App\Http\Traits\ICISNpdesQueries;
use App\Http\Traits\ManagerReportsQueries;
use App\Http\Traits\SecretaryReportsQueries;
use App\Http\Traits\TechnicianReportsQueries;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Excel;
use Mpdf\Mpdf;

class ReportsController extends Controller
{
    private $mpdf;
    private $excel;

    use ManagerReportsQueries,
        SecretaryReportsQueries,
        ICISNpdesQueries,
        TechnicianReportsQueries;

    public function __construct(Mpdf $mpdf, Excel $excel)
    {
        $this->mpdf = new Mpdf(['format' => 'A4-L']);
        $this->excel = $excel;
    }

    public function index()
    {
        $user = Auth::user();
        $users = User::where('county_id', session('county_id'))
            ->get(['id', 'first_name', 'last_name']);

        return view('reports')->with(['user' => $user, 'users' => $users]);
    }


    protected function getHTMLReport($request, $reportData)
    {
        $viewName = $this->getViewName($request);

        $viewData = $this->getViewData($request, $reportData);

        return view($viewName, $viewData);
    }

    public function generate(Request $request)
    {
        // ICIS XML report generation
        if (trim($request->type) === 'generateXMLReport') return $this->generateXMLReport($request);

        //calls the specific function based on its type to get report data
        $reportData = $this->{$request->type}($request);

        //if user wants report in excel format
        if ($request->input('format') === 'xls') {

            $viewName = $this->getViewName($request);
            $viewData = $this->getViewData($request, $reportData);

            $fileName = Helper::slugify($request->type . '-' . date('m-d-y')) . '.xls';

            return $this->excel
                ->download(new ReportsExporter($viewName, $viewData),
                    $fileName);
        }

        //if user wants a report in PDF format
        if ($request->input('format') === 'pdf') {

            $this->mpdf->WriteHTML($this->getHTMLReport($request, $reportData));

            $fileName = Helper::slugify($request->type . '-' . date('m-d-y')) . '.pdf';

            return @$this->mpdf->Output($fileName, 'I');
        }

        //if user wants a report in HTML format
        return $this->getHTMLReport($request, $reportData);
    }

    /**
     * @param $request
     * @return |null
     */
    protected function getEmployee($request)
    {
        $employee = null;

        //if report is based on employee
        if (isset($request->user_id)) {

            $employee = User::where('id', $request->user_id)->first();

        }

        return $employee;
    }

    protected function getViewName($request)
    {
        //convert _ to - in names to get view
        return 'reports.' . Helper::replaceUnderscoreWithDash($request->type);
    }

    /**
     * @param $request
     * @param $reportData
     * @return array |null
     */
    protected function getViewData($request, $reportData)
    {
        $employee = $this->getEmployee($request);

        $viewData = compact('reportData', 'request', 'employee');

        return $viewData;
    }
}
