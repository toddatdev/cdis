@extends('layouts.app')


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
                            <h1>Working...</h1>
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


