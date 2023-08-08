<?php

namespace App;

use App\Models\County\County;
use App\Models\Document\Document;
use App\Models\Inspection\Inspection;
use App\Models\Project\Project;
use App\Models\Project\ProjectFile;
use App\Models\Project\ProjectTime;
use App\Scopes\CountyScope;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'county_id', 'first_name', 'last_name', 'role', 'is_logged_in', 'is_active',
        'email', 'password', 'phone_number',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $dates = [
        'last_activity'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getAuthenticatedUserId()
    {
        return Auth::user()->id;
    }

    public static function getCurrentICISUser()
    {
        $authenticatedUserId = self::getAuthenticatedUserId();

        $user = self::where('id', $authenticatedUserId)->select([
            'icis_username',
            DB::raw('CONCAT(first_name," ", last_name) AS author')
        ])->first();

        //get the county by session id
        $county = County::getAuthenticatedCounty();

        $contact = implode(' ', [$county->address_1,
            $county->address_2,
            $county->phone,
            $user->email
        ]);

        return (object)['id' => $user->icis_username,
            'author' => $user->author,
            'contact' => $contact,
            'county' => $county->name,
            'county_code' => $county->county_code
        ];
    }


    public function getNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'user_id')->withoutGlobalScope(CountyScope::class);
    }

    public function inspections()
    {
        return $this->hasMany(Inspection::class);
    }

    public function timeTrackings()
    {
        return $this->hasMany(ProjectTime::class);
    }

    public function county()
    {
        return $this->belongsTo(County::class);
    }

    public function files()
    {
        return $this->hasMany(ProjectFile::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

}
