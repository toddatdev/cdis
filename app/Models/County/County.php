<?php

namespace App\Models\County;

use App\User;
use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    public static function getAuthenticatedCounty()
    {
        return self::where('id', session('county_id'))->first();
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function getContactAttribute()
    {
        return $this->attributes['address_1'] . ', ' .
            $this->attributes['address_2'] . ', ' .
            $this->attributes['phone'];
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}
