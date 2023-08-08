<?php

namespace App\Http\Controllers\Inspection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class InspecInfoController extends Controller
{

    protected $InspecProjectData;
    protected $latest_project_id;

    public function index($id)
    {
        return $id;
        //set session if user is creating a new inspection report
        Session::put('is_new_entry', true);

        return view('site-inspection');
    }

    public function store(Request $request)
    {
        try {

            $this->InspecProjectData = $request->except(['_token']);

            //check if user is creating a new project
            if (Session::has('is_new_entry')) {

                //forgot session after user has created a new project
                Session::forget('is_new_entry');

                $request->user()
                    ->projects()
                    ->updateOrCreate($this->InspecProjectData);

            } else {

                //if user is updating an existing project
                $this->latest_project_id = $request->user()->projects()->latest()->get('id')[0]->id;

                $request->user()
                    ->projects()
                    ->updateOrCreate(['id' => $this->latest_project_id], $this->InspecProjectData);
            }


            return response()
                ->json(['error' => false,
                    'title' => 'New Project Created',
                    'message' => 'Project basic info saved successfully.']);


        } catch (\Exception $exception) {

            Log::error($exception->getMessage());

            return response()->json(['error' => true, 'message' => 'something went wrong! Try again!']);
        }
    }
}
