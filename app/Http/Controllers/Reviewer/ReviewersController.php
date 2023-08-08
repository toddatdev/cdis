<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use App\Http\Helper\Helper;
use App\Models\Reviewer\Reviewer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ReviewersController extends Controller
{

    public function index()
    {
        return view('admin.reviewer-signatures');
    }

    public function show($id)
    {
        $file_name = Reviewer::where('id', $id)->first()->path;

        return response()
            ->json([
                'error' => false,
                'path' => asset($file_name)
            ]);
    }

    public function uploadSignature(Request $request, $id)
    {
        //find the selected user by id
        $reviewer = Reviewer::where('id', $id)->first();

        $old_file = public_path($reviewer->path);;

        //if already has a signature remove that png file
        if (File::exists($old_file)) {

            File::delete($old_file);
        }

        $extension = $request->file('file')->getClientOriginalExtension();

        $name = 'sig_' . time() . '.' . $extension;
        $path = 'signatures/' . $name;

        // storing image in storage/app/public Folder
        Storage::disk('public')->put($path, file_get_contents($request->file('file')));

        //saves the path of reviewer uploaded image
        $reviewer->path = $name;

        //save the reviewer
        $reviewer->save();

        return response()
            ->json(['error' => false,
                'path' => asset('storage/signatures/' . $name),
                'title' => 'Signature uploaded!',
                'message' => 'Your signature has been uploaded.']);

    }


    public function updateSignature(Request $request)
    {

        //get reviewer id from user input
        $reviewer_id = $request->reviewer_id;

        //find the selected user by id
        $reviewer = Reviewer::where('id', $reviewer_id)->first();

        $old_file = $reviewer->path;

        //if already has a signature remove that png file
        if (File::exists($old_file)) {

            File::delete($old_file);
        }

        //get signature base 64 string from input
        $signature_base64 = $request->input('signature');

        //convert to image/png and returns $name of image
        $file_name = Helper::base64_to_image($signature_base64);

        $reviewer->path = $file_name;

        //save the reviewer
        $reviewer->save();

        return response()
            ->json(['error' => false,
                'path' => asset('storage/signatures/' . $file_name),
                'title' => 'Signature updated!',
                'message' => 'Your signature has been updated.']);
    }
}
