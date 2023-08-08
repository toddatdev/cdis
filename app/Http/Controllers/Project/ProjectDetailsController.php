<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectDetailsController extends Controller
{
    protected $projectData;
    protected $nasics;

    public function store(Request $request)
    {
        try {

            $this->projectData = $request->except(['_token', 'nasics']);
            $this->nasics = $request->only('nasics')['nasics'];
            $project_id = $request->project_id;

            $projectDetails = Project::find($project_id)->projectDetails()
                ->updateOrCreate(['project_id' => $project_id], $this->projectData);


            //count nasics data inputs
            $count = count($this->nasics);

            $nasic_id = 1;

            for ($i = 0; $i < $count; $i++) {

                //get a row one by one of medication data
                $nasic_row = ['nasic' => $this->nasics[$i], 'id' => $nasic_id];

                //save one row at a time until loop completes
                $projectDetails->nasics()
                    ->updateOrInsert(['id' => $nasic_id, 'project_detail_id' => $projectDetails->id], $nasic_row);

                $nasic_id++;
            }

            return response()
                ->json(['error' => false,
                    'title' => 'Project Details',
                    'message' => 'Project details saved successfully.']);

        } catch (\Exception $exception) {

            Log::error($exception->getMessage());

            return response()->json(['error' => true, 'message' => 'something went wrong! Try again!']);
        }
    }
}
