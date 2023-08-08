@extends('layouts.app')

@push('css')
    <!-- Toastr style -->
    <link href="{{asset('css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">
@endpush
@section('breadcrumb')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>User Settings</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('dashboard')}}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a>User</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Settings</strong>
                </li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-9 offset-1">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="row w-100">
                        <div class="col-md-12 mt-3">
                            <form action="{{route('user.update')}}" role="form" method="post" id="form-user-settings">
                                @csrf
                                <div class="row w-100">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Employee ID</label>
                                            <input type="text" placeholder="{{sprintf('%05d', $user->id ?? '')}}"
                                                   class="form-control"
                                                   name="employee_id" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input type="text" placeholder="asathomas241" class="form-control"
                                                   name="username" value="{{$user->username?? ''}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ICIS Username</label>
                                            <input type="text" placeholder="icisasa201"
                                                   value="{{$user->icis_username?? ''}}"
                                                   class="form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" placeholder="asathomas@gmail.com"
                                                   class="form-control" name="email" value="{{$user->email?? ''}}"
                                                   disabled="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="first_name"
                                                   value="{{$user->first_name?? ''}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" class="form-control"
                                                   name="last_name" value="{{$user->last_name?? ''}}">
                                        </div>
                                    </div>


                                    <div class="row w-100 mt-sm-4 ml-sm-5 ml-md-5 ml-lg-0 mt-lg-5">
                                        <div class="col-md-4  offset-4 offset-lg-5">
                                            <button class="btn btn-sm btn-primary " id="btn-update" type="submit">
                                                <strong>Update Info</strong>
                                            </button>
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
@endsection

@push('js')
    <!-- Toastr -->
    <script src="{{asset('js/plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{asset('js/settings.js')}}"></script>
@endpush
