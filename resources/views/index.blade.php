@extends('layouts.app')

@push('css')
    <link href="css/plugins/bootstrapSocial/bootstrap-social.css" rel="stylesheet">
@endpush

@section('breadcrumb')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10 pt-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Overview</strong>
                </li>
            </ol>
        </div>
    </div>
@endsection
@section('content')

    <div class="row">
        <div class="col-md-2 offset-1">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Go To</h5>
                </div>
                <div class="ibox-content " style="min-height: 385px;">
                    <a href="{{route('projects.search.index')}}" class="btn btn-block btn-social btn-linkedin">
                        <span class="fa fa-search"></span> Search Plan Entries
                    </a>
                    <a href="{{route('projects.show')}}" class="btn btn-block btn-social btn-linkedin">
                        <span class="fa fa-save"></span> Add New Plan Entry
                    </a>
                    <a href="{{route('reports')}}" class="btn btn-block btn-social btn-linkedin">
                        <span class="fa fa-files-o"></span> Reports
                    </a>
                    <a href="{{route('letter.show')}}" class="btn btn-block btn-social btn-linkedin">
                        <span class="fa fa-envelope-open-o"></span> Generate Letters
                    </a>
                    <a href="{{route('site.inspection')}}" class="btn btn-block btn-social btn-linkedin">
                        <span class="fa fa-search-plus"></span> Site Inspection Form
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>County Map</h5>
                    <p>
                        {{--                        <a href="#" class="text-dark">Show Only Mine</a> |--}}
                        <a href="#" class="text-navy btn-county-map map-filter" data-project-type="mine">Show Only Mine</a> |
                        <a href="#" class="text-dark btn-county-map map-filter" data-project-type="all">Show All for
                            County</a> |
                        <a href="#" class="text-dark btn-county-map map-filter" data-project-type="closed">Closed</a>
                    </p>
                </div>
                <div class="ibox-content " style="min-height: 350px;">
                    <div id="map"
                         style="height: 100%; width: 100%; position: absolute; top: 0px; left: 0px; background-color: rgb(229, 227, 223);"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9 offset-1">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Most Recent Projects</h5>
                </div>
                <div class="ibox-content ">
                    @if(!$recentProjects->isEmpty())
                        <table class="table " id="table-recent-projects">
                            <thead>
                            <thead>
                            <tr>
                                <th>Entry Number</th>
                                <th>Project Name</th>
                                <th>Access Date</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($recentProjects as $project)
                                <tr>
                                    <td class="entry-number">{{$project->project_id}}</td>
                                    <td class="text-navy project-name"><a
                                            href="{{route('projects.edit', $project->project_id)}}"
                                            class="text-navy ">{{$project->name}}</a></td>
                                    <td class="project-date">{{sqlToHtmlDate($project->access_dt ?? '')}}</td>
                                    <td class="text-center project-details">
                                        <a href="{{route('letter.show', $project->project_id)}}"
                                           class="text-navy btn btn-white letters-link" data-toggle="tooltip"
                                           title="Generate Letter"><i class="fa fa-envelope-open-o"></i></a>
                                        <a href="{{route('site.inspection', $project->project_id)}}"
                                           class="text-navy btn btn-white inspections-link" data-toggle="tooltip"
                                           title="Site Inspection"><i class="fa fa-search-plus"></i></a>
                                        <a href="{{route('projects.edit', $project->project_id)}}"
                                           class="text-navy btn btn-white projects-link" title="Edit Project"
                                           data-toggle="tooltip"><i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <h3 class="text-center">No recent project found!</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="js/cdis.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAg0Mz9gHy_14P5nhUO-1gIWa5CUC5aORA&callback=initMap"
            defer></script>
    <script>
        let map;
        function initMap(whose = 'mine') {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 40.3128392, lng: -75.1445985},
                zoom: 10
            });

            addMarkers(whose);
        }

        function addMarkers(whose) {
            $.get('/long-lat/' + whose, function (data) {

                for (var i = 0; i < data.length; i++) {

                    var mark = data[i];

                    //TODO: Implement Show Only Mine
                    // if (whose === 'mine' && mark[4] !== id) {
                    //     continue;
                    // }

                    var marker = new google.maps.Marker({
                        position: {lat: mark[1], lng: mark[2]},
                        map: map,
                        title: mark[0],
                        url: mark[3]
                    });

                    google.maps.event.addListener(marker, 'click', function () {
                        window.location.href = this.url;
                    });
                }
            });
        }

        $(document).ready(function () {
            $(document).on('click', 'a.map-filter', function (e) {
                e.preventDefault();
                $(this).siblings().removeClass('text-navy').addClass('text-dark');
                $(this).addClass('text-navy').removeClass('text-dark');
                initMap($(this).data('project-type'));
            });
        });
    </script>
@endpush
