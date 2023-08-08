<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProjectLocation extends Model implements Auditable
{

    use \OwenIt\Auditing\Auditable;


    protected $fillable = [
        'address_1', 'address_2', 'city', 'zipcode',
        'lat_deg', 'lat_min', 'lat_sec', 'long_deg', 'long_min', 'long_sec'

    ];

    public static function getLocationById($project_id)
    {
        $project_location = self::where('project_id', $project_id)
            ->first(['project_id', 'address_1 as project_location', 'city', 'zipcode']);

        if (empty($project_location)) {
            return [];
        }

        return json_decode($project_location, true);
    }

    public static function degToDec($lat_deg, $lat_min, $lat_sec, $lng_deg, $lng_min, $lng_sec)
    {
        return array(
            'latitude' => $lat_deg + ((($lat_min * 60) + ($lat_sec)) / 3600),
            'longitude' => ($lng_deg + ((($lng_min * 60) + ($lng_sec)) / 3600)) * -1 // * -1 because this is always W in the US.
        );
    }

}
