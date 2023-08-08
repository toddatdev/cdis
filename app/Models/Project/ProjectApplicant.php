<?php

namespace App\Models\Project;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;

class ProjectApplicant extends Authenticatable implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    use Notifiable;

    protected $guard = 'applicant';

    protected $table = 'project_applicants';

    protected $fillable = [
        'id', 'name', 'company_name',
        'address_1', 'address_2', 'city', 'state', 'zipcode',
        'phone_number', 'phone_number_ext', 'fax_number', 'email',
    ];

    public static function getApplicantById($project_id)
    {
        $project_applicant = self::where('project_id', $project_id)->first([
            'project_id',
            'name AS applicant_name',
            'company_name AS applicant_company',
            'address_1 AS applicant_address_1',
            'address_2 AS applicant_address_2',
            'phone_number AS applicant_phone',
            'city AS applicant_city',
            'state AS applicant_state',
            'zipcode AS applicant_zipcode',
        ]);

        if (empty($project_applicant)) {
            return [];
        }

        return json_decode($project_applicant, true);

    }
}
