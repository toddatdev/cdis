<?php

namespace App\Models\Inspection;

use Illuminate\Database\Eloquent\Model;

class InspecFinding extends Model
{
    protected $guarded = [];


    public function violations()
    {
        return $this->hasMany(InspecFindingsViolation::class, 'inspec_findings_id');
    }
}
