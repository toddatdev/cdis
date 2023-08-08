<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Helper\Helper;
use App\Models\Project\Project;
use App\Models\Project\ProjectReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectReviewsController extends Controller
{
    protected $projectData;
    protected $latest_project;
    protected $latest_project_id;


    public function index($project_id)
    {
        return Helper::loadReviews($project_id);
    }

    public function update(Request $request, $project_id, $review_id)
    {

        try {

            Project::find($project_id)->projectReview()
                ->updateOrCreate(['id' => $review_id, 'project_id' => $project_id], $request->all());

            return response()
                ->json(['error' => false,
                    'title' => 'Project Review',
                    'message' => 'Project reviews info has been updated.']);

        } catch (\Exception $exception) {

            Log::error($exception->getMessage());

            return response()->json(['error' => true, 'message' => 'something went wrong! Try again!']);
        }
    }

    public function store(Request $request)
    {
        try {

            $this->projectData = $request->except(['_token']);

            $project_id = $request->project_id;

            Project::find($project_id)->projectReview()
                ->create($this->projectData);


            return response()
                ->json(['error' => false,
                    'title' => 'Project Review',
                    'message' => 'Project reviews info has been updated.']);

        } catch (\Exception $exception) {

            Log::error($exception->getMessage());

            return response()->json(['error' => true, 'message' => 'something went wrong! Try again!']);
        }
    }

    public function destroy($project_id, $review_id)
    {
        ProjectReview::where('id', $review_id)->where('project_id', $project_id)->delete();
    }


}
