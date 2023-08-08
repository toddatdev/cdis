@extends('reports.app')

@section('title', 'DEP Clean Water Fund - CDIS Reports')

@section('content')@php
        if (empty($reportData)) {
                 $table =   '<h2>No Data Available for selected parameters</h2>';
             } else {
                 $table = '<h3 class="text-center">Commonwealth Of Penna. Clean Water Fund to<br/> <br>Southeast Region DEP<br/><br>' . date('m/j/Y g:i A') . '</h3>';
                 $table .= "<table class='table table-bordered'><thead><tr><th>Items</th><th>Check #</th><th class='text-left'>Received From</th><th>County</th><th>Municipality</th><th class='chk-date'>Chk. Date</th><th class='text-left'>Project Name</th><th>NPDES Permit #</th><th>Dist Acres</th><th>Amount</th></tr></thead>";
                 $table .= '<tr> </tr>';
                 $c = 1;
                 $total = 0;
                 foreach ($reportData as $d) {
                     $total += (float) $d->tbd_fee;
                     $table .= '<tr><td>' . $c++ . '</td><td>' . clean($d->tbdfee_chknum) . '</td><td class="text-left">'  . clean($d->tbdfee_payor ) . '</td><td>' . session('county') . '</td><td>' . $d->munic . '</td><td>' . $d->tbdfee_chkdate . '</td><td  class="text-left">' . clean( $d->project )  . '</td><td>' . clean($d->npdes_numb). '</td><td>' . $d->acres_tbd . '</td><td>$' . $d->tbd_fee . '</td></tr>';
                 }
                 for ($i = 0; $i <= 2; $i++) {
                     $table .= '<tr><td>' . $c++ . '</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
                 }
                 $table .= '<tr><td>' . $c++ . '</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>TOTAL:</td><td>$' . $total . '</td></tr></table>';
 
             }echo $table;@endphp
@stop


