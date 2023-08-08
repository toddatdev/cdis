@extends('layouts.app')

@push('css')
    <link href="css/plugins/bootstrapSocial/bootstrap-social.css" rel="stylesheet">
@endpush

@section('breadcrumb')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-md-9 pt-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active"><strong>Changelogs</strong></li>
            </ol>
        </div>
        <div class="col-md-2 pt-2">
            <a href="{{route('projects.edit', request()->id )}}" class="btn btn-outline  btn-primary btn-block">
                Return to Edit Project
            </a>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Project </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link" href="">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Modifier Name</th>
                            <th>Modified Date</th>
                            <th>Event</th>
                            <th>Field</th>
                            <th>Old Value</th>
                            <th>New Value</th>
                        </tr>
                        </thead>
                        <tbody>

                        @forelse ($projectAudits as $audit)
                            <tr class="bg-muted">
                                <td>
                                    {{ucfirst($audit->getMetadata()['user_first_name']). ' ' . ucfirst($audit->getMetadata()['user_last_name'])}}
                                </td>
                                <td>
                                    {{ humanReadableDateTime($audit->getMetadata()['audit_created_at'])}}
                                </td>
                                <td><strong>Event</strong></td>
                                <td><strong>Field</strong></td>
                                <td><strong>Old Value</strong></td>
                                <td><strong>New Value</strong>
                                    <i class="fa fa-plus float-right collapse-btn"
                                       style="font-size: 1.5em; color: #1ab394;"
                                       id="collapsible-{{dateToClassName($audit->getMetadata()['audit_created_at'])}}"></i>
                                </td>
                            </tr>
                            @foreach ($audit->getModified() as $attribute => $modified)
                                <tr style="display: none"
                                    class="collapsible collapsible-{{dateToClassName($audit->getMetadata()['audit_created_at'])}} bg-white">
                                    <td colspan="2">
                                    </td>
                                    <td> {{$audit->event}}</td>
                                    <td> {{ucwords(clean($attribute))}}</td>
                                    <td> {{sqlToHTMLByDateDetection($modified['old'] ?? '')}}</td>
                                    <td> {{ sqlToHTMLByDateDetection($modified['new'])}}</td>
                                </tr>
                            @endforeach
                        @empty
                            <p>No changelogs found</p>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="ibox">
                <div class="ibox-title">
                    <h5>Project Details </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link" href="">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Modifier Name</th>
                            <th>Modified Date</th>
                            <th>Event</th>
                            <th>Field</th>
                            <th>Old Value</th>
                            <th>New Value</th>
                        </tr>
                        </thead>
                        <tbody>

                        @forelse ($detailsAudits as $audit)
                            <tr class="bg-muted">
                                <td>
                                    {{ucfirst($audit->getMetadata()['user_first_name']). ' ' . ucfirst($audit->getMetadata()['user_last_name'])}}
                                </td>
                                <td>
                                    {{ humanReadableDateTime($audit->getMetadata()['audit_created_at'])}}
                                </td>
                                <td><strong>Event</strong></td>
                                <td><strong>Field</strong></td>
                                <td><strong>Old Value</strong></td>
                                <td><strong>New Value</strong>
                                    <i class="fa fa-plus float-right collapse-btn"
                                       style="font-size: 1.5em; color: #1ab394;"
                                       id="collapsible-{{dateToClassName($audit->getMetadata()['audit_created_at'])}}"></i>
                                </td>
                            </tr>
                            @foreach ($audit->getModified() as $attribute => $modified)
                                <tr style="display: none"
                                    class="collapsible collapsible-{{dateToClassName($audit->getMetadata()['audit_created_at'])}} bg-white">
                                    <td colspan="2">
                                    </td>
                                    <td> {{$audit->event}}</td>
                                    <td> {{ucwords(clean($attribute))}}</td>
                                    <td> {{sqlToHTMLByDateDetection($modified['old'] ?? '')}}</td>
                                    <td> {{ sqlToHTMLByDateDetection($modified['new'])}}</td>
                                </tr>
                            @endforeach
                        @empty
                            <p>No changelogs found</p>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Project Location </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link" href="">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Modifier Name</th>
                            <th>Modified Date</th>
                            <th>Event</th>
                            <th>Field</th>
                            <th>Old Value</th>
                            <th>New Value</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($locationAudits as $audit)
                            <tr class="bg-muted">
                                <td>
                                    {{ucfirst($audit->getMetadata()['user_first_name']). ' ' . ucfirst($audit->getMetadata()['user_last_name'])}}
                                </td>
                                <td>
                                    {{ humanReadableDateTime($audit->getMetadata()['audit_created_at'])}}
                                </td>
                                <td><strong>Event</strong></td>
                                <td><strong>Field</strong></td>
                                <td><strong>Old Value</strong></td>
                                <td><strong>New Value</strong>
                                    <i class="fa fa-plus float-right collapse-btn"
                                       style="font-size: 1.5em; color: #1ab394;"
                                       id="collapsible-{{dateToClassName($audit->getMetadata()['audit_created_at'])}}"></i>
                                </td>
                            </tr>
                            @foreach ($audit->getModified() as $attribute => $modified)
                                <tr style="display: none"
                                    class="collapsible collapsible-{{dateToClassName($audit->getMetadata()['audit_created_at'])}} bg-white">
                                    <td colspan="2">
                                    </td>
                                    <td> {{$audit->event}}</td>
                                    <td> {{ucwords(clean($attribute))}}</td>
                                    <td> {{sqlToHTMLByDateDetection($modified['old'] ?? '')}}</td>
                                    <td> {{ sqlToHTMLByDateDetection($modified['new'])}}</td>
                                </tr>
                            @endforeach
                        @empty
                            <p>No changelogs found</p>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Project Engineers </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link" href="">
                            <i class="fa fa-chevron-up"></i>
                        </a>

                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Modifier Name</th>
                            <th>Modified Date</th>
                            <th>Event</th>
                            <th>Field</th>
                            <th>Old Value</th>
                            <th>New Value</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($engineerAudits as $audit)
                            <tr class="bg-muted">
                                <td>
                                    {{ucfirst($audit->getMetadata()['user_first_name']). ' ' . ucfirst($audit->getMetadata()['user_last_name'])}}
                                </td>
                                <td>
                                    {{ humanReadableDateTime($audit->getMetadata()['audit_created_at'])}}
                                </td>
                                <td><strong>Event</strong></td>
                                <td><strong>Field</strong></td>
                                <td><strong>Old Value</strong></td>
                                <td><strong>New Value</strong>
                                    <i class="fa fa-plus float-right collapse-btn"
                                       style="font-size: 1.5em; color: #1ab394;"
                                       id="collapsible-{{dateToClassName($audit->getMetadata()['audit_created_at'])}}"></i>
                                </td>
                            </tr>
                            @foreach ($audit->getModified() as $attribute => $modified)
                                <tr style="display: none"
                                    class="collapsible collapsible-{{dateToClassName($audit->getMetadata()['audit_created_at'])}} bg-white">
                                    <td colspan="2">
                                    </td>
                                    <td> {{$audit->event}}</td>
                                    <td> {{ucwords(clean($attribute))}}</td>
                                    <td> {{sqlToHTMLByDateDetection($modified['old'] ?? '')}}</td>
                                    <td> {{ sqlToHTMLByDateDetection($modified['new'])}}</td>
                                </tr>
                            @endforeach
                        @empty
                            <p>No changelogs found</p>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Project Permit </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link" href="">
                            <i class="fa fa-chevron-up"></i>
                        </a>

                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Modifier Name</th>
                            <th>Modified Date</th>
                            <th>Event</th>
                            <th>Field</th>
                            <th>Old Value</th>
                            <th>New Value</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($permitAudits as $audit)
                            <tr class="bg-muted">
                                <td>
                                    {{ucfirst($audit->getMetadata()['user_first_name']). ' ' . ucfirst($audit->getMetadata()['user_last_name'])}}
                                </td>
                                <td>
                                    {{ humanReadableDateTime($audit->getMetadata()['audit_created_at'])}}
                                </td>
                                <td><strong>Event</strong></td>
                                <td><strong>Field</strong></td>
                                <td><strong>Old Value</strong></td>
                                <td><strong>New Value</strong>
                                    <i class="fa fa-plus float-right collapse-btn"
                                       style="font-size: 1.5em; color: #1ab394;"
                                       id="collapsible-{{dateToClassName($audit->getMetadata()['audit_created_at'])}}"></i>
                                </td>
                            </tr>
                            @foreach ($audit->getModified() as $attribute => $modified)
                                <tr style="display: none"
                                    class="collapsible collapsible-{{dateToClassName($audit->getMetadata()['audit_created_at'])}} bg-white">
                                    <td colspan="2">
                                    </td>
                                    <td> {{$audit->event}}</td>
                                    <td> {{ucwords(clean($attribute))}}</td>
                                    <td> {{sqlToHTMLByDateDetection($modified['old'] ?? '')}}</td>
                                    <td> {{ sqlToHTMLByDateDetection($modified['new'])}}</td>
                                </tr>
                            @endforeach
                        @empty
                            <p>No changelogs found</p>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div><div class="ibox">
                <div class="ibox-title">
                    <h5>Project Fees & Reviews </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link" href="">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Modifier Name</th>
                            <th>Modified Date</th>
                            <th>Event</th>
                            <th>Field</th>
                            <th>Old Value</th>
                            <th>New Value</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($feeAudits as $audit)
                            <tr class="bg-muted">
                                <td>
                                    {{ucfirst($audit->getMetadata()['user_first_name']). ' ' . ucfirst($audit->getMetadata()['user_last_name'])}}
                                </td>
                                <td>
                                    {{ humanReadableDateTime($audit->getMetadata()['audit_created_at'])}}
                                </td>
                                <td><strong>Event</strong></td>
                                <td><strong>Field</strong></td>
                                <td><strong>Old Value</strong></td>
                                <td><strong>New Value</strong>
                                    <i class="fa fa-plus float-right collapse-btn"
                                       style="font-size: 1.5em; color: #1ab394;"
                                       id="collapsible-{{dateToClassName($audit->getMetadata()['audit_created_at'])}}"></i>
                                </td>
                            </tr>
                            @foreach ($audit->getModified() as $attribute => $modified)
                                <tr style="display: none"
                                    class="collapsible collapsible-{{dateToClassName($audit->getMetadata()['audit_created_at'])}} bg-white">
                                    <td colspan="2">
                                    </td>
                                    <td> {{$audit->event}}</td>
                                    <td> {{ucwords(clean($attribute))}}</td>
                                    <td> {{sqlToHTMLByDateDetection($modified['old'] ?? '')}}</td>
                                    <td> {{ sqlToHTMLByDateDetection($modified['new'])}}</td>
                                </tr>
                            @endforeach
                        @empty
                            <p>No changelogs found</p>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="js/cdis.js"></script>
    <script>
        $('body').on('click', '.collapse-btn', function (e) {
            e.preventDefault();

            if ($(this).hasClass('fa-minus')) {
                $(this).addClass('fa-plus');
                $(this).removeClass('fa-minus');

            } else {

                $(this).removeClass('fa-plus');
                $(this).addClass('fa-minus');
            }


            var clicked_link = $(this).attr('id');

            $(this).parents('tbody').find('tr.' + clicked_link).slideToggle();

        })
    </script>


@endpush


