<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RecentProject extends Model
{
    public $timestamps = false;

    protected $guarded = [];


    public function project()
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public static function logAccessTime(int $project_id)
    {
        $data = [
            'project_id' => $project_id,
            'user_id' => Auth::user()->id,
            'access_dt' => date('Y-m-d H:i:s')
        ];

        self::updateOrInsert(['project_id' => $project_id, 'user_id' => Auth::user()->id], $data);

        //get ids of all the old projects in recent access history
        $old_ids = self::where('user_id', Auth::user()->id)->orderBy('access_dt', 'desc')->skip(6)->take(10)->pluck('id')->toArray();

        //delete all the projects
        self::destroy($old_ids);
    }


}
