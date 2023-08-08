@extends('layouts.app')

@section('title', 'Manage Contacts | CDIS - Dashboard')
@push('css')


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

    <!-- Toastr style -->
    <link href="{{asset('css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">

    <!-- I Checks   -->
    <link rel="stylesheet" href="{{asset('css/plugins/iCheck/custom.css')}}">


    <link href="{{asset('css/plugins/jQueryUI/jquery-ui.css')}}" rel="stylesheet">
    <!--  Jquery Plugins  -->
    <link href="{{asset('css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
@endpush

@section('breadcrumb')
    <div class="row wrapper border-bottom white-bg page-heading pt-2">
        <div class="col-lg-4 pt-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('dashboard')}}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a>Settings</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Manage Contacts</strong>
                </li>
            </ol>
        </div>
        <div class="col-md-2 pt-2">
            <a href="#" type="engineer" class="btn btn-outline  btn-primary btn-block btn-create-contact"
               id="btn-create-engineer">
                Create Engineer
            </a>
        </div>
        <div class="col-md-2 pt-2">
            <a href="{{'edit'}}" type="applicant" class="btn btn-outline  btn-primary btn-block btn-create-contact"
               id="btn-create-applicant">
                Create Applicant
            </a>
        </div>
        <div class="col-md-2 pt-2">
            <a href="#" type="coapplicant" class="btn btn-outline  btn-primary btn-block btn-create-contact"
               id="btn-create-coapplicant">
                Create Co-Applicant
            </a>
        </div>
        <div class="col-md-2 pt-2">
            <a href="#" type="copermittee" class="btn btn-outline  btn-primary btn-block btn-create-contact"
               id="btn-create-copermittee">
                Create Co-Permittee
            </a>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-10 offset-1">
            <div class="ibox pb-2">
                <div class="ibox-title">
                    <h5>Search Contacts</h5>
                </div>
                <div class="ibox-content">
                    <form action="{{route('contacts.search')}}" method="post" id="search-form">
                        @csrf
                        <div class="row w-100">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cname"> Company Name</label>
                                    <input type="text" id="cname" class="form-control" autofocus name="company">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name">Contact Name</label>
                                    <input type="text" id="name" class="form-control" autofocus name="name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="contact-type">Contact Type</label>
                                    <select class="form-control" name="type" id="contact-type">
                                        <option value="">Select One</option>
                                        <option value="engineer">Engineer/Consultant</option>
                                        <option value="applicant">Applicant</option>
                                        <option value="coapplicant">CoApplicant</option>
                                        <option value="copermittee">CoPermittee</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 mt-4">
                                <button class="btn btn-block btn-primary " id="btn-search-contact" type="submit">
                                    <strong>Search Contact</strong>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="ibox d-none" id="search-results-container">
                <div class="ibox-title">
                    <h5>Search Results</h5>
                </div>
                <div class="ibox-content ">
                    <h3 id="not-found-message" class="d-none text-center">No contacts found!</h3>
                    <table class="table table-hover" id="search-table">
                        <thead>
                        <tr>
                            <th>Entry Number</th>
                            <th>Company Name</th>
                            <th>Engineer/Applicant/CoApplicant/CoPermittee</th>
                            <th>Address</th>
                            <th>City/State/Zipcode</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody id="table-search-body">
                        <tr>
                            <td></td>
                            <td class="text-navy"><a href="#" class="text-navy -underline"></a></td>
                            <td></td>
                            <td></td>
                            <td class="text-center">
                                <a href="#" class="btn btn-danger btn-xs btn-mark-old">Mark As Old</a>
                            </td>
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

    <div class="modal show" id="modal-edit-applicant" role="dialog">
        <div class="modal-dialog" style="min-width: 800px;">
            <div class="modal-content animated fadeIn">
                <form action="{{route('contacts.create')}}" id="form-edit-applicant" method="post">
                    @csrf
                    <input type="hidden" name="TYPE" id="TYPE">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title text-white">Edit Applicant</h4>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="APPLIC">Applicant Name</label>
                                <input type="text" class="form-control"
                                       id="APPLIC" name="APPLIC">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="APP_COMPANY">Applicant Company
                                    Name</label>
                                <input type="text" class="form-control"
                                       id="APP_COMPANY" name="APP_COMPANY">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="APP_ADD1">Applicant Address</label>
                                <input type="text" class="form-control"
                                       id="APP_ADD1" name="APP_ADD1">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="APP_ADD2">Applicant Address Line
                                    2</label>
                                <input type="text" class="form-control"
                                       id="APP_ADD2" name="APP_ADD2">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="APP_CITY">Applicant City</label>
                                <input type="text" class="form-control"
                                       id="APP_CITY" name="APP_CITY">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="APP_STATE">Applicant State</label>
                                <select id="APP_STATE" class="form-control" name="APP_STATE">
                                    <option value="">Select State</option>
                                    @if(isset($states))
                                        @foreach($states as $key => $option)

                                            <option value="{{$key}}">{{$option}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="APP_ZIP">Applicant Zipcode</label>
                                <input type="text" class="form-control"
                                       id="APP_ZIP" name="APP_ZIP">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="APP_PHONE">Applicant Phone
                                    Number</label>
                                <input type="text" class="form-control us-phone"
                                       id="APP_PHONE" name="APP_PHONE">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="APP_EXT">Applicant Phone Number
                                    Ext</label>
                                <input type="text"
                                       class="form-control us-phone" id="APP_EXT"
                                       name="APP_EXT">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="APP_FAX">Applicant Fax
                                    Number</label>
                                <input type="text" class="form-control us-phone"
                                       id="APP_FAX" name="APP_FAX">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="APP_EMAIL">Applicant Email</label>
                                <input type="text" class="form-control"
                                       id="APP_EMAIL" name="APP_EMAIL">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer ">
                        <button type="button" class="btn btn-primary btn-update-contact" contacttype="applicant">
                            Update
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal  show" id="modal-edit-co-applicant" role="dialog">
        <div class="modal-dialog" style="min-width: 800px;">
            <div class="modal-content animated fadeIn">
                <form action="{{route('contacts.create')}}" id="form-edit-co-applicant" method="post">
                    @csrf
                    <input type="hidden" name="TYPE" id="TYPE">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title text-white">Edit Co-Applicant</h4>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="Name">Applicant Name</label>
                                <input type="text" class="form-control"
                                       id="Name" name="Name">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Company">Applicant Company
                                    Name</label>
                                <input type="text" class="form-control"
                                       id="Company" name="Company">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="Address1">Applicant Address</label>
                                <input type="text" class="form-control"
                                       id="Address1" name="Address1">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="Address2">Applicant Address Line
                                    2</label>
                                <input type="text" class="form-control"
                                       id="Address2" name="Address2">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="City">Applicant City</label>
                                <input type="text" class="form-control"
                                       id="City" name="City">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="State">Applicant State</label>
                                <select id="State" class="form-control" name="State">
                                    <option value="">Select State</option>
                                    @if(isset($states))
                                        @foreach($states as $key => $option)

                                            <option value="{{$key}}">{{$option}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="Zip">Applicant Zipcode</label>
                                <input type="text" class="form-control"
                                       id="Zip" name="Zip">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="Phone">Applicant Phone
                                    Number</label>
                                <input type="text" class="form-control us-phone"
                                       id="Phone" name="Phone">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="PhoneExt">Applicant Phone Number
                                    Ext</label>
                                <input type="text"
                                       class="form-control us-phone" id="PhoneExt"
                                       name="PhoneExt">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="Fax">Applicant Fax
                                    Number</label>
                                <input type="text" class="form-control us-phone"
                                       id="Fax" name="Fax">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="Email">Applicant Email</label>
                                <input type="text" class="form-control"
                                       id="Email" name="Email">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer ">
                        <button type="button" class="btn btn-primary btn-update-contact" contacttype="applicant">
                            Update
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal  show" id="modal-edit-engineer" role="dialog">
        <div class="modal-dialog" style="min-width: 800px;">
            <div class="modal-content animated fadeIn">
                <form action="{{route('contacts.create')}}" id="form-edit-engineer" method="post">
                    @csrf
                    <input type="hidden" name="TYPE" id="TYPE">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title text-white">Edit Engineer</h4>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="SENTBY">Engineer Name</label>
                                <input type="text" class="form-control"
                                       id="SENTBY" name="SENTBY">
                            </div>
                            <div class="form-group col-md-6 offsetmd">
                                <label for="ENGINEER">Engineer Company
                                    Name</label>
                                <input type="text" class="form-control"
                                       id="ENGINEER" name="ENGINEER">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="ENG_ADD1">Engineer Address</label>
                                <input type="text" class="form-control"
                                       id="ENG_ADD1" name="ENG_ADD1">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="ENG_ADD2">Engineer Address Line
                                    2</label>
                                <input type="text" class="form-control"
                                       id="ENG_ADD2" name="ENG_ADD2">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="ENG_CITY">Engineer City</label>
                                <input type="text" class="form-control"
                                       id="ENG_CITY" name="ENG_CITY">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="ENG_STATE">Engineer State</label>
                                <select name="ENG_STATE" class="form-control" id="ENG_STATE">
                                    <option value="">Select State</option>
                                    @if(isset($states))
                                        @foreach($states as $key => $option)
                                            <option value="{{$key}}">{{$option}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="ENG_ZIP">Engineer Zipcode</label>
                                <input type="text" class="form-control"
                                       id="ENG_ZIP" name="ENG_ZIP">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="ENG_PHONE">Engineer Phone
                                    Number</label>
                                <input type="text" class="form-control us-phone"
                                       id="ENG_PHONE" name="ENG_PHONE">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="ENG_EXT">Engineer Phone Number
                                    Ext</label>
                                <input type="text" class="form-control us-phone"
                                       id="ENG_EXT" name="ENG_EXT">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="ENG_FAX">Engineer Fax
                                    Number</label>
                                <input type="text" class="form-control us-phone"
                                       id="ENG_FAX" name="ENG_FAX">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="ENG_EMAIL">Engineer Email</label>
                                <input type="text" class="form-control"
                                       id="ENG_EMAIL" name="ENG_EMAIL">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-primary btn-update-contact" contacttype="engineer">Update
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal  show" id="modal-edit-co-perm" role="dialog">
        <div class="modal-dialog" style="min-width: 800px;">
            <div class="modal-content animated fadeIn">
                <form action="{{route('contacts.create')}}" method="post" id="form-edit-co-perm">
                    @csrf
                    <input type="hidden" name="TYPE" id="TYPE">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title text-white">Edit Co-Permittee</h4>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="DATE_ACQUIRED">Received Date</label>
                                    <input class="form-control datepicker readonly-date" readonly
                                           type="text" autofocus placeholder="MM/DD/YYYY">
                                    <input type="hidden" class="form-control ymd-date-input"
                                           name="DATE_ACQUIRED" id="DATE_ACQUIRED">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Ack_Date">Reviewed Date</label>
                                    <input class="form-control datepicker readonly-date" placeholder="MM/DD/YYYY"
                                           type="text"
                                           readonly>
                                    <input type="hidden" class="form-control ymd-date-input"
                                           id="Ack_Date" readonly name="Ack_Date">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-4">
                                    <div class="checks pt-2">
                                        <label class="a-checks">
                                            <input type='hidden' value='0' name="Ack">
                                            <input class="checkbox" name="Ack" id="Ack" type="checkbox" value="1">
                                            <span class="checkmark"></span> Is Acknowledged
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title">Co-Permittee Name</label>
                                    <input class="form-control" name="title" id="title" type="text">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="COMPANY">Co-Permittee Company</label>
                                    <input class="form-control" name="COMPANY"
                                           id="COMPANY" type="text">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Email">Email</label>
                                    <input class="form-control" name="Email" id="Email" type="text">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ADDRESS1">Address 1</label>
                                    <input class="form-control" name="ADDRESS1"
                                           id="ADDRESS1" type="text">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ADDRESS2">Address 2</label>
                                    <input class="form-control" name="ADDRESS2"
                                           id="ADDRESS2" type="text">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="CITY">City</label>
                                    <input class="form-control" name="CITY" id="CITY" type="text">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="STATE">State</label>
                                    <input class="form-control" name="STATE" id="STATE" type="text">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ZIP">Zip Code</label>
                                    <input class="form-control" name="ZIP" id="ZIP" type="text">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="PHONE">Phone</label>
                                    <input class="form-control us-phone" name="PHONE" id="PHONE" type="text">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="FAX">Fax</label>
                                    <input class="form-control us-phone" name="FAX" id="FAX" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-primary btn-update-contact" contacttype="copermittee">
                            Update
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@push('js')
    <script src="{{asset('js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- Toastr -->
    <script src="{{asset('js/plugins/toastr/toastr.min.js')}}"></script>

    <!-- Input Mask Jquery Plugin -->
    <script src="{{asset('js/plugins/inputmask/jquery.inputmask.bundle.js')}}"></script>

    <!-- Icheck -->
    <script src="{{asset('js/plugins/iCheck/icheck.min.js')}}"></script>

    <script src="{{asset('js/search-contacts.js')}}"></script>
@endpush
