<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProjectFee extends Model implements Auditable
{
    use  \OwenIt\Auditing\Auditable;
    
    protected $fillable = [
        'is_admin', 'received_date', 'submission_type', 'review_number', 'disturbed_acres',
        'total_acres', 'fee_type', 'fee_amount', 'check_number', 'payer_name', 'check_date'
    ];
}
