<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Models\Contact\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected $project;

    public function index()
    {
        return view('admin.contacts');
    }

    public function search(Request $request)
    {
        //get the project by name & if entry number is not empty then add it
        //into search query as well.

        /* Database table correspondence
        title 			-> company
        EngineerName  	-> SENTBY
        Company        	-> ENGINEER */

        $contacts = [];
        $name = strtolower($request->name);
        $company = strtolower($request->company);

        if ($request->type === 'engineer') {

            $contacts = Contact::where('type', $request->type)
                ->when((!empty($name) && !empty($company)), function ($query) use ($name, $company) {

                    $query->whereRaw("( LOWER(json_extract(data, '$.ENGINEER')) LIKE '%" . $company . "%' OR
                                    LOWER(json_extract(data, '$.SENTBY')) LIKE '%" . $name . "%' )");

                })->when(!empty($name), function ($query) use ($name) {

                    $query->whereRaw(" LOWER(json_extract(data, '$.SENTBY')) LIKE '%" . $name . "%'");

                })->when(!empty($company), function ($query) use ($company) {

                    $query->whereRaw(" LOWER(json_extract(data, '$.ENGINEER')) LIKE '%" . $company . "%'");

                })
                ->where('is_old', 'no')
                ->where('county_id', session('county_id'))
                ->orderBy('id', 'desc')
                ->paginate(12);

        } elseif ($request->type === 'applicant') {

            // APPLIC -> applicant_name
            // APP_COMPANY -> applicant_company

            $contacts = Contact::where('type', $request->type)
                ->when((!empty($name) && !empty($company)), function ($query) use ($name, $company) {

                    $query->whereRaw("( LOWER(json_extract(data, '$.APP_COMPANY')) LIKE '%" . $company . "%' OR
                                  LOWER(json_extract(data, '$.APPLIC')) LIKE '%" . $name . "%') ");

                })->when(!empty($name), function ($query) use ($name) {

                    $query->whereRaw(" LOWER(json_extract(data, '$.APPLIC')) LIKE '%" . $name . "%'");

                })->when(!empty($company), function ($query) use ($company) {

                    $query->whereRaw(" LOWER(json_extract(data, '$.APP_COMPANY')) LIKE '%" . $company . "%'");

                })
                ->where('is_old', 'no')
                ->where('county_id', session('county_id'))
                ->paginate(12);


        } elseif ($request->type === 'coapplicant') {

            // APPLIC -> applicant_name
            // APP_COMPANY -> applicant_company

            $contacts = Contact::where('type', $request->type)
                ->when((!empty($name) && !empty($company)), function ($query) use ($name, $company) {

                    $query->whereRaw("( LOWER(json_extract(data, '$.Company')) LIKE '%" . $company . "%' OR
                                  LOWER(json_extract(data, '$.Name')) LIKE '%" . $name . "%') ");

                })->when(!empty($name), function ($query) use ($name) {

                    $query->whereRaw(" LOWER(json_extract(data, '$.Name')) LIKE '%" . $name . "%'");

                })->when(!empty($company), function ($query) use ($company) {

                    $query->whereRaw(" LOWER(json_extract(data, '$.Company')) LIKE '%" . $company . "%'");

                })
                ->where('is_old', 'no')
                ->where('county_id', session('county_id'))
                ->orderBy('id', 'desc')
                ->paginate(12);

        } elseif ($request->type === 'copermittee') {


            $contacts = Contact::where('type', $request->type)
                ->when((!empty($name) && !empty($company)), function ($query) use ($name, $company) {

                    $query->whereRaw("( LOWER(json_extract(data, '$.COMPANY')) LIKE '%" . $company . "%' OR
                                  LOWER(json_extract(data, '$.NAME')) LIKE '%" . $name . "%') ");

                })->when(!empty($name), function ($query) use ($name) {

                    $query->whereRaw(" LOWER(json_extract(data, '$.NAME')) LIKE '%" . $name . "%'");

                })->when(!empty($company), function ($query) use ($company) {

                    $query->whereRaw(" LOWER(json_extract(data, '$.COMPANY')) LIKE '%" . $company . "%'");

                })
                ->where('is_old', 'no')
                ->where('county_id', session('county_id'))
                ->orderBy('id', 'desc')
                ->paginate(12);
        }

        return $contacts;
    }

    public function getContact($type, $id)
    {
        return Contact::whereId($id)
            ->where('type', $type)
            ->where('county_id', session('county_id'))
            ->where('is_old', 'no')
            ->first(['data', 'id']);
    }

    public function updateStatus($id)
    {
        $contact = Contact::find($id);
        $contact->is_old = 'yes';
        $contact->save();


        return response()
            ->json(['error' => false,
                'title' => 'Status Updated',
                'message' => 'Contact status has been updated!']);

    }

    public function create(Request $request)
    {

        Contact::createContact($request);

        return response()
            ->json(['error' => false,
                'title' => 'Contact Updated!',
                'message' => ucfirst($request->TYPE) . ' has been created.']);
    }


    public function update(Request $request, $contactId)
    {

        Contact::updateContact($request, $contactId);

        return response()
            ->json(['error' => false,
                'title' => 'Contact Updated!',
                'message' => ucfirst($request->TYPE) . ' has been updated.']);
    }


}
