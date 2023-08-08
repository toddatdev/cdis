@extends('reports.app')

@section('title', 'Completeness Report - CDIS Reports')

@section('content')@php
    if (empty($reportData)) {
                     $table =   '<h2>No Data Available for selected parameters</h2>';
               } else {
                   $table = '<h2>Completeness Review Report For ' . sqlToHtmlDate($request->from) . ' to ' . sqlToHtmlDate($request->to) . '</h2>';
                   $table .= '<h3>Complete</h3>';
                   $table .= "<table class='table table-bordered'><thead><tr><th>Date Received</th><th class='project-name'>Project Name</th><th>Date Reviewed:</th><th># Days</th><th>Rev. By</th></tr></thead>";
                   $i = 0;
                   foreach ($reportData as $d) {
                       if (strtolower($d->status) === 'complete') {
                           $table .= '<tr><td>' . sqlToHtmlDate($d->rec) . '</td><td class="project-name">' . clean($d->project). '</td><td>' . sqlToHtmlDate($d->rev) . '</td><td>' . $d->age . '</td><td>' . $d->initial . '</td></tr>';
                           $i++;
                       }
                   }

                   $table .= '</table><p><strong>Number of Reviews For this Section: ' . $i . '</strong></p>';
                   $i = 0;
                   $table .= "<h3>Not Complete</h3><table class='table table-bordered'>";
                   $table .= '<tr><th>Date Received</th><th class="project-name">Project Name</th><th>Date Reviewed:</th><th># Days</th><th>Rev. By</th></tr>';
                   foreach ($reportData as $d) {
                       if (strtolower($d->status) === 'incomplete') {
                           $table .= '<tr><td>' . sqlToHtmlDate($d->rec) . '</td><td  class="project-name">' . clean($d->project). '</td><td>' . sqlToHtmlDate($d->rev) . '</td><td>' . $d->age . '</td><td>' . $d->initial . '</td></tr>';
                           $i++;
                       }
                   }
                   $table .= '</table><p><strong>Number of Reviews For this Section: ' . $i . '</strong></p>';
                   $i = 0;
                   $table .= "<h3>No Comment</h3><table align='center' class='table table-bordered'>";
                   $table .= '<tr><th>Date Received</th><th  class="project-name">Project Name</th><th>Date Reviewed:</th><th># Days</th><th>Rev. By</th></tr>';
                   foreach ($reportData as $d) {
                       if (strtolower($d->status) === 'no comment' || strtolower($d->status) === 'n/c') {
                           $table .= '<tr><td>' . sqlToHtmlDate($d->rec) . '</td><td  class="project-name"> ' . clean($d->project) . '</td><td>' . sqlToHtmlDate($d->rev) . '</td><td>' . $d->age . '</td><td>' . $d->initial . '</td></tr>';
                           $i++;
                       }
                   }
                   $table .= '</table><p><strong>Number of Reviews For this Section: ' . $i . '</strong></p>';
                   $i = 0;
                   $table .= "<h3>Withdrawn</h3><table class='table table-bordered'>";
                   $table .= '<tr><th>Date Received</th><th  class="project-name" >Project Name</th><th>Date Reviewed:</th><th># Days</th><th>Rev. By</th></tr>';
                   foreach ($reportData as $d) {
                       if (strtolower($d->status) === 'withdrawn') {
                           $table .= '<tr><td>' . sqlToHtmlDate($d->rec) . '</td><td  class="project-name">' . clean($d->project). '</td><td>' . sqlToHtmlDate($d->rev) . '</td><td>' . $d->age . '</td><td>' . $d->initial . '</td></tr>';
                           $i++;
                       }
                   }
                   $table .= '</table><p><strong>Number of Reviews For this Section: ' . $i . '</strong></p>';
echo $table;
}
@endphp
@stop


