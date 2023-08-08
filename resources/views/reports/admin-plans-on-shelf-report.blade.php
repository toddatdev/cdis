@extends('reports.app')

@section('title', 'Admin Plans on Shelf Report - CDIS Reports')

@section('content')@php
    $emp = '';


     if(isset($employee)){
      $emp =  'Employee: ' . $employee->name ;
     }

     if(empty($reportData)){

     echo  '<h2>No Data Available for selected parameters</h2>';

     }else{

$table = '<h2>Admin Plans on Shelf <br />' . '</h2> <h3>'. $emp.'</h3><table class="table table-bordered"><thead>';
$table .= '<tr><th class="project-name">Project Name</th><th>Admin?</th><th>Received</th><th>Tech</th></tr></thead>';
foreach ($reportData as $d) {

    $tech = '';

 if(!empty($d->tech)){
    $tech = explode(' ', $d->tech)[0];
 }
$table .= '<tr><td  class="project-name">' . clean( $d->projectName ). '</td><td>Yes</td><td>' . sqlToHtmlDate($d->daterec) . '</td><td>' . $tech . '</td></tr>';
}
$table .= '</table><br />';
$table .= "<p class='text-center'># of plans waiting for Admin Review: " . count($reportData) . '</p>';

echo $table;
 }
@endphp
@stop


