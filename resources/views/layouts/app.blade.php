@include('layouts.partials.header')
<div id="wrapper">
    {{-- Including Sidebar --}}
    @include('layouts.partials.sidebar')

    <div id="page-wrapper" class="gray-bg">

        {{-- Including Top Bar--}}
        @include('layouts.partials.top-bar')

        {{-- Yield the breadcrumb content --}}
        @yield('breadcrumb')

        <div class="wrapper wrapper-content">

            {{--Place for yielding main content--}}
            @yield('content')

        </div>
        <div class="footer">
            <div class="float-right">
{{--                <a href="#"><strong>DevDimensions</strong></a>--}}
            </div>
            <div>
                <strong>Copyright</strong> CDIS &copy; 2014-{{date('Y')}}
            </div>
        </div>
    </div>
</div>

{{--Including Footer--}}
@include('layouts.partials.footer')
