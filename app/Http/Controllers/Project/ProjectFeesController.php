<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Helper\Helper;
use App\Models\Project\Project;
use App\Models\Project\ProjectFee;
use Illuminate\Http\Request;

class ProjectFeesController extends Controller
{
    protected $projectData;
    protected $latest_project;
    protected $latest_project_id;


    public function index($project_id)
    {
        return Helper::loadFees($project_id);
    }

    public function update(Request $request, $project_id, $fee_id)
    {

//        try {

        return $request->all();

        Project::find($project_id)->projectFee()
            ->updateOrCreate(['id' => $fee_id, 'project_id' => $project_id], $request->all());

        return response()
            ->json(['error' => false,
                'title' => 'Project Fee',
                'message' => 'Project Fee info has been updated.']);

        /*        } catch (\Exception $exception) {

                    Log::error($exception->getMessage());

                    return response()->json(['error' => true, 'message' => 'something went wrong! Try again!']);
                }*/
    }


    public function store(Request $request)
    {
//        try {

        $this->projectData = $request->except(['_token', 'project_id']);


        return $request->all();

        $project_id = $request->project_id;

        Project::find($project_id)->projectFee()
            ->create($this->projectData);

        return response()
            ->json(['error' => false,
                'title' => 'Project Fee',
                'message' => 'Project fee info has been updated.']);

        /*        } catch (\Exception $exception) {

                    Log::error($exception->getMessage());

                    return response()->json(['error' => true, 'message' => 'something went wrong! Try again!']);
                }*/
    }


    public function destroy($project_id, $fee_id)
    {
        ProjectFee::where('id', $fee_id)->where('project_id', $project_id)->delete();
    }
}
