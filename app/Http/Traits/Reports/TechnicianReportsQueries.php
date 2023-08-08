<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\DB;

Trait  TechnicianReportsQueries
{

    public function admin_plans_on_shelf_report($request)
    {
        $user_id = $request->user_id;

        if (empty($user_id)) {

            return DB::select("SELECT  LEFT(p.name , 48) AS projectName, r.name as tech, t.RECEIVED as daterec FROM transactions AS t INNER JOIN projects AS p ON p.id= t.project_id  LEFT JOIN project_details as pd ON p.id = pd.project_id LEFT JOIN reviewers as r ON pd.reviewer_id = r.id WHERE  t.is_admin = 1 AND (t.REVIEWED = '' OR t.REVIEWED IS NULL) AND ((t.ADMIN_REV_DATE = '' OR t.ADMIN_REV_DATE IS NULL) AND (t.RETURN_REASON = '' OR t.RETURN_REASON IS NULL))  AND p.is_closed = 0 AND t.conservationdistrict='" . session('district') . "' ORDER BY p.user_id ASC");

        } else {

            return DB::select("SELECT  LEFT(p.name , 48) AS projectName, r.name as tech, t.RECEIVED as daterec FROM transactions AS t INNER JOIN projects AS p ON p.id= t.project_id  LEFT JOIN project_details as pd ON p.id = pd.project_id LEFT JOIN reviewers as r ON pd.reviewer_id = r.id  WHERE  t.is_admin = 1 AND (t.REVIEWED = '' OR t.REVIEWED IS NULL) AND ((t.ADMIN_REV_DATE = '' OR t.ADMIN_REV_DATE IS NULL) AND (t.RETURN_REASON = '' OR t.RETURN_REASON IS NULL))  AND r.id = " . $user_id . "  AND p.is_closed = 0 AND t.conservationdistrict='" . session('district') . "' ORDER BY p.user_id ASC");
        }

    }

    public
    function tech_plans_on_shelf_report($request)
    {
        $user_id = $request->user_id;


        if (empty($user_id)) {

            return DB::select("SELECT LEFT(p.name, 48) AS projectName, r.name as tech,t.RECEIVED as daterec FROM transactions AS t LEFT JOIN projects AS p ON p.id  = t.project_id LEFT JOIN project_details as pd ON p.id = pd.project_id LEFT JOIN reviewers as r ON pd.reviewer_id = r.id WHERE t.is_admin != 1 AND t.RECEIVED !='' AND (t.REVIEWED = '' OR t.REVIEWED IS NULL) AND (t.RETURN_REASON = '' OR t.RETURN_REASON IS NULL) AND  t.conservationdistrict = '" . session('district') . "' AND p.is_closed = 0 AND p.user_id != ''  AND t.RECEIVED > DATE_SUB(NOW(), INTERVAL 120 DAY)  ORDER BY p.user_id");

        }

        return DB::select("SELECT LEFT(p.name, 48) AS projectName, r.name as tech,t.RECEIVED as daterec FROM transactions AS t LEFT JOIN projects AS p ON p.id  = t.project_id LEFT JOIN project_details as pd ON p.id = pd.project_id LEFT JOIN reviewers as r ON pd.reviewer_id = r.id WHERE t.is_admin !=1 AND t.RECEIVED !='' AND (t.REVIEWED = '' OR t.REVIEWED IS NULL) AND (t.RETURN_REASON = '' OR t.RETURN_REASON IS NULL) AND  t.conservationdistrict = '" . session('district') . "' AND p.is_closed = 0 AND p.user_id != ''  AND t.RECEIVED > DATE_SUB(NOW(), INTERVAL 120 DAY) AND p.user_id = '" . $user_id . "'  ORDER BY p.user_id ASC");

    }

    public function monthly_review_report($request)
    {
        $from = $request->from;
        $to = $request->to;

        $projects = DB::select("SELECT LEFT(p.name, 32) AS name, t.RECEIVED AS review_received, t.REV_NUMBER AS reviewcount, t.ADMIN_STATUS AS complete, t.ADMIN_REV_DATE AS comp_date, t.NR AS nr, t.REVIEWED AS reviewed, t.TECH_STATUS AS status, CASE WHEN t.TECH_INIT = '' THEN t.ADMIN_INIT ELSE t.TECH_INIT END AS tech FROM transactions AS t LEFT JOIN projects as p ON t.project_id= p.id WHERE p.is_closed = 0 AND t.REVIEWED BETWEEN CAST('" . $from . "' AS DATE) AND CAST('" . $to . "' AS DATE) AND p.county_id= '" . session('county_id') . "'  ORDER BY t.REVIEWED ASC");


        $reportData = [];

        foreach ($projects as $project) {

            $reportData[$project->tech][] = $project;
        }

        return $reportData;
    }

}
