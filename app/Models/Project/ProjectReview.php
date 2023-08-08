<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class ProjectReview extends Model
{
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'is_admin', 'received_date', 'admin_status', 'admin_review_date', 'admin_initials', 'reviewed_date',
        'tech_status', 'tech_initials', 'return_reason', 'date_withdrawn'
    ];
}
