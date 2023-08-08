<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Helper\Helper;
use App\Models\Project\ProjectFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectFilesController extends Controller
{
    public function store(Request $request)
    {
        $file_name = Helper::makeFileName($request->file);

        //uploads file to aws s3 disk
        $is_uploaded = ProjectFile::uploadToS3($file_name, $request->file);

        if (!$is_uploaded) {

            return response()->json(['error' => true,
                'title' => 'File Upload Error!',
                'message' => 'There was an error while uploading. Try again!']);
        }

        //get mapped data
        $data = $this->mapToArray($request, $file_name);

        //persist to database
        $project_file_id = ProjectFile::store($data)['file_id'];


        return response()->json(['error' => false,
            'title' => 'File uploaded!',
            'path' => $data['path'],
            'project_file_id' => $project_file_id,
            'key' => $file_name,
            'message' => 'File and it\'s info has been saved.']);
    }

    public function destroy($project_id, $id)
    {
        $project_file = ProjectFile::where('id', $id)->where('project_id', $project_id)->first();

//        return $project_file;
        $disk = session('district');

        if (Storage::disk($disk)->exists($project_file->filename)) {

            Storage::disk($disk)->delete($project_file->filename);
        }

        $project_file->delete();

        return response()->json(['error' => false,
            'title' => 'File Deleted!',
            'message' => 'File has been deleted.']);
    }

    /**
     * @param Request $request
     * @param string $file_name
     * @param $data
     * @return mixed
     */
    protected function mapToArray(Request $request, string $file_name)
    {
        //map data to documents table
        $data['filename'] = $file_name;
        $data['path'] = ProjectFile::getUploadedPath($file_name);
        $data['user_id'] = Auth::user()->id;
        $data['project_id'] = $request->project_id;
        $data['doctype'] = 'file';
        $data['memo'] = $request->memo;

        return $data;
    }
}
