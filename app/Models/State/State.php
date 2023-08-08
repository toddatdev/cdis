<?php

namespace App\Models\State;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ['name', 'abbr'];
    public $timestamps = false;
}
