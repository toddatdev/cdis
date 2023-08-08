<?php

namespace App\Models\Inspection;

use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{

    protected $fillable = [
        'entry_number', 'technician', 'report_number', 'project_name', 'inspection_date'
        , 'inspection_time', 'designated', 'weather', 'site_rep', 'site_rep_title'
        , 'site_insp', 'site_insp_title', 'inspection_type', 'tax_parcel_number'
        , 'photos_taken', 'site_description'];


    public function getInspectionInfo($id)
    {

    }

    public function permitPlan()
    {
        return $this->hasOne(InspecPermitPlan::class);
    }

    public function finding()
    {
        return $this->hasOne(InspecFinding::class);
    }
}
