<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project\Project;
use App\Models\Project\ProjectLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectLocationsController extends Controller
{
    protected $projectData;
    protected $latest_project;
    protected $latest_project_id;

    public function store(Request $request)
    {
        try {

            $this->projectData = $request->except(['_token']);

            $project_id = $request->project_id;

            Project::find($project_id)->projectLocation()
                ->updateOrCreate(['project_id' => $project_id], $this->projectData);

            return response()
                ->json(['error' => false,
                    'title' => 'Project Location',
                    'message' => 'Project locations info has been updated.']);

        } catch (\Exception $exception) {

            Log::error($exception->getMessage());

            return response()->json(['error' => true, 'message' => 'something went wrong! Try again!']);
        }
    }

    public function getCoordinates(Request $request)
    {
        $latdeg = $request->latdeg;
        $latmin = $request->latmin;
        $latsec = $request->latsec;
        $lngdeg = $request->lngdeg;
        $lngmin = $request->lngmin;
        $lngsec = $request->lngsec;

        return response()->json(
            ProjectLocation::degToDec(
                $latdeg,
                $latmin,
                $latsec,
                $lngdeg,
                $lngmin,
                $lngsec
            )
        );
    }


}
