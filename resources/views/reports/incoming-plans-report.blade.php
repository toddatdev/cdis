@extends('reports.app')

{{--    <table  class='table table-responsive'>--}}
@section('title', 'Incoming Plans Report - CDIS Reports')
@push('css')
    <style>
        td {
            text-align: left;
            padding: 0;
        }

        thead tr {
            border-bottom: 2px solid red;
        }

        th {
            border: none;
            padding: 0;
            font-size: 1rem;
            text-align: left;
        }

    </style>
@endpush
@section('content')

    <h1 class='text-center' rowspan='2'>Monthly Incoming Plan Log <br/>From {{ sqlToHtmlDate($request->from) }} to {{ sqlToHtmlDate($request->to) }}</h1>
    <table  style='font-size: .8rem;'>
        <thead  style='border-bottom: 1px solid #000000;'>
            <tr>
                <th>N/R</th>
                <th>Date Received</th>
                <th>Project Name</th>
                <th>Municipality</th>
                <th>Total Ac.</th>
                <th>Dist Ac.</th>
                <th>NPDES Number</th>
                <th>Review Fee</th>
                <th>NPDES Fee</th>
                <th>DEP Fee</th>
                <th>Expedited Fees</th>
                <th>Total Fees</th>
            </tr>
        </thead>
        <tbody>
            @php
                $plansrec = count($reportData);
                $totalacres = 0;
                $totaldisturbed = 0;
                $totalrevfees = 0;
                $totalnpdes = 0;
                $totaldep = 0;
                $totalfees = 0;
                $totalexp = 0;
                $n = 0;
                $r = 0;
            @endphp
            @foreach($reportData as $d)
                @php
                    if (strtolower($d->nr) === 'n') {
                        $n++;
                    } elseif (strtolower($d->nr) === 'r') {
                        $r++;
                    }
                @endphp

                <tr>
                    <td>{{$d->nr}}</td>
                    <td>{{date('m/d/Y', strtotime($d->received))}}</td>
                    <td>{{substr_replace(clean($d->name), '', 27)}}</td>
                    <td>{{$d->munic}}</td>
                    <td>{!! str_replace('.', '&#x2E;', $d->totalacres) !!}</td>
                    <td>{!! str_replace('.', '&#x2E;', $d->tobedisturb) !!}</td>
                    <td>{{clean($d->npdes_numb)}}</td>
                    <td>{!! "&#x24;" !!}{!! str_replace('.', '&#x2E;', $d->review) !!}</td>
                    <td>{!! "&#x24;" !!}{!! str_replace('.', '&#x2E;', $d->npdes ) !!}</td>
                    <td>{!! "&#x24;" !!}{!! str_replace('.', '&#x2E;', $d->dep ) !!}</td>
                    <td>{!! "&#x24;" !!}{!! str_replace('.', '&#x2E;', $d->expedited) !!}</td>
                    <td>{!! "&#x24;" !!}{!! str_replace('.', '&#x2E;', $d->total ) !!}</td>
                </tr>
                @php
                    $totalrevfees += $d->review;
                    $totalnpdes += $d->npdes;
                    $totaldep += $d->dep;
                    $totalfees += $d->total;
                    $totalexp +=(int) $d->expedited;
                @endphp
            @endforeach
        </tbody>
    </table>
    @foreach(collect($reportData)->reverse()->unique('name') as $d)
        @php
            $totalacres += $d->totalacres;
            $totaldisturbed += $d->tobedisturb;
        @endphp
    @endforeach
    <table  class="table table-responsive">
        <thead>
            <tr>
                <th style="font-weight: bold; text-align: left;">Total Acres</th>
                <th style="font-weight: bold; text-align: left;">Total Acres Distrubed</th>
                <th style="font-weight: bold; text-align: left;">Total Review Fee</th>
                <th style="font-weight: bold; text-align: left;">Total NPDES Fees</th>
                <th style="font-weight: bold; text-align: left;">Total DEP Fees</th>
                <th style="font-weight: bold; text-align: left;">Total Expedited Fees</th>
                <th style="font-weight: bold; text-align: left;">Total Fees</th>
                <th style="font-weight: bold; text-align: left;">Number of Plans Received</th>
                <th style="font-weight: bold; text-align: left;">New</th>
                <th style="font-weight: bold; text-align: left;">Resubmit</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: left;">{!! str_replace('.', '&#x2E;', number_format($totalacres, 3)) !!}</td>
                <td style="text-align: left;">{!! str_replace('.', '&#x2E;', number_format($totaldisturbed, 3)) !!}</td>
                <td style="text-align: left;">{!! str_replace('.', '&#x2E;', number_format($totalrevfees, 2)) !!}</td>
                <td style="text-align: left;">{!! str_replace('.', '&#x2E;', number_format($totalnpdes, 2)) !!}</td>
                <td style="text-align: left;">{!! str_replace('.', '&#x2E;', number_format($totaldep, 2)) !!}</td>
                <td style="text-align: left;">{!! str_replace('.', '&#x2E;', number_format($totalexp, 2)) !!}</td>
                <td style="text-align: left;">{!! str_replace('.', '&#x2E;', number_format($totalfees, 2)) !!}</td>
                <td style="text-align: left;">{{$plansrec}}</td>
                <td style="text-align: left;">{{$n}}</td>
                <td style="text-align: left;">{{$r}}</td>
            </tr>
        </tbody>
    </table>

@endsection
