<?php

namespace App\Http\Controllers\Project;


use App\Http\Controllers\Controller;
use App\Models\Project\Project;
use Illuminate\Http\Request;

class ProjectSearchController extends Controller
{
    protected $project;

    public function index()
    {
        return view('search-projects');
    }

    public function search(Request $request)
    {
        //project details search values
        $project_details_sv = $request->only(['municipality_id', 'reviewer_id', 'tax_parcel']);

        //project location search values
        $project_location_sv = $request->only(['address_1']);

        //project permit search values
        $project_permit_sv = $request->only(['npdes_number']);

        //get the project by name & if entry number is not empty then add it
        //into search query as well.
        $query = Project::where('name', 'like', '%' . $request->name . '%')
            ->when(!empty($request->entry_number), function ($query) use ($request) {

                return $query->where('id', 'like', '%' . $request->entry_number . '%');

            })->with(['projectDetails.reviewer:id,name', 'projectPermit', 'projectLocation:id,project_id,address_1']);


        //if start date and end dates are not empty build query on date between
        if ($request->from && $request->to) {

            //convert them to SQL date format
            $from = $request->from;
            $to = $request->to;

            $query->whereHas('ProjectPermit', function ($query) use ($from, $to) {

                $query->whereBetween('received_date', [$from, $to]);
            });
        }

        //builds search query based on given values
        $query = $this->build_search_query($query, 'ProjectDetails', $project_details_sv);
        $query = $this->build_search_query($query, 'ProjectLocation', $project_location_sv);
        $query = $this->build_search_query($query, 'ProjectPermit', $project_permit_sv);


        return $query->orderBy('projects.id', 'desc')->paginate(12);
    }

    /**
     * @param $query
     * @param $search_values
     * @return  $query
     */
    public function build_search_query($query, $table, $search_values)
    {
        foreach ($search_values as $key => $search_value) {

            if ($search_value !== null) {

                $query->whereHas($table, function ($query) use ($search_value, $key) {

                    if ($key === 'municipality_id' || $key === 'reviewer_id') {

                        $query->where($key, $search_value);

                    } else {

                        $query->where($key, 'like', '%' . $search_value . '%');
                    }
                });
            }
        }

        return $query;
    }
}


