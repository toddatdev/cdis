<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Withdrawn Report - CDIS Reports')</title>

    {{--    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('css/style.css')}}" rel="stylesheet">
        <link href="{{asset('css/cdis.css')}}" rel="stylesheet">--}}

    <style>
        body {
            font-size: 14px;
            font-family: "open sans", "Helvetica Neue", Helvetica, Arial, sans-serif;

        }

        .container {
            max-width: 83%;
            margin-left: auto;
            margin-right: auto;
            margin-top: 40px;
        }

        .bg-primary {

            background-color: #1ab394 !important;
            color: #ffffff;
        }

        .py-3 {

            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .px-2 {

            padding-right: 0.5rem;
            padding-left: 0.5rem;
            text-align: center;
        }

        h2 {
            text-align: center;
        }

        h3, h4, h5 {
            margin-top: 5px;
            font-weight: 600;
            color: #676A6C;
        }

        h3 {
            font-size: 16px;

            padding-top: 40px;
        }

        h4 {
            font-size: 14px;
            margin: 5px 0 8px;
        }

        h4.text-white.text-center {
            color: #fff !important;
        }

        h4.text-center {
            text-align: center;
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
        }

        .table td {
            border: 1px solid #e7eaec;
            padding: 10px;
            font-size: 13px;
            color: #676a6c;
        }

        hr.hr-line-dashed.mt-5 {
            border-style: dashed;
            color: #e7eaec;
            margin-top: 40px;
        }

        th {
            border: 1px solid #e7eaec;
            padding: 8px;
            font-size: 13px;
        }

        td {
            text-align: center;
        }

        td.project-name, th.project-name {
            text-align: left !important;
        }

        hr.hr-line-dashed {

            border-style: dashed;
            color: #e7eaec;

            margin: 20px 0;
        }

        .float-right {
            float: right;
        }

        .float-left {
            float: left;
        }

        .text-left {
            text-align: left !important;
        }

        .text-center {
            text-align: center !important;
        }

        .chk-date {
            width: 6%;
        }
    </style>@stack('css')
</head>
<body class="bg-white">
<div class="container">@yield('content')
</div>
</body>
</html>

