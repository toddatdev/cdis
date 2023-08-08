<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProjectPermit extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'npdes_number', 'received_date', 'pindi_date', 'final_inspection_date', 'permit_complete_date',
        'permit_issued_date', 'permit_expiration_date', 'is_notice_received', 'notice_received_date',
        'is_notice_acknowledged', 'is_active'
    ];

    public static function getPermitById($project_id)
    {
        $project_permit = self::where('project_id', $project_id)
            ->first([
                'project_id',
                'npdes_number',
                'received_date',
                'final_inspection_date',
                'permit_issued_date',
                'permit_expiration_date'
            ]);

        if (empty($project_permit)) {
            return [];
        }

        return json_decode($project_permit, true);
    }
}



