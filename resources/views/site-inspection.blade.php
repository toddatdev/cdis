@extends('layouts.app')

@section('title', 'Site Inspection | CDIS - Dashboard')
@push('css')
    <!-- Jquery Smart Wizard Plugin CSS -->
    <link href="{{asset('css/plugins/smart-wizard/css/smart_wizard.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/plugins/smart-wizard/css/smart_wizard_theme_arrows.css')}}" rel="stylesheet"
          type="text/css"/>


    <!-- jQuery UI -->
    <link href="{{asset('css/plugins/jQueryUI/jquery-ui.css')}}" rel="stylesheet">

    <!--  Jquery Plugins  -->
    <link href="{{asset('css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">

    <!-- Toastr style -->
    <link href="{{asset('css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">

    <!-- Sweet Alert -->
    <link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">

    <!-- I Checks   -->
    <link rel="stylesheet" href="{{asset('css/plugins/iCheck/custom.css')}}">

    <link href="{{asset('css/plugins/clockpicker/clockpicker.css')}}" rel="stylesheet">

    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/cdis.css')}}">
@endpush
@section('breadcrumb')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10 pt-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('dashboard')}}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a>Sites</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Inspection Form</strong>
                </li>
            </ol>
        </div>
        <div class="col-md-2 pt-2">
            <a href="{{route('projects.edit', request()->id)}}" class="btn btn-outline  btn-primary btn-block">
                Return to Edit Project
            </a>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-10 offset-1">
            <div class="ibox">
                <div class="">
                    <div class="m-0 bg-white">
                        <div id="smartwizard">
                            <ul>
                                <li><a href="#step-1">
                                        <br>
                                        <p>Project Information</p>
                                    </a></li>
                                <li><a href="#step-2"><br>
                                        <p>Permit and Plan Requirements</p>
                                    </a></li>
                                <li><a href="#step-3"><br/>
                                        <p>Inspection Findings</p>
                                    </a></li>
                            </ul>
                            <div>
                                <div id="step-1" class="pt-5 p-3">
                                    <form action="{{route('inspection.info.store')}}" id="form-step-0" method="post">
                                        @csrf
                                        {{-- If empty means user is creating new inspection otherwise updating it--}}
                                        <input type="hidden" name="inspection_id" class="inspection-id" value="">
                                        <div class="ibox border-light">
                                            <h3 class="ibox-title bg-light">Project Details</h3>
                                            <div class="ibox-content">
                                                <div class="row">
                                                    <div class="form-group col-md-3">
                                                        <div class="form-group">
                                                            <label for="entry-number">Entry Number</label>
                                                            <input type="text" class="form-control entry-number"
                                                                   name="entry_number"
                                                                   value="{{$project->id ?? ''}}" id="entry-number"
                                                                   readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="technician">Technician</label>
                                                        <select class="form-control technician" id="technician" name="technician">
                                                            <option value="">Select Technician</option>
                                                            @foreach($reviewers as $reviewer)
                                                                @if((int)($project->projectDetails->reviewer_id ?? '') === $reviewer->id)
                                                                    <option value="{{$reviewer->id}}"
                                                                            selected>{{$reviewer->name}}</option>
                                                                @else
                                                                    <option value="{{$reviewer->id}}">{{$reviewer->name}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="report-number">Report Number</label>
                                                        <input type="text" class="form-control"
                                                               id="report-number" name="report_number">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="project-name">Project Name</label>
                                                        <input type="text" class="project-name form-control" name="project_name"
                                                               id="project-name"
                                                               value="{{$project->name ?? ''}}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-3 "
                                                         data-placement="left" data-align="top"
                                                         data-autoclose="true">
                                                        <label for="inspection-date">Inspection Date</label>
                                                        <input type="text" class="form-control datepicker readonly-date"
                                                               id="inspection-date" readonly placeholder="MM/DD/YYYY"
                                                               name="inspection_date">
                                                    </div>
                                                    <div class="form-group clockpicker col-md-3"
                                                         data-autoclose="true">
                                                        <label for="taxparcel">Inspection Time</label>
                                                        <input type="text" class="form-control readonly-date"
                                                               value="09:30"
                                                               id="taxparcel" readonly name="inspection_time">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="watershed">Designated/Existing Use</label>
                                                        <input type="text" class="form-control"
                                                               id="watershed" name="designated">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="receiving_stream">Weather</label>
                                                        <input type="text" class="form-control" value=""
                                                               id="receiving_stream" name="weather">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="site-rep">Site Representatives</label>
                                                        <input type="text" class="form-control" id="site-rep"
                                                               name="site_rep">
                                                    </div>

                                                    <div class="form-group col-md-3">
                                                        <label for="ownership">Site Representative Title</label>
                                                        <input type="text" class="form-control"
                                                               id="ownership" name="site_rep_title">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="ch_93">Site Inspector</label>
                                                        <input type="text" class="form-control" id="ch_93"
                                                               name="site_insp">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="total_acres">Site Inspector Title</label>
                                                        <input type="text" class="form-control"
                                                               id="total_acres" name="site_insp_title">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="inspection-type">Inspection Type</label>
                                                        <select name="inspection_type" class="form-control"
                                                                id="inspection-type">
                                                            <option value="">Select Inspection Type</option>
                                                            <option value="complete">Complete</option>
                                                            <option value="partial">Partial
                                                            </option>
                                                            <option value="follow_up">Follow Up
                                                            </option>
                                                            <option value="complaint">Complaint</option>
                                                            <option value="final">Final</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="disturbed_acres">Tax Parcel Number</label>
                                                        <input type="text" class="form-control" name="tax_parcel_number"
                                                               id="disturbed_acres" value="{{$project->projectDetails->tax_parcel ?? ''}}">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="disturbed_acres">Photographs Taken</label>
                                                        <div class="i-checks  mt-2">
                                                            <label class="checkbox-inline">
                                                                <input type="radio" value="1" name="photos_taken">
                                                                <i></i> Yes
                                                            </label>
                                                            <label class="ml-2">
                                                                <input type="radio" value="0" name="photos_taken"
                                                                       checked>
                                                                <i></i>
                                                                No</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="disturbed_acres">Site Descriptions and
                                                            Observations</label>
                                                        <textarea name="site_description" id=""
                                                                  class="form-control"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="step-2" class="pt-5 p-3">
                                    <form action="{{route('inspection.permit.store')}}" id="form-step-1" method="post">
                                        @csrf
                                        {{-- If empty means user is creating new inspection otherwise updating it--}}
                                        <input type="hidden" name="inspection_id" class="inspection-id" value="">

                                        <div class="ibox border-light">
                                            <h3 class="ibox-title bg-light">Permit and Plan Requirements</h3>
                                            <div class="ibox-content">
                                                <div class="row">
                                                    <div class="col-sm-1">
                                                        <strong>Yes</strong>
                                                    </div>
                                                    <div class="col-sm-1 text-left">
                                                        <strong>No</strong>
                                                    </div>
                                                    <div class="form-group col-sm-5">
                                                        <strong>Item</strong>
                                                    </div>
                                                    <div class="col-sm-5 text-center">
                                                        <strong>Type of Activity</strong>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-1">
                                                        <div class="i-checks ">
                                                            <label class="checkbox-inline">
                                                                <input type="radio" value="1"
                                                                       name="written_erosion_required">
                                                                <i></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <div class="i-checks ">
                                                            <label class="checkbox-inline">
                                                                <input type="radio" value="0"
                                                                       name="written_erosion_required" checked>
                                                                <i></i>
                                                            </label>

                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p>Written Erosion and Sediment Plan Required</p>
                                                    </div>
                                                    <div class="col-sm-4 offset-md-2">
                                                        <div class="i-checks">
                                                            <label for="prc">
                                                                <input type="hidden" value="0" name="prc">
                                                                <i></i>
                                                                <input type="checkbox" value="1" id="prc" name="prc">
                                                                <i></i>
                                                                <span class="pl-1"> Pub. Road Constr./Maintenance (PRC)</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-1">
                                                        <div class="i-checks ">
                                                            <label class="checkbox-inline">
                                                                <input type="radio" value="1"
                                                                       name="post_const_written">
                                                                <i></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <div class="i-checks ">
                                                            <label class="checkbox-inline">
                                                                <input type="radio" value="0"
                                                                       name="post_const_written" checked>
                                                                <i></i>
                                                            </label>

                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p>Written Post Construction Storm Water Management
                                                            Plan</p>
                                                    </div>
                                                    <div class="col-sm-4 offset-md-2">
                                                        <div class="i-checks">
                                                            <label for="rsbd">
                                                                <input type="hidden" value="0" name="rsbd">
                                                                <i></i>
                                                                <input type="checkbox" value="1" id="rsbd" name="rsbd">
                                                                <i></i>
                                                                <span class="pl-1">Res Subdivision (RSBD)</span></label>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-1">
                                                        <div class="i-checks ">
                                                            <label class="checkbox-inline">
                                                                <input type="radio" value="1"
                                                                       name="written_erosion_requested">
                                                                <i></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <div class="i-checks ">
                                                            <label class="checkbox-inline">
                                                                <input type="radio" value="0"
                                                                       name="written_erosion_requested" checked>
                                                                <i></i>
                                                            </label>

                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p>Written Erosion and Sediment Plan Requested</p>
                                                    </div>
                                                    <div class="col-sm-4 offset-md-2">
                                                        <div class="i-checks">
                                                            <label for="gov">
                                                                <input type="hidden" value="0" name="gov">
                                                                <input type="checkbox" value="1" id="gov" name="gov">
                                                                <i></i>
                                                                <span class="pl-1">Gov. Facilities (GOV)</span></label>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-1">
                                                        <div class="i-checks ">
                                                            <label class="checkbox-inline">
                                                                <input type="radio" value="1"
                                                                       name="pcsm_requested">
                                                                <i></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <div class="i-checks ">
                                                            <label class="checkbox-inline">
                                                                <input type="radio" value="0"
                                                                       name="pcsm_requested" checked>
                                                                <i></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p>Post Construction Stormwater Management Plan
                                                            requested</p>
                                                    </div>
                                                    <div class="col-sm-4 offset-md-2">
                                                        <div class="i-checks">
                                                            <label for="utl">
                                                                <input type="hidden" value="0" name="utl">
                                                                <input type="checkbox" value="1" id="utl" name="utl">
                                                                <i></i>
                                                                <span class="pl-1">	Utilities Facilities (UTL)</span></label>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-1">
                                                        <div class="i-checks ">
                                                            <label class="checkbox-inline">
                                                                <input type="radio" value="1" name="esp_required">
                                                                <i></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <div class="i-checks ">
                                                            <label class="checkbox-inline">
                                                                <input type="radio" value="0"
                                                                       name="esp_required" checked>
                                                                <i></i>
                                                            </label>

                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p>E & S Plan Required</p>
                                                    </div>
                                                    <div class="col-sm-4 offset-md-2">
                                                        <div class="i-checks">
                                                            <label for="sws">
                                                                <input type="hidden" value="0" name="sws">
                                                                <input type="checkbox" value="1" id="sws" name="sws">
                                                                <i></i>
                                                                <span class="pl-1"> Sewer Water Facilities (SWS) </span></label>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-1">
                                                        <div class="i-checks ">
                                                            <label class="checkbox-inline">
                                                                <input type="radio" value="1"
                                                                       name="npdes_required">
                                                                <i></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <div class="i-checks ">
                                                            <label class="checkbox-inline">
                                                                <input type="radio" value="0"
                                                                       name="npdes_required" checked>
                                                                <i></i>
                                                            </label>

                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p>NPDES Permit Required</p>
                                                    </div>
                                                    <div class="col-sm-4 offset-md-2">
                                                        <div class="i-checks">
                                                            <label for="rrs">
                                                                <input type="hidden" value="0" name="rrs">
                                                                <input type="checkbox" value="1" id="rrs" name="rrs">
                                                                <i></i>
                                                                <span class="pl-1"> Redmediation/Restoration Services</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-1">
                                                        <div class="i-checks ">
                                                            <label class="checkbox-inline">
                                                                <input type="radio" value="1" name="phased_const">
                                                                <i></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <div class="i-checks ">
                                                            <label class="checkbox-inline">
                                                                <input type="radio" value="0"
                                                                       name="phased_const" checked>
                                                                <i></i>
                                                            </label>

                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p>Phased Constr.</p>
                                                    </div>
                                                    <div class="col-sm-4 offset-md-2">
                                                        <div class="i-checks">
                                                            <label for="prrs">
                                                                <input type="hidden" value="0" name="prrs">
                                                                <input type="checkbox" value="1" id="prrs" name="prrs">
                                                                <i></i>
                                                                <span class="pl-1">Private Road or Residence (PRRS) </span></label>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-1">
                                                        <div class="i-checks ">
                                                            <label class="checkbox-inline">
                                                                <input type="radio" value="1"
                                                                       name="non_phased_const">
                                                                <i></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <div class="i-checks ">
                                                            <label class="checkbox-inline">
                                                                <input type="radio" value="0"
                                                                       name="non_phased_const" checked>
                                                                <i></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p>Non-Phased Constr.</p>
                                                    </div>
                                                    <div class="col-sm-4 offset-md-2">
                                                        <div class="i-checks">
                                                            <label for="cmin">
                                                                <input type="hidden" value="0" name="cmin">
                                                                <input type="checkbox" value="1" id="cmin" name="cmin">
                                                                <i></i>
                                                                <span class="pl-1">Comm/Industry Development (CMIN)</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-1"></div>
                                                    <div class="col-sm-1"></div>
                                                    <div class="col-sm-4"></div>
                                                    <div class="col-sm-4 offset-md-2">
                                                        <div class="i-checks">
                                                            <label for="recf">
                                                                <input type="hidden" value="0" name="recf"> <i></i>
                                                                <input type="checkbox" value="1" id="recf" name="recf">
                                                                <i></i>
                                                                <span class="pl-1"> Recreation Facilities (RECF) </span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-1"></div>
                                                    <div class="col-sm-1"></div>
                                                    <div class="col-sm-4"></div>
                                                    <div class="col-sm-4 offset-md-2">
                                                        <div class="i-checks">
                                                            <label for="aga">
                                                                <input type="hidden" value="0" name="aga">
                                                                <input type="checkbox" value="1" id="aga" name="aga">
                                                                <i></i>
                                                                <span class="pl-1">	Agricultural Activities (AGA)</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-1"></div>
                                                    <div class="col-sm-1"></div>
                                                    <div class="col-sm-4"></div>
                                                    <div class="col-sm-4 offset-md-2">
                                                        <div class="i-checks">
                                                            <label for="pl">
                                                                <input type="hidden" value="0" name="pl">
                                                                <input type="checkbox" value="1" id="pl" name="pl">
                                                                <i></i>
                                                                <span class="pl-1">Pipeline (PL)</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-1"></div>
                                                    <div class="col-sm-1"></div>
                                                    <div class="col-sm-4"></div>
                                                    <div class="col-sm-4 offset-md-2">
                                                        <div class="i-checks">
                                                            <label for="silv">
                                                                <input type="hidden" value="0" name="silv">
                                                                <input type="checkbox" value="1" id="silv" name="silv">
                                                                <i></i>
                                                                <span class="pl-1">	Silviculture (SILV)</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-1"></div>
                                                    <div class="col-sm-1"></div>
                                                    <div class="col-sm-4"></div>
                                                    <div class="col-sm-4 offset-md-2">
                                                        <div class="i-checks">
                                                            <label for="other">
                                                                <input type="hidden" value="0" name="other">
                                                                <input type="checkbox" value="1" id="other"
                                                                       name="other"> <i></i>
                                                                <span class="pl-1">	Other</span></label>
                                                            <input type="text" class="form-control" name="other_value">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="step-3" class="pt-5 p-3">
                                    <form action="{{route('inspection.findings.store')}}" id="form-step-2"
                                          method="post">
                                        @csrf
                                        {{-- If empty means user is creating new inspection otherwise updating it--}}
                                        <input type="hidden" name="inspection_id" class="inspection-id" value="">
                                        <input type="hidden" name="project_id" class="project-id"
                                               value="{{$project->id ?? ''}}">

                                        <div class="ibox border-light">
                                            <h3 class="ibox-title bg-light">Inspection Findings<br>
                                            </h3>
                                            <div class="ibox-content">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="i-checks">
                                                            <label for="violations_obs">
                                                                <input type="checkbox" value="na" id="violations_obs"
                                                                       name="violations[]"> <i></i>
                                                                <span class="pl-1">1. No Violations Observed at this time.</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="hr-line-dashed">
                                                <div class="row px-3">
                                                    <div class="col-sm-12">
                                                        <div class="i-checks pb-3">
                                                            <label for="admin">
                                                                <strong class="pl-1">2. Failure To (check all
                                                                    that apply): </strong></label>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="i-checks">
                                                                    <label for="a">
                                                                        <input type="checkbox" value="a" id="a"
                                                                               name="violations[]">
                                                                        <span class="pl-1">
               a. develop a written erosion and sediment (E&amp;S) plan (102.4)
               </span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="i-checks">
                                                                    <label for="b">
                                                                        <input type="checkbox" value="b" id="b"
                                                                               name="violations[]">
                                                                        <span class="pl-1">b. have E&amp;S plan available onsite (102.4)</span></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="i-checks">
                                                                    <label for="c">
                                                                        <input type="checkbox" value="c" id="c"
                                                                               name="violations[]">
                                                                        <span class="pl-1">c. submit and E&amp;S plan as requested (102.4)</span></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="i-checks">
                                                                    <label for="d">
                                                                        <input type="checkbox" value="d" id="d"
                                                                               name="violations[]">
                                                                        <span class="pl-1">d. implement effective E&S Best Management Practices (BMPs) (102.4)</span></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="i-checks">
                                                                    <label for="e">
                                                                        <input type="checkbox" value="e" id="e"
                                                                               name="violations[]">
                                                                        <span class="pl-1"> e. maintain effective E&amp;S BMPs (102.4)</span></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 my-3">
                                                                <div class="i-checks">
                                                                    <label for="f">
                                                                        <input type="checkbox" value="f" id="f"
                                                                               name="violations[]">
                                                                        <span class="pl-1"> f. use Antidegredation Best Available Combination of Technologies (ABACT) discharges to High Quality or Exception Value Waters (102.4)</span></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 my-3">
                                                                <div class="i-checks">
                                                                    <label for="g">
                                                                        <input type="checkbox" value="g" id="g"
                                                                               name="violations[]">
                                                                        <span class="pl-1"> g. obtain an NPDES Permit for Stormwater Discharges Associated with construction activities. (102.5)</span></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="i-checks">
                                                                    <label for="h">
                                                                        <input type="checkbox" value="h" id="h"
                                                                               name="violations[]">
                                                                        <span class="pl-1"> h. obtain an E&amp;S permit (102.5)</span></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="i-checks">
                                                                    <label for="i">
                                                                        <input type="checkbox" value="i" id="i"
                                                                               name="violations[]">
                                                                        <span class="pl-1"> i. prepare and implement a PPC Plan (102.5)</span></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="i-checks">
                                                                    <label for="j">
                                                                        <input type="checkbox" value="j" id="j"
                                                                               name="violations[]">
                                                                        <span class="pl-1"> j. submit Notice of Termination (102.7)</span></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 mb-2">
                                                                <div class="i-checks">
                                                                    <label for="k">
                                                                        <input type="checkbox" value="k" id="k"
                                                                               name="violations[]">
                                                                        <span class="pl-1"> k. develop written Post Construction Stormwater Management (PCSM) Plan (102.5)</span></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="i-checks">
                                                                    <label for="l">
                                                                        <input type="checkbox" value="l" id="l"
                                                                               name="violations[]">
                                                                        <span class="pl-1"> l. have PCSM Plan available onsite (102.5)</span></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="i-checks">
                                                                    <label for="m">
                                                                        <input type="checkbox" value="m" id="m"
                                                                               name="violations[]">
                                                                        <span class="pl-1"> m. submit PCSM Plan as requested (102.5)</span></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="i-checks">
                                                                    <label for="n">
                                                                        <input type="checkbox" value="n" id="n"
                                                                               name="violations[]">
                                                                        <span class="pl-1"> n. implement effective PCSM BMPs (102.5)</span></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="i-checks">
                                                                    <label for="o">
                                                                        <input type="checkbox" value="o" id="o"
                                                                               name="violations[]">
                                                                        <span class="pl-1"> o. maintain effective PCSM BMPs (102.5)</span></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="i-checks">
                                                                    <label for="p">
                                                                        <input type="checkbox" value="p" id="p"
                                                                               name="violations[]">
                                                                        <span class="pl-1"> p. perform reporting and recordkeeping as required (102.5)</span></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="i-checks">
                                                                    <label for="q">
                                                                        <input type="checkbox" value="q" id="q"
                                                                               name="violations[]">
                                                                        <span class="pl-1"> q. implement riparian buffer or riparian forest buffer (102.14)</span></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="i-checks">
                                                                    <label for="r">
                                                                        <input type="checkbox" value="r" id="r"
                                                                               name="violations[]">
                                                                        <span class="pl-1"> r. meet regulatory requirements for riparian forest buffer (102.14)
               </span></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="i-checks">
                                                                    <label for="s">
                                                                        <input type="checkbox" value="s" id="s"
                                                                               name="violations[]">
                                                                        <span class="pl-1"> s. provide temporary stabilization of the earth disturbance site (102.22)</span></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="i-checks">
                                                                    <label for="t">
                                                                        <input type="checkbox" value="t" id="t"
                                                                               name="violations[]">
                                                                        <span class="pl-1"> t. provide permanent stabilization of the earth disturbance site (102.22)</span></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="i-checks">
                                                                    <label for="u">
                                                                        <input type="checkbox" value="u" id="u"
                                                                               name="violations[]">
                                                                        <span class="pl-1"> u. comply with permit conditions (402 CSL)
               </span></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="hr-line-dashed">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="i-checks">
                                                            <label for="sopd_csl">

                                                                <input type="checkbox" value="pollutant_discharged" name="violations[]"
                                                                       id="sopd_csl"> <i></i>
                                                                <span class="pl-1">3. Sediment or other pollutant was discharged into waters of the Commonwealth. (402 CSL) </span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="i-checks">
                                                            <label for="scpp_csl">
                                                                <input type="hidden" value="0" name="scpp_csl">
                                                                <input type="checkbox" value="pollutant_potential" name="violations[]"
                                                                       id="scpp_csl"> <i></i>
                                                                <span class="pl-1">4. Site conditions present a potential for pollution to waters of the Commonwealth. (402 CSL) </span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="i-checks">
                                                            <label for="dept_comply">
                                                                <input type="checkbox" value="vio_department_order" name="violations[]"
                                                                       id="dept_comply"> <i></i>
                                                                <span class="pl-1">Failure to Comply with Department Order </span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="i-checks">
                                                            <label for="pcsm_comply">
                                                                <input type="checkbox" value="vio_pcsm_long_term" id="pcsm_comply"
                                                                       name="violations[]"> <i></i>
                                                                <span class="pl-1">Failure to comply with PCSM long-term operation and maintenance requirements. </span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="i-checks">
                                                            <label for="no_meeting">
                                                            <input type="checkbox" value="preconstruction_meeting" id="no_meeting"
                                                                       name="violations[]"> <i></i>
                                                                <span class="pl-1">Failure to conduct a pre construction meeting. </span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 my-3">
                                                        <div class="i-checks">
                                                            <label for="no_proof">
                                                                <input type="checkbox" value="aa" id="no_proof"
                                                                       name="violations[]"> <i></i>
                                                                <span class="pl-1">Failure to provide proof of consultation with the Pennsylvania Natural Heritage Program regarding the presence of a State or Federal threatened or endangered species on a project site requiring a Chapter 102 permit. </span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 my-3">
                                                        <div class="i-checks">
                                                            <label for="no_permit">
                                                                <input type="checkbox" value="bb" id="no_permit"
                                                                       name="violations[]"> <i></i>
                                                                <span class="pl-1">Failure to withhold a building or other permit or approval from those proposing or conducting earth disturbance activities, which require a Department permit, until the Department or conservation district has approved/acknowledged the Chapter 102 permit. </span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 my-3">
                                                        <div class="i-checks">
                                                            <label for="violation_exists">

                                                                <input type="checkbox" value="1" id="violation_exists"
                                                                       name="violation_exists"> <i></i>
                                                                <span class="pl-1 font-bold"> Inspection of this project has revealed site conditions which constitute violations of 25 Pa. Code Chapters 92a and/or 102 and the Clean Streams Law, the act of June 22, 1937, P.L. 1987, 35 P.S. §691.1 et seq. </span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <label for="cam">
                                                            Compliance Assistance Measures
                                                        </label>
                                                        <textarea name="cam" id="cam" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-sm-6 ">
                                                        <div class="form-group">
                                                            <label for="fui_date">
                                                                Follow Up Inspection Will Occur On or About This
                                                                Date
                                                            </label>
                                                            <input type="text" placeholder="MM/DD/YYYY"
                                                                   class="form-control datepicker readonly-date us-date"
                                                                   id="fui_date" readonly>
                                                            <input type="hidden" class="form-control ymd-date-input"
                                                                   id="plan_date" readonly name="fui_date">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3 ">
                                                        <div class="form-group">
                                                            <label for=""> Date Filed </label>
                                                            <input type="text"
                                                                   class="form-control datepicker readonly-date"
                                                                   readonly placeholder="MM/DD/YYYY" id="date">
                                                            <input type="hidden" class="form-control ymd-date-input"
                                                                   readonly
                                                                   name="date">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3 ">
                                                        <div class="form-group">
                                                            <label for="">
                                                                Email Report To
                                                            </label>
                                                            <input type="text" class="form-control" name="email">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <!-- Input Mask Jquery Plugin -->
    <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>

    <!-- Summer Note -->
    <script src="{{asset('js/plugins/summernote/summernote-bs4.js')}}"></script>

    <!-- Icheck -->
    <script src="{{asset('js/plugins/iCheck/icheck.min.js')}}"></script>

    <!-- Clock picker -->
    <script src="{{asset('js/plugins/clockpicker/clockpicker.js')}}"></script>

    <!-- Toastr -->
    <script src="{{asset('js/plugins/toastr/toastr.min.js')}}"></script>

    <!-- Sweet alert -->
    <script src="{{asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>

    <!-- jQuery UI -->
    <script src="{{asset('js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    <!-- Include jQuery Validator plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>

    <!-- Include SmartWizard JavaScript source -->
    <script type="text/javascript" src="{{asset('js/plugins/smart-wizard/js/jquery.smartWizard.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('js/cdis.js')}}"></script>

    <script type="text/javascript" src="{{asset('js/site-inspection.js')}}"></script>
@endpush
