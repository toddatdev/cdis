@extends('reports.app')

@section('title', 'PADOT Hours Report - CDIS Reports')

@push('css')
    <style>
        tr.highlight:nth-child(4n), tr.highlight:nth-child(4n-1) {

            background: rgba(0, 0, 0, .06);
        }

        table tr.highlight:nth-child(4n-2), tr.highlight:nth-child(4n-3) {

            background: rgba(0, 0, 0, .1);
            border-left: 2px solid #1ab394;
        }
    </style>
@endpush

@section('content')@php

        if (empty($reportData)) {
          $table  =   '<h2 >No Data Available for selected parameters</h2>';
        } else {
        $table = '<h2  class="py-3">PADOT HOURS ___ Quarter 20__</h2>';
        $table .= '<hr />';
        $tot = 0;

        foreach ($reportData as $e => $tech) {
        foreach ($tech as $t) {

        $table .= '<table class="table table-bordered bg-light"><tr><th>Technician</th><th>' . $e . '</th></tr><tr><td>Date</td><td>Hours</td><td>Time Category</td></tr>';
            $h = 0;

            foreach ($t as $p) {

            $table .= '<tr class="highlight"><td>' . sqlToHtmlDate($p->trx_date) . '</td><td>' .
             $p->hours . '</td><td>' . str_replace('&', ' and ' , $p->time_category ). '</td></tr>';
            $table .= '<tr class="highlight"><td>Project: </td><td>' . clean($p->project) . '</td><td></td></tr>';
            $h += (float) $p->hours;
            }
            $table .= '<tr><td>Project Hours: </td><td>' . $h . '</td><td></td></tr>';
            $table .= '</table>';
        }
        $tot += $h;
        $table .= '<hr />';
        }
        $table .= 'Total Hours:: ' . $tot;
}
        echo $table;
    @endphp
@stop


