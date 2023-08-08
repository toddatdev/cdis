@extends('layouts.app')

@editMode
@section('title', 'Edit Project | CDIS - Dashboard')
@else
    @section('title', 'New Project | CDIS - Dashboard')
@endEditMode

@push('css')
    <!-- Jquery Smart Wizard Plugin CSS -->
    <link href="{{asset('css/plugins/smart-wizard/css/smart_wizard.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/plugins/smart-wizard/css/smart_wizard_theme_arrows.css')}}" rel="stylesheet"
          type="text/css"/>

    <link href="{{asset('css/plugins/jQueryUI/jquery-ui.css')}}" rel="stylesheet">
    <!--  Jquery Plugins  -->
    <link href="{{asset('css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">

    <link href="{{asset('css/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">

    <!-- I Checks   -->
    <link rel="stylesheet" href="{{asset('css/plugins/iCheck/custom.css')}}">

    <!-- Toastr style -->
    <link href="{{asset('css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">

    <!-- Sweet Alert -->
    <link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">


    <link href="{{asset('css/style.css" rel="stylesheet')}}">
    {{--    <link href="{{asset('css/plugins/bootstrapSocial/bootstrap-social.css')}}'" rel="stylesheet">--}}

    <style type="text/css">

        table::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        table::-webkit-scrollbar-track {
            background: rgba(0,0,0,.1);
        }
        table::-webkit-scrollbar-thumb {
            background-color: rgba(0,0,0,.3) ;
            border-radius: 6px;
            /*border: 3px solid var(--scrollbarBG);*/
        }



        .ibox.border-light {
            border-left: 1px solid #dee2e6 !important;
            border-right: 1px solid #dee2e6 !important;
            border-bottom: 1px solid #dee2e6 !important;
        }

        .datepicker {
            z-index: 99999999 !important;
        }

        /* ** Smart wizard plugin overrides
          **  active arrow background ***/

        .sw-theme-arrows > ul.step-anchor > li.active > a {
            background-color: #18a689 !important;
        }

        .sw-theme-arrows > ul.step-anchor > li.active > a:after {
            border-left: 30px solid #18a689 !important;
        }

        .ibox-content {
            position: relative;
        }

        .note-editor.note-frame .note-editing-area .note-codable {
            padding-top: 30px !important;
        }

        .readonly-date {
            background-color: #fff !important;
        }

        #pagination {
            max-width: 100%;
            overflow: auto;
        }
    </style>

@endpush

@section('breadcrumb')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-md-3">
            @editMode
            <h2 id="create-project-heading">Edit Project</h2>
            @else
                <h2 id="create-project-heading">Create New Project</h2>
                @endEditMode
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{route('dashboard')}}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a>Projects</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong id="project-breadcrumb-name">
                            @editMode
                            {{$project->name ?? ''}}
                            @else
                                Create New Project
                                @endEditMode
                        </strong>
                    </li>
                </ol>
        </div>
        <div class="col-md-2 pt-3"><a href="{{route('projects.search.index')}}"
                                      class="btn btn-outline  btn-primary btn-block mt-4">Search
                Plan Entries</a></div>
        <div class="col-md-2 pt-3">
            <a href="{{route('letter.show')}}{{isset($project->id)? '/'. $project->id : '' }}"
               id="btn-generate-letter"
               class="btn btn-outline btn-breadcrumb btn-primary {{!isset($project->id) ? 'disabled' : ''}} btn-block mt-4">Generate
                Letter</a>
        </div>
        <div class="col-md-2 pt-3"><a
                href="{{route('site.inspection')}}{{isset($project->id)? '/'. $project->id : '' }}"
                id="btn-site-inspection"
                class="btn btn-outline btn-primary btn-breadcrumb {{!isset($project->id) ? 'disabled' : ''}} btn-block mt-4">Site
                Inspection</a></div>

        <div class="col-md-2 pt-3"><a
                href="{{route('project.changelog', $project->id ?? '')}}"
                id="btn-site-inspection"
                class="btn btn-outline btn-primary btn-breadcrumb {{!isset($project->id) ? 'disabled' : ''}} btn-block mt-4">View
                Changelogs</a></div>

    </div>
