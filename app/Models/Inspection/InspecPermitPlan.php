<?php

namespace App\Models\Inspection;

use Illuminate\Database\Eloquent\Model;

class InspecPermitPlan extends Model
{
    protected $fillable = [
        'written_erosion_required', 'post_const_written', 'written_erosion_requested'
        , 'pcsm_requested', 'esp_required', 'npdes_required', 'phased_const'
        , 'non_phased_const', 'prc', 'rsbd', 'gov', 'utl', 'sws', 'rrs'
        , 'prrs', 'cmin', 'recf', 'aga', 'pl', 'silv', 'other', 'other_value'];

    public function inspection()
    {
        return $this->belongsTo(Inspection::class);
    }
}
