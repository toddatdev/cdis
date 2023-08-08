<?php

namespace App\Http\Traits;


use Illuminate\Support\Facades\DB;

Trait  ManagerReportsQueries
{
    public function padot_hours_report($request)
    {
        $from = $request->from;
        $to = $request->to;

        $projects = DB::select("SELECT p.name AS project, tt.trx_date, tt.reviewer_id, tt.time_category,  tt.hours, pd.total_acres, pd.disturbed_acres AS acres_tbd, pa.address_1 AS app_add1, r.name as first_name FROM reviewers as r INNER JOIN (project_time_tracking AS tt INNER JOIN projects AS p ON tt.project_id = p.id INNER JOIN project_details pd on p.id = pd.project_id INNER JOIN project_applicants pa on p.id = pa.project_id) ON r.id = tt.reviewer_id WHERE (((p.name) Like 'P%DOT%') AND p.county_id = " . session('county_id') . " AND ((tt.trx_date) BETWEEN  CAST('" . $from . "' AS DATE) AND  CAST('" . $to . "' AS DATE))) ");

        $reportData = [];

        foreach ($projects as $project) {

            $reportData[$project->first_name]['projects'][] = $project;
        }

        return $reportData;
    }

    public function completeness_report($request)
    {
        $from = $request->from;
        $to = $request->to;

        return DB::select("SELECT LEFT(p.name, 32) AS project, TIMESTAMPDIFF(DAY, t.RECEIVED, t.ADMIN_REV_DATE) AS age, t.ADMIN_STATUS as status, t.RECEIVED as rec, t.ADMIN_REV_DATE as rev, CASE WHEN t.ADMIN_INIT = '' THEN t.TECH_INIT ELSE t.ADMIN_INIT END AS initial FROM transactions AS t LEFT JOIN projects AS p ON p.id = t.project_id WHERE  t.ADMIN_REV_DATE BETWEEN CAST('" . $from . "' AS DATE) AND CAST('" . $to . "' AS DATE) AND is_closed = 0 AND p.county_id = " . session('county_id') . '  AND t.ADMIN_STATUS IS NOT NULL  ORDER BY initial ASC ');

    }

    public function complete_review_report($request)
    {
        return $this->review_report($request, 'complete');
    }

    public function incomplete_review_report($request)
    {
        return $this->review_report($request, 'incomplete');
    }

    public function withdrawn_report($request)
    {
        return $this->review_report($request, 'withdrawn');
    }


    protected function review_report($request, $type)
    {
        $from = $request->from;
        $to = $request->to;

        return DB::select("SELECT LEFT(p . name, 32) AS project , TIMESTAMPDIFF(DAY, t . RECEIVED, t . ADMIN_REV_DATE) AS age, t . ADMIN_STATUS as status, t . RECEIVED as rec, t . ADMIN_REV_DATE as rev, CASE WHEN t . ADMIN_INIT = '' THEN t . TECH_INIT ELSE t . ADMIN_INIT END AS initial FROM transactions AS t LEFT JOIN projects AS p ON p . id = t . project_id
         WHERE  t . ADMIN_REV_DATE BETWEEN CAST('" . $from . "' AS DATE) AND CAST('" . $to . "' AS DATE)
         AND p.is_closed = 0 AND p . county_id = '" . session('county_id') . "' AND t . ADMIN_STATUS IS NOT NULL AND t . ADMIN_STATUS = '" . $type . "'  ORDER BY initial ASC ");
    }

    public function dep_clean_water_fund_report($request)
    {
        $from = $request->from;
        $to = $request->to;

        return DB::select("SELECT t . tbdfee_chknum, t . tbdfee_payor,  (select name from municipalities where id = pd . municipality_id) AS munic, t . tbdfee_chkdate, LEFT(p . name, 24) AS project, pp . npdes_number AS npdes_numb, t . tobedisturb AS acres_tbd, t . tbd_fee FROM projects AS p LEFT JOIN  transactions AS t ON p . id = t . project_id JOIN project_details pd on p . id = pd . project_id JOIN project_permits pp on p . id = pp . project_id WHERE  t . RECEIVED BETWEEN CAST('" . $from . "' AS DATE) AND CAST('" . $to . "' AS DATE) AND is_closed = 0 AND p . county_id = " . session('county_id') . " AND t . conservationdistrict = '" . session('district') . "' AND t . TBD_FEE != 0.00 AND t . TBD_FEE IS NOT NULL");


    }


}