@endsection
@section('content')
    <div class="modal  show" id="modal-edit-co-permittee" tabindex="-1" role="dialog" style="z-index: 9999 !important;">
        <div class="modal-dialog" style="min-width: 800px;">
            <div class="modal-content animated fadeIn">
                <form action="{{route('projects.permittee.store')}}" method="post" id="form-co-permittee-edit">
                    @csrf
                    {{-- If empty means user is creating new project otherwise updating a project--}}
                    <input type="hidden" name="project_id" class="project-id"
                           value="{{$project->id ?? ''}}">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title text-white">Edit / View Co-Permittee</h4>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="modal-edit-co-permittee-body"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 offset-xl-1 col-xl-10">
            @if((int)($project->is_closed ?? '') === 1)

                <div class="alert alert-warning alert-dismissible fade plan-alert show d-flex justify-content-between"
                     role="alert">
                    <div class="mt-1">
                        <strong>This Plan is closed!</strong> <span>provided</span>
                        <span
                            class="bg-white p-1 "><strong>Closing Date: </strong><span>{{ sqlToHtmlDate($project->close->closing_date ?? '')}} </span></span>
                        <span
                            class="bg-white p-1 ml-1"><strong> Box Number:</strong> <span>{{$project->close->box_number ?? ''}}</span></span>
                        <span
                            class="bg-white p-1 ml-1"><strong>Reason: </strong><span>{{$project->close->reason ?? ''}}</span></span>
                        <span
                            class="bg-white p-1 ml-1"><strong>Notes: </strong><span>{{$project->close->notes ?? ''}} </span></span>
                    </div>
                    <div>
                        @if((int)($project->is_closed ?? '') === 1)
                            <a href="#modal-close-plan" data-toggle="modal"
                               class="btn btn-primary text-white btn-sm" id="btn-activate-plan"
                               data-url="{{route('projects.activate', $project->id ?? '')}}"><strong>Activate
                                    Plan</strong></a>
                        @endif
                    </div>
                </div>
            @endif
            <div class="mt-4">
                <div id="smartwizard" class="bg-white">
                    <ul>
                        <li><a href="#step-1"><br/>
                                <p>Create</p>
                            </a></li>
                        <li>
                            <a href="#step-2"><br/>
                                <p>Project Info</p>
                            </a></li>
                        <li><a href="#step-3"><br/>
                                <p>Physical Location</p>
                            </a></li>
                        <li><a href="#step-4"><br/>
                                <p>Applicant Info</p>
                            </a></li>
                        <li><a href="#step-5"><br/>
                                <p>Engineer Info</p>
                            </a></li>
                        <li><a href="#step-6"><br/>
                                <p>Permit Info</p>
                            </a></li>
                        <li><a href="#step-7"><br/>
                                <p>Fees Info</p>
                            </a></li>
                        <li><a href="#step-8"><br/>
                                <p>Reviews</p>
                            </a></li>
                        <li>
                            <a href="#step-9"><br/>
                                <p>Misc Information</p>
                            </a>
                        </li>
                    </ul>
                    <div id="form-new-project-wizard" data-toggle="validator" style="min-height: auto !important;">
                        <div id="step-1" class="pt-5 p-3">
                            <form action="{{route('projects.store')}}" method="post" id="form-step-0"
                                  data-toggle="validator">
                                @csrf
                                {{-- If empty means user is creating new project otherwise updating a project--}}
                                <input type="hidden" name="project_id" class="project-id"
                                       value="{{$project->id ?? ''}}">
                                {{-- County Id will be used to diffrentiate b/w projects from different counties--}}
                                <input type="hidden" name="county_id" id="county"
                                       value="{{session('county_id')}}">
                                <div class="ibox border-light">
                                    <h3 class="ibox-title bg-light">Basic Information</h3>
                                    <div class="ibox-content">
                                        <div class="row">
                                            @editMode
                                            <div class="form-group col-md-12" id="project-name-box">
                                                <label for="project-name">Project Name
                                                    <small>(Required)</small>
                                                </label>
                                                <input type="text" class="form-control"
                                                       name="name"
                                                       value="{{$project->name ?? ''}}"
                                                       id="project-name"
                                                       autofocus required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                            @else
                                                <div class="form-group col-md-6" id="project-name-box">
                                                    <label for="project-name">Project Name
                                                        <small>(Required)</small>
                                                    </label>
                                                    <input type="text" class="form-control"
                                                           name="name"
                                                           value="{{$project->name ?? ''}}"
                                                           id="project-name"
                                                           autofocus required>
                                                    <div class="help-block with-errors"></div>
                                                </div>

                                                <div class="form-group col-md-6" id="plan-type-box">
                                                    <label for="plan-type">Plan Type
                                                        <small>(Required)</small>
                                                    </label>
                                                    <select name="plan_type" class="form-control"
                                                            id="plan-type" required>
                                                        <option value="">Select Plan Type</option>
                                                        @foreach($options['plan_types'] as $key => $option)
                                                            @if(($project->plan_type ?? '') === $key)
                                                                <option value="{{$key}}" selected>{{$option}}</option>
                                                            @else
                                                                <option value="{{$key}}">{{$option}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                                @endEditMode
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="step-2" class="pt-5 p-3" style="">
                            <form action="{{route('projects.details.store')}}" method="post" id="form-step-1">
                                @csrf
                                {{-- If empty means user is creating new project otherwise updating a project--}}
                                <input type="hidden" name="project_id" class="project-id"
                                       value="{{$project->id ?? ''}}">
                                <div class="ibox border-light position-relative">
                                    <h3 class="ibox-title bg-light">Project Details</h3>
                                    <div class="ibox-content" id="project-details-content">
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <div class="form-group">
                                                    <label for="id">Entry Number</label>
                                                    <input type="text" class="form-control project-id"
                                                           value="{{$project->id ?? ''}}" id="id" disabled="disabled">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="technician">Technician</label>
                                                <select class="form-control" name="reviewer_id" id="technician">
                                                    <option value="">Select Technician</option>
                                                    @if(isset($reviewers))
                                                        @foreach($reviewers as $reviewer)
                                                            @if((int)($project->projectDetails->reviewer_id ?? '') === $reviewer->id)
                                                                <option value="{{$reviewer->id}}"
                                                                        selected>{{$reviewer->name}}</option>
                                                            @else
                                                                <option
                                                                    value="{{$reviewer->id}}">{{$reviewer->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>

                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="municipality">Municipality</label>
                                                <select class="form-control" name="municipality_id" id="municipality">
                                                    <option value="">Select Municipality</option>
                                                    @if(isset($municipalities))
                                                        @foreach($municipalities as $municipality)
                                                            @if((int)($project->projectDetails->municipality_id ?? '') === (int)$municipality->id)
                                                                <option value="{{$municipality->id}}"
                                                                        selected>{{$municipality->name}}</option>
                                                            @else
                                                                <option
                                                                    value="{{$municipality->id}}">{{$municipality->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                {{-- County is just for display here It's realy value is in Basic info form--}}
                                                <label for="county">County</label>
                                                <input type="text" value="{{ucfirst(session('county'))}}"
                                                       class="form-control"
                                                       readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-9">
                                                <label for="project-details-name">Project Name</label>
                                                <input type="text" class="form-control project-name " readonly
                                                       value="{{$project->name ?? ''}}">

                                            </div>
                                            <div class="col-md-3 text-center">
                                                <a href="#" data-toggle="modal"
                                                   class="btn btn-primary mt-4 " style="width: 48%;"
                                                   id="btn-add-permittee">
                                                    Add Co-Permittee
                                                </a>
                                                <a href="#" data-toggle="modal"
                                                   class="btn btn-primary mt-4 w-50"
                                                   data-id="{{$project->id?? ''}}" id="btn-see-permittee">
                                                    See Co-Permittee
                                                </a>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label for="taxparcel">Tax Parcel</label>
                                                <input type="text" class="form-control"
                                                       id="taxparcel"
                                                       name="tax_parcel"
                                                       value="{{$project->projectDetails->tax_parcel?? ''}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="watershed">Watershed</label>
                                                <input type="text" class="form-control"
                                                       id="watershed" name="watershed"
                                                       value="{{$project->projectDetails->watershed?? ''}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="receiving_stream">Receiving Stream</label>
                                                <input type="text" class="form-control"
                                                       id="receiving_stream" name="receiving_stream"
                                                       value="{{$project->projectDetails->receiving_stream?? ''}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="plan_date">Plan Date</label>
                                                <input type="text" placeholder="MM/DD/YYYY"
                                                       class="form-control datepicker readonly-date us-date"
                                                       id="plan_date" readonly>
                                                <input type="hidden" class="form-control ymd-date-input"
                                                       readonly name="plan_date"
                                                       value="{{$project->projectDetails->plan_date ?? ''}}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label for="ownership">Ownership</label>
                                                <select name="ownership" class="form-control"
                                                        id="ownership">
                                                    <option value="">Select Ownership</option>
                                                    @foreach($options['ownerships'] as $key => $option)
                                                        @if(($project->projectDetails->ownership ?? '') === $key)
                                                            <option value="{{$key}}" selected>{{$option}}</option>
                                                        @else
                                                            <option value="{{$key}}">{{$option}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="ch_93">Ch. 93 Class</label>
                                                <input type="text" class="form-control"
                                                       id="ch_93" name="ch_93_class"
                                                       value="{{$project->projectDetails->ch_93_class?? ''}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="proj-total-acres">Total Acres</label>
                                                <input type="text" class="form-control"
                                                       id="proj-total-acres" name="total_acres"
                                                       value="{{$project->projectDetails->total_acres?? ''}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="disturbed-acres">Disturbed Acres</label>
                                                <input type="text" class="form-control"
                                                       id="disturbed-acres" name="disturbed_acres"
                                                       value="{{$project->projectDetails->disturbed_acres?? ''}}">
                                            </div>
                                        </div>
                                        <div class="row ">
                                            <div class="col-md-9">
                                                <div class="naics-group row">
                                                    @if(!isset($project->projectDetails->nasics) || count($project->projectDetails->nasics) === 0 )

                                                        <div class="form-group col-md-4 naics-item">
                                                            <label for="naics">NAICS</label>
                                                            <input type="text" id="naics"
                                                                   class="form-control" name="nasics[]">
                                                        </div>
                                                    @else
                                                        @foreach($project->projectDetails->nasics as $nasic)
                                                            <div class="form-group col-md-4 naics-item">
                                                                <label for="naics">NAICS</label>
                                                                <input type="text" id="naics"
                                                                       class="form-control" value="{{$nasic->nasic}}"
                                                                       name="nasics[]">
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mt-4 pt-1 ">
                                                <button class="btn btn-primary btn-block"
                                                        id="btn-add-naics">
                                                    Add NAICS
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="step-3" class="pt-5 p-3">
                            <form action="{{route('project.locations.store')}}" id="form-step-2" method="post"
                                  autocomplete="off">
                                @csrf
                                {{-- If empty means user is creating new project otherwise updating a project--}}
                                <input type="hidden" name="project_id" class="project-id" value="{{$project->id?? ''}}">
                                <div class="ibox border-light">
                                    <h3 class="ibox-title bg-light">Physical Location <br>
                                        <small>Latitude is assumed North, longitude is assumed West.
                                            Please don't use negative values for the longitude.
                                        </small>
                                    </h3>
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label for="location">Location/Address</label>
                                                <input type="text" class="form-control"
                                                       id="location" name="address_1"
                                                       value="{{$project->ProjectLocation->address_1 ?? ''}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="address2">Address 2</label>
                                                <input type="text" class="form-control"
                                                       id="address2" name="address_2"
                                                       value="{{$project->ProjectLocation->address_2 ?? ''}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="loc-city">City</label>
                                                <input type="text" class="form-control"
                                                       id="loc-city" name="city"
                                                       value="{{$project->ProjectLocation->city ?? ''}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="pl-zipcode">Zipcode</label>
                                                <input type="text" class="form-control"
                                                       id="pl-zipcode" name="zipcode"
                                                       value="{{$project->ProjectLocation->zipcode?? ''}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3 mb-0">
                                                <label for="location">Latitude</label>
                                                <input type="text" class="form-control latitude lat-long" id="lat">

                                            </div>
                                            <div class="form-group col-md-3 mb-0">
                                                <label for="address2">Longitude</label>
                                                <input type="text" class="form-control longitude lat-long" id="lng">
                                            </div>
                                            <div class="col-md-12 mt-0 pt-0">
                                            <span class="small">*enter the latitude and longitude values directly or enter them in DMS format below.</span>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <hr class="hr-line-dashed">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="lat_degrees">Latitude(DMS)</label>
                                                <div class="input-group latitude">
                                                    <input type="text"
                                                           class="form-control col-md-4 long-lat-input lat-dms"
                                                           id="lat_degrees" name="lat_deg"
                                                           data-dms="degree"
                                                           value="{{$project->ProjectLocation->lat_deg ?? ''}}">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">°</span>
                                                    </div>

                                                    <input type="text"
                                                           class="form-control col-md-4 long-lat-input lat-dms"
                                                           id="lat_minutes" name="lat_min"
                                                           data-dms="minutes"
                                                           value="{{$project->ProjectLocation->lat_min ?? ''}}">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">'</span>
                                                    </div>
                                                    <input type="text"
                                                           class="form-control col-md-4 long-lat-input lat-dms"
                                                           id="lat_seconds" name="lat_sec"
                                                           data-dms="seconds"
                                                           value="{{$project->ProjectLocation->lat_sec ?? ''}}">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">"</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="lat_degrees">Longitude(DMS)</label>
                                                <div class="input-group longitude">
                                                    <input type="text"
                                                           class="form-control col-md-4 long-lat-input lng-dms"
                                                           id="lng_degrees" name="long_deg"
                                                           data-dms="degree"
                                                           value="{{$project->ProjectLocation->long_deg ?? ''}}">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">°</span>
                                                    </div>
                                                    <input type="text"
                                                           class="form-control col-md-4 long-lat-input lng-dms"
                                                           id="lng_minutes" name="long_min"
                                                           data-dms="minutes"
                                                           value="{{$project->ProjectLocation->long_min ?? ''}}">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">'</span>
                                                    </div>
                                                    <input type="text"
                                                           class="form-control col-md-4 long-lat-input lng-dms"
                                                           id="lng_seconds" name="long_sec"
                                                           data-dms="seconds"
                                                           value="{{$project->ProjectLocation->long_sec ?? ''}}">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">"</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <button type="button" id="generate-map"
                                                        class="btn btn-primary">Generate Map
                                                </button>
                                            </div>
                                            <div class="form-row mx-auto w-100" id="map" style="display: block;">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="step-4" class="pt-5 p-3">
                            <form action="{{route('project.applicants.store')}}" method="post" id="form-step-3">
                                @csrf
                                {{-- If empty means user is creating new project otherwise updating a project--}}
                                <input type="hidden" name="project_id" class="project-id"
                                       value="{{$project->id ?? ''}}">

                                @if(!isset($project->projectApplicants) || count($project->projectApplicants) === 0)
                                    <div class="ibox border-light applicant-box">
                                        <div class="ibox-title bg-light" style="padding-right: 30px;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h3>Applicant Information <br>
                                                        <small>You can add Co-Applicant as is needed by
                                                            clicking "Add Co-Applicant" below.
                                                        </small>
                                                    </h3>
                                                </div>
                                                <div class="col-md-2 offset-md-4">
                                                    <a href="#modal-search-contact" data-toggle="modal"
                                                       data-title="Search Applicant!" id="search-applicant"
                                                       data-type="applicant"
                                                       class="btn-block btn btn-primary btn-search-co-applicant">Search
                                                        Applicant</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ibox-content">
                                            <div class="row">
                                                <div class="form-group col-md-3">
                                                    <label for="APPLIC">Applicant Name</label>
                                                    <input type="text" class="form-control"
                                                           id="APPLIC" name="name[]"
                                                           value="{{$applicant->name?? ''}}">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="APP_COMPANY">Applicant Company
                                                        Name</label>
                                                    <input type="text" class="form-control"
                                                           id="APP_COMPANY" name="company_name[]"
                                                           value="{{$applicant->company_name ?? ''}}">
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label for="APP_ADD1">Applicant Address</label>
                                                    <input type="text" class="form-control"
                                                           id="APP_ADD1" name="address_1[]"
                                                           value="{{$applicant->address_1 ?? ''}}">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="APP_ADD2">Applicant Address Line
                                                        2</label>
                                                    <input type="text" class="form-control"
                                                           id="APP_ADD2" name="address_2[]"
                                                           value="{{$applicant->address_2 ?? ''}}">
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="form-group col-md-3">
                                                    <label for="APP_CITY">Applicant City</label>
                                                    <input type="text" class="form-control"
                                                           id="APP_CITY" name="city[]"
                                                           value="{{$applicant->city ?? ''}}">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="APP_STATE">Applicant State</label>
                                                    <select id="APP_STATE" class="form-control" name="state[]">
                                                        <option value="">Select State</option>
                                                        @if(isset($states))
                                                            @foreach($states as $key => $option)
                                                                @if(($applicant->state ?? '') === $key))
                                                                <option value="{{$key}}"
                                                                        selected>{{$option}}</option>
                                                                @else
                                                                    <option value="{{$key}}">{{$option}}</option>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="APP_ZIP">Applicant Zipcode</label>
                                                    <input type="text" class="form-control"
                                                           id="APP_ZIP" name="zipcode[]"
                                                           value="{{$applicant->zipcode ?? ''}}">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="APP_PHONE">Applicant Phone
                                                        Number</label>
                                                    <input type="text" class="form-control us-phone"
                                                           id="APP_PHONE" name="phone_number[]"
                                                           value="{{$applicant->phone_number ?? ''}}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-3">
                                                    <label for="APP_EXT">Applicant Phone Number
                                                        Ext</label>
                                                    <input type="text"
                                                           class="form-control " id="APP_EXT"
                                                           name="phone_number_ext[]"
                                                           value="{{$applicant->phone_number_ext ?? ''}}">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="APP_FAX">Applicant Fax
                                                        Number</label>
                                                    <input type="text" class="form-control us-phone"
                                                           id="APP_FAX" name="fax_number[]"
                                                           value="{{$applicant->fax_number ?? ''}}">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="APP_EMAIL">Applicant Email</label>
                                                    <input type="text" class="form-control"
                                                           id="APP_EMAIL" name="email[]"
                                                           value="{{$applicant->email ?? ''}}">
                                                </div>
                                                <div class="form-group col-md-3 mt-4">
                                                    <button type="button"
                                                            class="btn btn-block btn-primary btn-add-co-applicant">
                                                        Add Co-Applicant
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    @foreach(($project->projectApplicants?? '') as $key => $applicant)

                                        <input type="hidden" name="applicant_id[]" value="{{$applicant->id ?? ''}}">
                                        <div
                                            class="ibox border-light {{($key === 0)? 'applicant-box' : 'co-applicant-box'}}">
                                            <div class="ibox-title bg-light" style="padding-right: 30px;">
                                                @if($key === 0)
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h3>Applicant Information<br>
                                                                <small>You may add as many Co-Applicants as is needed by
                                                                    clicking "Add Co-Applicant" below.
                                                                </small>
                                                            </h3>
                                                        </div>
                                                        <div class="col-md-2 offset-md-4">
                                                            <a href="#modal-search-contact" data-toggle="modal"
                                                               data-title="Search Applicant!" id="search-applicant"
                                                               data-type="applicant"
                                                               class="btn-block btn btn-primary btn-search-co-applicant">Search
                                                                Applicant</a>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h3>Co-Applicant Information</h3>
                                                        </div>
                                                        <div class="col-md-2 offset-md-4">
                                                            <a href="#modal-search-contact" data-toggle="modal"
                                                               data-title="Search Co-Applicant!" id="search-applicant"
                                                               data-type="coapplicant"
                                                               class="btn-block btn btn-primary btn-search-co-applicant">Search
                                                                Co-Applicant</a>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ibox-content">
                                                <div class="row">
                                                    <div class="form-group col-md-3">
                                                        <label for="APPLIC">Applicant Name</label>
                                                        <input type="text" class="form-control"
                                                               id="APPLIC" name="name[]"
                                                               value="{{$applicant->name?? ''}}">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="title">Applicant Company
                                                            Name</label>
                                                        <input type="text" class="form-control"
                                                               id="APP_COMPANY" name="company_name[]"
                                                               value="{{$applicant->company_name ?? ''}}">
                                                    </div>

                                                    <div class="form-group col-md-3">
                                                        <label for="APP_ADD1">Applicant Address</label>
                                                        <input type="text" class="form-control"
                                                               id="APP_ADD1" name="address_1[]"
                                                               value="{{$applicant->address_1 ?? ''}}">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="APP_ADD2">Applicant Address Line
                                                            2</label>
                                                        <input type="text" class="form-control"
                                                               id="APP_ADD2" name="address_2[]"
                                                               value="{{$applicant->address_2 ?? ''}}">
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="form-group col-md-3">
                                                        <label for="APP_CITY">Applicant City</label>
                                                        <input type="text" class="form-control"
                                                               id="APP_CITY" name="city[]"
                                                               value="{{$applicant->city ?? ''}}">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="APP_STATE">Applicant
                                                            State {{$applicant->state}}</label>
                                                        <select id="APP_STATE" class="form-control" name="state[]">
                                                            <option value="">Select One</option>
                                                            @if(isset($states))
                                                                @foreach($states as $key => $option)
                                                                    @if(($applicant->state ?? '') === $key))
                                                                    <option value="{{$key}}"
                                                                            selected>{{$option}}</option>
                                                                    @else
                                                                        <option value="{{$key}}">{{$option}}</option>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="APP_ZIP">Applicant Zipcode</label>
                                                        <input type="text" class="form-control"
                                                               id="APP_ZIP" name="zipcode[]"
                                                               value="{{$applicant->zipcode}}">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="APP_PHONE">Applicant Phone
                                                            Number</label>
                                                        <input type="text" class="form-control us-phone"
                                                               id="APP_PHONE" name="phone_number[]"
                                                               value="{{$applicant->phone_number}}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-3">
                                                        <label for="APP_EXT">Applicant Phone Number
                                                            Ext</label>
                                                        <input type="text"
                                                               class="form-control " id="APP_EXT"
                                                               name="phone_number_ext[]"
                                                               value="{{$applicant->phone_number_ext ?? ''}}">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="APP_FAX">Applicant Fax
                                                            Number</label>
                                                        <input type="text" class="form-control us-phone"
                                                               id="APP_FAX" name="fax_number[]"
                                                               value="{{$applicant->fax_number ?? ''}}">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="APP_EMAIL">Applicant Email</label>
                                                        <input type="text" class="form-control"
                                                               id="APP_EMAIL" name="email[]"
                                                               value="{{$applicant->email ?? ''}}">
                                                    </div>
                                                    <div class="form-group col-md-3 mt-4">
                                                        @if($loop->index === 0)
                                                            <button type="button"
                                                                    class="btn btn-block btn-primary btn-add-co-applicant" {{(count($project->projectApplicants) > 1) ? 'disabled' : ''}}>
                                                                Add Co-Applicant
                                                            </button>
                                                        @else
                                                            <button type="button"
                                                                    data-url="{{route('project.applicants.destroy', [$project->id, $applicant->id])}}"
                                                                    class="btn btn-block btn-primary btn-danger btn-remove-co-applicant">
                                                                Remove Co-Applicant
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </form>
                        </div>
                        <div id="step-5" class="pt-5 p-3">
                            <form action="{{route('project.engineers.store')}}" id="form-step-4" method="post">
                                @csrf
                                {{-- If empty means user is creating new project otherwise updating a project--}}
                                <input type="hidden" name="project_id" class="project-id"
                                       value="{{$project->id ?? ''}}">
                                <div class="ibox border-light">
                                    <div class="ibox-title bg-light" style="padding-right: 30px;">
                                        <div class="row">
                                            <h3 class="col-md-4">Engineer Information</h3>
                                            <a href="#modal-search-contact" data-toggle="modal"
                                               data-title="Search Engineer!" id="search-engineer" data-type="engineer"
                                               class="btn btn-primary col-md-2 offset-md-6">Search Engineer</a>
                                        </div>
                                    </div>
                                    <div class="ibox-content">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="name">Engineer Name</label>
                                                <input type="text" class="form-control"
                                                       id="name" name="name"
                                                       value="{{$project->projectEngineer->name ?? ''}}">
                                            </div>
                                            <div class="form-group col-md-3 offsetmd">
                                                <label for="ENGINEER">Engineer Company
                                                    Name</label>
                                                <input type="text" class="form-control"
                                                       id="ENGINEER" name="company_name"
                                                       value="{{$project->projectEngineer->company_name ?? ''}}">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="ENG_ADD1">Engineer Address</label>
                                                <input type="text" class="form-control"
                                                       id="ENG_ADD1" name="address_1"
                                                       value="{{$project->projectEngineer->address_1 ?? ''}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="ENG_ADD2">Engineer Address Line
                                                    2</label>
                                                <input type="text" class="form-control"
                                                       id="ENG_ADD2" name="address_2"
                                                       value="{{$project->projectEngineer->address_2 ?? ''}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="ENG_CITY">Engineer City</label>
                                                <input type="text" class="form-control"
                                                       id="ENG_CITY" name="city"
                                                       value="{{$project->projectEngineer->city ?? ''}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="ENG_STATE">Engineer State</label>
                                                <select name="state" class="form-control" id="ENG_STATE">
                                                    <option value="">Select State</option>
                                                    @if(isset($states))
                                                        @foreach($states as $key => $option)
                                                            @if(($project->projectEngineer->state ?? '') == $key))
                                                            <option value="{{$key}}"
                                                                    selected>{{$option}}</option>
                                                            @else
                                                                <option value="{{$key}}">{{$option}}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="ENG_ZIP">Engineer Zipcode</label>
                                                <input type="text" class="form-control"
                                                       id="ENG_ZIP" name="zipcode"
                                                       value="{{$project->projectEngineer->zipcode ?? ''}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="ENG_PHONE">Engineer Phone
                                                    Number</label>
                                                <input type="text" class="form-control us-phone"
                                                       id="ENG_PHONE" name="phone_number"
                                                       value="{{$project->projectEngineer->phone_number ?? ''}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="ENG_EXT">Engineer Phone Number
                                                    Ext</label>
                                                <input type="text" class="form-control "
                                                       id="ENG_EXT" name="phone_number_ext"
                                                       value="{{$project->projectEngineer->phone_number_ext ?? ''}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="ENG_FAX">Engineer Fax
                                                    Number</label>
                                                <input type="text" class="form-control us-phone"
                                                       id="ENG_FAX" name="fax_number"
                                                       value="{{$project->projectEngineer->fax_number ?? ''}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="ENG_EMAIL">Engineer Email</label>
                                                <input type="text" class="form-control"
                                                       id="ENG_EMAIL" name="email"
                                                       value="{{$project->projectEngineer->email ?? ''}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div id="step-6" class="pt-5 p-3">
                            <form action="{{route('project.permits.store')}}" id="form-step-5" method="post">
                                @csrf
                                {{-- If empty means user is creating new project otherwise updating a project--}}
                                <input type="hidden" name="project_id" class="project-id"
                                       value="{{$project->id ?? ''}}">
                                <div class="ibox border-light">
                                    <h3 class="ibox-title bg-light">Project Tracking Information</h3>
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label for="npdes-number-input">NPDES Permit Number</label>
                                                <input type="text" class="form-control"
                                                       id="npdes-number-input" name="npdes_number"
                                                       value="{{$project->projectPermit->npdes_number ?? ''}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="permit_received">Date Received</label>
                                                <input type="text" class="form-control datepicker readonly-date"
                                                       id="permit_received" readonly
                                                       placeholder="MM/DD/YYYY">
                                                <input type="hidden" class="ymd-date-input" name="received_date"
                                                       value="{{$project->projectPermit->received_date?? ''}}">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="pindi_date">PINDI Date</label>
                                                <input type="text" class="form-control datepicker readonly-date"
                                                       id="pindi_date" readonly
                                                       placeholder="MM/DD/YYYY">
                                                <input type="hidden" class="ymd-date-input" name="pindi_date"
                                                       value="{{$project->projectPermit->pindi_date?? ''}}">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="final_inspection">Date of Final
                                                    Inspection</label>
                                                <input type="text"
                                                       class="form-control datepicker readonly-date"
                                                       id="final_inspection" readonly
                                                       placeholder="MM/DD/YYYY">
                                                <input type="hidden" class="ymd-date-input" name="final_inspection_date"
                                                       value="{{$project->projectPermit->final_inspection_date?? ''}}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label for="permit_complete">Permit Complete
                                                    Date</label>
                                                <input type="text"
                                                       class="form-control datepicker readonly-date"
                                                       id="permit_complete" readonly placeholder="MM/DD/YYYY">
                                                <input type="hidden" class="ymd-date-input" name="permit_complete_date"
                                                       value="{{$project->projectPermit->permit_complete_date?? ''}}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="permit_issued">Permit Issued</label>
                                                <input type="text"
                                                       class="form-control datepicker readonly-date"
                                                       id="permit_issued" readonly placeholder="MM/DD/YYYY">
                                                <input type="hidden" class="ymd-date-input" name="permit_issued_date"
                                                       value="{{$project->projectPermit->permit_issued_date ?? ''}}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="permit_expiration_date">Permit Expiration
                                                    Date</label>
                                                <input type="text"
                                                       class="form-control datepicker readonly-date"
                                                       id="permit_expiration_date" readonly
                                                       placeholder="MM/DD/YYYY"
                                                       value="{{$project->projectPermit->permit_expiration_date?? '12/07/2024'}}">
                                                <input type="hidden" class="ymd-date-input"
                                                       name="permit_expiration_date"
                                                       value="{{$project->projectPermit->permit_expiration_date?? '2024-12-07'}}">
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3>Notice of Termination</h3>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="form-group col-md-4">

                                                <div class="checks">
                                                    <label class="a-checks" id="not-received">
                                                        <input type='hidden' value='0' name='is_notice_received'>
                                                        <input type="checkbox" value="1"
                                                               id="not-received"
                                                               name="is_notice_received" {{($project->projectPermit->is_notice_received?? '')? 'checked' : ''}}>
                                                        <span class="checkmark"></span> Notice Received
                                                    </label>
                                                </div>

                                                <div class="checks">
                                                    <label class="a-checks" id="not-acknowledged">
                                                        <input type='hidden' value='0' name='is_notice_acknowledged'>
                                                        <input type="checkbox" value="1"
                                                               id="not-acknowledged"
                                                               name="is_notice_acknowledged"
                                                            {{($project->projectPermit->is_notice_acknowledged?? '')? 'checked' : ''}}>
                                                        <span class="checkmark"></span> Notice Acknowledged
                                                    </label>
                                                </div>
                                                <div class="checks">
                                                    <label class="a-checks" id="active">
                                                        <input type='hidden' value='0' name='is_active'>
                                                        <input type="checkbox" value="1"
                                                               id="active"
                                                               name="is_active" {{($project->projectPermit->is_active?? '')? 'checked' : ''}} >
                                                        <span class="checkmark"></span> Active
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="not_received_date">Notice Received
                                                    Date</label>
                                                <input type="text"
                                                       class="form-control datepicker readonly-date"
                                                       id="not_received_date" readonly
                                                       placeholder="MM/DD/YYYY">
                                                <input type="hidden" class="ymd-date-input" name="notice_received_date"
                                                       value="{{$project->projectPermit->notice_received_date ?? ''}}">
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <a href="#" id="btn-add-time-record" data-toggle="modal"
                                                   class="btn btn-primary mt-4 "
                                                   data-id="{{$project->id?? ''}}">
                                                    Record Time For This Project</a>
                                                <a href="#" id="btn-view-time-record" data-toggle="modal"
                                                   class="btn btn-primary mt-4 ml-1"
                                                   data-id="{{$project->id?? ''}}">View All Time For This Project</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div id="step-7" class="pt-5 p-3">
                            <div class="ibox border-light mb-0">
                                <form action="{{route('project.fees.store')}}" method="post" id="form-step-6"
                                      data-mode="create">
                                    @csrf
                                    {{-- If empty means user is creating new project otherwise updating a project--}}
                                    <input type="hidden" name="project_id" class="project-id"
                                           value="{{$project->id ?? ''}}">
                                    <h3 class="ibox-title bg-light">Fee Information</h3>
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div class="form-group col-md-2">
                                                <label for="received">Received Date</label>
                                                <input type="text" class="form-control datepicker readonly-date"
                                                       placeholder="MM/DD/YYYY" readonly id="received">
                                                <input type="hidden" class="ymd-date-input" name="received">
                                            </div>
                                            <div class="form-group col-md-2 ">
                                                <label for="is-admin">Admin?</label>
                                                <div class="checks">
                                                    <label class="a-checks" id="is-admin">Is Admin?
                                                        <input type='hidden' name='is_admin' value="0">
                                                        <input type='checkbox' id="is-admin" value='1' name='is_admin'>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-2 ">
                                                <label for="nr">Fee Submission Type</label>
                                                <div class="i-checks ">
                                                    <label class="checkbox-inline">
                                                        <input type="radio" value="N" name="nr"
                                                               id="nr">
                                                        <i></i> New
                                                    </label>
                                                    <label class="ml-2"> <input type="radio"
                                                                                value="R"
                                                                                name="nr"
                                                                                id="resubmit-fee"> <i></i>
                                                        Resubmit</label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="rev-number">Review Number</label>
                                                <input type="text" name="rev_number"
                                                       class="form-control" id="rev-number">
                                            </div>
                                            <div class="form-group col-md-2">

                                                <label for="totalacres">Total Acres</label>
                                                <input type="text" name="totalacres"
                                                       class="form-control" id="totalacres">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="tobedisturb">Disturbed Acres</label>
                                                <input type="text" name="tobedisturb"
                                                       class="form-control" id="tobedisturb">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label for="dist-fee">Dist Fee</label>
                                                <input type="number" name="dist_fee"
                                                       class="form-control" id="dist-fee">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="dist-chknum">Dist CHK NUM</label>
                                                <input type="text" name="dist_chknum"
                                                       class="form-control" id="dist-chknum">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="dist-fee-chkdate">Dist Fee CHK Date</label>
                                                <input type="text" class="form-control datepicker readonly-date"
                                                       placeholder="MM/DD/YYYY" readonly id="dist-fee-chkdate">
                                                <input type="hidden" class="ymd-date-input" name="dist_fee_chkdate">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="distfee-payor">DIST Fee Payor</label>
                                                <input type="text" name="distfee_payor"
                                                       class="form-control" id="distfee-payor">
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label for="mccd-cwf-fee">{{$district}} CWF Fee</label>
                                                <input type="number" name="mccd_cwf_fee"
                                                       class="form-control" id="mccd-cwf-fee">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="mccd-cwf-chknum">{{$district}} CWF CHKNUM</label>
                                                <input type="text" name="mccd_cwf_chknum"
                                                       class="form-control" id="mccd-cwf-chknum">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="mccd-cwf-chkdate">{{$district}} CWF CHKDATE</label>
                                                <input type="text" class="form-control datepicker readonly-date"
                                                       placeholder="MM/DD/YYYY" readonly id="mccd-cwf-chkdate">
                                                <input type="hidden" class="ymd-date-input" name="mccd_cwf_chkdate">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="mccd-cwf-payor">{{$district}} CWF Payor</label>
                                                <input type="text" name="mccd_cwf_payor"
                                                       class="form-control" id="mccd-cwf-payor">
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label for="tbd-fee">TBD Fee</label>
                                                <input type="number" name="tbd_fee"
                                                       class="form-control" id="tbd-fee">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="tbdfee-chknum ">TBD Fee CHKNUM</label>
                                                <input type="text" name="tbdfee_chknum"
                                                       class="form-control" id="tbdfee-chknum"
                                                       data-rule-digits="true">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="tbdfee-chkdate">TBD CHK Date</label>
                                                <input type="text" class="form-control datepicker readonly-date"
                                                       placeholder="MM/DD/YYYY" readonly id="tbdfee-chkdate">
                                                <input type="hidden" class="ymd-date-input" name="tbdfee_chkdate">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="tbdfee-payor">TBD Fee Payor</label>
                                                <input type="text" name="tbdfee_payor"
                                                       class="form-control" id="tbdfee-payor">
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label for="expedite-fee">Expedite Fee</label>
                                                <input type="number" name="expedite_fee"
                                                       class="form-control" id="expedite-fee">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="exp-check-num">EXP CHKNUM</label>
                                                <input type="text" name="exp_check_num"
                                                       class="form-control" id="exp-check-num"
                                                       data-rule-digits="true">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="exp-check-date">EXP CHK Date</label>
                                                <input type="text" class="form-control datepicker readonly-date"
                                                       placeholder="MM/DD/YYYY" readonly id="exp-check-date">
                                                <input type="hidden" class="ymd-date-input" name="exp_check_date">

                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="exp-payor">EXP Fee Payor</label>
                                                <input type="text" name="exp_payor"
                                                       class="form-control" id="exp-payor">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label for="plan-date">Plan Date</label>
                                                <input type="text" class="form-control datepicker readonly-date"
                                                       id="plan-date" readonly
                                                       placeholder="MM/DD/YYYY">
                                                <input type="hidden" class="ymd-date-input" name="plan_date">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="tech-init">Technician</label>
                                                <input type="text" class="form-control" name="tech_init" id="tech-init">
                                            </div>
                                            <div class="form-group col-md-3 mt-4">
                                                <button type="button"
                                                        class="btn btn-block btn-primary btn-add-fee-entry mt-1">
                                                    Add Fee Entry
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="ibox mb-0">
                                    <div class="ibox-title" style="
    border-top: 1px solid rgba(0,0,0,.1);
    border-bottom: 1px solid rgba(0,0,0,.1);
    text-align: center;
    background: rgba(0,0,0,.03); ">
                                        <h5 class="text-uppercase">Project Fees and Payment Information</h5>
                                    </div>
                                    <div class="w-100" id="fees-table-parent">
                                        <table class="table table-responsive table-hover table-bordered mb-0"
                                               id="fees-table">
                                            <thead>
                                            <tr>
                                                <th class="text-center">Received Date</th>
                                                <th class="text-center">Is Admin?</th>
                                                <th class="text-center">NR</th>
                                                <th class="text-center">Review Number</th>
                                                <th class="text-center">Total Acres</th>
                                                <th class="text-center">Disturbed Acres</th>
                                                <th class="text-center">Dist Fee</th>
                                                <th class="text-center">DIST CHKNUM</th>
                                                <th class="text-center">DIST FEE CHKDATE</th>
                                                <th class="text-center">DIST FEE Payor</th>
                                                <th class="text-center">{{$district}} CWF Fee</th>
                                                <th class="text-center">{{$district}} CWF CHKNUM</th>
                                                <th class="text-center">{{$district}} CWF CHKDATE</th>
                                                <th class="text-center">{{$district}} CWF Payor</th>
                                                <th class="text-center">TBD Fee</th>
                                                <th class="text-center">TBD FEE CHKNUM</th>
                                                <th class="text-center">TBD CHK Date</th>
                                                <th class="text-center">TBD Fee Payor</th>
                                                <th class="text-center">Expedite Fee</th>
                                                <th class="text-center">EXP CHKNUM</th>
                                                <th class="text-center">EXP CHK Date</th>
                                                <th class="text-center">EXP Fee Payor</th>
                                                <th class="text-center">Technician</th>
                                                <th class="text-center">Plan Date</th>
                                                <th class="text-center" style="position: sticky; top:0; right: 0;">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody id="fees-table-body">

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div id="step-8" class="pt-5 p-3">
                            <div class="ibox border-light">
                                <form action="{{route('project.reviews.store')}}" method="post" id="form-step-7"
                                      data-mode="create">
                                    @csrf
                                    {{-- If empty means user is creating new project otherwise updating a project--}}
                                    <input type="hidden" name="project_id" class="project-id"
                                           value="{{$project->id ?? ''}}">
                                    <h3 class="ibox-title bg-light">Review Information</h3>
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label for="received-date">Received Date</label>
                                                <input type="text" class="form-control datepicker readonly-date"
                                                       placeholder="MM/DD/YYYY" readonly id="received-date">
                                                <input type="hidden" class="ymd-date-input" name="received">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="is-admin">Admin?</label>
                                                <div class="checks">
                                                    <label class="a-checks" id="is-admin">Is Admin?
                                                        <input type='hidden' value='0' name='is_admin'>
                                                        <input type='checkbox' value='1' id='is-admin' name='is_admin'>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="admin-review-date">Admin Review Date</label>
                                                <input type="text"
                                                       class="form-control datepicker readonly-date"
                                                       id="admin-rev-date" readonly
                                                       placeholder="MM/DD/YYYY">
                                                <input type="hidden" class="ymd-date-input" name="admin_rev_date">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="admin-status">Admin Status</label>
                                                <select name="admin_status" id="admin-status"
                                                        class="form-control">
                                                    <option value="">Select Admin Status</option>
                                                    @foreach($options['admin_statuses'] as $key => $option)
                                                        <option value="{{$key}}">{{$option}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="admin-initials">Admin Initials</label>
                                                <input type="text" name="admin_init"
                                                       class="form-control" id="admin-init">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="reviewed-date">Reviewed Date</label>
                                                <input type="text"
                                                       class="form-control datepicker readonly-date"
                                                       id="reviewed" readonly placeholder="MM/DD/YYYY">
                                                <input type="hidden" class="ymd-date-input" name="reviewed">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="tech-status">Tech Status</label>
                                                <select name="tech_status" id="tech-status"
                                                        class="form-control">
                                                    <option value="">Select Tech Status</option>
                                                    @foreach($options['tech_statuses'] as $key => $option)
                                                        <option value="{{$key}}">{{$option}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="tech_initials">Tech Initials</label>
                                                <input type="text" name="tech_init"
                                                       class="form-control" id="tech_init">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="date-withdrawn">Date Withdrawn</label>
                                                <input type="text"
                                                       class="form-control datepicker readonly-date"
                                                       id="date-wd" readonly placeholder="MM/DD/YYYY">
                                                <input type="hidden" class="ymd-date-input"
                                                       name="date_wd">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="return-reason">Return Reason</label>
                                                <input type="text" name="return_reason"
                                                       class="form-control" id="return-reason">
                                            </div>
                                            <div class="form-group col-md-3 mt-4">
                                                <button type="button"
                                                        class="btn btn-block btn-primary btn-add-review-entry mt-1">
                                                    Add Review Entry
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="ibox mb-0">
                                    <div class="ibox-title" style="
    border-top: 1px solid rgba(0,0,0,.1);
    border-bottom: 1px solid rgba(0,0,0,.1);
    text-align: center;
    background: rgba(0,0,0,.03); ">
                                        <h5 class="text-uppercase">Project Reviews Information</h5>
                                    </div>
                                    <div class="w-100">
                                        <table class="table w-100 table-hover table-bordered mb-0" id="search-table">
                                            <thead>
                                            <tr>
                                                <th class="text-center">Received Date</th>
                                                <th class="text-center">Is Admin</th>
                                                <th class="text-center">Admin Review Date</th>
                                                <th class="text-center">Admin Status</th>
                                                <th class="text-center">Admin Initials</th>
                                                <th class="text-center">Reviewed Date</th>
                                                <th class="text-center">Tech Status</th>
                                                <th class="text-center">Tech Initials</th>
                                                <th class="text-center">Date Withdrawn</th>
                                                <th class="text-center">Return Reason</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody id="reviews-table-body">

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>


                        </div>
                        <div id="step-9" class="pt-5 p-3 show">
                            <form action="{{route('projects.memo.store')}}" method="post" id="form-step-8">
                                <form action="{{route('projects.memo.store')}}" method="post" id="form-step-8">
                                    @csrf
                                    <p id="logged-in-user" class="d-none">{{Auth()->user()->name}}</p>
                                    {{-- If empty means user is creating new project otherwise updating a project--}}
                                    <input type="hidden" name="project_id" class="project-id"
                                           value="{{$project->id ?? ''}}">
                                    <div class="ibox border-light">
                                        <h3 class="ibox-title bg-light">Documents and Files</h3>
                                        <div class="ibox-content no-padding">
                                            <table id="table-files" class="table">
                                                <thead>
                                                <tr>
                                                    <th style="width:10%">Date</th>
                                                    <th style="width:25%">Document</th>
                                                    <th style="width:35%">Memo</th>
                                                    <th style="width:10%">Creator</th>
                                                    <th style="width:13%" class="text-center">Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody class="pb-5">
                                                @if(!isset($project->files) || count($project->files)  === 0)
                                                    <tr>
                                                        <td>
                                                            <input class="date form-control" type="text"
                                                                   value="{{date('m/d/Y')}}"
                                                                   readonly>
                                                        </td>
                                                        <td class="text-center" style="vertical-align: middle">
                                                            {{-- <a href="#" target="_blank">{{$file->path ?? ''}} <i--}}
                                                            {{-- class="fa fa-download"></i></a>--}}
                                                            <div class="file-upload-wrapper"
                                                                 data-text="Select your file!">
                                                                <input name="file" type="file"
                                                                       class="file-upload-field file"
                                                                       data-url="{{route('project.file.store')}}"
                                                                       data-token="{{csrf_token()}}">
                                                            </div>
                                                        </td>
                                                        <td><input class="form-control memo" type="text" name="memo"
                                                                   value="{{$file->memo ?? ''}}"></td>
                                                        <td><input class="form-control creator" readonly type="text"
                                                                   value="{{$user->name ?? ''}}">
                                                        </td>
                                                        <td style="vertical-align: middle" class="text-center">
                                                            <a class="btn btn-secondary btn-upload text-white disabled">
                                                                Upload!
                                                            </a>
                                                            <a class="btn btn-danger btn-secondary disabled btn-delete">
                                                                <i class="fa fa-trash text-white"></i> </a>
                                                    </tr>
                                                @else
                                                    @foreach($project->files as $file)
                                                        <tr>
                                                            <td>
                                                                <input class="form-control date" type="text"
                                                                       value="{{$file->created_at->format('m/d/Y')}}"
                                                                       readonly>
                                                            </td>
                                                            <td class="pl-3" style="vertical-align: middle">
                                                                <div class="file-upload-wrapper"
                                                                     data-text="{{$file->name ?? ''}}"
                                                                     style="display: none;">
                                                                    <input name="file" type="file"
                                                                           class="file-upload-field file"
                                                                           data-url="/projects/file/store"
                                                                           data-token="{{csrf_token()}}">
                                                                </div>
                                                                <a href="{{$file->path}}"
                                                                   target="_blank"
                                                                   class="btn-file-download">{{preg_replace('/([0-9])+\_\_/', '', $file->filename) }}</a>
                                                            </td>
                                                            <td><input class="form-control memo" type="text" name="memo"
                                                                       value="{{$file->memo ?? ''}}"
                                                                       readonly="readonly">
                                                            </td>
                                                            <td><input class="form-control creator" readonly=""
                                                                       type="text"
                                                                       value="{{$file->user->name ?? ''}}">
                                                            </td>
                                                            <td style="vertical-align: middle" class="text-center">
                                                                <a class="btn btn-upload text-white disabled btn-secondary">Upload!</a>
                                                                <a class="btn btn-danger btn-secondary btn-delete"
                                                                   data-id="{{$file->id ?? ''}}">
                                                                    <i class="fa fa-trash text-white"></i> </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        <a href="#" class="btn btn-primary btn-circle btn-lg"
                                                           id="btn-clone-files-row"><i class="fa fa-plus"></i></a>
                                                    </td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="ibox border-light">
                                        <h3 class="ibox-title bg-light">Project Memo</h3>
                                        <div class="ibox-content no-padding">
                                    <textarea class="form-control no-border" name="project_memo"
                                              style="min-height:100px;"
                                              id="project-memo"
                                              placeholder="Write the project memo...">{{$project->memo ?? ''}}</textarea>
                                        </div>
                                    </div>

                                    @editMode
                                    <a href="#" class="btn btn-primary my-1" id="btn-update-project-memo">Update
                                        Memo</a>
                                    @else
                                        <a href="#" class="btn btn-primary my-1" id="btn-update-project-memo">Save
                                            Memo</a>
                                        @endEditMode

                                        <hr class="hr-line-dashed">

                                        {{--        @if((int)($project->is_closed?? '') === 1)
                                                    <div class="alert alert-warning alert-dismissible fade plan-alert show"
                                                         role="alert">

                                                        <strong>This Plan is closed!</strong> You can activate it by clicking the
                                                        button
                                                        below.
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                @endif--}}

                                        <div id="action-buttons">
                                            @if((int)($project->is_closed ?? '') !== 1)
                                                {{--             <a href="#modal-close-plan" data-toggle="modal"
                                                                class="btn btn-warning my-2 " id="btn-activate-plan"
                                                                data-url="{{route('projects.activate', $project->id ?? '')}}"><strong>ACTIVATE
                                                                     PLAN</strong></a>
                                                         @else--}}
                                                <a href="#modal-close-plan" data-toggle="modal"
                                                   class="btn btn-danger my-2 " id="btn-toggle-plan-modal"><strong>CLOSE
                                                        PLAN</strong></a>
                                            @endif
                                        </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal  show" id="modal-finish-wizard" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title text-white">New project created!</h4>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p style="font-size: .9rem" class="text-center">A new project has been created for you. Now you can
                        update the rest of the
                        information by going through the
                        different tabs.</p>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-white mx-auto" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal  show" id="modal-search-contact" tabindex="-1" role="dialog" style="z-index: 99991 !important;">
        <div class="modal-dialog" style="max-width: 800px;">
            <div class="modal-content animated fadeIn">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title text-white"></h4>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body pb-0">
                    <div class="row">
                        <div class="col-12">
                            <form action="{{route('contacts.search')}}" method="post" id="search-form">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="hidden" name="type" id="input-contact-type">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="company"
                                                   placeholder="Search By Company">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <button class="btn btn-block btn-primary " id="btn-search-contact"
                                                type="submit">
                                            <strong>Search</strong>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <div class="ibox border-light d-none" id="search-results-container">
                                <div class="ibox-content pb-0">
                                    <h3 id="not-found-message" class="d-none text-center">No contacts found!</h3>
                                    <table class="table table-hover" id="search-table">
                                        <thead>
                                        <tr>
                                            <th>Company</th>
                                            <th>Name</th>
                                            <th>City/State/ZIP</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody id="table-search-body">

                                        </tbody>
                                    </table>
                                </div>
                                <div class="ibox-content pb-0">
                                    <ul class="pagination" id="pagination"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>


    <div class="modal  show" id="modal-add-co-permittee" role="dialog">
        <div class="modal-dialog" style="min-width: 800px;">
            <div class="modal-content animated fadeIn">
                <form action="{{route('projects.permittee.store')}}" method="post" id="form-co-permittee-save">
                    @csrf
                    {{-- If empty means user is creating new project otherwise updating a project--}}
                    <input type="hidden" name="project_id" class="project-id"
                           value="{{$project->id ?? ''}}">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title text-white">Add Co-Permittee to this Project!</h4>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="received-date">Received Date</label>
                                    <input class="form-control datepicker readonly-date" readonly
                                           type="text" autofocus placeholder="MM/DD/YYYY">
                                    <input type="hidden" class="form-control ymd-date-input" readonly
                                           name="received_date" id="received-date">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="reviewed-date">Reviewed Date</label>
                                    <input class="form-control datepicker readonly-date" placeholder="MM/DD/YYYY"
                                           type="text"
                                           readonly>
                                    <input type="hidden" class="form-control ymd-date-input"
                                           id="reviewed-date" readonly name="reviewed_date">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <a href="#modal-search-contact" data-toggle="modal" data-title="Search Co-Permittee!"
                                   id="search-applicant" data-type="copermittee"
                                   class="btn-block btn btn-primary mt-4">Search
                                    Co-Permittee</a>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-4">
                                    <div class="checks pt-2">
                                        <label class="a-checks">
                                            <input type='hidden' value='0' name='acknowledged'>
                                            <input class="checkbox" name="acknowledged"
                                                   id="acknowledged" type="checkbox" value="1">
                                            <span class="checkmark"></span> Is Acknowledged
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title">Co-Permittee Name</label>
                                    <input class="form-control" name="name" id="title" type="text">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="company">Co-Permittee Company</label>
                                    <input class="form-control" name="company"
                                           id="company" type="text">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input class="form-control" name="email" id="email" type="text">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="address-1">Address 1</label>
                                    <input class="form-control" name="address_1"
                                           id="address-1" type="text">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="address-2">Address 2</label>
                                    <input class="form-control" name="address_2"
                                           id="address-2" type="text">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input class="form-control" name="city" id="city" type="text">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="state">State</label>
                                    <input class="form-control" name="state" id="state" type="text">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="zipcode">Zip Code</label>
                                    <input class="form-control" name="zipcode" id="zipcode" type="text">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="PHONE">Phone</label>
                                    <input class="form-control us-phone" name="phone" id="PHONE" type="text">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="FAX">Fax</label>
                                    <input class="form-control us-phone" name="fax" id="FAX" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-primary " id="btn-co-permittee-save">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal  show" id="modal-view-time-record" tabindex="-1" role="dialog">
        <div class="modal-dialog" style="min-width: 700px;">
            <div class="modal-content animated fadeIn">
                <form action="{{route('projects.time.store')}}" method="post" id="form-view-time-record">
                    @csrf
                    {{-- If empty means user is creating new project otherwise updating a project--}}
                    <input type="hidden" name="project_id" class="project-id"
                           value="{{$project->id ?? ''}}">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title text-white">Recorded Time Details
                        </h4>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer ">
                        <a href="{{route('reports.xls.download', $project->id?? '')}}"
                           class="btn btn-warning disabled" target="_blank" id="btn-export-excel">Export
                            Excel
                        </a>
                        <a href="{{route('reports.pdf.download', $project->id?? '')}}" target="_blank"
                           class="btn btn-danger disabled" id="btn-export-pdf">Export PDF</a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal  show" id="modal-record-time" tabindex="-1" role="dialog">
        <div class="modal-dialog" style="min-width: 700px;">
            <div class="modal-content animated fadeIn">
                <form action="{{route('projects.time.store')}}" method="post" id="form-project-time-save">
                    @csrf
                    {{-- If empty means user is creating new project otherwise updating a project--}}
                    <input type="hidden" name="project_id" class="project-id"
                           value="{{$project->id ?? ''}}">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title text-white">Record time for this Project!</h4>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="project-name">Project Name</label>
                                    <input class="form-control project-name" readonly type="text"
                                           value="{{$project->name?? ''}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="time-category">Time Category</label>
                                    <select id="time-category" class="form-control input-md mb-md" name="time_category">
                                        <option value="">Select Time Category</option>
                                        <option value="Initial Plan Received">Initial Plan Received</option>
                                        <option value="Plan Review Meeting">Plan Review Meeting</option>
                                        <option value="Pre-Construction Meeting">Pre-Construction Meeting</option>
                                        <option value="Initial Site Inspection">Initial Site Inspection</option>
                                        <option value="Complaint Investigation">Complaint Investigation</option>
                                        <option value="Enforcement Meeting">Enforcement Meeting</option>
                                        <option value="Notice Of Termination">Notice Of Termination</option>
                                        <option value="Right To Know Database Search">Right To Know Database Search
                                        </option>
                                        <option value="Right To Know Meeting">Right To Know Meeting</option>
                                        <option value="NPDES Review">NPDES Review</option>
                                        <option value="E &amp; S Review">E &amp; S Review</option>
                                        <option value="Admin Review">Admin Review</option>
                                        <option value="Date Stamp &amp; Data Entry">Date Stamp &amp; Data Entry</option>
                                        <option value="Enforcement Referral">Enforcement Referral</option>
                                        <option value="Co-Permittee Application Entry">Co-Permittee Application Entry
                                        </option>
                                        <option value="Transferee Application Entry">Transferee Application Entry
                                        </option>
                                        <option value="N.O.T. - Data Entry">N.O.T. - Data Entry</option>
                                        <option value="Copy Letters, Mailings  &amp; File Project">Copy Letters,
                                            Mailings
                                            &amp; File Project
                                        </option>
                                        <option value="Admin Meeting">Admin Meeting</option>
                                        <option value="Final Site Inspection">Final Site Inspection</option>
                                        <option value="Pre-Application Meeting">Pre-Application Meeting</option>
                                        <option value="Major Modification">Major Modification</option>
                                        <option value="Minor Revision">Minor Revision</option>
                                        <option value="Returned Check">Returned Check</option>
                                        <option value="Sort Checks And Mail Bills">Sort Checks And Mail Bills</option>
                                        <option value="Acknowledge Transfer">Acknowledge Transfer</option>
                                        <option value="Inadequate Review Meeting">Inadequate Review Meeting</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="technician">Technician</label>
                                    <select id="technician" class="form-control" name="reviewer_id">
                                        <option value="">Select Technician</option>
                                        @if(isset($reviewers))
                                            @foreach($reviewers as $reviewer)
                                                <option value="{{$reviewer->id}}">{{$reviewer->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="entered-date">Date</label>
                                    <input class="form-control datepicker readonly-date"
                                           placeholder="MM/DD/YYYY" readonly type="text" autocomplete="false">
                                    <input type="hidden" class="form-control ymd-date-input" id="entered-date" readonly
                                           name="entered_date">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="submit-type">New/Resubmit</label>
                                    <select id="submit-type" class="form-control" name="submit_type">
                                        <option value="">Select Submit Type</option>
                                        <option value="N">New</option>
                                        <option value="R">Resubmit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hours">Hours</label>
                                    <input class="form-control" name="hours" id="hours" type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Entered By</label>
                                <input class="form-control" name="entered_by" id="entered-by" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <button type="submit" id="btn-project-time-save" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal slide" id="modal-close-plan" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn" style="min-width: 700px">
                <form action="{{route('projects.close')}}" method="post" id="form-project-close">
                    @csrf
                    {{-- If empty means user is creating new project otherwise updating a project--}}
                    <input type="hidden" name="project_id" class="project-id"
                           value="{{$project->id ?? ''}}">
                    <div class="modal-header bg-danger">
                        <h4 class="modal-title text-white">Close Plan</h4>
                        <button type="button" class="close text-white" data-dismiss="modal"><span
                                aria-hidden="true">×</span><span
                                class="sr-only">Close</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="box-number">Box Number</label>
                                    <input class="form-control" id="box-number" name="box_number" type="text"
                                           autofocus>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="reason">Reason</label>
                                    <input class="form-control" id="reason" name="reason" type="text">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea name="notes" id="notes" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Dismiss</button>
                        <button type="button" class="btn btn-danger" id="btn-close-plan">Close Plan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal  show" id="modal-edit-record-time" tabindex="-1" role="dialog" style="z-index: 999999">
        <div class="modal-dialog" style="min-width: 700px;">
            <div class="modal-content  ">
                <form action="#" method="post" id="form-edit-record-time">
                    @csrf
                    {{-- If empty means user is creating new project otherwise updating a project--}}
                    <input type="hidden" name="project_id" class="project-id"
                           value="{{$project->id ?? ''}}">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title text-white">Edit recorded time for this Project!</h4>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="project-name">Project Name</label>
                                    <input class="form-control project-name" readonly type="text"
                                           value="{{$project->name?? ''}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="time-category">Time Category</label>
                                    <select id="time-category" class="form-control input-md mb-md" name="time_category">
                                        <option value="">Select Time Category</option>
                                        <option value="Initial Plan Received">Initial Plan Received</option>
                                        <option value="Plan Review Meeting">Plan Review Meeting</option>
                                        <option value="Pre-Construction Meeting">Pre-Construction Meeting</option>
                                        <option value="Initial Site Inspection">Initial Site Inspection</option>
                                        <option value="Complaint Investigation">Complaint Investigation</option>
                                        <option value="Enforcement Meeting">Enforcement Meeting</option>
                                        <option value="Notice Of Termination">Notice Of Termination</option>
                                        <option value="Right To Know Database Search">Right To Know Database Search
                                        </option>
                                        <option value="Right To Know Meeting">Right To Know Meeting</option>
                                        <option value="NPDES Review">NPDES Review</option>
                                        <option value="E &amp; S Review">E &amp; S Review</option>
                                        <option value="Admin Review">Admin Review</option>
                                        <option value="Date Stamp &amp; Data Entry">Date Stamp &amp; Data Entry</option>
                                        <option value="Enforcement Referral">Enforcement Referral</option>
                                        <option value="Co-Permittee Application Entry">Co-Permittee Application Entry
                                        </option>
                                        <option value="Transferee Application Entry">Transferee Application Entry
                                        </option>
                                        <option value="N.O.T. - Data Entry">N.O.T. - Data Entry</option>
                                        <option value="Copy Letters, Mailings  &amp; File Project">Copy Letters,
                                            Mailings
                                            &amp; File Project
                                        </option>
                                        <option value="Admin Meeting">Admin Meeting</option>
                                        <option value="Final Site Inspection">Final Site Inspection</option>
                                        <option value="Pre-Application Meeting">Pre-Application Meeting</option>
                                        <option value="Major Modification">Major Modification</option>
                                        <option value="Minor Revision">Minor Revision</option>
                                        <option value="Returned Check">Returned Check</option>
                                        <option value="Sort Checks And Mail Bills">Sort Checks And Mail Bills</option>
                                        <option value="Acknowledge Transfer">Acknowledge Transfer</option>
                                        <option value="Inadequate Review Meeting">Inadequate Review Meeting</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="reviewer-id">Technician</label>
                                    <select id="reviewer-id" class="form-control" name="reviewer_id">
                                        <option value="">Select Technician</option>
                                        @if(isset($reviewers))
                                            @foreach($reviewers as $reviewer)
                                                <option value="{{$reviewer->id}}">{{$reviewer->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="entered-date">Date</label>
                                    <input class="form-control datepicker readonly-date"
                                           placeholder="MM/DD/YYYY" readonly type="text" autocomplete="false">
                                    <input type="hidden" class="form-control ymd-date-input" id="entered-date" readonly
                                           name="entered_date">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="submit-type">New/Resubmit</label>
                                    <select id="submit-type" class="form-control" name="submit_type">
                                        <option value="">Select Submit Type</option>
                                        <option value="N">New</option>
                                        <option value="R">Resubmit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hours">Hours</label>
                                    <input class="form-control" name="hours" id="hours" type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Entered By</label>
                                <input class="form-control" name="entered_by" id="entered-by" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btn-time-update" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <!-- Input Mask Jquery Plugin -->
    <script src="{{asset('js/plugins/inputmask/jquery.inputmask.bundle.js')}}"></script>

    <!-- Summer Note -->
    <script src="{{asset('js/plugins/summernote/summernote-bs4.js')}}"></script>

    <!-- Icheck -->
    <script src="{{asset('js/plugins/iCheck/icheck.min.js')}}"></script>

    <!-- Jquery Validator -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

    <!-- Include jQuery Validator plugin -->
    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>--}}
    <script src="{{asset('js/plugins/bootstrap-validator/validator.min.js')}}"></script>

    <!-- Include SmartWizard JavaScript source -->
    <script type="text/javascript" src="{{asset('js/plugins/smart-wizard/js/jquery.smartWizard.min.js')}}"></script>


    <!-- Toastr -->
    <script src="{{asset('js/plugins/toastr/toastr.min.js')}}"></script>

    <!-- Sweet alert -->
    <script src="{{asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>


    <!-- jQuery UI -->
    <script src="{{asset('js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('js/search-contact-in-project.js')}}"></script>h

    <script type="text/javascript" src="{{asset('js/plugins/areyousure/are-you-sure.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/projects.js')}}"></script>

    @editMode
    <script type="text/javascript">
        $(function () {
            $('#btn-finish').addClass('disabled, d-none');
            $('.sw-btn-next').text('Update & Continue');
        });


    </script>
    @endEditMode

    <script type="text/javascript">
        $(function () {
            //implements are you sure method
            $('form').areYouSure();

            $('[data=tooltip]').tooltip();

            $('#modal-finish-plan').modal();
            @if(!empty($project->id ?? ''))
            //make all the tabs clickable on btn finish click
            $('body #smartwizard .step-anchor li.nav-item').addClass('done');
            @endif
        });

    </script>
@endpush
