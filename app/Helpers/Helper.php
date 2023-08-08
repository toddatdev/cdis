<?php

namespace App\Http\Helper;

use App\Models\Project\ProjectPermittee;
use App\Models\Project\ProjectTime;
use App\Models\Transaction\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class Helper
{
    public static function get_plan_type_opts(): array
    {
        return [
            'individual' => 'Individual',
            'general' => 'General',
            'nonpermitted' => 'Non-Permitted/E&S Plan',
            'inspection' => 'Blank/Inspection Only Plan',
            'project_application' => 'Project Application',
        ];
    }


    public static function slugify($text)
    {

        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        //replace space by -
        $text = str_replace(' ', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;

    }

    public static function htmlToSQLDate($htmlDate)
    {

        if ($htmlDate === null || $htmlDate === 'null' || empty($sqlDate)) {

            return null;
        }

        return (new Carbon($htmlDate))->format('Y-m-d');
    }

    public static function getAreaCode($phone)
    {

        //separates area code from phone and removes brackets and dashes
        $line = preg_replace('/\D/', '', $phone);

        $area_code = '';

        if ($line !== '') {
            $area_code = '(' . substr($line, 0, -7) . ')';
        }

        return $area_code;
    }

    public static function getPhoneWithoutAreaCode($phone)
    {

        //separates area code from phone and removes brackets and dashes
        $line = preg_replace('/\D/', '', $phone);

        $phone = substr($line, 3, 7);

        return $phone;

    }


    public static function sqlToHtmlDate($sqlDate)
    {
        if ($sqlDate === null || $sqlDate === 'null' || empty($sqlDate)) {
            return '';
        }

        try {
            return Carbon::parse($sqlDate)->format('m/d/Y');
        }catch(\Exception $e) {
            return $sqlDate;
        }
    }

    public static function get_fee_type_options()
    {
        return [
            'dist_fee' => 'District Fee',
            'tbd_fee' => 'TBD Fee',
            'cwf_fee' => 'CWF Fee',
            'exp_fee' => 'Expedite Fee',
        ];
    }

    public static function get_admin_status_options()
    {
        return [
            'complete' => 'Complete',
            'incomplete' => 'Incomplete',
            'no comment' => 'No Comment',
            'withdrawn' => 'Withdrawn'
        ];

    }


    public static function get_tech_status_options()
    {
        return [
            'adequate' => 'Adequate',
            'inadequate' => 'InAdequate'
        ];
    }

    public
    static function get_time_categories_options()
    {
        return array(
            '' => 'Select One',
            'Initial Plan Received' => 'Initial Plan Received',
            'Plan Review Meeting' => 'Plan Review Meeting',
            'Pre-Construction Meeting' => 'Pre-Construction Meeting',
            'Initial Site Inspection' => 'Initial Site Inspection',
            'Complaint Investigation' => 'Complaint Investigation',
            'Enforcement Meeting' => 'Enforcement Meeting',
            'Notice Of Termination' => 'Notice Of Termination',
            'Right To Know Database Search' => 'Right To Know Database Search
                                        ',
            'Right To Know Meeting' => 'Right To Know Meeting',
            'NPDES Review' => 'NPDES Review',
            'E & S Review' => 'E & S Review',
            'Admin Review' => 'Admin Review',
            'Date Stamp & Data Entry' => 'Date Stamp & Data Entry',
            'Enforcement Referral' => 'Enforcement Referral',
            'Co-Permittee Application Entry' => 'Co-Permittee Application Entry
                                        ',
            'Transferee Application Entry' => 'Transferee Application Entry
                                        ',
            'N.O.T.-Data Entry' => 'N.O.T.-Data Entry',
            'Copy Letters, Mailings  & File Project' => 'Copy Letters,
                                            Mailings
                                            & File Project
                                        ',
            'Admin Meeting' => 'Admin Meeting',
            'Final Site Inspection' => 'Final Site Inspection',
            'Pre-Application Meeting' => 'Pre-Application Meeting',
            'Major Modification' => 'Major Modification',
            'Minor Revision' => 'Minor Revision',
            'Returned Check' => 'Returned Check',
            'Sort Checks And Mail Bills' => 'Sort Checks And Mail Bills',
            'Acknowledge Transfer' => 'Acknowledge Transfer',
            'Inadequate Review Meeting' => 'Inadequate Review Meeting',
        );
    }

    public
    static function get_states_options()
    {
        return [
            'AL' => 'Alabama',
            'AK' => 'Alaska',
            'AZ' => 'Arizona',
            'AR' => 'Arkansas',
            'CA' => 'California',
            'CO' => 'Colorado',
            'CT' => 'Connecticut',
            'DE' => 'Delaware',
            'DC' => 'District of Columbia',
            'FL' => 'Florida',
            'GA' => 'Georgia',
            'HI' => 'Hawaii',
            'ID' => 'Idaho',
            'IL' => 'Illinois',
            'IN' => 'Indiana',
            'IA' => 'Iowa',
            'KS' => 'Kansas',
            'KY' => 'Kentucky',
            'LA' => 'Louisiana',
            'ME' => 'Maine',
            'MD' => 'Maryland',
            'MA' => 'Massachusetts',
            'MI' => 'Michigan',
            'MN' => 'Minnesota',
            'MS' => 'Mississippi',
            'MO' => 'Missouri',
            'MT' => 'Montana',
            'NE' => 'Nebraska',
            'NV' => 'Nevada',
            'NH' => 'New Hampshire',
            'NJ' => 'New Jersey',
            'NM' => 'New Mexico',
            'NY' => 'New York',
            'NC' => 'North Carolina',
            'ND' => 'North Dakota',
            'OH' => 'Ohio',
            'OK' => 'Oklahoma',
            'OR' => 'Oregon',
            'PA' => 'Pennsylvania',
            'RI' => 'Rhode Island',
            'SC' => 'South Carolina',
            'SD' => 'South Dakota',
            'TN' => 'Tennessee',
            'TX' => 'Texas',
            'UT' => 'Utah',
            'VT' => 'Vermont',
            'VA' => 'Virginia',
            'WA' => 'Washington',
            'WV' => 'West Virginia',
            'WI' => 'Wisconsin',
            'WY' => 'Wyoming'
        ];
    }

    public
    static function get_ownership_opts()
    {
        return [
            'CNG' => 'County Government',
            'COR' => 'Corporation',
            'CTG' => 'Municipality',
            'DIS' => 'District',
            'FDF' => 'Federal Facility (U.S. Government) ',
            'GOC' => 'GOCO (Gov Owned/Contractor Operated)',
            'IND' => 'Individual',
            'MWD' => 'Municipal or Water District',
            'MXO' => 'Mixed Ownership (e.g., Public/Private)',
            'NON' => 'Non Government',
            'POF' => 'Privately Owned Facility',
            'SDT' => 'School District',
            'STF' => 'State Government',
            'TRB' => 'Tribal Government',
            'UNK' => 'Unknown',
        ];

    }

    public
    static function prepare_options_html($options, $selected)
    {
        $select_options = [];

        foreach ($options as $key => $type) {
            if ($selected === $key) {
                $select_options[] .= "<option value='{$key}' selected >{ $type }</option >";
            } else {
                $select_options[] .= "<option value='{$key}' > { $type} }</option >";
            }
        }
        return $select_options;
    }

    public
    static function base64_to_image($base64_string)
    {
        if (empty($base64_string)) {
            return '';
        }

        $name = 'sig_' . time() . '.png';
        $path = 'signatures/' . $name;

        @list(, $file_data) = explode(',', $base64_string);

        if ($file_data !== '') {

            // storing image in storage/app/public Folder
            Storage::disk('public')->put($path, base64_decode($file_data));
        }

        return $name;
    }

    /**
     * @param string $format d/m/Y
     * @param $date  d/m/Y
     * @return string
     */
    public
    static function toSQLDate($date): string
    {
        return Carbon::createFromFormat('m/d/Y', $date)->format('Y-m-d');
    }

    public
    static function replaceUnderscoreWithDash($string)
    {
        return str_replace('_', '-', $string);
    }

    public
    static function getFileNameFromFilePath(string $file_path)
    {
        $path_parts = explode('/', $file_path);

        return end($path_parts);
    }

    public
    static function makeEmailSubject($projectname)
    {
        return ucfirst(session('county')) . ' County Conservation District Site Inspection Report for ' .
            ucwords(str_replace('-', ' ', self::slugify($projectname)));
    }

    public
    static function makeFileName($file)
    {
        return time() . '__' . $file->getClientOriginalName();
    }

    public
    function getCoordinates(Request $request)
    {
        $latdeg = $request->latdeg;
        $latmin = $request->latmin;
        $latsec = $request->latsec;
        $lngdeg = $request->lngdeg;
        $lngmin = $request->lngmin;
        $lngsec = $request->lngsec;
        return response()->json(
            $this->degToDec(
                $latdeg,
                $latmin,
                $latsec,
                $lngdeg,
                $lngmin,
                $lngsec
            )
        );
    }

    function degToDec($lat_deg, $lat_min, $lat_sec, $lng_deg, $lng_min, $lng_sec)
    {
        return array(
            "latitude" => $lat_deg + ((($lat_min * 60) + ($lat_sec)) / 3600),
            "longitude" => ($lng_deg + ((($lng_min * 60) + ($lng_sec)) / 3600)) * -1 // * -1 because this is always W in the US.
        );
    }


    protected
    static function isAdmin($isAdmin)
    {
        return $isAdmin ? "<span class='fa fa-check text-navy'></span>" : "<span class='fa fa-times text-danger'></span>";
    }


    public
    static function loadTimeTrackingDetails($project_id)
    {
        $recordedTimes = ProjectTime::getRecordedTimeByProjectId($project_id);

        if (empty(count($recordedTimes))) {
            return '<h3 class="text-center">No time recorded for this project.</h3>';
        }

        $resubmitRows = '';
        $totalResubmitHours = 0;
        $newRows = '';
        $totalNewHours = 0;

        //new or resubmit
        $mixRows = '';
        $totalMixHours = 0;

        foreach ($recordedTimes as $recordedTime) {

            $technician_name = $recordedTime->technician->name ?? '';

            if ($recordedTime->submit_type === 'R') {

                $totalResubmitHours += (float)$recordedTime->hours;

                $resubmitRows .= '<tr>
                                        <td>' . $technician_name . '</td>
                                        <td>' . self::sqlToHtmlDate($recordedTime->entered_date) . '</td>
                                        <td class="text-center hrs resubmit-hrs">' . $recordedTime->hours . '</td>
                                        <td>' . $recordedTime->time_category . '</td>
                                        <td class="text-center">
                                            <a href="#"  style="font-size: 1.3em;" class="text-navy btn-edit-time" data-id="' . $recordedTime->id . '" ><i class="fa fa-edit"></i></a>
                                            <a href="#"  style="font-size: 1.3em;" class="text-danger btn-delete-time" data-id="' . $recordedTime->id . '" ><i class="fa fa-times"></i></a>


                                        </td>
                                    </tr>';
            }

            if ($recordedTime->submit_type === 'N') {

                $totalNewHours += (float)$recordedTime->hours;

                $newRows .= '<tr>
                                        <td>' . $technician_name . '</td>
                                        <td>' . self::sqlToHtmlDate($recordedTime->entered_date) . '</td>
                                        <td class="text-center hrs new-hrs">' . $recordedTime->hours . '</td>
                                        <td >' . $recordedTime->time_category . '</td>
                                        <td class="text-center project-details ">
                                                                        <a href="#"  style="font-size: 1.3em;" class="text-navy btn-edit-time" data-id="' . $recordedTime->id . '" ><i class="fa fa-edit"></i></a>
                                            <a href="#"  style="font-size: 1.3em;" class="text-danger btn-delete-time" data-id="' . $recordedTime->id . '" ><i class="fa fa-times"></i></a>
                                        </td>
                                    </tr>';
            }


            if ($recordedTime->submit_type === '') {

                $totalMixHours += (float)$recordedTime->hours;

                $mixRows .= '<tr>
                                        <td>' . $technician_name . '</td>
                                        <td>' . self::sqlToHtmlDate($recordedTime->entered_date) . '</td>
                                        <td class="text-center hrs resubmit-hrs">' . $recordedTime->hours . '</td>
                                        <td>' . $recordedTime->time_category . '</td>
                                        <td class="text-center">
                                            <a href="#"  style="font-size: 1.3em;" class="text-navy btn-edit-time" data-id="' . $recordedTime->id . '" ><i class="fa fa-edit"></i></a>
                                            <a href="#"  style="font-size: 1.3em;" class="text-danger btn-delete-time" data-id="' . $recordedTime->id . '" ><i class="fa fa-times"></i></a>


                                        </td>
                                    </tr>';
            }
        }

        $timeTables = '<div class="row">

                                <div class="col-md-12">
                                    <h3>Time Recorded for Project: &nbsp;(' . $recordedTime->project->name . ')</h3>
                                </div>

                            <div class="col-md-12">
                                <h3>Time Recorded for: N</h3>
                                <table class="table table-bordered" id="table-new-time-record">
                                    <thead>
                                    <tr>
                                        <th class="text-center bg-primary">Technician</th>
                                        <th class="text-center bg-primary">Date</th>
                                        <th class="text-center bg-primary">Hours</th>
                                        <th class="bg-primary">Time Category</th>
                                     <th class="text-center bg-primary ">Actions</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                        ' . $newRows . '
                                    <tr>
                                        <td colspan="5">
                                            <h4>Total Time for N = <span id="total-new-hrs">' . $totalNewHours . '</span> hours</h4>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <hr class="hr-line-dashed mb-2">
                            </div>
                            <div class="col-md-12">
                                <h3>Time Recorded for: R</h3>
                                <table class="table table-bordered" id="table-resubmit-time-record">
                                    <thead>
                                    <tr>
                                        <th class="text-center bg-primary">Technician</th>
                                        <th class="text-center bg-primary">Date</th>
                                        <th class="text-center bg-primary">Hours</th>
                                        <th class="bg-primary">Time Category</th>

                                         <th class="text-center bg-primary ">Actions</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    ' . $resubmitRows . '
                                    <tr>
                                        <td colspan="5">
                                            <h4>Total Time for R = <span id="total-resubmit-hrs">' . $totalResubmitHours . '</span> hours</h4>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <hr class="hr-line-dashed mb-2">
                            </div>

                            <div class="col-md-12">
                                <h3>Time Recorded for: N or R</h3>
                                <table class="table table-bordered" id="table-resubmit-time-record">
                                    <thead>
                                    <tr>
                                        <th class="text-center bg-primary">Technician</th>
                                        <th class="text-center bg-primary">Date</th>
                                        <th class="text-center bg-primary">Hours</th>
                                        <th class="bg-primary">Time Category</th>

                                         <th class="text-center bg-primary ">Actions</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    ' . $mixRows . '
                                    <tr>
                                        <td colspan="5">
                                            <h4>Total Time for N or R = <span id="total-resubmit-hrs">' . $totalMixHours . '</span> hours</h4>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr class="hr-line-dashed">
                                <h4 class="text-center">Grand Total Time: <span id="total-hrs">' . ($totalNewHours + $totalResubmitHours + $totalMixHours) . '</h4>
                                <hr class="hr-line-dashed">
                            </div>
                        </div>';


        return $timeTables;
    }


//only for time trakcing reports use
    public
    static function loadTimeTrackingDetailsForReport($project_id)
    {
        $recordedTimes = ProjectTime::getRecordedTimeByProjectId($project_id);

        $resubmitRows = '';
        $totalResubmitHours = 0;
        $newRows = '';
        $totalNewHours = 0;

        //new or resubmit
        $mixRows = '';
        $totalMixHours = 0;

        foreach ($recordedTimes as $recordedTime) {

            $technician_name = $recordedTime->technician->name ?? '';

            if ($recordedTime->submit_type === 'R') {

                $totalResubmitHours += (float)$recordedTime->hours;

                $resubmitRows .= '<tr>
                                        <td>' . $technician_name . '</td>
                                        <td>' . self::sqlToHtmlDate($recordedTime->entered_date) . '</td>
                                        <td class="text-center hrs resubmit-hrs">' . $recordedTime->hours . '</td>
                                        <td>' . str_replace('&', ' and ', $recordedTime->time_category) . '</td>

                                    </tr>';
            }

            if ($recordedTime->submit_type === 'N') {

                $totalNewHours += (float)$recordedTime->hours;

                $newRows .= '<tr>
                                        <td>' . $technician_name . '</td>
                                        <td>' . self::sqlToHtmlDate($recordedTime->entered_date) . '</td>
                                        <td class="text-center hrs new-hrs">' . $recordedTime->hours . '</td>
                                        <td >' . str_replace('&', ' and ', $recordedTime->time_category) . '</td>

                                    </tr>';
            }

            if ($recordedTime->submit_type === '') {

                $totalMixHours += (float)$recordedTime->hours;

                $mixRows .= '<tr>
                                        <td>' . $technician_name . '</td>
                                        <td>' . self::sqlToHtmlDate($recordedTime->entered_date) . '</td>
                                        <td class="text-center hrs resubmit-hrs">' . $recordedTime->hours . '</td>
                                        <td>' . str_replace('&', ' and ', $recordedTime->time_category) . '</td>
                                        <td class="text-center">   </td>
                                    </tr>';
            }
        }

        $timeTables = '<h3>Time Recorded for Project: (' . $recordedTime->project->name . ')</h3>
                                    <br>
                                <h3 >Time Recorded for: N</h3>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th  >Technician</th>
                                        <th  >Date</th>
                                        <th class="text-center " >Hours</th>
                                        <th  >Time Category</th>
                                     </tr>
                                    </thead>
                                    <tbody>
                                        ' . $newRows . '
                                    <tr>
                                        <td colspan="4" >
                                            <h4>Total Time for N = <span id="total-new-hrs">' . $totalNewHours . '</span> hours</h4>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                <h3  >Time Recorded for: R</h3>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th >Technician</th>
                                        <th >Date</th>
                                        <th  class="text-center ">Hours</th>
                                        <th >Time Category</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    ' . $resubmitRows . '
                                    <tr>
                                        <td colspan="4" >
                                            <h4>Total Time for R = ' . $totalResubmitHours . ' hours</h4>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>


                                 <h3 >Time Recorded for: N or R</h3>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th  >Technician</th>
                                        <th  >Date</th>
                                        <th  class="text-center " >Hours</th>
                                        <th  >Time Category</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    ' . $mixRows . '
                                    <tr>
                                        <td colspan="4" >
                                            <h4>Total Time for N or R = ' . $totalMixHours . ' hours</h4>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                      <h4 class="text-center" >Grand Total Time: ' . ($totalNewHours + $totalResubmitHours + $totalMixHours) . '</h4>';

        return $timeTables;
    }


    public
    static function loadPermittees($project_id)
    {
        $permitttees = ProjectPermittee::getPermitteeByProjectId($project_id);

        $tab = '<div class="tabs-container">
                              <ul class="nav nav-tabs">';

        $permittees_count = count($permitttees);


        if ($permittees_count <= 0) {

            return null;

        }

        if (!empty($permittees_count)) {


            for ($i = 1; $i <= $permittees_count; $i++) {

                $isActive = ($i === 1) ? 'active' : '';

                $tab .= '<li ><a class="nav-link ' . $isActive . '" data-toggle="tab" href="#tab-' . $i . '" ><strong >' . $i . '</strong ></a ></li >';
            }
        }


        $tab .= '</ul> <div class="tab-content"> ';


        foreach ($permitttees as $key => $permitttee) {

            $permitttee = (object)$permitttee;

            ++$key;

            $isActive = ($key === 1) ? 'active show' : '';
            $isAcknowledged = ((int)$permitttee->co_permittee_acknowledged === 1) ? 'checked' : '';

            $tab .= ' <div id="tab-' . $key . '" class="tab-pane ' . $isActive . '">
                                    <div class="panel-body"><form action="' . route('projects.permittee.update', [$project_id, $permitttee->id]) . '" method="post">
                                           <input type="hidden" name="project_id" class="project-id" value="' . $project_id . '">
                                           <input type="hidden" name="permittee_id" class="permittee-id" value="' . $permitttee->id . '">
                                           <input type="hidden" name="_token" class="' . csrf_token() . '">

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="received-date-' . $key . '">Received Date</label>
                                                   <input class="form-control datepicker readonly-date" readonly
                                                           type="text" autofocus placeholder="MM/DD/YYYY">
                                                    <input type="hidden" class="form-control ymd-date-input" id="received-date-' . $key . '" readonly
                                                           name="received_date" value="' . $permitttee->co_permittee_received_date . '">


                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="reviewed-date-' . $key . '">Reviewed Date</label>
                                                    <input class="form-control datepicker readonly-date" placeholder="MM / DD / YYYY"
                                                           type="text"
                                                           readonly>
                                                    <input type="hidden" class="form-control ymd-date-input"
                                                           id="reviewed-date-' . $key . '" readonly name="reviewed_date"  value="' . $permitttee->co_permittee_reviewed_date . '">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mt-4">
                                                    <div class="checks pt-2">
                                                        <label class="a-checks" id="acknowledged-' . $key . '">
                                                            <input type="hidden" value="0" name="acknowledged">
                                                            <input class="checkbox" name="acknowledged"
                                                                   id="acknowledged-' . $key . '" type="checkbox" value="1" ' . $isAcknowledged . '>
                                                            <span class="checkmark"></span> Is Acknowledged </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name-' . $key . '">Co-Permittee Name</label>
                                                    <input class="form-control" name="name" id="name-' . $key . '" type="text"  value="' . $permitttee->co_permittee_name . '">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="company-' . $key . '">Co-Permittee Company</label>
                                                    <input class="form-control" name="company"
                                                           id="company-' . $key . '" type="text"  value="' . $permitttee->co_permittee_company . '">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="email-' . $key . '">Email</label>
                                                    <input class="form-control" name="email" id="email-' . $key . '" type="text" value="' . $permitttee->co_permittee_email . '">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="address-1-' . $key . '">Address 1</label>
                                                    <input class="form-control" name="address_1"
                                                           id="address-1-' . $key . '" type="text" value="' . $permitttee->co_permittee_address_1 . '">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="address-2-' . $key . '">Address 2</label>
                                                    <input class="form-control" name="address_2"
                                                           id="address-2-' . $key . '" type="text"  value="' . $permitttee->co_permittee_address_2 . '">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="city-' . $key . '">City</label>
                                                    <input class="form-control" name="city" id="city-' . $key . '" type="text"  value="' . $permitttee->co_permittee_city . '">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="state-' . $key . '">State</label>
                                                    <input class="form-control" name="state" id="state-' . $key . '" type="text"   value="' . $permitttee->co_permittee_zip . '">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="zipcode-' . $key . '">Zip Code</label>
                                                    <input class="form-control" name="zipcode" id="zipcode-' . $key . '" type="text"  value="' . $permitttee->co_permittee_zip . '">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone-' . $key . '">Phone</label>
                                                    <input class="form-control us-phone" name="phone" id="phone-' . $key . '" type="text"  value="' . $permitttee->co_permittee_phone . '">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="fax-' . $key . '">Fax</label>
                                                    <input class="form-control us-phone" name="fax" id="fax-' . $key . '" type="text"  value="' . $permitttee->co_permittee_fax . '">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 offset-md-8 text-right">
                                                <button type="button" class="btn btn-primary btn-co-permittee-update">Update</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div> </form>
                                    </div></div> ';
        }

        $tab .= ' </div></div> ';

        return $tab;
    }

    public
    static function loadFees($project_id)
    {
        $transactions = Transaction::getFees($project_id);

        $tr = '';

        foreach ($transactions as $transaction) {
            $transaction = (object)$transaction;

            $tr .= " <tr>
                        <td class='text-center received' > " . self::sqlToHtmlDate($transaction->received) . "</td >
                        <td class='text-center is-admin' data-admin='" . $transaction->is_admin . "' > " .
                self::isAdmin($transaction->is_admin) . "</td >
                        <td class='text-center nr' >" . $transaction->nr . "</td >
                        <td class='text-center rev-number' >" . $transaction->rev_number . "</td >
                        <td class='text-center totalacres' >" . $transaction->totalacres . "</td >
                        <td class='text-center tobedisturb' >" . $transaction->tobedisturb . "</td >


                        <td class='text-center dist-fee' >" .
                number_format((float)$transaction->dist_fee, 2, '.', '') . "</td >
                        <td class='text-center dist-chknum' >" . $transaction->dist_chknum . "</td >
                        <td class='text-center dist-fee-chkdate' >" . self::sqlToHtmlDate($transaction->dist_fee_chkdate) . "</td >
                        <td class='text-center distfee-payor' >" . $transaction->distfee_payor . "</td >


                        <td class='text-center mccd-cwf-fee' >" .
                number_format((float)$transaction->mccd_cwf_fee, 2, '.', '') . "</td >
                        <td class='text-center mccd-cwf-chknum' >" . $transaction->mccd_cwf_chknum . "</td >
                        <td class='text-center mccd-cwf-chkdate' >" . self::sqlToHtmlDate($transaction->mccd_cwf_chkdate) . "</td >
                        <td class='text-center mccd-cwf-payor' >" . $transaction->mccd_cwf_payor . "</td >



                        <td class='text-center tbd-fee' >" .
                number_format((float)$transaction->tbd_fee, 2, '.', '') . "</td >
                        <td class='text-center tbdfee-chknum' >" . $transaction->tbdfee_chknum . "</td >
                        <td class='text-center tbdfee-chkdate' >" . self::sqlToHtmlDate($transaction->tbdfee_chkdate) . "</td >
                        <td class='text-center tbdfee-payor' >" . $transaction->tbdfee_payor . "</td >


                        <td class='text-center  expedite-fee' >" .
                number_format((float)$transaction->expedite_fee, 2, '.', '') . "</td >
                        <td class='text-center   exp-check-num' >" . $transaction->exp_check_num . "</td >
                        <td class='text-center  exp-check-date' >" . self::sqlToHtmlDate($transaction->exp_check_date) . "</td >
                        <td class='text-center  exp-payor' >" . $transaction->exp_payor. "</td >



                        <td class='text-center tech-init' >" . $transaction->tech_init . "</td >
                        <td class='text-center plan-date' >" . self::sqlToHtmlDate($transaction->s) . "</td >

                        <td class='text-center project-details' style='position: sticky; top: 0; right: 0; background: #fff;' >
                            <a href='#' class='text-navy btn-edit-fee' data-id='" . $transaction->id . "' style='font-size: 1.3em;'
                               data-toggle='tooltip' data-original-title='Edit Fee Info' ><i
                                        class='fa fa-edit' ></i ></a >
                            <a href='#' class='text-danger btn-delete-fee' data-id='" . $transaction->id . "' style='font-size: 1.4em;'
                               data-toggle='tooltip' data-original-title='Delete Review Info' ><i class='fa fa-times' ></i ></a >
                        </td >
                    </tr> ";
        }

        return $tr;
    }

    public
    static function loadReviews($project_id)
    {
        $transactions = Transaction::where('project_id', $project_id)->get();

        $tr = '';

        foreach ($transactions as $transaction) {

            $tr .= "<tr >
                        <td class='text-center received-date' > " . self::sqlToHtmlDate($transaction->received) . "</td >
                        <td class='text-center is-admin' data-admin=' " . $transaction->is_admin . "' > " . self::isAdmin($transaction->is_admin) . "</td >
                        <td class='text-center admin-rev-date' > " . self::sqlToHtmlDate($transaction->admin_rev_date) . "</td >
                        <td class='text-center admin-status' > " . $transaction->admin_status . "</td >
                        <td class='text-center admin-init' >" . $transaction->admin_init . "</td >
                        <td class='text-center reviewed' > " . self::sqlToHtmlDate($transaction->reviewed) . "</td >
                        <td class='text-center tech-status' > " . $transaction->tech_status . "</td >
                        <td class='text-center tech-init' >" . $transaction->tech_init . "</td >
                        <td class='text-center date-wd' > " . self::sqlToHtmlDate($transaction->date_wd) . "</td >
                        <td class='text-center' > " . substr($transaction->return_reason, 0, 20) . '...' . "</td >
                        <td class='text-center return-reason d-none' >" . $transaction->return_reason . "</td >
                        <td class='text-center project-details' >
                            <a href='#' class='text-navy btn-edit-review' style='font-size: 1.3em;' data-id='" . $transaction->id . "'
                             data-toggle='tooltip' data-original-title='Edit Review Info' > <i class='fa fa-edit' ></i >
                            </a >
                            <a href='#' class='text-danger btn-delete-review' data-id='" . $transaction->id . "'
                             style='font-size: 1.4em;' data-toggle='tooltip' data-original-title='Delete Review Info' > <i class='fa fa-times' ></i >
                            </a >
                        </td >
                </tr > ";


        }

        return $tr;
    }
}
