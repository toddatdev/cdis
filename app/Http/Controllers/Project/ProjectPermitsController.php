<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project\Project;
use Illuminate\Http\Request;

class ProjectPermitsController extends Controller
{
    protected $projectData;
    protected $latest_project;

    public function store(Request $request)
    {
//        try {

        $this->projectData = $request->except(['_token', 'project_id']);

        $project_id = $request->project_id;

        Project::find($project_id)->projectPermit()
            ->updateOrCreate(['project_id' => $project_id], $this->projectData);

        return response()
            ->json(['error' => false,
                'title' => 'Project Permit',
                'message' => 'Project permits info has been updated.']);

//        } catch (\Exception $exception) {
//
//            Log::error($exception->getMessage());
//
//            return response()->json(['error' => true, 'message' => 'something went wrong! Try again!']);
//        }
    }


}
