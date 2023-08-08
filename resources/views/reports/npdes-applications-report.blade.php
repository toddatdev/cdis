@extends('reports.app')

@section('title', 'NPDES Applications Report - CDIS Reports')
@section('content')@php
        $table = '<h2 >' . ucwords(session('county')) . ' County Conservation District<br />NPDES Applications<br/>';
            $table .= '<span >';
                    $table .= sqlToHtmlDate($request->from);
                    $table .= "</span> to <span >";
                    $table .= sqlToHtmlDate($request->to);
                    $table .= '</span></h2>';

        $table .= "<table class='table table-bordered'><thead  ><tr><th>Date Acknowledged</th><th  >Project Name<br />Location<br />Municipality<br />NPDES Number</th><th>Project Acres: <br />Dist. Acres</th><th  >Applicant<br />Applicant Company<br />Applicant Address 1<br />Applicant Address 2<br />Applicant City, State, Zip</th><th>Receiving<br /> Stream<br />Ch. 93<br /> Class</th><th>Ownership</th></tr></thead><tbody>";

        $r = 0;

        foreach ($reportData as $d) {

        $r++;
        $ownarray = array("CNG" => "County Government", "COR" => "Corporation", "CTG" => "Municipality", "DIS" => "District", "FDF" => "Federal Facility (US Government)", "GOC" => "GOCO (Gov Owned/Contractor Operated)", "IND" => "Individual",
        "MWD" => "Municipal or Water Distrit", "MXO" => "Mixed Ownership (e.g., Public/Private)", "NON" => "Non Government", "POF" => "Privately Owned Facility", "SDT" => "School District", "STF" => "State Government",
        "TRB" => "Tribal Government", "UNK" => "Unknown");

        $ownership = $ownarray[$d->ownership] ?? '';

        $table .= "<tr><td >" . sqlToHtmlDate($d->np_date_a) . "</td><td >" . clean($d->name) . "<br />" . clean($d->loc) . "<br />" . clean($d->munic ). "<br />" . clean($d->npdes_numb) . "</td><td >" . clean($d->total_acres) . "<br />" . clean($d->acres_tbd) . '</td><td >' . clean($d->applic) . '<br />' . clean($d->app_company ). '<br />' . clean($d->app_add1). "<br />" . clean($d->app_add2) . "<br />" . clean($d->app_city) . "," . clean($d->app_state ). " " . clean($d->app_zip) . '</td><td >' . clean($d->stream) . '<br />' . clean($d->stream_class). '</td><td >' . clean($ownership) . '</td></tr>';
        }

        $table .= '</tbody></table>';
        $table .= '<p><strong>Number of General NPDES Permits Acknowledged for the above time period: : ' . $r . '</strong></p>';


echo $table;

    @endphp
@stop

