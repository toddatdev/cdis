@extends('layouts.app')

@section('title', 'Search Projects | CDIS - Dashboard')
@push('css')
    <link rel="stylesheet" href="{{asset('css/plugins/jQueryUI/jquery-ui.css')}}">
    <style>
        td.project-details .btn {
            padding: .22rem .45rem !important;
        }

        #table-search-body td {
            vertical-align: middle !important;
            padding: 5px;
            position: relative;
        }

        #pagination {
            max-width: 100%;
            overflow: auto;
        }
    </style>
@endpush

@section('breadcrumb')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10 pt-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('dashboard')}}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a>Projects</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Search Project</strong>
                </li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-10 offset-1">
            @isset($message)
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Please Search!</strong> {{$message}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endisset
            <div class="ibox pb-2">
                <div class="ibox-title">
                    <h5>Search a Project</h5>
                </div>
                <div class="ibox-content">
                    <form action="{{route('projects.search')}}" method="post" id="search-form">
                        @csrf
                        <div class="row w-100">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name">Project Name</label>
                                    <input type="text" id="name" class="form-control" autofocus name="name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>NPDES Number</label>
                                    <input type="text" class="form-control" name="npdes_number">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Entry Number</label>
                                    <input type="text" class="form-control" name="entry_number">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="municipality">Municipality</label>
                                    <select class="form-control" name="municipality_id" id="municipality">
                                        <option value="">Select Municipality</option>
                                        @if(isset($municipalities))
                                            @foreach($municipalities as $municipality)
                                                <option value="{{$municipality->id}}">{{$municipality->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Location</label>
                                    <input type="text" class="form-control" name="address_1">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tech">Technician</label>
                                    <select class="form-control" name="reviewer_id" id="tech">
                                        <option value="">Select Technician</option>
                                        @if(isset($reviewers))
                                            @foreach($reviewers as $reviewer)
                                                <option value="{{$reviewer->id}}">{{$reviewer->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>NPDES Received Date</label>
                                    <input type="text" class="form-control date-range-picker" id="date-range">
                                    <input type="hidden" name="from" id="from">
                                    <input type="hidden" name="to" id="to">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tax Parcel</label>
                                    <input type="text" class="form-control" name="tax_parcel">
                                </div>
                            </div>
                            <div class="row w-100 mt-sm-4 ml-sm-5 ml-md-5 ml-lg-5 mt-lg-3">
                                <div class="col-md-4  offset-4 offset-lg-5">
                                    <a href="#" class="btn btn-sm btn-primary " id="btn-search">
                                        <strong>Search Project</strong>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="ibox d-none" id="search-results-container">
                <div class="ibox-title ">
                    <h5>Search Results </h5> <span> (<span id="found-records">250</span> projects found)</span>
                </div>
                <div class="ibox-content ">
                    <h3 id="not-found-message" class="d-none text-center">No projects found!</h3>
                    <table class="table" id="search-table">
                        <thead>
                        <tr>
                            <th>Entry Number</th>
                            <th>Project Name</th>
                            <th>Technician</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody id="table-search-body">
                        <tr class="text-center">
                            <td colspan="5"><h3>No Projects Found!</h3></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="ibox-content">
                    <ul class="pagination" id="pagination"></ul>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <!-- jQuery UI -->
    <script src="{{asset('js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/search-projects.js')}}"></script>
@endpush
