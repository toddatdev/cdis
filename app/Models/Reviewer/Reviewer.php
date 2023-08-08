<?php

namespace App\Models\Reviewer;

use App\Models\Project\Project;
use Illuminate\Database\Eloquent\Model;

class Reviewer extends Model
{
    protected const IMG_PATH = 'storage/signatures/';

    protected $hidden = ['signature'];


    public function getPathAttribute($value)
    {
        return self::IMG_PATH . $value;
    }


    public static function getReviewerById($reviewer_id)
    {
        //reviewer is not part of selected letter
        if (empty($reviewer_id)) {
            return [];
        }
        $reviewer = self::whereId($reviewer_id)->first([
            'name AS reviewer',
            'extension AS reviewer_extension',
            'title AS reviewer_title',
            'email AS reviewer_email',
            'path',
            'initials AS reviewer_initials'
        ]);

        //convert base 64 string to jpg image
//        $reviewer->signature = Helper::base64_to_image($reviewer->signature);

        return json_decode($reviewer, true);

    }

    public function projects()
    {
        return $this->belongsTo(Project::class);

    }
}
