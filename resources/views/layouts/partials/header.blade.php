<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'CDIS - Dashboard')</title>

    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('fonts/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/daterangepicker/daterangepicker-bs3.css')}}" rel="stylesheet">
    <link href="{{asset('css/animate.css')}}" rel="stylesheet">
    {{--    <link href="{{asset('css/plugins/jQueryUI/jquery-ui.css')}}" rel="stylesheet">--}}

    @stack('css')

    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/cdis.css')}}" rel="stylesheet">

    <style>
        /* The a-checks */
        .a-checks {
            display: block;
            position: relative;
            padding-left: 30px;
            margin-bottom: 12px;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Hide the browser's default checkbox */
        .a-checks input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        * {
            box-sizing: border-box;
        }

        /* Create a custom checkbox */
        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 22px;
            width: 22px;
            background-color: #fff;
            border: 1px solid #e5e6e7;
        }

        /* On mouse-over, add a grey background color */
        .a-checks:hover input ~ .checkmark {
            border: 2px solid #3d8c63;
        }

        /* When the checkbox is checked, add a blue background */
        .a-checks input:checked ~ .checkmark {
            background-color: #18a689;
            border: 2px solid #18a689;
        }

        /* Create the checkmark/indicator (hidden when not checked) */
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the checkmark when checked */
        .a-checks input:checked ~ .checkmark:after {
            display: block;
        }

        /* Style the checkmark/indicator */
        .a-checks .checkmark:after {
            left: 6px;
            top: 3px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }
    </style>
</head>
<body class="mini-navbar">
