<?php

namespace App\Models\Project;

use App\Models\County\County;
use Illuminate\Database\Eloquent\Model;

class NpdesCounter extends Model
{

    protected $table = 'npdes_counter';

    protected $fillable = ['county_id', 'general', 'individual'];

    public $timestamps = false;

    public function county()
    {
        return $this->belongsTo(County::class);
    }
}
