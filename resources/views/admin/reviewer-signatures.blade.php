@extends('layouts.app')
@section('title', 'Manage Signatures | CDIS - Dashboard')
@push('css')
    <link rel="stylesheet" href="{{asset('js/plugins/signature-pad/jquery.signaturepad.css')}}">
    <link rel="stylesheet" href="{{asset('css/plugins/toastr/toastr.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css"/>
    <style>
        .old-signature-heading {
            border-bottom: 2px solid #ccc;
            max-width: 300px;
            color: #000;
            font: italic normal 1em/1.375 Georgia, Times, serif;
        }

        .old-signature-pad {
            margin-top: 35px;
            width: 300px;
            height: 150px;
            overflow: hidden;
        }
    </style>
@endpush
@section('breadcrumb')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10 pt-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('dashboard')}}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a>Settings</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Manage Signatures</strong>
                </li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-9 mx-auto">
            <div class="ibox pb-2">
                <div class="ibox-title pr-3">
                    <div class="row">
                        <div class="col-md-3 align-self-center">
                            <h3>Manage Signatures</h3>
                        </div>
                        <div class="col-md-9">
                            <p class="mb-0">
                                Below are two options for adding a signature image to CDIS.
                            </p>
                            <p class="mb-0">
                                First, select a technician from the dropdown and then choose to Upload or Draw.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <form method="post" action="" id="form-update-signature">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3 align-self-end">
                                            <label for="technician">
                                                Technician
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <p class="mb-0" style="font-size: 10px">
                                                Drawing is recommended with touch screen (phone or larger device) and
                                                stylus.
                                            </p>
                                            <p class="mb-0" style="font-size: 10px">
                                                Uploading requires minor scanning and cropping capability.
                                            </p>
                                            <p class="mb-0" style="font-size: 10px">
                                                You may also <span class="text-dark">email your scanned image to: <a
                                                        href="mailto:support@realtech.net">support@realtechs.net</a> for assistance.</span>
                                            </p>
                                        </div>
                                    </div>
                                    <select class="form-control" name="reviewer_id" id="technician" required>
                                        <option value="">Select One</option>
                                        @if(isset($reviewers))
                                            @foreach($reviewers as $reviewer)
                                                @if(($project->projectDetails->reviewer->name ?? '') === $reviewer->name)

                                                    <option value="{{$reviewer->id}}"
                                                            selected>{{$reviewer->name}}</option>
                                                @else
                                                    <option value="{{$reviewer->id}}">{{$reviewer->name}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 ">
                                <p class="old-signature-heading">
                                    Your signature will appear below once uploaded.
                                </p>
                                <div class="bg-muted old-signature-pad " style="border: 1px solid #777;">
                                    <img src="{{asset('img/sig-placeholder.png')}}" id="img-old-signature"
                                         class="img-fluid"
                                         alt="old signature image">
                                </div>
                            </div>
                            <div class="col-md-6 ml-auto text-right">
                                <div class="sigPad ml-auto" style="width: 301px">
                                    <p class="drawItDesc">Draw your signature in the box below</p>
                                    <ul class="sigNav">
                                        <li class="clearButton"><a href="#clear">Clear</a></li>
                                    </ul>
                                    <div class="sig sigWrapper"
                                         style="width: 302px; height: 152px; border-color: #777;">
                                        <div class="typed"></div>
                                        <canvas class="pad" id="sig-canvas" width="300" height="150"></canvas>
                                        <input type="hidden" name="signature" id="signature">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                                            <button id="btn-open-sig-modal" class="btn btn-primary btn-block" data-toggle="modal">
                                                                Upload Signature Image
                                                            </button>
                                                            <input type="file" name="upload_image" id="upload_image" accept="image/*" style="display: none"/>
                            </div>
                            <div class="col-md-4 ml-auto">
                                <button class="btn btn-block btn-primary " id="btn-update-signature" type="submit">
                                    Update Drawn Signature
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{--    <div class="modal show" id="modal-upload-signature" tabindex="-1" role="dialog" style="z-index: 99991 !important;">--}}
    {{--        <div class="modal-dialog" style="max-width: 800px;">--}}
    {{--            <div class="modal-content animated fadeIn">--}}
    {{--                <div class="modal-header bg-primary">--}}
    {{--                    <h4 class="modal-title text-white">Upload a signature file</h4>--}}
    {{--                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>--}}
    {{--                </div>--}}
    {{--                <div class="modal-body pb-0">--}}
    {{--                    <div class="row">--}}
    {{--                        <div class="col-12">--}}
    {{--                            <form action="" method="post" id="form-upload-signature" enctype="multipart/form-data">--}}
    {{--                                <input type="hidden" name="_token" value="{{csrf_token()}}">--}}
    {{--                                <div class="row">--}}
    {{--                                    <div class="col-md-7">--}}
    {{--                                        <div class="form-group">--}}
    {{--                                            <input type="file" class="form-control" name="file" id="file" accept="image/jpeg, image/png, image/jpg">--}}
    {{--                                            <small>Image must be in PNG, JPEG format and (300 X 150) in dimensions. </small>--}}
    {{--                                        </div>--}}
    {{--                                    </div>--}}
    {{--                                    <div class="col-md-5">--}}
    {{--                                        <button class="btn btn-block btn-primary" id="btn-upload-sig"--}}
    {{--                                                type="submit">--}}
    {{--                                            <strong>Upload</strong>--}}
    {{--                                        </button>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                            </form>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <div class="modal-footer ">--}}
    {{--                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    <form id="uploadimageModal" class="modal" role="dialog" onsubmit="event.preventDefault()">
        @csrf
        <div class="modal-dialog" style="max-width: 570px;">
            <div class="modal-content animated fadeIn">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title text-white">Crop &amp; Upload Signature</h4>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body text-center">
                    <div id="image_demo" style="width:350px; margin-top:30px"></div>
                    <input type="hidden" name="signature" id="usignature">
                    <input type="hidden" name="reviewer_id" id="ureviewer_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-success crop_image" id="crop-and-upload">Crop & Upload Image</button>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('js')

    <script src="{{asset('js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/plugins/signature-pad/jquery.signaturepad.js')}}"></script>
    <script src="{{asset('js/plugins/toastr/toastr.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
    <script>
        $(function () {

            var sigPad = $('.sigPad').signaturePad({
                onDraw: function () {

                    var dataURL = $('#sig-canvas')[0].toDataURL('image/png');

                    $('#signature').val(dataURL);
                }
            });

            //clear canvaus output values
            $('body').on('click', '.clearButton a', function (e) {
                e.preventDefault();
                $('#signature').val('');
            });


            $('#technician').on('change', function () {

                var technician_id = $(this).val();


                //if users select back to select one
                if (technician_id === '') {

                    $('#img-old-signature').attr('src', '/img/sig-placeholder.png');
                    return;
                }

                //update form action based on selected user
                var update_url = '/reviewers/' + technician_id + '/update';
                $('#form-update-signature').attr('action', update_url);

                //clear the canvas
                $('#signature').val('');
                sigPad.clearCanvas();

                $.get('/reviewers/ ' + technician_id + '/show', function (response) {

                    if (response.path.includes('.png') || response.path.includes('.jpeg') || response.path.includes('.jpg')) {

                        $('#img-old-signature').attr('src', response.path);

                    } else {

                        $('#img-old-signature').attr('src', '/img/sig-placeholder.png');
                    }
                });
            });


            $('#btn-open-sig-modal').on('click', function (e) {
                e.preventDefault();

                if ($('#technician').val() !== '') {

                    var reviewer_id = $('#technician').val();

                    // var url = '/reviewers/' + reviewer_id + '/upload';
                    var url = '/reviewers/' + reviewer_id + '/update';

                    $('#crop-and-upload').attr('data-action-url', url);
                    $('#ureviewer_id').val(reviewer_id);
                    // $('#form-upload-signature').attr('action', url);

                    // $('#modal-upload-signature').modal('show');
                    document.getElementById('upload_image').click()

                } else {

                    alert('please select a technician');
                }
            });


            //upload signature through image
            $('#form-upload-signature').submit(function (e) {
                e.preventDefault();

                var form = $(this);

                var btn = form.find('#btn-upload-sig');

                var formData = new FormData(form[0]);

                showSpiner(btn);

                $.ajax({
                    url: form.attr('action'),
                    type: 'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function (response) {

                        if (!response.error) {

                            $('#img-old-signature').attr('src', response.path);

                            notify(response.title, response.message);
                        }
                    },
                    complete: function () {
                        $('#modal-upload-signature').modal('hide');
                        hideSpinner(btn, 'Upload');
                    }
                });
            });


            //upload drawn signatures
            $('#form-update-signature').submit(function (e) {
                e.preventDefault();

                var form = $(this);

                if (form.find('.error').length > 0) {
                    return;
                }

                var btn = form.find('#btn-update-signature');

                showSpiner(btn);

                $.ajax({
                    url: form.attr('action'),
                    type: 'post',
                    cache: false,
                    data: form.serialize(),
                    dataType: "json",
                    success: function (response) {

                        if (!response.error) {

                            $('#img-old-signature').attr('src', response.path);

                            //clear the canvas
                            $('#signature').val('');
                            sigPad.clearCanvas();

                            notify(response.title, response.message);

                        }
                    },
                    complete: function () {

                        hideSpinner(btn, 'Update Signature');
                    }
                });
            });


            $image_crop = $('#image_demo').croppie({
                enableExif: true,
                viewport: {
                    width: 300,
                    height: 150,
                    type: 'square' //circle
                },
                boundary: {
                    width: 512,
                    height: 400
                }
            });

            $('#upload_image').on('change', function () {
                var reader = new FileReader();
                reader.onload = function (event) {
                    $image_crop.croppie('bind', {
                        url: event.target.result
                    }).then(function () {
                        console.log('jQuery bind complete');
                    });
                }
                reader.readAsDataURL(this.files[0]);
                $('#uploadimageModal').modal('show');
            });

            $('.crop_image').click(function (event) {
                event.preventDefault();
                $image_crop.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function (resp) {
                    $('#usignature').val(resp);

                    $.ajax({
                        url: $('#crop-and-upload').attr('data-action-url'),
                        type: 'post',
                        cache: false,
                        data: $('#uploadimageModal').serialize(),
                        dataType: "json",
                        success: function (response) {
                            $('#uploadimageModal').modal('hide');
                            if (!response.error) {
                                $('#upload_image').val('');
                                document.getElementById("uploadimageModal").reset();
                                $('#img-old-signature').attr('src', response.path);

                                //clear the canvas
                                $('#usignature').val('');
                                // sigPad.clearCanvas();

                                notify(response.title, response.message);

                            }
                        },
                        complete: function () {

                            // hideSpinner(btn, 'Update Signature');
                        }
                    });
                })
            });

        });
    </script>
@endpush
