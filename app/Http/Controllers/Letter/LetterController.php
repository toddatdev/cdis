<?php

namespace App\Http\Controllers\Letter;

use App\Http\Controllers\Controller;
use App\Http\Helper\Helper;
use App\Libraries\Phpdocx\PhpDocX;
use App\Models\Project\Project;
use App\Models\Project\ProjectFile;
use App\Models\Reviewer\Reviewer;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use WordFragment;

class LetterController extends Controller
{

    //letters directory where they are stored after creation for download
    protected const LETTERS_DIRECTORY = '/tmp/letters/';

    //templates have placeholder variables
    protected const LETTERS_TEMPLATE_DIRECTORY = 'storage/letters/templates/';


    public function index($project_id = -1)
    {
        if ($project_id === -1) {

            return view('search-projects')
                ->with('message', 'You should search the project first in order to generate a letter.');
        }

        return view('generate-letters', compact('project_id'));
    }

    public function download($project_id, $auth_code)
    {
        $letter = ProjectFile::where('project_id', $project_id)->where('auth_code', $auth_code)->first();

        if (!empty($letter)) {
            return response()->redirectTo($letter->path);
        }

        return abort(404);
    }

    protected function getLetterTemplate($type)
    {
        return public_path(self::LETTERS_TEMPLATE_DIRECTORY . $type . '.docx');
    }

    /**
     * @param Request $request
     * @return string
     * @description Generates a word document with the given data
     */
    public function generate(Request $request)
    {
        //get the template by letter type
        $template = $this->getLetterTemplate($request->letter_type);

        //instantiation of phpDocX library
        $docX = (new PhpDocX())->docX($template);

        //get template data
        $data = $this->getTemplateData($request);

//        Log::info('Data', $data);
        //fill the template with data
        $docX = $this->fillTemplateWithData($docX, $data);

        //clean unused variables
        $docX = $this->cleanTemplateVariables($docX);

        $file_name = str_slug($request->letter_type) . '.docx';

        //if letter directory doesn't exist create it.
        if (!File::exists(public_path(self::LETTERS_DIRECTORY))) {
            File::makeDirectory(public_path(self::LETTERS_DIRECTORY), 0777, true, true);
        }

        //complete file path with file name
        $file_path = public_path(self::LETTERS_DIRECTORY) . DIRECTORY_SEPARATOR . $file_name;

        //create new file
        $docX->createDocx($file_path);

        //upload letters to s3
        $is_uploaded = ProjectFile::uploadToS3($file_name, $file_path);

        if (!$is_uploaded) {

            return response()->json(['error' => true,
                'title' => 'Letter Upload Error!',
                'message' => 'There was an error while uploading. Try again!']);
        }

        //get mapped data
        $data = $this->mapToArray($request, $file_name);

        //persist to database
        $response = ProjectFile::store($data);

        return route('letters.download', [$response['project_id'], $response['auth_code']]);
    }

    /*
     *
     *replace the variables with the given data
     * */
    protected function fillTemplateWithData($template, $data)
    {
        //header image path based on logged in county
        $header_img_path = public_path('img/letters/' . strtolower(session('county')) . '-header.png');

        //replace the header image with according to county
        $template->replacePlaceholderImage('HEADER', $header_img_path);

        //path has the signature image
        if (isset($data['path']) && $data['path'] !== 'storage/signatures/') {

            $template->replacePlaceholderImage('SIGNATURE', $data['path']);

        }

        //check options of admin incomplete GS
        if (!empty($data['options'])) {
//            $loptions = [];
//            foreach ($data['options'] as $option) {
//                if (is_array($option)) {
//                    $lopt = new WordFragment($template, 'document');
//                    $lopt->addList($option, 0, ['font' => 'Times New Roman', 'fontSize' => 12]);
//                    $loptions[][] = $lopt;
//                    $loptions[][] = $option;
//
//                } else {
//                    $loptions[] = $option;
//                }
//            }

            $list = new WordFragment($template, 'document');

            if (in_array($data['letter_type'], ['general_permit_incompleteness', 'admin_incompleteness_letter_for_individual_permit', 'admin_incompleteness_letter_for_general_permit'])) {
//                $list->addList($data['options'], 0, ['font' => 'Times New Roman', 'fontSize' => 12, 'useWordFragmentStyles' => true]);
//                $template->replaceVariableByWordFragment(array('options_items' => $list));
//                $template->replaceVariableByHTML('options_items', 'block', $data['options_items']);
            } else {
                $list->addList($data['options'], 3, ['font' => 'Times New Roman', 'fontSize' => 12]);
                $template->replaceVariableByWordFragment(array('resubmittal' => $list));
            }
        }

        //checkbox for es-permit-rec-for-permit-action letter
        if ($data['recommended'] === 'yes') {

            $template->tickCheckboxes(['approve' => 1]);

        } else if ($data['recommended'] === 'no') {

            $template->tickCheckboxes(['deny' => 1]);
        }

        $opt = array('parseLineBreaks' => true);

        //removes empty data from array
        $clean_data = array_filter($data, function ($value) {
            return $value !== null && $value !== '';
        });

//        return $clean_data;

        $template->replaceVariableByText($clean_data, $opt);
        $template->replaceVariableByText($clean_data, ['target' => 'header']);

        return $template;
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
//        $variables = array_merge($header_variables_array);

        foreach ($variables as $variable) {

            $template->removeTemplateVariable($variable, 'inline');

        }
        return $template;
    }

