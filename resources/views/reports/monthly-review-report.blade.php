@extends('reports.app')

@section('title', 'Monthly Review Report - CDIS Reports')

@section('content')

    @if(empty($reportData))
        <h2>No Data Available for selected parameters</h2>
    @else
        <h2>Review Report From {{sqlToHtmlDate($request->from)}} to {{sqlToHtmlDate($request->to)}}</h2>
        @php
            $noOfReviewsForMonth = 0;
        @endphp
        @foreach($reportData as $t => $e)
            @php
                $noOfReviews = 0;
            @endphp
            <hr/>
            <u>
                <strong>{{$t}}</strong>
            </u>
            <hr/>
            <table class='table table-bordered'>
                <thead>
                <tr>
                    <th>Received</th>
                    <th>Project Name</th>
                    <th>Complete</th>
                    <th>NR</th>
                    <th>Rev#</th>
                    <th width='200px'>Reviewed</th>
                    <th>Status</th>
                </tr>
                </thead>
                @foreach($e as $d)
                    @php
                        $noOfReviewsForMonth += ++$noOfReviews;
                    @endphp
                    <tr>
                        <td>{{sqlToHtmlDate($d->review_received)}}</td>
                        <td class='project-name'>{{clean($d->name)}}</td>
                        <td>{{$d->comp_date !== '' ? sqlToHtmlDate($d->comp_date) : ''}}</td>
                        <td>{{$d->nr}}</td>
                        <td>{{$d->reviewcount}}</td>
                        <td>{{sqlToHtmlDate($d->reviewed)}}</td>
                        <td>{{$d->status}}</td>
                    </tr>
                @endforeach
            </table>
            <strong>Number of Reviews: {{$noOfReviews}}</strong>
        @endforeach
        <p>
            <strong>Number of Reviews for the Month: {{ $noOfReviewsForMonth }}</strong>
        </p>
    @endif


@endsection

