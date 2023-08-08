@extends('reports.app')

@section('title', 'District Fee Collected Report - CDIS Reports')
@section('heading')
    <h3>District Fee Collected</h3>
@endsection

@section('content')@php
        $table = "<h2 class='text-center' >District fees collected</h2><br />";
        $table .= "<table class='table table-bordered'><tr><th>Date Received</th><th class='text-left'>Project Name</th><th>Check Date</th><th>Check #:</th><th>Payor</th><th>Fee</th></tr>";
            $r = 0;
            $total = 0;
            foreach ($reportData as $d) {
            $table .= '<tr><td>' . sqlToHtmlDate($d->rec) . '</td><td class="text-left">' . clean($d->proj) . '</td><td>' . $d->check_date . '</td><td>' . clean($d->check_num) . '</td><td>' . clean($d->payor) . '</td><td>' . $d->fee . '</td></tr>';
            $total += (float) $d->fee;
            }
            $table .= '</table>';
        $table .= '<p><strong>Number of Fees Collected: ' . count($reportData) . '  Total Fees Collected: $' . $total . '</strong>  </p>';
       echo $table;
    @endphp

@stop


