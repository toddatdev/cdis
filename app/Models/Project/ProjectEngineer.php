<?php

namespace App\Models\Project;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;

class ProjectEngineer extends Authenticatable implements Auditable
{
    use  \OwenIt\Auditing\Auditable;

    use Notifiable;

    protected $guard = 'engineer';

    protected $fillable = [
        'name', 'company_name',
        'address_1', 'address_2', 'city', 'state', 'zipcode',
        'phone_number', 'phone_number_ext', 'fax_number', 'email'
    ];

    public function getAddress3Attribute()
    {
        return $this->attributes['city'] . ', ' . $this->attributes['state'] . ' ' . $this->attributes['zipcode'];
    }

    public static function getEngineerById($project_id)
    {
        $project_engineer = self::where('project_id', $project_id)
            ->first([
                'project_id',
                'name as engineer_name',
                'company_name as engineer_company_name',
                'address_1 as engineer_address_1',
                'address_2 as engineer_address_2',
                'city AS engineer_city',
                'state AS engineer_state',
                'zipcode AS engineer_zipcode',
            ]);

        $engineer_address_3 = '';

        if ($project_engineer->engineer_city && $project_engineer->engineer_state) {

            $engineer_address_3 = $project_engineer->engineer_city . ', ' . $project_engineer->engineer_state . ' ' . $project_engineer->engineer_zipcode;
        }


        if (empty($project_engineer)) {
            return [];
        }

        return array_merge(['engineer_address_3' => $engineer_address_3], json_decode($project_engineer, true));
    }
}
