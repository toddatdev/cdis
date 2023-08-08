<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project\Project;
use App\Models\Project\ProjectApplicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectApplicantsController extends Controller
{
    protected $latest_project;
    protected $latest_project_id;

    public function store(Request $request)
    {
       try {

        $applicants = $request->except(['_token', 'project_id']);

        $project_id = (integer)$request->project_id;

        //count total applicants by it's name array
        $count = count($request->name);

        $applicant_id = 1;

        for ($i = 0; $i < $count; $i++) {


            //get a row one by one of applicant data
            $applicant_row[] = '';

            foreach ($applicants as $key => $applicant) {

                $applicant_row[$key] = $applicant[$i] ?? '';
            }

            $applicant_id = (!empty($applicant_row['applicant_id'])) ? $applicant_row['applicant_id'] : $applicant_id + $i;

            unset($applicant_row[0], $applicant_row[1], $applicant_row['applicant_id']);

            //save one row at a time until loop completes
            Project::find($project_id)->projectApplicants()
                ->updateOrInsert(['project_id' => $project_id, 'id' => $applicant_id], $applicant_row);
        }

        return response()
            ->json(['error' => false,
                'title' => 'Project Applicant',
                'applicant_destroy_url' => route('project.applicants.destroy', [$project_id, $applicant_id]),
                'message' => 'Project applicant info has been updated']);

             } catch (\Exception $exception) {

                 Log::error($exception->getMessage());

                 return response()->json(['error' => true, 'message' => 'something went wrong! Try again!']);
             }
    }

    public function destroy($project_id, $applicant_id)
    {

        ProjectApplicant::where('id', $applicant_id)->where('project_id', $project_id)->delete();

        return response()->json(['error' => false,
            'title' => 'Co-Applicant removed.',
            'message' => 'Co-Applicant has been removed.']);
    }
}
