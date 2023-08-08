<?php

namespace App\Models\Project;

use App\Models\Municipality\Municipality;
use App\Models\Reviewer\Reviewer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

class ProjectDetail extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'project_id',
        'reviewer_id', 'municipality_id', 'tax_parcel',
        'watershed', 'receiving_stream', 'plan_date', 'ownership',
        'ch_93_class', 'total_acres', 'disturbed_acres'
    ];

    protected $dates = ['created_at', 'updated_at'];


    public static function getProjectDetailsById($id)
    {
        $project_details = self::where('project_id', $id)
            ->selectRaw(' project_id,
             DATE_FORMAT(plan_date, "%m/%d/%Y") as plan_date,
             reviewer_id,
             total_acres,
             ch_93_class as stream_class,
             tax_parcel as tmp,
             disturbed_acres,
             watershed,
             municipality_id ')->first();

        //if it returns empty set
        if (empty($project_details)) {
            return [];
        }

        if (isset($project_details->municipality_id)) {

            $municipality = Municipality::where('id', $project_details->municipality_id)->select(['name AS municipality'])->first();

            return array_merge(json_decode($municipality, true), json_decode($project_details, true));
        }

        return json_decode($project_details, true);

    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(Reviewer::class);
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }

    public function nasics()
    {
        return $this->hasMany(ProjectDetailNasics::class);
    }

}