    protected function getTemplateData($request)
    {
        //get the project id from hidden input
        $project_id = $request->project_id;

        $form_data = $request->except(['_token', 'memo', 'reviewer', 'project_id']);

        //get reviewer by selected reviewer id
        $reviewer = Reviewer::getReviewerById($request->reviewer);

        $db_data = Project::getLettersData($project_id);

        $db_data = array_merge($db_data, $reviewer);

        //add today date to form data
        $form_data['date'] = date('m/d/Y');

        if ($request->letter_type === 'adequate_indiv_npdes_authorization') {

            $form_data['permit_expiration_date'] = Helper::sqlToHtmlDate($db_data['permit_expiration_date']);

        }
        if ($request->letter_type === 'compliance_notice') {

            //data manipulation for compliance notice letter
            $form_data['compliance_notice'] =
                str_replace('00/00/00', $db_data['final_inspection_date'], $request->compliance_notice);
            $form_data['es_plan_request'] =
                str_replace('00/00/00', $db_data['final_inspection_date'], $request->es_plan_request);


        } elseif ($request->letter_type === 'copermitee_form_incomplete') {

            $deficiencies = '';

            if (!empty($request->deficiencies)) {

                //data manipulation for co permittee form incomplete
                foreach ($request->deficiencies as $deficiency) {

                    $deficiencies .= PHP_EOL . $deficiency;

                }

                $form_data['deficiencies'] = $deficiencies;
            }
        } elseif ($request->letter_type === 'es_permit_recommendation_for_permit_action' ||

            $request->letter_type === 'not_approval' ||
            $request->letter_type === 'not_partial') {

            //format the incoming html date
            $form_data['permit_processed_date'] = (new DateTime($request->permit_processed_date))->format('m/d/Y');
            $form_data['inspection_date'] = (new DateTime($request->inspection_date))->format('m/d/Y');

        } elseif ($request->letter_type === 'es_permit_technical_deficiency') {

            $reg = 'DEP REGIONAL OFFICE ADDRESS';
            $dist = 'DISTRICT MAILING ADDRESS';

            //find $reg and $dist value found in the pcm checkbox and replace with the given input values
            $form_data['pcsm_level'] = str_replace(array($reg, $dist),
                array($request->regional_mailing_address, $request->district_mailing_address), $request->pcsm_level);

            $form_data['deporcd'] = 'Conservation District';
            $form_data['dateplus60'] = Carbon::now()->addDays(60)->format('m/d/Y');

            if (!empty($request->deficiencies)) {

                //data manipulation for co permittee form incomplete
                $form_data['deficiencies'] = implode('\r\n', $request->deficiencies);
            }

        } elseif ($request->letter_type === 'inadequate_es') {

            if (!empty($request->requested)) {

                $form_data['requested'] = implode('\r\n', $request->requested);
            }

        } elseif ($request->letter_type === 'adequate_with_comments') {

            $form_data['district_state'] = 'PA';

            if (!empty($request->requested)) {

                $form_data['requested'] = implode('\r\n\r\n', $request->requested);
            }

            if ((int)$db_data['disturbed_acres'] < 1) {
                $form_data['npdes_required'] = '*PROPOSED DISTURBANCE IS AT ' . $db_data['disturbed_acres'] . ' ACRES, IF DISTURBANCE EXCEEDS 1.0 ACRES AN NPDES PERMIT WILL BE REQUIRED*';
            }
        } elseif ($request->letter_type === 'admin_incomplete_mccd' || $request->letter_type === 'admin_incomplete_bccd') {

            $form_data['dateplus60'] = Carbon::now()->addDays(60)->format('m/d/Y');

        } elseif ($request->letter_type === 'extension') {

            //search the string and replace the due date
            $search = 'duedateduedate';
            $due_date = (new DateTime($request->due_date))->format('m/d/Y');
            $form_data['extension_status'] = str_replace($search, $due_date, $request->extension_status);
            $form_data['deficiencies'] = implode('\r\n', $request->options);


        } elseif ($request->letter_type === 'denial_permit') {

            $form_data['deficiencies'] = implode('\r\n', $request->options);

        } elseif ($request->letter_type === 'not_denial') {

            $form_data['paragraphs'] = implode('\r\n', $request->requested);

        } elseif ($request->letter_type === 'inadequate_npdes') {

            $form_data['deficiencies'] = implode('\r\n\r\n', $request->deficiencies);

        } elseif ($request->letter_type === 'general_permit_incompleteness') {

//            if (!empty($request->requested)) {
//
//                $form_data['requested'] = $request->requested;//implode('\r\n', $request->requested);
//            }

            $form_data = array_merge($form_data, $reviewer);
            $form_data['dateplus60'] = Carbon::now()->addDays(60)->format('m/d/Y');

        } elseif ($request->letter_type === 'admin_incompleteness_letter_for_general_permit') {

            if ($request->pag0 !== '' && $request->pag0 !== null) {

                $form_data['pag0v'] = 'Please be advised that no extensions will be granted beyond the 60 calendar-day period to make a PAG-01 NOI complete.';
            }

            $options = [];

//            if (is_array($request->input('options'))){
//                $options[] = '<ol style="list-style-type: none; padding-left: 10px;">';
//                $total = count($request->input('options')) - 1 ;
//                foreach ($request->input('options') as $key => $option) {
//
//                    if (is_array($option)) {
//
//                        if ($total != $key && is_array($request->input('options')[$key + 1])) {
//                            $options[] = '<ol style="list-style-type: none; padding-left: 20px;">';
//                        }
//
//                        foreach ($option as $sop) {
//                            $options[] = "<li>" . $sop . "</li>";
//                        }
//
//                        if ($total != $key && !is_array($request->input('options')[$key + 1])) {
//                            $options[] = '</ol></li><br/><br/>';
//                        }
//
//
//                    } else {
//                        $op = '<li>' . $option;
//
//                        if ($total != $key && !is_array($request->input('options')[$key + 1])) {
//                            $op .= '</li><br/>';
//                        }
//
//                        $options[] = $op;
//                    }
//                }
//                $options[] = '</ol>';
//
//                $form_data['options_items'] = implode("", $options);
//            }

            if (is_array($request->input('options'))){
                foreach ($request->input('options') as $option) {
                    if (is_array($option)) {
                        foreach ($option as $sop) {
                            $options[] = "    " . $sop;
                        }
                    } else {
                        $options[] = $option;
                    }
                }

                $form_data['options_items'] = implode('\r\n', $options);
            }

            $form_data['dateplus60'] = Carbon::now()->addDays(60)->format('m/d/Y');

        } elseif ($request->letter_type === 'admin_incompleteness_letter_for_individual_permit') {
            $options = [];

            if (is_array($request->input('options'))){
                foreach ($request->input('options') as $option) {
                    if (is_array($option)) {
                        foreach ($option as $sop) {
                            $options[] = "    " . $sop;
                        }
                    } else {
                        $options[] = $option;
                    }
                }

                $form_data['options_items'] = implode('\r\n', $options);
            }
            $form_data['dateplus60'] = Carbon::now()->addDays(60)->format('m/d/Y');
        }

        return array_merge($db_data, $form_data);
    }


    protected function mapToArray(Request $request, string $file_name)
    {
        //map data to documents table
        $data['filename'] = $file_name;
        $data['path'] = ProjectFile::getUploadedPath($file_name);
        $data['user_id'] = Auth::user()->id;
        $data['auth_code'] = md5(time() . $request->project_id . Helper::slugify($file_name));
        $data['project_id'] = $request->project_id;
        $data['doctype'] = 'Letter';
        $data['memo'] = $request->memo;

        return $data;

    }
}
