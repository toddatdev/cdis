@extends('reports.app')

@section('title', 'Complete Review Report - CDIS Reports')
@section('heading', 'Complete Review Report For (' . date('M, d Y') .') to (' . date('M, d Y')  . ')')

@section('content')

    @if (empty($reportData))
        <h2>No Data Available for selected parameters</h2>'
    @else
        <h2>Complete Review Report For {{ sqlToHtmlDate($request->from) }} to {{ sqlToHtmlDate($request->to) }} </h2>
        <table class='table table-bordered' align='center'>
            <thead>
            <tr>
                <th>Date Received</th>
                <th class='project-name'>Project Name</th>
                <th>Date Reviewed:</th>
                <th># Days</th>
                <th>Rev. By</th>
            </tr>
            </thead>
            @php
                $i = 0;
            @endphp
            @foreach ($reportData as $d)
                <tr>
                    <td>{{sqlToHtmlDate($d->rec)}}</td>
                    <td class="project-name">{{clean($d->project)}}</td>
                    <td>{{sqlToHtmlDate($d->rev)}}</td>
                    <td>{{$d->age}}</td>
                    <td>{{clean($d->initial)}}</td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
        </table>
        <p>
            <strong>Number of Reviews For this Section: {{ $i }}</strong>
        </p>
    @endif
@stop


