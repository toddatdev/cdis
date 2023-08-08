<?php

namespace App\Http\Controllers;


use App\Models\Project\Project;
use Illuminate\Contracts\Support\Renderable;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $recentProjects = (new Project)->recentProjects();

        return view('index', compact('recentProjects'));
    }

    public function getLongLatInfo($projectType = 'mine')
    {

        $projects = Project::with('projectLocation', 'County')
            ->whereHas('projectLocation', function ($query) {
                $query->where('lat_deg', '!=', 0);
                $query->where('long_deg', '!=', 0);
            })->when($projectType === 'closed', function ($q) {
                return $q->where('is_closed', 1);
            })->when($projectType === 'mine', function ($q) {
                return $q->where('user_id', auth()->user()->id);
            })->when($projectType === 'all', function ($q) {
                return $q->where('is_closed', 0);
            })->where('county_id', session('county_id'))
            ->orderBy('id', 'desc')->limit(100)
            ->get();

        $markers = array();

        foreach ($projects as $project) {

            $name = $project->name;
            $user_id = $project->user_id;

            $deg = $this->degToDec(
                $project->projectLocation->lat_deg,
                $project->projectLocation->lat_min,
                $project->projectLocation->lat_sec,
                $project->projectLocation->long_deg,
                $project->projectLocation->long_min,
                $project->projectLocation->long_sec
            );

            $lat = $deg['latitude'];
            $long = $deg['longitude'];

            $markers[] = array($name, $lat, $long, url(route('projects.edit', $project->id)), $user_id);
        }

        return response()->json($markers);
    }

    function degToDec($lat_deg, $lat_min, $lat_sec, $lng_deg, $lng_min, $lng_sec)
    {
        return array(
            'latitude' => $lat_deg + ($lat_min / 60) + ($lat_sec / 3600),
            // * -1 because this is always W in the US.
            'longitude' => ($lng_deg + ($lng_min / 60) + ($lng_sec / 3600)) * -1
        );
    }
}
