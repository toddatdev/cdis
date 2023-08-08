<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Helper\Helper;
use App\Models\Project\Project;
use App\Models\Project\ProjectPermittee;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProjectPermitteeController extends Controller
{

    public function store(Request $request)
    {

        $data = $request->except(['_token', 'project_id']);

        $project_id = $request->project_id;

        Project::find($project_id)
            ->permittees()->create($data);

        return response()->json(['error' => false,
            'title' => 'Permittee Added!',
            'message' => 'Permittee has been added to project.'
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', 'project_id', 'permittee_id']);

        ProjectPermittee::where('id', $request->permittee_id)->where('project_id', $request->project_id)->update($data);

        return response()->json(['error' => false,
            'title' => 'Permittee Added!',
            'message' => 'Permittee has been added to project.']);

    }

    public function show($projectId)
    {
        try {

            return Helper::loadPermittees($projectId);

        } catch (NotFoundHttpException $e) {
            return false;
        }
    }
}
