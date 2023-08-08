@extends('reports.app')

@section('title', 'Withdrawn Report - CDIS Reports')
@section('heading', 'Withdrawn Review Report For (' . date('M, d Y') .') to (' . date('M, d Y')  . ')')

@section('content')
    @php
        if (empty($reportData)) {
                   $table =   '<h2 >No Data Available for selected parameters</h2>';
              } else {
                  $table = '<h2 >Withdrawn Review Report For ' . sqlToHtmlDate($request->from) . ' to ' . sqlToHtmlDate($request->to) . '</h2>';
                  $table .= "<table align='center' class='table table-bordered'><thead><tr><th>Date Received</th><th class='project-name'>Project Name</th><th>Date Reviewed:</th><th># Days</th><th>Rev. By</th></tr></thead>";
                  $i = 0;
                  foreach ($reportData as $d) {
                      $table .= '<tr><td>' . sqlToHtmlDate($d->rec) . '</td><td class="project-name">' . clean($d->project) . '</td><td>' . sqlToHtmlDate($d->rev) . '</td><td>' . $d->age . '</td><td>' . clean($d->initial). '</td></tr>';
                      $i++;
                  }
                  $table .= '</table><p><strong>Number of Reviews For this Section: ' . $i . '</strong></p>';
    }
    echo $table;
    @endphp
@stop


