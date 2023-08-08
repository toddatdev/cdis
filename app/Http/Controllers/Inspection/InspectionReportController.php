<?php

namespace App\Http\Controllers\Inspection;

use App\Http\Controllers\Controller;
use App\Http\Helper\Helper;
use App\Libraries\Phpdocx\PhpDocX;
use App\Mail\RecipientActivated;
use App\Models\Document\Document;
use App\Models\Inspection\Inspection;
use App\Models\Project\Project;
use App\Models\Project\ProjectFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class InspectionReportController extends Controller
{

    //inspection report directory where they are stored after creation for download
    protected const INSPECTION_DIRECTORY = '/tmp/inspections/';

    //templates have placeholder variables
    protected const INSPECTIONS_TEMPLATE_DIRECTORY = 'storage/inspections/templates/';

    public function email(Request $request)
    {
        $data = $request->all();

        Mail::send('emails.inspection-report', $data, function ($message) use ($request) {

            $message->to($request->email)->subject($request->subject);
            $message->from('DoNotReply@conservationdistrict.us', 'Conservation District');

        });

        return response()
            ->json(['error' => false,
                'title' => 'Inspection Report',
                'message' => 'Inspection report has been emailed.']);
    }

    public function download($project_id, $auth_code)
    {

        $report = ProjectFile::where('project_id', $project_id)->where('auth_code', $auth_code)->first();

        if (!empty($report)) {
            return response()->redirectTo($report->path);
        }

        return abort(404);
    }

    protected function getInspectionTemplate()
    {
        $file_name = 'electronic_inspection_form.docx';

        return public_path(self::INSPECTIONS_TEMPLATE_DIRECTORY . $file_name);
    }

    public function generate(Request $request)
    {
        //get the template
        $template = $this->getInspectionTemplate();

        //instantiation of phpDocX library
        $docX = (new PhpDocX())->docX($template);

        //get template data
        $data = $this->getTemplateData($request);

        //fill the template with data
        $docX = $this->fillTemplateWithData($docX, $data);

        //clean unused variables
        // $docX = $this->cleanTemplateVariables($docX);

        $data['filename'] = Helper::slugify($data['projectname'] . '-' . time() . '_electronic_inspection_form') . '.docx';

        $data['auth_code'] = md5(time() . $data['project_id'] . Helper::slugify($data['projectname']));

        //if inspections directory doesn't exist create it.
        if (!File::exists(public_path(self::INSPECTION_DIRECTORY))) {
            File::makeDirectory(public_path(self::INSPECTION_DIRECTORY), 0777, true, true);
        }

        //complete file path with file name
        $data['file_path'] = public_path(self::INSPECTION_DIRECTORY) . $data['filename'];

        //create new file
        $docX->createDocx($data['file_path']);

        return $data;
    }

    public function getTemplateData($request)
    {
        //get all the project variables from database results
        return $this->getProjectVariables($request);

    }

    private function fillTemplateWithData($docX, array $variables)
    {

        $docX->setTemplateSymbol('@');

        $options = array('parseLineBreaks' => true);
        $docX->replaceVariableByText($variables, $options);
        $options = array('target' => 'header');
        $docX->replaceVariableByText($variables, $options);
        $options = array('target' => 'footer');
        $docX->replaceVariableByText($variables, $options);


        if ((int)$variables['violation_exists'] === 1) {

            $docX->tickCheckboxes(['violation_exists' => 1]);
        }


        $violations_list = [];

        if (!empty($variables['violations'])) {

            foreach ($variables['violations'] as $violation) {

                $violations_list[$violation] = 1;
            }

            $docX->tickCheckboxes($violations_list);
        }


        if (!empty($variables['permit_plan'])) {

            $permit_plan = json_decode($variables['permit_plan'], true);

            $requirements = [];

            foreach ($permit_plan as $key => $requirement) {

                if ((int)$requirement === 1) {

                    $requirements[$key] = 1;
                }

                if ((int)$requirement === 0) {

                    $key .= '_no';

                    $requirements[$key] = 1;
                }
            }

            $docX->tickCheckboxes($requirements);
        }

        if ((int)$variables['photos_taken'] === 1) {

            $docX->tickCheckboxes(['photos_taken_yes' => 1]);

        }
        if ((int)$variables['photos_taken'] === 0) {

            $docX->tickCheckboxes(['photos_taken_no' => 1]);
            $docX->tickCheckboxes(['photos_taken_no' => 1]);
        }

        $docX->tickCheckboxes([$variables['inspection_type'] => 1]);


        return $docX;
    }

    /**
     * @param $project
     * @return array
     */
    protected function getPermitteeVariables($project): array
    {
        $permittee_variables = [];

        if (empty($project->permitteeies)) {

            return $permittee_variables;
        }

        if (!empty($project->permitteeies)) {

            $i = 1;

            foreach ($project->permitteeies as $permittee) {

                $permittee = (object)$permittee;

                $permittee_variables['party' . $i . 'name'] = $permittee->co_permittee_name ?? '';
                $permittee_variables['party' . $i . 'address'] = $permittee->co_permittee_address_1 ?? '';

                $permittee_variables['party' . $i . 'state'] = $permittee->co_permittee_city ?? '' . ', ' .
                    $permittee->co_permittee_state ?? '' . ', ' .
                    $permittee->co_permittee_zip ?? '';

                $permittee_variables['party' . $i . 'area'] = Helper::getAreaCode($permittee->co_permittee_phone ?? '');
                $permittee_variables['party' . $i . 'phone'] = Helper::getPhoneWithoutAreaCode($permittee->co_permittee_phone ?? '');

                $i++;
            }
        }

        return $permittee_variables;
    }

    /**
     * @param $request
     * @param $inspection
     * @param $project
     * @return array
     */
    protected function getProjectVariables($request)
    {
        //get project data by id
        $project = (object)Project::getProjectDataForInspection($request->project_id);

        //get inspection information by inspection id
        $inspection = Inspection::where('id', $request->inspection_id)->with(['permitPlan', 'finding'])->get();


        //get all the permittee variables from database results
        $permittee_variables = $this->getPermitteeVariables($project);

        $project_variables = [
            'project_id' => $request->project_id,
            'email' => $request->email,
            'doctype' => 'Site Inspection Report',
            'violation_exists' => $request->violation_exists,
            'other_value' => $inspection[0]->other_value,
            'photos_taken' => $inspection[0]->photos_taken,
            'inspection_type' => $inspection[0]->inspection_type,
            'reportnum' => $inspection[0]->report_number ?? '',
            'projectname' => $inspection[0]->project_name ?? '',
            'inspdate' => sqlToHtmlDate($inspection[0]->inspection_date ?? ''),
            'insptime' => $inspection[0]->inspection_time ?? '',
            'weather' => $inspection[0]->weather ?? '',
            'repname' => $inspection[0]->site_rep ?? '',
            'reptitle' => $inspection[0]->site_rep_title ?? '',
            'inspname' => $inspection[0]->site_insp ?? '',
            'insptitle' => $inspection[0]->site_insp_title ?? '',
            'inspector' => $inspection[0]->site_insp ?? '',
            'taxparcel' => $inspection[0]->tax_parcel_number ?? '',
            'descriptionsobservations' => $inspection[0]->site_description ?? '',
            'obscontinue' => $inspection[0]->site_description ?? '',
            'projectarea' => $project->total_acres ?? '',
            'disturbed' => $project->disturbed_acres ?? '',
            'location' => $project->project_location ?? '',
            'municipality' => $project->municipality ?? '',
            'countyfax' => $project->county_fax ?? '',
            'countyphone' => $project->county_phone ?? '',
            'countyaddress' => $project->county_address ?? '',
            'permitnum' => $project->npdes_number ?? '',
            'waters' => $project->watershed ?? '',
            'designateduse' => $inspection[0]->designated ?? '',
            'followup' => sqlToHtmlDate($request->fui_date ?? ''),
            'filed' => sqlToHtmlDate($request->date ?? ''),
            'assistance' => $request->cam ?? '',
            'permit_plan' => $inspection[0]->permitPlan ?? '',
            'violations' => $request->violations,

            'exp' => sqlToHtmlDate($project->permit_expiration_date ?? ''),
            'county' => ucfirst(session('county')),
            'district' => ucfirst(session('district'))
        ];

        return array_merge($permittee_variables, $project_variables);
    }

    /*
     *
     *clear all the placeholder variables
     * */
    protected function cleanTemplateVariables($template)
    {
        $variables = $template->getTemplateVariables();

        $header_variables_array = $variables['header'] ?? array();
        $document_variables_array = $variables['document'] ?? array();

        $variables = array_merge($header_variables_array, $document_variables_array);

        foreach ($variables as $variable) {

            $template->removeTemplateVariable($variable, ['document', 'header', 'footer']);

        }

        return $template;
    }


}
