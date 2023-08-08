@extends('reports.app')

@section('title', 'CWF Fees Collected Report - CDIS Reports')
@section('heading',  'Clean Water Fund Fees collected')

@section('content')@php
        $table = "<h1 class='text-center'>" . strtoupper(session('district')) . ' Clean Water Fund Fees collected</h1><br />';
    $table .= "<table class='table table-bordered' align='center'><tr><th>Date Received</th><th class='project-name'>Project Name</th><th>Check Date</th><th>Check #:</th><th>Payor</th><th>Fee</th></tr>";
    $r = 0;
    $total = 0;
    $total = 0;
    foreach ($reportData as $d) {
        $table .= '<tr><td>' . sqlToHtmlDate($d->rec) . '</td><td class="project-name">' . clean($d->proj) . '</td><td>' . $d->check_date . '</td><td>' . clean($d->check_num) . '</td><td>' . clean($d->payor) . '</td><td>' . $d->fee . '</td></tr>';
        $total += (float) $d->fee;
    }
    $table .= '</table>';
    $table .= '<p><strong>Number of Fees Collected: ' . count($reportData) . '  Total Fees Collected: $' . $total . '</strong></p>';
    echo $table;

    @endphp
@stop


