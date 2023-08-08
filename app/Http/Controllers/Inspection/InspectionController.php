<?php

namespace App\Http\Controllers\Inspection;

use App\Http\Controllers\Controller;
use App\Models\Project\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InspectionController extends Controller
{

    public function index($project_id = -1)
    {
        if ($project_id === -1) {

            return view('search-projects')->with('message', 'You should search the project first in order to create an inspection report.');
        }

        $project = Project::getProjectWithDetails($project_id);

        return view('site-inspection', compact('project'));
    }


    public function store(Request $request)
    {
        try {

            $inspectionData = $request->except(['_token', 'inspection_id']);

            $inspection_id = $request->inspection_id;

            //if there is inspection id in the hidden input that
            // means he is updating an existing inspection else create a new one
            if (empty($inspection_id)) {

                $inspection_id = $request->user()
                    ->inspections()
                    ->create($inspectionData)->id;
            } else {

                $request->user()
                    ->inspections()
                    ->updateOrCreate(['id' => $inspection_id], $inspectionData)->id;
            }

            return response()
                ->json(['error' => false,
                    'title' => 'Inspection Info',
                    'inspection_id' => $inspection_id,
                    'message' => 'Inspection info saved successfully.']);

        } catch (\Exception $exception) {

            Log::error($exception->getMessage());

            return response()->json(['error' => true, 'message' => 'something went wrong! Try again!']);
        }
    }
}
