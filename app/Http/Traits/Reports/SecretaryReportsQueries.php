<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait SecretaryReportsQueries
{
    public function incoming_plans_report($request)
    {
        $from = $request->from;
        $to = $request->to;

        return DB::select("SELECT t.received,  pp.npdes_number AS npdes_numb, TBD_FEE as dep, t.totalacres, t.tobedisturb,  (select name from municipalities where id = pd.municipality_id) as munic, nr, IF(expedite_fee='', 0.00, IF(expedite_fee IS NULL,0.00,expedite_fee)) as expedited, DIST_FEE as review, MCCD_CWF_FEE AS npdes, ( IF(tbd_fee='', 0.00, IF(tbd_fee IS NULL,0.00,tbd_fee)) +
 IF(DIST_FEE ='', 0.00, IF(DIST_FEE  IS NULL,0.00,DIST_FEE))+
   IF(MCCD_CWF_FEE ='', 0.00, IF(MCCD_CWF_FEE  IS NULL,0.00,MCCD_CWF_FEE))+
 IF(expedite_fee='', 0.00, IF(expedite_fee IS NULL,0.00,expedite_fee))) AS total, p.*, LEFT(p.name, 32) AS PROJECT FROM projects AS p left join project_details pd on p.id = pd.project_id   left JOIN project_permits pp on p.id = pp.project_id  LEFT  JOIN transactions as t ON p.id = t.project_id WHERE (t.received BETWEEN CAST('" . $from . "' AS DATE) AND CAST('" . $to . "' AS DATE)) AND p.county_id = '" . session('county_id') . "' AND t.conservationdistrict = '" . session('district') . "' AND is_closed = 0 AND nr != ''  ORDER BY t.received ASC");

    }

    public function npdes_actions_report($request)
    {
        $from = $request->from;
        $to = $request->to;

        return DB::select("SELECT p.name , pd.ownership, (select name from municipalities where id = pd.municipality_id) as munic,  pd.receiving_stream AS stream,  pp.npdes_number AS npdes_numb, pd.ch_93_class AS stream_class, pd.disturbed_acres AS acres_tbd, pp.permit_issued_date AS np_date_i, pd.total_acres, pp.received_date AS  np_date_r, pe.name AS engineer, pa.name as applic, pa.company_name AS app_company, pa.address_1 as app_add1, pa.address_2 as app_add2, pa.city AS app_city, pa.state as app_state, pa.zipcode as app_zip, pl.address_1 as loc, '" . $from . "' AS Expr1, '" . $to . "' AS Expr2 FROM projects AS p JOIN project_details pd on p.id = pd.project_id JOIN project_permits pp on p.id = pp.project_id JOIN project_locations pl on p.id = pl.project_id  JOIN project_engineers pe on p.id = pe.project_id JOIN project_applicants pa on p.id = pa.project_id WHERE (pp.npdes_number LIKE '%PAG%' OR pp.npdes_number LIKE '%PAD%' OR pp.npdes_number LIKE '%PAC%') AND is_closed = 0 AND pp.permit_issued_date BETWEEN CAST('" . $from . "' AS DATE) AND CAST('" . $to . "' AS DATE) AND p.county_id = " . session('county_id') . '  ORDER BY np_date_i ASC');

    }

    public function npdes_applications_report($request)
    {
        $from = $request->from;
        $to = $request->to;

        return DB::select("SELECT p.name , pd.ownership,   (select name from municipalities where id = pd.municipality_id) as munic,  pd.receiving_stream AS stream,  pp.npdes_number AS npdes_numb, pd.ch_93_class AS stream_class, pd.disturbed_acres AS acres_tbd, pp.permit_complete_date AS np_date_a, pd.total_acres, pp.received_date AS  np_date_r, pe.name AS engineer, pa.name as applic, pa.company_name AS app_company, pa.address_1 as app_add1, pa.address_2 as app_add2, pa.city AS app_city, pa.state as app_state, pa.zipcode as app_zip, pl.address_1 as loc, '" . $from . "' AS Expr1, '" . $to . "' AS Expr2 FROM projects AS p JOIN project_details pd on p.id = pd.project_id JOIN project_permits pp on p.id = pp.project_id JOIN project_locations pl on p.id = pl.project_id  JOIN project_engineers pe on p.id = pe.project_id JOIN project_applicants pa on p.id = pa.project_id  WHERE (pp.npdes_number LIKE '%PAI%' OR pp.npdes_number LIKE '%PAD%' OR pp.npdes_number LIKE '%PAC%') AND  is_closed = 0 AND pp.permit_complete_date BETWEEN CAST('" . $from . "' AS DATE) AND CAST('" . $to . "' AS DATE) AND p.county_id = " . session('county_id') . '  ORDER BY np_date_a ASC');

    }

    public function dep_fees_collected_report($request)
    {
        $from = $request->from;
        $to = $request->to;

        return DB::select("SELECT t.RECEIVED as rec, LEFT(p.name , 24) as proj, t.MCCD_CWF_CHKDATE as check_date, t.MCCD_CWF_CHKNUM as check_num, t.MCCD_CWF_PAYOR AS payor, MCCD_CWF_FEE as fee FROM transactions AS t LEFT JOIN projects AS p ON p.id= t.project_id WHERE t.RECEIVED BETWEEN CAST('" . $from . "' AS DATE) AND CAST('" . $to . "' AS DATE) AND is_closed = 0 AND MCCD_CWF_FEE != 0.00 AND p.county_id = '" . session('county_id') . "' ORDER BY t.received  ASC");


    }

    public function district_fee_collected_report($request)
    {
        $from = $request->from;
        $to = $request->to;

        return DB::select("SELECT t.RECEIVED as rec, LEFT(p.name, 24) as proj, t.DIST_FEE_CHKDATE as check_date, t.TBDFEE_CHKNUM as check_num, t.DISTFEE_PAYOR AS payor, t.DIST_FEE as fee FROM transactions AS t LEFT JOIN projects AS p ON p.id = t.project_id WHERE t.RECEIVED BETWEEN CAST('" . $from . "' AS DATE) AND CAST('" . $to . "' AS DATE) AND is_closed = 0 AND t.DIST_FEE != 0.00 AND p.county_id=" . session('county_id') . ' ORDER BY t.received ASC');


    }

}
