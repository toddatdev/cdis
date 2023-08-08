<?php

namespace App\Models\Transaction;

use App\Models\Project\Project;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Transaction extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    public $timestamps = false;

    public static function getFees($project_id)
    {
        return self::where('project_id', $project_id)->where(function ($query) {
//            $query->where('admin_status', '=', null);
//            $query->Where('admin_init', '=', null);
//            $query->Where('tech_status', '=', null);
//            $query->Where('tech_init', '=', null);
//            $query->Where('return_reason', '=', null);
//            $query->Where('date_wd', '=', null);
//            $query->Where('admin_rev_date', '=', null);
        })
            ->whereNotNull([


            ])
            ->get();

        /*      $transactions = [];

              $i = 0;

              foreach ($data as $datum) {


                  if ($datum->dist_fee != '' || $datum->dist_chknum != '' || $datum->distfee_payor != '' || $datum->dist_fee_chkdate != '') {

                      $transactions[$i]['id'] = $datum->id;
                      $transactions[$i]['received_date'] = $datum->received;
                      $transactions[$i]['fee_type'] = $datum->fee_type;
                      $transactions[$i]['is_admin'] = $datum->is_admin;
                      $transactions[$i]['submission_type'] = $datum->nr;
                      $transactions[$i]['review_number'] = $datum->rev_number;
                      $transactions[$i]['total_acres'] = $datum->totalacres;
                      $transactions[$i]['disturbed_acres'] = $datum->tobedisturb;
                      $transactions[$i]['fee_type'] = 'dist_fee';
                      $transactions[$i]['fee_amount'] = $datum->dist_fee;
                      $transactions[$i]['check_number'] = $datum->dist_chknum;
                      $transactions[$i]['payer_name'] = $datum->distfee_payor;
                      $transactions[$i]['check_date'] = $datum->dist_fee_chkdate;
                  }

                  if ($datum->tbd_fee != '' || $datum->tbdfee_chknum != '' || $datum->tbdfee_payor != '' || $datum->tbdfee_chkdate != '') {


                      $transactions[$i]['id'] = $datum->id;
                      $transactions[$i]['received_date'] = $datum->received;
                      $transactions[$i]['fee_type'] = $datum->fee_type;
                      $transactions[$i]['is_admin'] = $datum->is_admin;
                      $transactions[$i]['submission_type'] = $datum->nr;
                      $transactions[$i]['review_number'] = $datum->rev_number;
                      $transactions[$i]['total_acres'] = $datum->totalacres;
                      $transactions[$i]['disturbed_acres'] = $datum->tobedisturb;

                      $transactions[$i]['fee_type'] = 'tbd_fee';
                      $transactions[$i]['fee_amount'] = $datum->tbd_fee;
                      $transactions[$i]['check_number'] = $datum->tbdfee_chknum;
                      $transactions[$i]['payer_name'] = $datum->tbdfee_payor;
                      $transactions[$i]['check_date'] = $datum->tbdfee_chkdate;
                  }


                  if ($datum->expedite_fee != '' || $datum->exp_check_num != '' || $datum->exp_payor != '' || $datum->exp_check_date != '') {

                      $transactions[$i]['id'] = $datum->id;
                      $transactions[$i]['received_date'] = $datum->received;
                      $transactions[$i]['fee_type'] = $datum->fee_type;
                      $transactions[$i]['is_admin'] = $datum->is_admin;
                      $transactions[$i]['submission_type'] = $datum->nr;
                      $transactions[$i]['review_number'] = $datum->rev_number;
                      $transactions[$i]['total_acres'] = $datum->totalacres;
                      $transactions[$i]['disturbed_acres'] = $datum->tobedisturb;
                      $transactions[$i]['fee_type'] = 'exp_fee';
                      $transactions[$i]['fee_amount'] = $datum->expedite_fee;
                      $transactions[$i]['check_number'] = $datum->exp_check_num;
                      $transactions[$i]['payer_name'] = $datum->exp_payor;
                      $transactions[$i]['check_date'] = $datum->exp_check_date;
                  }

                  if ($datum->mccd_cwf_fee != '' || $datum->mccd_cwf_chknum != '' || $datum->mccd_cwf_payor != '' || $datum->mccd_cwf_chkdate != '') {

                      $transactions[$i]['id'] = $datum->id;
                      $transactions[$i]['received_date'] = $datum->received;
                      $transactions[$i]['fee_type'] = $datum->fee_type;
                      $transactions[$i]['is_admin'] = $datum->is_admin;
                      $transactions[$i]['submission_type'] = $datum->nr;
                      $transactions[$i]['review_number'] = $datum->rev_number;
                      $transactions[$i]['total_acres'] = $datum->totalacres;
                      $transactions[$i]['disturbed_acres'] = $datum->tobedisturb;
                      $transactions[$i]['fee_type'] = 'cwf_fee';
                      $transactions[$i]['fee_amount'] = $datum->mccd_cwf_fee;
                      $transactions[$i]['check_number'] = $datum->mccd_cwf_chknum;
                      $transactions[$i]['payer_name'] = $datum->mccd_cwf_payor;
                      $transactions[$i]['check_date'] = $datum->mccd_cwf_chkdate;
                  }

                  $i++;
              }*/

        return $transactions;
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
