<?php

namespace App\Models\Contact;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{

    public $timestamps = false;

    public function getDataAttribute()
    {
        return json_decode($this->attributes['data'], true);
    }

    public static function createContact($request)
    {

        $data = json_encode($request->except(['_token']));

        $contact = new self();

        if ($request->TYPE === 'applicant') {

            $contact->name = $request->APPLIC;
            $contact->address = $request->APP_ADD1;
            $contact->city = $request->APP_CITY;
            $contact->state = $request->APP_STATE;
            $contact->zipcode = $request->APP_ZIP;

        } elseif ($request->TYPE === 'coapplicant') {

            $contact->name = $request->Name;
            $contact->address = $request->Address1;
            $contact->city = $request->City;
            $contact->state = $request->State;
            $contact->zipcode = $request->Zip;


        } elseif ($request->TYPE === 'engineer') {
            $contact->name = $request->ENGINEER;
            $contact->address = $request->ENG_ADD1;
            $contact->city = $request->ENG_CITY;
            $contact->state = $request->ENG_STATE;
            $contact->zipcode = $request->ENG_ZIP;

        } elseif ($request->TYPE === 'copermittee') {

            $contact->name = $request->title;
            $contact->address = $request->ADDRESS1;
            $contact->city = $request->CITY;
            $contact->state = $request->STATE;
            $contact->zipcode = $request->ZIP;
        }

        $contact->type = strtolower($request->TYPE);
        $contact->is_old = 'no';
        $contact->county_id = session('county_id');

        $contact->data = (string)$data;

        $contact->save();

    }

    public static function updateContact($request, $contactId)
    {
        $data = json_encode($request->except(['_token']));

        $contact = self::where('id', $contactId)
            ->where('county_id', session('county_id'))
            ->first();


        if ($request->TYPE === 'applicant') {

            $contact->name = $request->APPLIC;
            $contact->address = $request->APP_ADD1;
            $contact->city = $request->APP_CITY;
            $contact->state = $request->APP_STATE;
            $contact->zipcode = $request->APP_ZIP;

        } elseif ($request->TYPE === 'coapplicant') {

            $contact->name = $request->Name;
            $contact->address = $request->Address1;
            $contact->city = $request->City;
            $contact->state = $request->State;
            $contact->zipcode = $request->Zip;


        } elseif ($request->TYPE === 'engineer') {
            $contact->name = $request->ENGINEER;
            $contact->address = $request->ENG_ADD1;
            $contact->city = $request->ENG_CITY;
            $contact->state = $request->ENG_STATE;
            $contact->zipcode = $request->ENG_ZIP;

        } elseif ($request->TYPE === 'copermittee') {

            $contact->name = $request->title;
            $contact->address = $request->ADDRESS1;
            $contact->city = $request->CITY;
            $contact->state = $request->STATE;
            $contact->zipcode = $request->ZIP;
        }

        $contact->data = (string)$data;

        $contact->save();

    }
}
