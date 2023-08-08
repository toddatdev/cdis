<?php

namespace App\Models\Project;

use App\Models\Reviewer\Reviewer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProjectTime extends Model
{

    protected $table = 'project_time_tracking';


    protected $fillable = [
        'project_id', 'user_id', 'time_category', 'hours', 'submit_type', 'entered_date', 'entered_by', 'reviewer_id'
    ];

    public function reviewer()
    {
        return $this->hasOne(Reviewer::class);
    }

    public function getTrxDateAttribute()
    {
        return Carbon::parse($this->attributes['trx_date'])->format('m/d/Y');
    }

    public function project()
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    //specific for Project Time 
    public function technician()
    {
        return $this->hasOne(Reviewer::class, 'id', 'reviewer_id');
    }

    public static function getRecordedTimeByProjectId($project_id)
    {
        return self::where('project_id', $project_id)->get();
    }
}
