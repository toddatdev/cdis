<?php

namespace App\Http\Traits;

use App\Models\Project\Project;
use App\Models\Project\ProjectLocation;
use App\User;
use Illuminate\Support\Facades\File;
use XMLWriter;
use ZipArchive;

trait  ICISNpdesQueries
{
    public function icisNpdesReportData($type, $from, $to)
    {
        $projects = Project::with(['projectPermit',
            'projectDetails.municipality',
            'projectDetails.nasics',
            'projectLocation',
            'projectApplicants'

        ])->whereHas('projectPermit', function ($query) use ($from, $to, $type) {

            $query->where('npdes_number', '<>', '');

            if ($type === 'general') {
                $query->where('npdes_number', 'like', '%PAC%');
            }

            if ($type === 'basic') {
                $query->where('npdes_number', 'not like', '%PAC%');
            }

            $query->whereBetween('permit_issued_date', [$from, $to]);

        })->where('is_closed', '=', 0)
            ->where('county_id', session('county_id'))->get();


        return $projects;
    }

    public function generateXMLReport($request)
    {
        //date range
        $from = $request->from;
        $to = $request->to;

        //get all general projects b/w specific dates
        $generalProjects = $this->icisNpdesReportData('general', $from, $to);

        //get all individual projects b/w specific dates
        $basicProjects = $this->icisNpdesReportData('basic', $from, $to);

        //gets current user information from database
        $user = User::getCurrentICISUser();

        $general_report_uri = $this->getGeneralPermitSubmissionReport($request, $generalProjects, $user);
//        $basic_report_uri = $this->getBasicPermitSubmissionReport($request, $basicProjects, $user);

//        $file_name = $this->createZipFiles($basic_report_uri, $general_report_uri);
        $file_name = $this->createZipFiles($general_report_uri);

        return response()->download($file_name);
    }

    public function getGeneralPermitSubmissionReport($request, $projects, $user)
    {
        $general_uri = public_path('tmp/reports/icis_general_' . time() . '.xml');

        //creates xml writer object and sets it's basic properties
        $xml = $this->CreateXMLWriter($general_uri);

        //renders header element with given user information
        $xml = $this->writeHeaderElement($xml, $user);

        $xml = $this->startXML($xml, 'GeneralPermitSubmission');

        $this->fillProjectsDataToXML($request, $projects, $xml);

        $this->closeXML($xml);

        return $general_uri;
    }


    public function getBasicPermitSubmissionReport($request, $projects, $user)
    {

        $basic_uri = public_path('tmp/reports/icis_basic_' . time() . '.xml');

        //creates xml writer object and sets it's basic properties
        $xml = $this->CreateXMLWriter($basic_uri);

        //renders header element with given user information
        $xml = $this->writeHeaderElement($xml, $user);

        $xml = $this->startXML($xml, 'BasicPermitSubmission');

        $this->fillProjectsDataToXML($request, $projects, $xml);

        $this->closeXML($xml);

        return $basic_uri;

    }

    /**
     * @param XMLWriter $xml
     * @param $user
     * @return XMLWriter
     */
    protected function writeHeaderElement(XMLWriter $xml, $user): XMLWriter
    {
        $xml->startElement('Header');

        $xml->writeElement('Id', $user->id);
        $xml->writeElement('Author', $user->author);
        $xml->writeElement('Organization', $user->county . ' County Conservation District of Pennsylvania');
        $xml->writeElement('Title', 'General Permit Submission');
        $xml->writeElement('CreationTime', str_replace('+00:00', 'Z', gmdate('c')));
        $xml->writeElement('DataService', 'ICIS-NPDES');
        $xml->writeElement('ContactInfo', $user->contact);

        $xml->endElement();

        return $xml;
    }

    /**
     * @param string $uri
     * @return XMLWriter
     */
    protected function CreateXMLWriter(string $uri): XMLWriter
    {
        $xml = new XMLWriter();

        $xml->openUri($uri);

        $xml->setIndent(true);
        $xml->startDocument();
        $xml->startElementNS(null, 'Document', 'http://www.exchangenetwork.net/schema/icis/5');
        $xml->writeAttributeNS('xmlns', 'xsi', null, 'http://www.w3.org/2001/XMLSchema-instance');

        return $xml;
    }

    /**
     * @param XMLWriter $xml
     * @return XMLWriter
     */
    protected function startXML(XMLWriter $xml, $type): XMLWriter
    {
        $xml->startElement('Payload');
        $xml->startAttribute('Operation');
        $xml->text($type);
        $xml->endAttribute();

        return $xml;
    }

    /**
     * @param XMLWriter $xml
     */
    protected function closeXML(XMLWriter $xml): XMLWriter
    {
        $xml->endElement();
        $xml->endElement();
        $xml->endElement();
        $xml->endDocument();
        $xml->flush();

        return $xml;
    }

