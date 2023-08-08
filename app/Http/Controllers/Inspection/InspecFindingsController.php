<?php

namespace App\Http\Controllers\Inspection;

use App\Http\Controllers\Controller;
use App\Http\Helper\Helper;
use App\Models\Inspection\Inspection;
use App\Models\Project\ProjectFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InspecFindingsController extends Controller
{
    public function store(Request $request)
    {
        $inspec_report = new InspectionReportController();

        $data = $inspec_report->generate($request);

        $file_name = Helper::getFileNameFromFilePath($data['file_path']);

        $data['s3_path'] = ProjectFile::uploadToS3($file_name, $data['file_path']);

        //get mapped data
        $mappedData = $this->mapToArray($data);

        //Persist to database
        $response = ProjectFile::store($mappedData);

        return response()
            ->json(['error' => false,
                'title' => 'Inspection findings',
                'project_id' => $response['project_id'],
                'auth_code' => $response['auth_code'],
                'email' => $data['email'],
                'subject' => Helper::makeEmailSubject($data['projectname']),
                'message' => 'Inspection findings info saved successfully.']);


        try {

            $inspection_id = $request->inspection_id;
            $inspecFindingData = $request->except(['_token', 'violations']);
            $violations = $request->only('violations')['violations'] ?? null;


            $inspection_finding = Inspection::find($inspection_id)
                ->finding()
                ->updateOrCreate(['inspection_id' => $inspection_id], $inspecFindingData);


            //violations exists
            if ($violations !== null) {

                $violation_id = 1;

                foreach ($violations as $key => $violation) {

                    //save one row at a time until loop completes
                    $inspection_finding->violations()
                        ->updateOrCreate(['id' => $violation_id, 'inspec_findings_id' => $inspection_finding->id], $violations);

                    $violation_id++;
                }
            }


            return response()
                ->json(['error' => false,
                    'title' => 'Inspection findings',
                    'message' => 'Inspection findings info saved successfully.']);

        } catch (\Exception $exception) {

            Log::error($exception->getMessage());

            return response()->json(['error' => true, 'message' => 'something went wrong! Try again!']);
        }
    }

    /**
     * @param array $data
     * @return array
     */
    protected function mapToArray(array $data): array
    {
        return [
            'project_id' => $data['project_id'],
            'filename' => $data['filename'],
            'path' => $data['s3_path'],
            'auth_code' => $data['auth_code'],
            'doctype' => 'Site Inspection Report',
            'user_id' => Auth::user()->id
        ];

    }
}
