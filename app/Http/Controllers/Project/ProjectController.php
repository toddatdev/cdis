<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project\NpdesCounter;
use App\Models\Project\Project;
use App\Models\Project\ProjectClosed;
use App\Models\Project\RecentProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    protected $projectData;
    protected $county_id;


    public function __construct()
    {
        //workaround for getting session value in constructor
        $this->middleware(function ($request, $next) {

            $this->county_id = session()->get('county_id');

            return $next($request);
        });
    }

    public function index($project_id = -1)
    {
        $district =strtoupper(session('district'));

        if ($project_id !== -1)
        {

            $project = Project::getAllInformation($project_id);

            //log the recently accessed project
            RecentProject::logAccessTime($project_id);

            $district =strtoupper(session('district'));

            return view('projects', compact('project', 'district'));
        }

        return view('projects', compact('district'));
    }


    public function storeMemo(Request $request)
    {

        Project::where('id', $request->project_id)->update(['memo' => $request->project_memo]);

        return response()
            ->json(['error' => false,
                'title' => 'Project Memo',
                'message' => 'Project memo has been updated.']);

    }

    //close a project
    public function close(Request $request)
    {
        $data = $request->except(['_token', 'project_id']);
        $project_id = $request->project_id;

        $project = Project::find($project_id);

        $project->is_closed = 1;
        $project->save();

        //adding today as closing date
        $data = array_merge($data, ['closing_date' => date('Y-m-d')]);

        //update plan close table
        $project->close()->create($data);

        return response()
            ->json(['error' => false,
                'project_id' => $project_id,
                'title' => 'Plan Closed',
                'message' => 'Your plan has been closed.']);
    }

    //activate a project
    public function activate($id)
    {
        $project = Project::find($id);


        $project->is_closed = 0;
        $project->save();

//        remove the closed record from project closed table
        ProjectClosed::where('project_id', $id)->delete();

        return response()
            ->json(['error' => false,
                'title' => 'Plan Activated',
                'message' => 'Your plan has been activated.']);

    }

    public function store(Request $request)
    {
        try {

            $this->projectData = $request->except(['_token', 'project_id']);

            $project_id = $request->project_id;

            //if there is project id in the hidden input that
            // means he is updating an existing project else create a new project
            if (!empty($project_id)) {

                Project::updateOrCreate(['id' => $project_id], $this->projectData);

            }

            if (empty($project_id)) {

                $project_id = $request->user()
                    ->projects()
                    ->create($this->projectData)->id;


                //get generated npdes number
                $npdes_number = $this->generate_npdes_number($request->plan_type);


                //create a project permit with the generated npdes number
                Project::find($project_id)->projectPermit()
                    ->create(['npdes_number' => $npdes_number]);

            }

            return response()
                ->json(['error' => false,
                    'project_id' => $project_id,
                    'plan_type' => $request->plan_type,
                    'npdes_number' => $npdes_number ?? '',
                    'title' => 'New Project Created',
                    'message' => 'Project basic info saved successfully.',
                ]);

        } catch (\Exception $exception) {

            Log::error($exception->getMessage());


            return response()->json(['error' => true, 'message' => 'something went wrong! Try again!']);
        }
    }


    protected function generate_npdes_number($plan_type)
    {
        //if plan type is general or individual
        if (in_array($plan_type, ['general', 'individual'])) {

            //assign the specific code to plan based on type type
            $plan_code = ($plan_type === 'general') ? 'C' : 'D';


            $npdes = NpdesCounter::where('county_id', $this->county_id)->first();

            //npdes_number generation
            //selected plan_type has column name ('Individual' or 'General')
            $npdes_number = $npdes->county->state_abbr . $plan_code . $npdes->county->npdes_county_prefix . sprintf('%04d', $npdes->{$plan_type});


            //increment the counter number in database
            NpdesCounter::where('county_id', $this->county_id)->update([$plan_type => $npdes->{$plan_type} + 1]);

            return $npdes_number;
        }

        return '';
    }

}
