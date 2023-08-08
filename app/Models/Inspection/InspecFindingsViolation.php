<?php

namespace App\Models\Inspection;

use Illuminate\Database\Eloquent\Model;

class InspecFindingsViolation extends Model
{
    protected $table = 'inspec_findings_violations';

    protected $fillable = ['violations', 'inspec_findings_id'];

}
