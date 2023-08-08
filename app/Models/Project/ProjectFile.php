<?php

namespace App\Models\Project;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use OwenIt\Auditing\Contracts\Audit;

class ProjectFile extends Model
{

    protected $fillable = [
        'path', 'user_id', 'memo', 'filename', 'doctype', 'auth_code'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function store($data)
    {
        //persist the information to database
        $file = Project::find($data['project_id'])->files()->create($data);

        return ['file_id' => $file['id'], 'project_id' => $file['project_id'], 'auth_code' => $file['auth_code']];
    }

    public static function getUploadedPath($filename)
    {
        $disk = session('district');

        return Storage::disk($disk)->url($filename);
    }

    public static function uploadToS3($file_name, $file_path)
    {
        $district = session('district');

        //upload and store file in aws s3 disk
        $is_uploaded = Storage::disk($district)->put($file_name, file_get_contents($file_path), 'public');

        if ($is_uploaded) {

            unlink($file_path);

            return Storage::disk($district)->url($file_name);
        }

        return false;
    }

}
