<?php

namespace App\Models\Project;

use App\Models\County\County;
use App\Models\Reviewer\Reviewer;
use App\Models\Transaction\Transaction;
use App\Scopes\CountyScope;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use OwenIt\Auditing\Contracts\Auditable;

class Project extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    /*   protected $auditInclude = [
           'name',
           'plan_type',
           'is_closed',
           'memo'
       ];*/

    protected $fillable = [
        'name',
        'county_id',
        'plan_type',
        'is_closed',
        'memo',
        'application_status'
    ];


    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CountyScope());
    }


    public static function getProjectById($id)
    {
        $project = self::with(['county' => function ($query) {
            $query->select([
                'id',
                'name AS county_name',
                'phone as county_phone',
                'fax as county_fax',
                'manager as county_manager',
                'district',
                'state_abbr as state',
                'address_1 as county_address'
            ]);
        }])->where('id', $id)->first([
            'id as project_id',
            'county_id',
            'name AS project_name',
            'plan_type',
            'entry_number'
        ]);


        $project_county = array_merge(json_decode($project, true), json_decode($project->county, true));

        //unset county array from project county
        unset($project_county['county']);

        return $project_county;
    }

    public static function getAllInformation($project_id)
    {
        return self::with(['projectDetails' => function ($query) {
            $query->with('reviewer:id,name');
            $query->with('nasics');
        },
            'projectLocation', 'projectApplicants', 'projectEngineer', 'projectPermit', 'projectFees', 'projectReview', 'files', 'close'
        ])->where('id', $project_id)->first();
    }


    public static function getProjectDataForInspection($project_id)
    {
        $project = self::getProjectById($project_id);
        $project_details = ProjectDetail::getProjectDetailsById($project_id);
        $project_location = ProjectLocation::getLocationById($project_id);
        $project_applicant = ProjectApplicant::getApplicantById($project_id);
        $project_permit = ProjectPermit::getPermitById($project_id);
        $project_permitteeies = ProjectPermittee::getPermitteeByProjectId($project_id);


        return array_merge(
            $project,
            $project_details,
            $project_applicant,
            $project_permit,
            $project_location,
            ['permitteeies' => $project_permitteeies]
        );
    }

    public static function getLettersData($project_id)
    {
        $project = self::getProjectById($project_id);
        $project_details = ProjectDetail::getProjectDetailsById($project_id);
        $project_location = ProjectLocation::getLocationById($project_id);
        $project_applicant = ProjectApplicant::getApplicantById($project_id);
        $project_engineer = ProjectEngineer::getEngineerById($project_id);
        $project_permit = ProjectPermit::getPermitById($project_id);
        $project_permittee = ProjectPermittee::getSinglePermitteeByProjectId($project_id);

        return array_merge(
            $project,
            $project_details,
            $project_applicant,
            $project_engineer,
            $project_permit,
            $project_permittee,
            $project_location
        );
    }


    public static function getProjectWithDetails($project_id)
    {
        return self::with(['projectDetails.reviewer:id,name'])
            ->where('id', $project_id)->first(['id', 'name']);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function closedProjects()
    {
        return DB::table('projects AS p')
            ->join('recent_projects AS rp', 'p.id', '=', 'rp.project_id')
            ->where('p.county_id', session('county_id'))
            ->where('is_closed', 0)
            ->where('rp.user_id', Auth::user()->id)
            ->orderBy('access_dt', 'desc')->limit(6)
            ->get();
    }

    public function recentProjects()
    {
        return DB::table('projects AS p')
            ->join('recent_projects AS rp', 'p.id', '=', 'rp.project_id')
            ->where('p.county_id', session('county_id'))
            ->where('rp.user_id', Auth::user()->id)
            ->orderBy('access_dt', 'desc')->limit(6)
            ->get();
    }

    public function projectDetails()
    {
        return $this->hasOne(ProjectDetail::class);
    }

    public function projectLocation()
    {
        return $this->hasOne(ProjectLocation::class);
    }

    public function projectEngineer()
    {
        return $this->hasOne(ProjectEngineer::class);
    }

    public function projectPermit()
    {
        return $this->hasOne(ProjectPermit::class);
    }


    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }


    public function projectFees()
    {
        return $this->hasMany(ProjectFee::class);
    }

    public function projectReview()
    {
        return $this->hasOne(ProjectReview::class);
    }

    public function projectApplicants()
    {
        return $this->hasMany(ProjectApplicant::class);
    }

    public function files()
    {
        return $this->hasMany(ProjectFile::class);
    }

    public function permittees()
    {
        return $this->hasMany(ProjectPermittee::class);
    }

    public function reviewer()
    {
        return $this->hasOne(Reviewer::class);
    }

    //Time tracking
    public function timeTrackings()
    {
        return $this->hasMany(ProjectTime::class);
    }

    public function county()
    {
        return $this->belongsTo(County::class);
    }

    public function close()
    {
        return $this->hasOne(ProjectClosed::class);
    }
}
