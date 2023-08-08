<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class ProjectClosed extends Model
{
    protected $table = 'project_closed';

    protected $fillable = [
        'project_id', 'box_number', 'closing_date', 'reason', 'notes', 'technician_id'
    ];
}
