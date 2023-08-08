@extends('layouts.app')

@section('title', 'Generate Letters | CDIS - Dashboard')
@push('css')

    <link href="{{asset('css/plugins/jQueryUI/jquery-ui.css')}}" rel="stylesheet">

    <!-- I Checks   -->
    <link rel="stylesheet" href="{{asset('css/plugins/sweetalert/sweetalert.css')}}">
    <link rel="stylesheet" href="{{asset('css/plugins/iCheck/custom.css')}}">


    <style>
        /*.dependent-list-item {*/
        /*    display: none;*/
        /*}*/
        .tooltip-inner {
            max-width: 200px;
            padding: 3px 8px;
            color: #fff !important;
            text-align: center;
            background-color: #000 !important;
            border-radius: .25rem;
        }
    </style>

@endpush()
@section('breadcrumb')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-md-8 pt-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a>Generate</a></li>
                <li class="breadcrumb-item active"><strong>Letter</strong></li>
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
        <div class="col-md-9 offset-1">
            <div class="ibox w-75 mx-auto">
                <form action="{{route('letter.generate')}}" method="post" id="form-letter-generation">
                    @csrf
                    <input type="hidden" name="project_id" value="{{$project_id}}">
                    <div class="ibox-title" style="padding: 15px 20px 5px 15px">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mt-2">Generate New Letter</h5>
                            </div>
                            <div class="form-group col-md-6 ">
                                <select id="letter-type" class="form-control" name="letter_type">
                                    <option value="select_one">Select Letter Type</option>

                                    {{-- FOR BUCKS COUNTY --}}
                                    @if(session('county_id') === 1)
                                        <option value="npdes_permit_authorization">NPDES Permit Authorization</option>
                                        {{-- Common letters for both counties --}}
                                        <option value="admin_complete">Admin Complete</option>
                                        <option value="not_approval">NOT Approval</option>
                                        <option value="not_copermitee">NOT Copermittee</option>
                                        <option value="not_partial">NOT Partial</option>
                                        <option value="npdes_permit">NPDES Permit</option>
                                        {{-- END Common Letters --}}
                                        <option value="recommend_permit_action">Recommend Permit Action</option>
                                        <option value="inadequate_es">Inadequate E&amp;S</option>
                                        <option value="adequate_with_comments">Adequate with Comments</option>
                                        <option value="adequate_es">Adequate E&amp;S</option>
{{--                                        <option value="admin_incomplete_bccd">Admin Incomplete</option>--}}
                                        <option value="copermitee_form_incomplete">Copermittee Form Incomplete</option>
                                        <option value="inadequate_npdes">Inadequate NPDES</option>
                                        <option value="admin_incompleteness_letter_for_general_permit">General Permit Incompleteness</option>
                                        <option value="admin_incompleteness_letter_for_individual_permit">Individual Permit Incompleteness</option>
                                    @endif

                                    {{-- FOR MCCD COUNTY --}}
                                    @if(session('county_id') === 2)
                                        {{-- Common letters for both counties --}}
                                        <option value="npdes_permit_authorization">Adequate NPDES</option>
                                        <option value="admin_complete">Admin Complete</option>
                                        <option value="not_approval">NOT Approval</option>
                                        <option value="not_copermitee">NOT Copermittee</option>
                                        <option value="not_partial">NOT Partial</option>
                                        <option value="npdes_permit">NPDES Permit</option>
                                        {{-- END Common Letters --}}
                                        <option value="revision_adequate_non_permit">Revision Adequate Non Permit</option>
                                        <option value="revision_adequate_permit">Revision Adequate Permit</option>
                                        <option value="npdes_individual_recommendation_for_permit_action">
                                            NPDES Individual Recommendation for Permit Action</option>
                                        <option value="adequate_close_to_1_acre">ADEQUATE-close to 1-acre</option>
                                    @endif

{{--                                    <option value="general_permit_incompleteness">General Permit Incompleteness</option>--}}
                                    {{--<option value="admin_incomplete_mccd">Admin Incomplete</option>--}}
                                    {{-- <option value="compliance_notice">Compliance Notice</option>--}}
                                    {{--<option value="adequate_indiv_npdes_authorization">Adequate Indiv NPDES
                                      Authorization</option>--}}
                                    {{-- <option value="denial_permit">Denial Permit</option>--}}
                                    {{-- <option value="es_authorization">E&amp;S Authorization</option>--}}
                                    {{-- <option value="es_permit_recommendation_for_permit_action">
                                    E&amp;S Permit Recommendation For Permit Action</option>--}}
                                    {{-- <option value="es_permit_technical_deficiency">E&amp;S Permit Technical Deficiency</option>--}}
                                    {{-- <option value="extension">Extension</option>--}}
                                    {{--<option value="es_permit_recommendation_for_permit_action">--}}
                                    {{--    E&amp;S Permit Recommendation For Permit Action</option>--}}
                                    {{-- <option value="not_denial">NOT Denial</option>--}}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content" style="max-height: 70vh; overflow: auto" id="scrollable">
                        <div class="container mt-2">
                            <div class="dependent-list " id="dependent-list">
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content pb-0">
                        <div class="row">
                            <div class="form-group col-md-8">
                                <input name="memo" placeholder="Write a Memo" id="memo" class="form-control">
                            </div>
                            <div class="form-group col-md-4 text-right">
                                <a href="#" class="btn btn-primary btn-block" id="btn-generate-letter"
                                   disabled="disabled">
                                    Generate Letter
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <!-- jQuery UI -->
    <script src="{{asset('js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    <script src="{{asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{asset('js/plugins/iCheck/icheck.min.js')}}"></script>
    <script src="{{asset('js/generate-letters.js')}}"></script>
@endpush()
