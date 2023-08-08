<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/cdis.css')}}" rel="stylesheet">
    <link href="{{ asset('css/style.css')}}" rel="stylesheet">
</head>
<body>
<div class="modal show" id="modal-view-time-record" tabindex="-1" role="dialog" style="display: block; padding-right: 15px;">
    <div class="modal-dialog" style="min-width: 700px;">
        <div class="modal-content animated fadeIn">
            <form action="http://cdis.test/projects/time/store" method="post" id="form-view-time-record">
                <input type="hidden" name="_token" value="hfEGvPboKmB2q1encHThIpAWH9Kd60ZLVFekokm9">
                <input type="hidden" name="project_id" class="project-id" value="8251847">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title text-white">Time Recorded for Project: <span id="project-name">DD TEST PROJECT HIS IS TEST @TEST</span></h4>
                    <button type="button" class="close text-white" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body"><div class="row">
                        <div class="col-md-12">
                            <h3>Time Recorded for: N</h3>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="text-center bg-primary">Technician</th>
                                    <th class="text-center bg-primary">Date</th>
                                    <th class="text-center bg-primary">Hours</th>
                                    <th class="bg-primary">Time Category</th>
                                    <th class="text-center bg-primary">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Jessica Buck</td>
                                    <td>02/06/2020</td>
                                    <td class="text-center hrs new-hrs">3.5</td>
                                    <td>Pre-Construction Meeting</td>
                                    <td class="text-center project-details">
                                        <a href="#" class="text-navy btn-edit-time" data-id="18773" style="font-size: 1.3em;" data-toggle="tooltip" data-original-title="Edit Fee Info"><i class="fa fa-edit"></i></a>
                                        <a href="#" class="text-danger btn-delete-time" data-id="18773" style="font-size: 1.4em;" data-toggle="tooltip" data-original-title="Delete Review Info"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr><tr>
                                    <td>Jessica Buck</td>
                                    <td>02/06/2020</td>
                                    <td class="text-center hrs new-hrs">3.5</td>
                                    <td>Right To Know Database Search</td>
                                    <td class="text-center project-details">
                                        <a href="#" class="text-navy btn-edit-time" data-id="18774" style="font-size: 1.3em;" data-toggle="tooltip" data-original-title="Edit Fee Info"><i class="fa fa-edit"></i></a>
                                        <a href="#" class="text-danger btn-delete-time" data-id="18774" style="font-size: 1.4em;" data-toggle="tooltip" data-original-title="Delete Review Info"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr><tr>
                                    <td>Jessica Buck</td>
                                    <td>02/06/2020</td>
                                    <td class="text-center hrs new-hrs">55</td>
                                    <td>Plan Review Meeting</td>
                                    <td class="text-center project-details">
                                        <a href="#" class="text-navy btn-edit-time" data-id="18781" style="font-size: 1.3em;" data-toggle="tooltip" data-original-title="Edit Fee Info"><i class="fa fa-edit"></i></a>
                                        <a href="#" class="text-danger btn-delete-time" data-id="18781" style="font-size: 1.4em;" data-toggle="tooltip" data-original-title="Delete Review Info"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <h4>Total Time for N = <span id="total-new-hrs">62</span> hours</h4>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <hr class="hr-line-dashed mb-2">
                        </div>
                        <div class="col-md-12">
                            <h3>Time Recorded for: R</h3>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="text-center bg-primary">Technician</th>
                                    <th class="text-center bg-primary">Date</th>
                                    <th class="text-center bg-primary">Hours</th>
                                    <th class="bg-primary">Time Category</th>
                                    <th class="text-center bg-primary">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Jessica Buck</td>
                                    <td>02/06/2020</td>
                                    <td class="text-center hrs resubmit-hrs">3.5</td>
                                    <td>Pre-Construction Meeting</td>
                                    <td class="text-center project-details">
                                        <a href="#" class="text-navy btn-edit-time" data-id="18776" style="font-size: 1.3em;" data-toggle="tooltip" data-original-title="Edit Fee Info"><i class="fa fa-edit"></i></a>
                                        <a href="#" class="text-danger btn-delete-time" data-id="18776" style="font-size: 1.4em;" data-toggle="tooltip" data-original-title="Delete Review Info"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr><tr>
                                    <td>Jessica Buck</td>
                                    <td>02/06/2020</td>
                                    <td class="text-center hrs resubmit-hrs">3.5</td>
                                    <td>Pre-Construction Meeting</td>
                                    <td class="text-center project-details">
                                        <a href="#" class="text-navy btn-edit-time" data-id="18777" style="font-size: 1.3em;" data-toggle="tooltip" data-original-title="Edit Fee Info"><i class="fa fa-edit"></i></a>
                                        <a href="#" class="text-danger btn-delete-time" data-id="18777" style="font-size: 1.4em;" data-toggle="tooltip" data-original-title="Delete Review Info"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr><tr>
                                    <td>Jessica Buck</td>
                                    <td>02/06/2020</td>
                                    <td class="text-center hrs resubmit-hrs">33</td>
                                    <td>Complaint Investigation</td>
                                    <td class="text-center project-details">
                                        <a href="#" class="text-navy btn-edit-time" data-id="18778" style="font-size: 1.3em;" data-toggle="tooltip" data-original-title="Edit Fee Info"><i class="fa fa-edit"></i></a>
                                        <a href="#" class="text-danger btn-delete-time" data-id="18778" style="font-size: 1.4em;" data-toggle="tooltip" data-original-title="Delete Review Info"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr><tr>
                                    <td>Jessica Buck</td>
                                    <td>02/06/2020</td>
                                    <td class="text-center hrs resubmit-hrs">33.5</td>
                                    <td>N.O.T. - Data Entry</td>
                                    <td class="text-center project-details">
                                        <a href="#" class="text-navy btn-edit-time" data-id="18785" style="font-size: 1.3em;" data-toggle="tooltip" data-original-title="Edit Fee Info"><i class="fa fa-edit"></i></a>
                                        <a href="#" class="text-danger btn-delete-time" data-id="18785" style="font-size: 1.4em;" data-toggle="tooltip" data-original-title="Delete Review Info"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <h4>Total Time for R = <span id="total-resubmit-hrs">73.5</span> hours</h4>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <hr class="hr-line-dashed">
                            <h4 class="text-center">Grand Total Time: <span id="total-hrs">135.5</span></h4>
                            <hr class="hr-line-dashed">
                        </div>
                    </div></div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-warning " id="btn-export-excel">Export Excel</button>
                    <button type="button" class="btn btn-danger " id="btn-export-pdf">Export PDF</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
