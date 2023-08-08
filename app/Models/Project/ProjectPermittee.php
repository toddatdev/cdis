<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class ProjectPermittee extends Model
{
    protected $table = 'project_permittees';

    protected $fillable = [
        'name', 'company', 'address_1', 'address_2', 'city', 'state', 'zipcode', 'phone', 'received_date',
        'reviewed_date', 'fax', 'acknowledged', 'email'
    ];

    public static function getPermitteeByProjectId($project_id)
    {
        $project_permittee = self::where('project_id', $project_id)->get([
            'id',
            'received_date AS co_permittee_received_date',
            'reviewed_date AS co_permittee_reviewed_date',
            'name AS co_permittee_name',
            'acknowledged as co_permittee_acknowledged',
            'address_1 AS co_permittee_address_1',
            'address_2 AS co_permittee_address_2',
            'city AS co_permittee_city',
            'company AS co_permittee_company',
            'state AS co_permittee_state',
            'zipcode AS co_permittee_zip',
            'phone AS co_permittee_phone',
            'fax AS co_permittee_fax',
            'email AS co_permittee_email',
        ]);

        if (empty($project_permittee)) {
            return [];
        }

        return json_decode($project_permittee, true);
    }

    public static function getSinglePermitteeByProjectId($project_id)
    {
        $project_permittee = self::where('project_id', $project_id)->first([
            'name AS co_permittee_name',
            'company AS co_permittee_company',
            'city AS co_permittee_city',
            'state AS co_permittee_state',
            'zipcode AS co_permittee_zipcode',
            'address_1 AS co_permittee_address_1',
            'address_2 AS co_permittee_address_2'
        ]);

        if (empty($project_permittee)) {
            return [];
        }

        return json_decode($project_permittee, true);
    }
}
