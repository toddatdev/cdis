@extends('layouts.app')


@push('css')
    <!-- Toastr style -->
    <link href="{{asset('css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">
@endpush
@section('breadcrumb')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Admin Panel</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('dashboard')}}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a>Admin Panel</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Users</strong>
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

                    <h5>Users Information</h5>
                </div>
                <div class="ibox-content">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Employee Number</th>
                            <th>Employee Name</th>
                            <th>Email</th>
                            <th>Title</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{sprintf('%05d', $user->id)}}</td>
                                <td class="text-navy"><a href="#" class="text-navy -underline">{{$user->name}}</a></td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->role}}</td>
                                <td class="text-center">

                                    @if($user->is_active)
                                        <a href="{{route('user.deactivate', $user->id)}}"
                                           class="btn btn-danger btn-xs btn-update-status">Deactivate</a>
                                    @else
                                        <a href="{{route('user.activate', $user->id)}}"
                                           class="btn btn-success btn-xs btn-update-status">Activate</a>
                                    @endif
                                    {{--                                <button type="button" class="btn btn-primary btn-xs">Edit</button>--}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <!-- Toastr -->
    <script src="{{asset('js/plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{asset('js/admin.js')}}"></script>
@endpush
