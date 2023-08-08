<?php


namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;


class ProjectDetailNasics extends Model
{
    public $timestamps = false;
    protected $table = 'project_details_nasic';
    protected $fillable = ['nasic', 'id', 'project_detail_id'];
}