    /**
     * @param $request
     * @param $projects
     * @param XMLWriter $xml
     * @return XMLWriter
     */
    protected function fillProjectsDataToXML($request, $projects, XMLWriter $xml): XMLWriter
    {
        foreach ($projects as $project) {

            $npdes_number = $project->projectPermit->npdes_number;
            $permit_issued_date = $project->projectPermit->permit_issued_date;
            $permit_complete_date = $project->projectPermit->permit_complete_date;
            $permit_received_date = $project->projectPermit->received_date;
            $permit_expiration_date = $project->projectPermit->permit_expiration_date;

            if (strpos($npdes_number, 'PAC') !== false) {
                $permittype = 'GPC';
                $element = 'GeneralPermit';
                $general = true;

            } else {

                $permittype = 'NPD';
                $element = 'BasicPermit';
                $general = false;

            }

            if (strlen(trim($npdes_number)) !== 9) {
                continue;
            }

            if ($general) {
                $xml->startElement('GeneralPermitData');
            } else {
                $xml->startElement('BasicPermitData');
            }


            $xml->startElement('TransactionHeader');
            $xml->writeElement('TransactionType', $request->transaction_type);
            $xml->writeElement('TransactionTimestamp', str_replace('+00:00', 'Z', gmdate('c')));
            $xml->endElement();

            $xml->startElement($element);

            $xml->writeElement('PermitIdentifier', substr($npdes_number, 0, 9));

            if ($general) {
                $xml->writeElement('AssociatedMasterGeneralPermitIdentifier', 'PAC000000');
            }

            $xml->writeElement('PermitTypeCode', $permittype);
            $xml->writeElement('AgencyTypeCode', 'CT6');


            //if basic permit data
            if (!$general) {
                $xml->writeElement("ApplicationReceivedDate", $permit_received_date);
                $xml->writeElement("PermitApplicationCompletionDate", $permit_complete_date);
            }


            if ($permit_issued_date !== '0000-00-00') {
                $xml->writeElement('PermitIssueDate', $permit_issued_date);
                $xml->writeElement('PermitEffectiveDate', $permit_issued_date);
            }

            if ($permit_expiration_date !== '' && $permit_expiration_date !== '0000-00-00') {

                $xml->writeElement('PermitExpirationDate', $permit_expiration_date);

            }

            $xml->writeElement('PermitIssuingOrganizationTypeName', 'County');

            if (($project->projectDetails->nasics[0]->nasic ?? '') !== '') {

                $xml->startElement('NAICSCodeDetails');

                $itrator = 0;
                foreach ($project->projectDetails->nasics as $nasic) {

                    $xml->writeElement('NAICSCode', str_pad($nasic->nasic, 6, STR_PAD_LEFT));

                    if ($itrator === 0) {
                        $itrator++;
                        $xml->writeElement('NAICSPrimaryIndicatorCode', 'Y');
                    } else {
                        $xml->writeElement('NAICSPrimaryIndicatorCode', 'N');
                    }
                }

                $xml->endElement();
            }
            $xml->startElement('Facility');
            $xml->writeElement('FacilitySiteName', preg_replace('/[^\w ]/', '', substr($project->name, 0, 50)));

            if (!empty($project->projectLocation->address_1)) {

                $xml->writeElement('LocationAddressText', $project->projectLocation->address_1);
            }

            if (!empty($project->projectDetails->municipality->name)) {

                $xml->writeElement('LocalityName', $project->projectDetails->municipality->name);

            }

            #$xml->writeElement("LocationAddressCountyCode", $countycode);
            $xml->writeElement('LocationStateCode', 'PA');
            $xml->writeElement('LocationZipCode', substr($project->projectApplicants[0]->zipcode ?? '', 0, 5));
            $xml->writeElement('LocationCountryCode', 'US');
            $xml->writeElement('StateRegionCode', 01);

            if (($project->projectDetails->ownership ?? '') !== '') {

                $xml->writeElement('FacilityTypeOfOwnershipCode', $project->projectDetails->ownership);
            }

            $xml->writeElement('ConstructionProjectName', preg_replace('/[^\w ]/',
                '', substr($project->name, 0, 50)));


            $pl = $project->projectLocation ?? '';
            $projectCoordinates = [];

            if (!empty($pl)) {

                $projectCoordinates = ProjectLocation::degToDec($pl->lat_deg,
                    $pl->lat_min,
                    $pl->lat_sec,
                    $pl->long_deg,
                    $pl->long_min,
                    $pl->long_sec
                );

                $xml->writeElement('ConstructionProjectLatitudeMeasure', round($projectCoordinates['latitude'], 7));

                $xml->writeElement('ConstructionProjectLongitudeMeasure', round($projectCoordinates['longitude'], 7));

            }

            $xml->startElement('FacilityContact');
            $xml->startElement('Contact');

            if (($project->projectApplicants[0]->name ?? '') !== '') {

                $fullname = explode(' ', ($project->projectApplicants[0]->name ?? ''));

                $xml->writeElement('AffiliationTypeText', 'PCT');

                if (($fullname[0] ?? '') !== '') {

                    $xml->writeElement('FirstName', substr($fullname[0], 0, 30));

                } else {

                    $xml->writeElement('FirstName', 'No Record');

                }

                if (($fullname[1] ?? '') !== '') {

                    $xml->writeElement('LastName', substr($fullname[1], 0, 30));

                } else {

                    $xml->writeElement('LastName', 'No Record');
                }
            }

            $xml->writeElement('IndividualTitleText', 'Contact Person');

            if (($project->projectApplicants[0]->email ?? '') !== '') {

                $xml->writeElement('ElectronicAddressText', $project->projectApplicants[0]->email);

            }
            # $xml->writeElement("ElectronicAddressText", $projects[$i]["APP_EMAIL"]);
            $xml->endElement();
            $xml->endElement();

            if (!empty($projectCoordinates)) {

                $xml->startElement('GeographicCoordinates');
                $xml->writeElement('LatitudeMeasure', round($projectCoordinates['latitude'], 7));
                $xml->writeElement('LongitudeMeasure', round($projectCoordinates['longitude'], 7));
                $xml->writeElement('HorizontalReferenceDatumCode', '002');
                $xml->endElement();

            }
            $xml->endElement();

            $xml->startElement('PermitAddress');
            $xml->startElement('Address');
            $xml->writeElement('AffiliationTypeText', 'PMA');


            if (($project->projectApplicants[0]->name ?? '') !== '') {

                $xml->writeElement('OrganizationFormalName', $project->projectApplicants[0]->name);

            } else {

                $xml->writeElement('OrganizationFormalName', 'No Record');

            }

            /** @var TYPE_NAME $project */
            $applicant_address = trim(($project->projectApplicants[0]->address_1 ?? '') . ' ' .
                ($project->projectApplicants[0]->address_2 ?? '') . ' ' .
                ($project->projectApplicants[0]->city ?? ''));

            if ($applicant_address !== '') {

                $xml->writeElement('MailingAddressText',
                    substr($applicant_address, 0, 50));

            } else {

                $xml->writeElement('MailingAddressText', 'No Record');

            }

            if (trim($project->projectApplicants[0]->city ?? '') !== '') {

                $xml->writeElement('MailingAddressCityName', substr($project->projectApplicants[0]->city, 0, 14));

            } else {

                $xml->writeElement('MailingAddressCityName', 'No Record');

            }

            if (($project->projectApplicants[0]->state ?? '') !== '') {

                $xml->writeElement('MailingAddressStateCode', substr($project->projectApplicants[0]->state, 0, 2));

            } else {

                $xml->writeElement('MailingAddressStateCode', 'PA');

            }

            if (trim($project->projectApplicants[0]->zipcode ?? '') !== '') {

                $xml->writeElement('MailingAddressZipCode', substr($project->projectApplicants[0]->zipcode, 0, 5));

            }

            if (strlen(trim(preg_replace('/[^0-9]/', '', $project->projectApplicants[0]->phone_number ?? ''))) > 6) {

                $xml->startElement('Telephone');
                $xml->writeElement('TelephoneNumberTypeCode', 'OFF');
                $xml->writeElement('TelephoneNumber',
                    substr(preg_replace('/[^0-9]/', '', $project->projectApplicants[0]->phone_number), 0, 10));
                $xml->endElement();

            } else {

                $xml->startElement('Telephone');
                $xml->writeElement('TelephoneNumberTypeCode', 'OFF');
                $xml->writeElement('TelephoneNumber', 'No Record');
                $xml->endElement();
            }

            $xml->endElement();
            $xml->endElement();
            $xml->endElement();
            $xml->endElement();
        }

        return $xml;
    }

    /**
     * @param string $basic_report_uri
     * @param string $general_report_uri
     * @return string
     */
    protected function createZipFiles( string $general_report_uri, string $basic_report_uri = ''): string
    {
        $time = time();

        $zip = new ZipArchive;

        $path = public_path('tmp/reports/zip');

        $file_name = $path . '/' . $time . '_icisdownload.zip';

        //if letter directory doesn't exist create it.
        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $zip->open($file_name, ZipArchive::CREATE);

//        $zip->addFile($basic_report_uri, 'icis_individual_download_' . $time . '.xml');

        $zip->addFile($general_report_uri, 'icis_general_download_' . $time . '.xml');

        $zip->close();

//        unlink($basic_report_uri);
        unlink($general_report_uri);

        return $file_name;
    }
}
