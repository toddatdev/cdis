<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Helper\Helper;
use App\Models\Project\Project;
use App\Models\Project\ProjectTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectTimesController extends Controller
{
    public function update(Request $request, $timeId)
    {
        try {

            $data = $request->except(['_token', 'project_id', 'project_name']);

            ProjectTime::where('id', $timeId)->update($data);

            return response()
                ->json(['error' => false,
                    'title' => 'Recorded Time Updated',
                    'message' => 'Recorded time has been updated for this project.']);


        } catch (\Exception $exception) {

            Log::error($exception->getMessage());

            return response()->json(['error' => true, 'message' => 'something went wrong! Try again!']);
        }
    }


    public function store(Request $request)
    {

        try {
            $data = $request->except(['_token', 'project_id', 'project_name']);

            $project_id = $request->project_id;

            //find project and update it's time
            $timeTracking = Project::find($project_id)
                ->timeTrackings()
                ->create($data);

            return response()
                ->json(['error' => false,
                    'title' => 'Project Time',
                    'message' => 'Time has been logged for this project.']);

        } catch (\Exception $exception) {

            Log::error($exception->getMessage());

            return response()->json(['error' => true, 'message' => 'something went wrong! Try again!']);
        }
    }


    public function show($id)
    {
        return Helper::loadTimeTrackingDetails($id);
    }

    public function getSingleTimeDetails($timeId)
    {
        return json_encode(ProjectTime::where('id', $timeId)->first());
    }

    public function destroy($project_id, $time_id)
    {

        ProjectTime::where('id', $time_id)->where('project_id', $project_id)->delete();

        return response()
            ->json(['error' => false,
                'title' => 'Project Time',
                'message' => 'Project time record has been deleted.']);
    }
}
