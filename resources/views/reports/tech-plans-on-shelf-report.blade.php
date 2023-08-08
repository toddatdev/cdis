@extends('reports.app')
@section('title', 'Tech Plans on Shelf Report - CDIS Reports')
@section('heading', 'Tech Plans on Shelf')
@section('content')@php

    $emp = isset($employee)?   ' Employee: ' . $employee->name : '';

    if (empty($reportData)) {
          $table =   '<h2>No Data Available for selected parameters</h2>';
       } else {
           $table = '<h2>Tech Plans on Shelf ' . $emp . "</h2><table class='table table-bordered'>";
           $table .= '<thead>';
           $table .= '<tr><th class="project-name">Project Name</th><th>Admin?</th><th>Received</th><th>Technician</th></tr></thead>';
           foreach ($reportData as $d) {
               $table .= '<tr><td  class="project-name">' . clean( $d->projectName ). '</td><td>No</td><td>' .  sqlToHtmlDate($d->daterec) . '</td><td>' . $d->tech . '</td></tr>';
           }
           $table .= '</table><br />';
           $table .= '<p># of plans waiting for Technician Review: ' . count($reportData) . '</p>';
    }echo $table;@endphp
@stop


