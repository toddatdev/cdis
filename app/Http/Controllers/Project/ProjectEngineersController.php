<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectEngineersController extends Controller
{
    protected $projectData;
    protected $latest_project;

    public function store(Request $request)
    {
        try {

            $this->projectData = $request->except(['_token', 'project_id']);

            $project_id = $request->project_id;

            Project::find($project_id)->projectEngineer()
                ->updateOrCreate(['project_id' => $project_id], $this->projectData);

            return response()
                ->json(['error' => false,
                    'title' => 'Project Engineer',
                    'message' => 'Project engineer info has been updated.']);

        } catch (\Exception $exception) {

            Log::error($exception->getMessage());

            return response()->json(['error' => true, 'message' => 'something went wrong! Try again!']);
        }
    }

}
