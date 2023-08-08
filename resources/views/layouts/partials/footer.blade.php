<div class="modal  show" id="modal-timer-logout" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-body" style="background: #f8ac59; min-width: 700px;">
                <div class="timer">
                    <h1 id="head">You will be logged out after</h1>
                    <ul class="pl-0">
                        <li><span id="minutes">10</span>Minutes</li>
                        <li><span id="seconds">04</span>Seconds</li>
                    </ul>
                </div>
                <div class="row text-center">
                    <div class="col-md-4 offset-4">
                        <a href="#" class="btn btn-warning" id="btn-rest-timer" style="background: #cc7f2b;">Rest
                            Timer</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Mainly scripts -->
<script src="{{asset('js/jquery-3.1.1.min.js')}}"></script>
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="{{asset('js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
<script src="{{asset('js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('js/plugins/select2/select2.full.min.js')}}"></script>


<script src=""></script>
<script src="{{asset('js/plugins/moment/moment.js')}}"></script>
<script src="{{asset('js/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Custom and plugin javascript -->
<script src="{{asset('js/inspinia.js')}}"></script>

{{--only load if user is authenticated--}}
{{--Means don't load it on login page--}}
@auth()
    <script src="{{asset('js/cdis.js')}}"></script>
@endauth

<script src="{{asset('js/plugins/pace/pace.min.js')}}"></script>

<!-- jQuery UI -->
{{--<script src="{{asset('js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>--}}


@stack('js')

<script type="text/javascript">

    $('.date-range-picker').daterangepicker({

        opens: 'left'

    }, function (start, end, label) {

        $('#from').val(start.format('YYYY-MM-DD'));
        $('#to').val(end.format('YYYY-MM-DD'));
    });
</script>
</body>
</html>
