<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Helper\Helper;
use App\Models\Project\Project;
use App\Models\Transaction\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TransactionsController extends Controller
{

    public function indexFees($project_id)
    {
        return Helper::loadFees($project_id);
    }

    public function storeFee(Request $request)
    {
        try {

            $data = $request->except(['_token', 'project_id']);

            //add county id to data
            $data = array_merge($data, ['county_id' => session('county_id'), 'conservationdistrict' => session('district')]);

            $project_id = $request->project_id;

            Project::find($project_id)->transactions()
                ->create($data);

            return response()
                ->json(['error' => false,
                    'title' => 'Project Fee',
                    'message' => 'Project fee has been created.']);

        } catch (\Exception $exception) {

            Log::error($exception->getMessage());

            return response()->json(['error' => true, 'message' => 'something went wrong! Try again!']);
        }
    }

    public function updateFee(Request $request, $project_id, $fee_id)
    {
//        try {

        $data = $request->except(['_token', 'project_id']);

        //add county id to data
        $data = array_merge($data, ['county_id' => session('county_id'), 'conservationdistrict' => session('district')]);

        Project::find($project_id)->transactions()
            ->updateOrCreate(['id' => $fee_id, 'project_id' => $project_id], $data);

        return response()
            ->json(['error' => false,
                'title' => 'Project Fee',
                'message' => 'Project fee has been updated.']);

        /*        } catch (\Exception $exception) {

                    Log::error($exception->getMessage());

                    return response()->json(['error' => true, 'message' => 'something went wrong! Try again!']);
                }*/
    }


    public function destroyFee($project_id, $fee_id)
    {
        Transaction::where('id', $fee_id)->where('project_id', $project_id)->delete();
    }


    public function indexReviews($project_id)
    {
        return Helper::loadReviews($project_id);
    }


    public function storeReview(Request $request)
    {
        try {

            $request->request->add(['conservationdistrict' => session('district')]);
            $request->request->add(['fee_type' => 'review']);
            $request->request->add(['county_id' => session('county_id')]);


            Project::find($request->project_id)->transactions()
                ->create($request->all());

            return response()
                ->json(['error' => false,
                    'title' => 'Project Review',
                    'message' => 'Project review has been created!']);

        } catch (\Exception $exception) {

            Log::error($exception->getMessage());

            return response()->json(['error' => true, 'message' => 'something went wrong! Try again!']);
        }
    }


    public function updateReview(Request $request, $project_id, $review_id)
    {
        try {

            Project::find($project_id)->transactions()
                ->updateOrCreate(['id' => $review_id, 'project_id' => $project_id], $request->all());

            return response()
                ->json(['error' => false,
                    'title' => 'Project Review',
                    'message' => 'Project review has been updated!']);

        } catch (\Exception $exception) {

            Log::error($exception->getMessage());

            return response()->json(['error' => true, 'message' => 'something went wrong! Try again!']);
        }
    }

    public
    function destroyReview($project_id, $review_id)
    {
        Transaction::where('id', $review_id)->where('project_id', $project_id)->delete();
    }
    /*
        private
        function prepareData(Request $request)
        {
            $data = [];

            $data['county_id'] = session('county_id');

            $data['received'] = $request->received_date;
            $data['fee_type'] = $request->fee_type;
            $data['is_admin'] = $request->is_admin;
            $data['nr'] = $request->submission_type;
            $data['rev_number'] = $request->review_number;
            $data['totalacres'] = $request->total_acres;
            $data['tobedisturb'] = $request->disturbed_acres;
            $data['conservationdistrict'] = session('district');

            switch ($request->fee_type) {
                case 'dist_fee':
                    $data['dist_fee'] = $request->fee_amount;
                    $data['dist_chknum'] = $request->check_number;
                    $data['distfee_payor'] = $request->payer_name;
                    $data['dist_fee_chkdate'] = $request->check_date;
                    break;
                case 'tbd_fee':
                    $data['tbd_fee'] = $request->fee_amount;
                    $data['tbdfee_chknum'] = $request->check_number;
                    $data['tbdfee_payor'] = $request->payer_name;
                    $data['tbdfee_chkdate'] = $request->check_date;
                    break;
                case 'cwf_fee':
                    $data['mccd_cwf_fee'] = $request->fee_amount;
                    $data['mccd_cwf_chknum'] = $request->check_number;
                    $data['mccd_cwf_payor'] = $request->payer_name;
                    $data['mccd_cwf_chkdate'] = $request->check_date;
                    break;

                case 'exp_fee':
                    $data['expedite_fee'] = $request->fee_amount;
                    $data['exp_check_num'] = $request->check_number;
                    $data['exp_payor'] = $request->payer_name;
                    $data['exp_check_date'] = $request->check_date;
                    break;
            }

            return $data;
        }*/


}
