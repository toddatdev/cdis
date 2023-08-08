@extends('layouts.app')
@section('title', 'Reports | CDIS - Dashboard')
@section('breadcrumb')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Reports Control Panel</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('dashboard')}}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a>Reports</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>All</strong>
                </li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-9 offset-1">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Reports Options</h5>
                </div>
                <div class="ibox-content">
                    <form action="{{route('reports.generate')}}" role="form" method="post" id="form-reports"
                          target="_blank">
                        @csrf
                        <div class="row w-100">
                            <div class="col-md-6 both-reports">
                                <div class="form-group">
                                    <label for="report-type">Report Type</label>
                                    <select id="report-type" class="form-control" name="type" required>
                                        <option value="">Select A Report</option>
                                        <optgroup label="Manager Reports">
                                            <option value="padot_hours_report">&nbsp; &nbsp; &nbsp; - PADOT Hours Report
                                            </option>
                                            <option value="completeness_report">&nbsp; &nbsp; &nbsp; -
                                                Completeness Report
                                            </option>
                                            <option value="complete_review_report">&nbsp; &nbsp; &nbsp; - Complete
                                                Report
                                            </option>
                                            <option value="incomplete_review_report">&nbsp; &nbsp; &nbsp; -
                                                Incomplete Report
                                            </option>
                                            <option value="withdrawn_report">&nbsp; &nbsp; &nbsp; - Withdrawn
                                                Report
                                            </option>
                                            <option value="dep_clean_water_fund_report">&nbsp; &nbsp; &nbsp; - DEP/Clean
                                                Water
                                                Fund
                                            </option>
                                        </optgroup>
                                        <optgroup label="Secretary Reports">
                                            <option value="incoming_plans_report">&nbsp; &nbsp; &nbsp; - Incoming Plans
                                                Report
                                            </option>
                                            <option value="npdes_actions_report">&nbsp; &nbsp; &nbsp; - NPDES Actions
                                            </option>
                                            <option value="npdes_applications_report">&nbsp; &nbsp; &nbsp; - NPDES
                                                Applications
                                            </option>
                                            <option value="dep_fees_collected_report">&nbsp; &nbsp; &nbsp; - CWF Fees
                                                Collected
                                            </option>
                                            <option value="district_fee_collected_report">&nbsp; &nbsp; &nbsp; -
                                                District Fees Collected
                                            </option>
                                            <option value="generateXMLReport">&nbsp; &nbsp; &nbsp; - ICIS-NPDES
                                                Export
                                            </option>
                                        </optgroup>

                                        {{--                                        <option value="">Plan Counts</option>--}}
                                        <optgroup label="Technician Reports">
                                            <option value="admin_plans_on_shelf_report">&nbsp; &nbsp; &nbsp; - Admin
                                                Plans
                                                On Shelf
                                            </option>
                                            <option value="tech_plans_on_shelf_report">&nbsp; &nbsp; &nbsp; - Tech Plans
                                                On Shelf
                                            </option>
                                            <option value="monthly_review_report">&nbsp; &nbsp; &nbsp; - Reviews Report
                                            </option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 both-reports">
                                <div class="form-group">
                                    <label>Date Range</label>
                                    <input type="text" readonly
                                           class="form-control readonly-date date-range-picker">
                                    <input type="hidden" name="from" id="from">
                                    <input type="hidden" name="to" id="to">
                                </div>
                            </div>
                            <div class="col-md-6 icis-export-only " style="display: none;">
                                <div class="form-group">
                                    <label for="transaction-type">Transaction Type</label>
                                    <select class="form-control" name="transaction_type" id="transaction-type">
                                        <option value="N">New</option>
                                        <option value="R">Resubmit</option>
                                    </select>
                                </div>
                                <p><b>Please note:</b><br> This will generate and download one or many XML files in a
                                    Zip file for importing into ICIS.</p>
                            </div>
                            <div class="col-md-6 reports-only">
                                <div class="form-group">
                                    <label>Format</label>
                                    <select class="form-control" name="format">
                                        <option value="html">HTML</option>
                                        <option value="xls">Excel</option>
                                        <option value="pdf">PDF</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 reports-only">
                                <div class="form-group">
                                    <label for="technician">Technician</label>

                                    <select class="form-control" name="user_id" id="tech">
                                        <option value="">Select Technician</option>
                                        @if(isset($reviewers))
                                            @foreach($reviewers as $reviewer)
                                                <option value="{{$reviewer->id}}">{{$reviewer->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>

                                    {{--
                                                                        <select class="form-control" name="user_id" id="technician">
                                                                            <option value="">All Users</option>

                                    --}}
                                    {{--                                        @if(isset($users))--}}{{--

                                    --}}
                                    {{--                                            @foreach($users as $user)--}}{{--

                                    --}}
                                    {{--                                                <option value="{{$user->id}}">{{$user->name}}</option>--}}{{--

                                    --}}
                                    {{--                                            @endforeach--}}{{--

                                    --}}
                                    {{--                                        @endif--}}{{--


                                                                        </select>
                                    --}}
                                </div>
                            </div>
                            <div class="row w-100 mt-sm-4 ml-sm-5 ml-md-5 ml-lg-5 mt-lg-5">
                                <div class="col-md-4  offset-4 offset-lg-5">
                                    <button class="btn btn-sm btn-primary " id="btn-generate-report" type="submit">
                                        <strong>Generate Report</strong>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{asset('js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    <script type="text/javascript">
        $(function () {

            //validate inputs
            $('#btn-generate-report').on('click', function (e) {
                e.preventDefault();


                if ($('.date-range-picker').hasClass('error')) {

                    return 0;
                }

                $('#form-reports').submit();

            });


            $('#report-type').on('change', function () {


                //currently selected technician
                var selectedValue = $(this).val();

                var date_picker = $('.date-range-picker');
                var technician_selector = $('#technician');


                //enable date range and technician field by default
                enableField(date_picker);
                enableField(technician_selector);

                if (selectedValue === 'tech_plans_on_shelf_report' ||
                    selectedValue === 'admin_plans_on_shelf_report') {

                    disableField(date_picker);
                }

                //disable technician and date range
                if (selectedValue === 'monthly_review_report' ||
                    selectedValue === 'padot_hours_report' ||
                    selectedValue === 'completeness_report' ||
                    selectedValue === 'complete_review_report' ||
                    selectedValue === 'incomplete_review_report' ||
                    selectedValue === 'withdrawn_report' ||
                    selectedValue === 'incoming_plans_report') {

                    disableField(technician_selector);

                }

                if ($(this).val() === 'generateXMLReport') {

                    $('.reports-only').hide();
                    $('.icis-export-only').show();

                } else {

                    $('.icis-export-only').hide();
                    $('.reports-only').show();
                }
            })
        });


        function enableField(field) {
            //remove disabled
            field.attr('disabled', false).removeClass('disabled');
            field.attr('disabled', false);
        }

        function disableField(field) {
            field.val('');
            field.attr('disabled', true).addClass('disabled');
        }
    </script>
@endpush

