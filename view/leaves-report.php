<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 5 Admin &amp; Dashboard Template">
    <meta name="author" content="Bootlab">

    <link rel="canonical" href="https://appstack.bootlab.io/pages-clients.html" />
    <link rel="shortcut icon" href="img/favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="css/light.css" rel="stylesheet">

</head>


<body data-theme="colored" data-layout="fluid" data-sidebar-position="left" data-sidebar-behavior="sticky">
<div class="wrapper">
    <?php
    include_once "sidebar.php";
    include "../model/attendance_model.php";
    $attendanceObj=new Attendance();
    $attendanceResult=$attendanceObj->getAllAttendance();
    include "../model/employee_model.php";
    $employeeObj=new Employee();

    include "../model/holiday-leave-model.php";
    $holidayObj=new HolidayLeave();
    ?>
    <div class="main">
        <?php
        include_once "topbar.php";
        ?>
        <main class="content">
            <div class="container-fluid p-0">

                <!-- <h1 class="h3 mb-3">Leaves</h1> -->
                <div class="row mb-2 mb-xl-3">
                    <div class="col-auto d-none d-sm-block">
                        <h3>Leaves</h3>
                    </div>

                    <div class="col-auto ms-auto text-end mt-n1">
                        <div class="dropdown me-2 d-inline-block position-relative">
                            <a class="btn mb-2 btn-primary" style="padding: 5px 15px;" href="add-admin-leave.php">+ Add Leave</a>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-xl-12">
                        <div class="row">
                            <?php
                            //        check if msg is available
                            if(isset($_GET['msg'])){

                                ?>
                                <div class="col-md-12">
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        <div class="alert-message">
                                            <strong>Hello there!</strong>  <?php
                                            $msg=$_REQUEST['msg'];
                                            $msg=base64_decode($msg);
                                            echo $msg;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }

                            ?>

                            <div class="col-md-12"><div id="alertDiv"></div> </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <div class="card-actions float-end">
                                    <div class="dropdown position-relative">
                                        <a href="#" data-bs-toggle="dropdown" data-bs-display="static">
                                            <i class="align-middle" data-feather="more-horizontal"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="card-title mb-0">Leaves Report</h5>

                            </div>
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-3">
                                        <p>User :</p>
                                        <select class="form-control mb-3" id="user_id">
                                            <option value="0" selected>Select a user</option>
                                            <?php
                                            include "../model/user_modal.php";

                                            $UserObj=new User();
                                            $UserResult=$UserObj->getAllUsers();
                                            while ($user_row=$UserResult->fetch_assoc()) {
                                            ?>
                                            <!--value is similar to ID attribute-->
                                            <option value="<?php echo $user_row["user_id"];?>">

                                                <?php echo $user_row["user_fname"].' '.$user_row["user_lname"];
                                                }
                                                ?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <p>From :</p>
                                        <input type="date" value="01-06-2017" max="<?php echo date("Y-m-d") ?>" class="form-control" name="startDate" id="startDate">

                                    </div>
                                    <div class="col-4">
                                        <p>To :</p>
                                        <input type="date" value="01-06-2017" max="<?php echo date("Y-m-d") ?>" class="form-control" name="endDate" id="endDate">

                                    </div>
                                    <div class="col-1">
                                        <div style="padding-top: 35px">
                                            <button class="btn btn-primary shadow-sm" onclick="loadData()">
                                                <i class="align-middle" data-feather="filter">&nbsp;</i>
                                            </button>&nbsp
                                            <button class="btn btn-primary shadow-sm" onclick="window.location.reload();">
                                                <i class="align-middle" data-feather="refresh-cw">&nbsp;</i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div style="padding-top: 20px">
                                    <button class="btn btn-primary shadow-sm" id="showUpcoming">Upcoming</button>&nbsp;
                                    <button class="btn btn-secondary shadow-sm" id="showHistory">History</button>
                                </div>
                            </div>
                            <div class="card-body">

                                <table class="table table-responsive my-0" id="leaves-table">
                                    <thead>
                                    <tr>
                                        <th class="d-none d-xl-table-cell">User</th>
                                        <th class="d-none d-xl-table-cell">Date</th>
                                        <th>Leave type</th>
                                        <th class="d-none d-xl-table-cell">Reason</th>
                                        <th></th>
                                        <th></th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    $leaveResult=$holidayObj->getAllLeaves();

                                    while ($leaveRow=$leaveResult->fetch_assoc()){

                                        ?>
                                        <tr>
                                            <td class="d-none d-xl-table-cell">
                                                <div class="text-muted">
                                                    <?php
                                                    echo $leaveRow['user_fname'].' '.$leaveRow['user_lname'];
                                                    ?>
                                                </div>
                                            </td>
                                            <td class="d-none d-xl-table-cell">
                                                <div class="text-muted">
                                                    <?php
                                                    echo $date=$leaveRow['date'];
                                                    ?>
                                                </div>
                                            </td>
                                            <td>
                                                <?php
                                                if($leaveRow["leave_type"]==1){
                                                    echo 'Annual leave';
                                                }else if($leaveRow["leave_type"]==2){
                                                    echo 'Casual leave';

                                                }else if($leaveRow["leave_type"]==3){
                                                    echo 'Sick leave';
                                                }else{
                                                    echo 'Compensatory Leave';
                                                }
                                                ?>
                                            </td>
                                            <td><?php
                                                echo $leaveRow['reason'];
                                                ?>
                                            </td>
                                            <td>
                                               <?php
                                                if ($leaveRow['full_half_day']==1){
                                                    echo 'Full day';
                                                }
                                                else{
                                                    echo 'Half day';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($leaveRow['first_second']==1){
                                                    echo 'First half';
                                                }
                                                else if($leaveRow['first_second']==2){
                                                    echo 'Second half';
                                                }else{
                                                    echo '';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php

                                                if($leaveRow['leave_status']==1){
                                                    ?>
                                                    <span class="badge status bg-success"> Request Approved </span>

                                                    <?php
                                                }else if($leaveRow['leave_status']==2){
                                                    ?>
                                                    <span class="badge status bg-danger"> Request Declined </span>

                                                    <?php
                                                }
                                                else{
                                                    ?>
                                                    <span class="badge status text-bg-warning"> Request Pending </span>

                                                    <?php
                                                }
                                                ?>
                                            </td>

                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    </tbody>
                                </table>
                                <div id="show-filtered-table">

                                </div>


                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </main>
        <?Php
        include "footer.php";
        ?>
    </div>
</div>

<script src="js/app.js"></script>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Datatables clients
        $("#leaves-table").DataTable({
            responsive: true,
            order: [
                [1, "asc"]
            ],
            dom: 'Bfrtip',
            title: 'Attendance report',

            buttons: [
                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    download: 'open',
                    exportOptions: {
                        columns: [ 0, ':visible' ]
                    },
                    title: 'Attendance Report : ' + new Date().toDateString(),
                    filename: 'Attendance Report : ' + new Date().toDateString(),


                    customize: function ( doc ) {
                        doc.content[1].alignment = 'center';
                        doc.content[1].margin = [ 20, 0, 20, 0 ] //left, top, right, bottom

                        var cols = [];
                        cols[0] = {image: 'data:image/png;base64,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giZCvbXX1j9pAFxuwNcNRAhdxgChGN6X2btklponJLlRGx8jeNBs4b3odXcjee9BdRfwhA0NAi+oKl6VwcHBoHpVRPUZYxxVfVzhmclSCd66Xcn2jFmKTetr7BHT+o32TsmAnDTLyNZ13tb8lVDUbjRFX2tj0rB3DOwGHrPfa2x+E3BDI1NLIk0ScA6vOhaLpPfaNWOW2BLH1PQ07atXY9oNJi5SiJ2bmC6XMQu6geBiKYhFEz4bd2qEbNxmfKYF74iBlXXbdjvvKKHJP9/2r5iFPUHoWhzBCocJRW4bwdvSvQuEON3OnOu30NBZLLlJ7d2wgai5GfV+h4g8YAceV9VPisiLzjkQoTo9TZzLoaq3iMgu09YxVb1DVZ8+ODLiCJX3qgwPU8bYFAsD9gUNyj1mytjAfE85QXCnc03oxj1TgMYX2XuU4J4dGT5SZcy2cku3NMD6yr3AA4Q26jwR+QaqX/PevwkQ5/Oo930i8nUDbIJwKzHpnMM55733S/0CUyUTgBto6DTjo8xPMik13pWdbu8iIY6dlhZNBFnqaG0ljmNUdQzYLSLXEoL3ZYhsIwTj9cB2EbmX4CYAP/JJ8pV8S8vR0sQE67u6OHnq1FKPfU/Ski3t8LFj9PX0pP7QQjDhNPh+jBCcKwTzzrr9pIvj6szUFE253ErL+x+hJVsawKmJCda2t4NqnZCqHxaR44SCNWLu/uw48APgWVT/BhQQ4eCRI//1VgbLsLQsqUjdiTxq5cVeEfkEsAfV3yFyj8JrV23d+v1/7NtHel0kblnVzXualv2Nd2DjRgC8zL4aI7IFGBORE6p6ASAuio742txFbOEs+vr+tj+MXzwwQLViHUj6wcXu4xSI45h6tXpWgZXSO/rfBAP2cRmR8JgLppeZBwqFlZbvXaF/AfBCeZNa5f0cAAAAtGVYSWZJSSoACAAAAAYAEgEDAAEAAAABAAAAGgEFAAEAAABWAAAAGwEFAAEAAABeAAAAKAEDAAEAAAACAAAAEwIDAAEAAAABAAAAaYcEAAEAAABmAAAAAAAAAEgAAAABAAAASAAAAAEAAAAGAACQBwAEAAAAMDIxMAGRBwAEAAAAAQIDAACgBwAEAAAAMDEwMAGgAwABAAAA//8AAAKgBAABAAAANAEAAAOgBAABAAAAfgAAAAAAAACom/WPAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDI0LTAyLTAxVDA4OjI0OjQ3KzAwOjAwwIiYMAAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyNC0wMi0wMVQwODoyNDo0NyswMDowMLHVIIwAAAAodEVYdGRhdGU6dGltZXN0YW1wADIwMjQtMDItMDFUMDg6MjQ6NTgrMDA6MDDcInEkAAAAFXRFWHRleGlmOkNvbG9yU3BhY2UANjU1MzUzewBuAAAAIHRFWHRleGlmOkNvbXBvbmVudHNDb25maWd1cmF0aW9uAC4uLmryoWQAAAATdEVYdGV4aWY6RXhpZk9mZnNldAAxMDJzQimnAAAAFXRFWHRleGlmOkV4aWZWZXJzaW9uADAyMTC4dlZ4AAAAGXRFWHRleGlmOkZsYXNoUGl4VmVyc2lvbgAwMTAwEtQorAAAABh0RVh0ZXhpZjpQaXhlbFhEaW1lbnNpb24AMzA4S20cMQAAABh0RVh0ZXhpZjpQaXhlbFlEaW1lbnNpb24AMTI2AGhmrAAAABd0RVh0ZXhpZjpZQ2JDclBvc2l0aW9uaW5nADGsD4BjAAAAAElFTkSuQmCC'
                            , alignment: 'left', margin:[30] };
                        cols[1] = {text: 'Attendance Report', alignment: 'right', margin:[0,0,20] };
                        var objHeader = {};
                        objHeader['columns'] = cols;
                        doc['footer']=objHeader;


                    }
                },
                {
                    extend: 'spacer',
                    style: 'empty',
                },
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    autoFilter: true,
                    download: 'open',
                    exportOptions: {
                        columns: [ 0, ':visible' ]
                    },
                    title: 'Attendance Report : ' + new Date().toDateString(),
                    filename: 'Attendance Report : ' + new Date().toDateString(),



                },
                {
                    extend: 'spacer',
                    style: 'empty',
                },
                'colvis'

            ]

        });

    });

    loadData= function () {

        var user_id = $('#user_id').find(":selected").val();
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();

        if((startDate || endDate ) == "")//leaves applied by a particular employee
        {
            var url = "../controller/holiday_leave_controller.php?status=load_leave_report";

            $.post(url, {user_id: user_id}, function (data) {
                /*show the data that is being responded by server in the div id myfunctions*/
                $('#leaves-table').parents('div.dataTables_wrapper').first().hide();

                $("#show-filtered-table").html(data).show();
                $("#load_data").DataTable({
                    responsive: true,
                    order: [
                        [1, "asc"]
                    ],
                    dom: 'Bfrtip',

                    buttons: [
                        {
                            extend: 'pdfHtml5',
                            text: 'PDF',
                            title: 'Leave Report : ' + new Date().toDateString(),
                            download: 'open',
                            exportOptions: {
                                columns: [ 0, ':visible' ]
                            },
                            filename: 'Leave Report : ' + new Date().toDateString(),



                            customize: function ( doc ) {

                                var cols = [];
                                cols[0] = {image: 'data:image/png;base64,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giZCvbXX1j9pAFxuwNcNRAhdxgChGN6X2btklponJLlRGx8jeNBs4b3odXcjee9BdRfwhA0NAi+oKl6VwcHBoHpVRPUZYxxVfVzhmclSCd66Xcn2jFmKTetr7BHT+o32TsmAnDTLyNZ13tb8lVDUbjRFX2tj0rB3DOwGHrPfa2x+E3BDI1NLIk0ScA6vOhaLpPfaNWOW2BLH1PQ07atXY9oNJi5SiJ2bmC6XMQu6geBiKYhFEz4bd2qEbNxmfKYF74iBlXXbdjvvKKHJP9/2r5iFPUHoWhzBCocJRW4bwdvSvQuEON3OnOu30NBZLLlJ7d2wgai5GfV+h4g8YAceV9VPisiLzjkQoTo9TZzLoaq3iMgu09YxVb1DVZ8+ODLiCJX3qgwPU8bYFAsD9gUNyj1mytjAfE85QXCnc03oxj1TgMYX2XuU4J4dGT5SZcy2cku3NMD6yr3AA4Q26jwR+QaqX/PevwkQ5/Oo930i8nUDbIJwKzHpnMM55733S/0CUyUTgBto6DTjo8xPMik13pWdbu8iIY6dlhZNBFnqaG0ljmNUdQzYLSLXEoL3ZYhsIwTj9cB2EbmX4CYAP/JJ8pV8S8vR0sQE67u6OHnq1FKPfU/Ski3t8LFj9PX0pP7QQjDhNPh+jBCcKwTzzrr9pIvj6szUFE253ErL+x+hJVsawKmJCda2t4NqnZCqHxaR44SCNWLu/uw48APgWVT/BhQQ4eCRI//1VgbLsLQsqUjdiTxq5cVeEfkEsAfV3yFyj8JrV23d+v1/7NtHel0kblnVzXualv2Nd2DjRgC8zL4aI7IFGBORE6p6ASAuio742txFbOEs+vr+tj+MXzwwQLViHUj6wcXu4xSI45h6tXpWgZXSO/rfBAP2cRmR8JgLppeZBwqFlZbvXaF/AfBCeZNa5f0cAAAAtGVYSWZJSSoACAAAAAYAEgEDAAEAAAABAAAAGgEFAAEAAABWAAAAGwEFAAEAAABeAAAAKAEDAAEAAAACAAAAEwIDAAEAAAABAAAAaYcEAAEAAABmAAAAAAAAAEgAAAABAAAASAAAAAEAAAAGAACQBwAEAAAAMDIxMAGRBwAEAAAAAQIDAACgBwAEAAAAMDEwMAGgAwABAAAA//8AAAKgBAABAAAANAEAAAOgBAABAAAAfgAAAAAAAACom/WPAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDI0LTAyLTAxVDA4OjI0OjQ3KzAwOjAwwIiYMAAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyNC0wMi0wMVQwODoyNDo0NyswMDowMLHVIIwAAAAodEVYdGRhdGU6dGltZXN0YW1wADIwMjQtMDItMDFUMDg6MjQ6NTgrMDA6MDDcInEkAAAAFXRFWHRleGlmOkNvbG9yU3BhY2UANjU1MzUzewBuAAAAIHRFWHRleGlmOkNvbXBvbmVudHNDb25maWd1cmF0aW9uAC4uLmryoWQAAAATdEVYdGV4aWY6RXhpZk9mZnNldAAxMDJzQimnAAAAFXRFWHRleGlmOkV4aWZWZXJzaW9uADAyMTC4dlZ4AAAAGXRFWHRleGlmOkZsYXNoUGl4VmVyc2lvbgAwMTAwEtQorAAAABh0RVh0ZXhpZjpQaXhlbFhEaW1lbnNpb24AMzA4S20cMQAAABh0RVh0ZXhpZjpQaXhlbFlEaW1lbnNpb24AMTI2AGhmrAAAABd0RVh0ZXhpZjpZQ2JDclBvc2l0aW9uaW5nADGsD4BjAAAAAElFTkSuQmCC'
                                    , alignment: 'left', margin:[30] };
                                cols[1] = {text: 'Leave Report', alignment: 'right', margin:[0,0,20] };
                                var objHeader = {};
                                objHeader['columns'] = cols;
                                doc['footer']=objHeader;


                            }
                        },
                        {
                            extend: 'spacer',
                            style: 'empty',
                        },
                        {
                            extend: 'excelHtml5',
                            text: 'Excel',
                            title: 'Leave Report : ' + new Date().toDateString(),
                            autoFilter: true,
                            download: 'open',
                            exportOptions: {
                                columns: [ 0, ':visible' ]
                            },
                            filename: 'Leave Report : ' + new Date().toDateString(),




                        },
                        {
                            extend: 'spacer',
                            style: 'empty',
                        },
                        'colvis'

                    ]

                });


            });
        }

        else {

            if(user_id == 0){ //leaves applied by employees during a time period
                var url2 = "../controller/holiday_leave_controller.php?status=load_leave_report_date_range";

                $.post(url2, {user_id: user_id, startDate: startDate, endDate: endDate}, function (data) {
                    /*show the data that is being responded by server in the div id myfunctions*/
                    $('#leaves-table').parents('div.dataTables_wrapper').first().hide();
                    $("#show-filtered-table").html(data).show();
                    $("#load_data").DataTable({
                        responsive: true,
                        order: [
                            [1, "asc"]
                        ],
                        dom: 'Bfrtip',
                        title: 'Leave report',

                        buttons: [
                            {
                                extend: 'pdfHtml5',
                                text: 'PDF',
                                title: 'Leave Report : ' + new Date().toDateString(),
                                download: 'open',
                                exportOptions: {
                                    columns: [0, ':visible']
                                },
                                filename: 'Leave Report : ' + new Date().toDateString(),


                                customize: function (doc) {

                                    var cols = [];
                                    cols[0] = {
                                        image: 'data:image/png;base64,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giZCvbXX1j9pAFxuwNcNRAhdxgChGN6X2btklponJLlRGx8jeNBs4b3odXcjee9BdRfwhA0NAi+oKl6VwcHBoHpVRPUZYxxVfVzhmclSCd66Xcn2jFmKTetr7BHT+o32TsmAnDTLyNZ13tb8lVDUbjRFX2tj0rB3DOwGHrPfa2x+E3BDI1NLIk0ScA6vOhaLpPfaNWOW2BLH1PQ07atXY9oNJi5SiJ2bmC6XMQu6geBiKYhFEz4bd2qEbNxmfKYF74iBlXXbdjvvKKHJP9/2r5iFPUHoWhzBCocJRW4bwdvSvQuEON3OnOu30NBZLLlJ7d2wgai5GfV+h4g8YAceV9VPisiLzjkQoTo9TZzLoaq3iMgu09YxVb1DVZ8+ODLiCJX3qgwPU8bYFAsD9gUNyj1mytjAfE85QXCnc03oxj1TgMYX2XuU4J4dGT5SZcy2cku3NMD6yr3AA4Q26jwR+QaqX/PevwkQ5/Oo930i8nUDbIJwKzHpnMM55733S/0CUyUTgBto6DTjo8xPMik13pWdbu8iIY6dlhZNBFnqaG0ljmNUdQzYLSLXEoL3ZYhsIwTj9cB2EbmX4CYAP/JJ8pV8S8vR0sQE67u6OHnq1FKPfU/Ski3t8LFj9PX0pP7QQjDhNPh+jBCcKwTzzrr9pIvj6szUFE253ErL+x+hJVsawKmJCda2t4NqnZCqHxaR44SCNWLu/uw48APgWVT/BhQQ4eCRI//1VgbLsLQsqUjdiTxq5cVeEfkEsAfV3yFyj8JrV23d+v1/7NtHel0kblnVzXualv2Nd2DjRgC8zL4aI7IFGBORE6p6ASAuio742txFbOEs+vr+tj+MXzwwQLViHUj6wcXu4xSI45h6tXpWgZXSO/rfBAP2cRmR8JgLppeZBwqFlZbvXaF/AfBCeZNa5f0cAAAAtGVYSWZJSSoACAAAAAYAEgEDAAEAAAABAAAAGgEFAAEAAABWAAAAGwEFAAEAAABeAAAAKAEDAAEAAAACAAAAEwIDAAEAAAABAAAAaYcEAAEAAABmAAAAAAAAAEgAAAABAAAASAAAAAEAAAAGAACQBwAEAAAAMDIxMAGRBwAEAAAAAQIDAACgBwAEAAAAMDEwMAGgAwABAAAA//8AAAKgBAABAAAANAEAAAOgBAABAAAAfgAAAAAAAACom/WPAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDI0LTAyLTAxVDA4OjI0OjQ3KzAwOjAwwIiYMAAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyNC0wMi0wMVQwODoyNDo0NyswMDowMLHVIIwAAAAodEVYdGRhdGU6dGltZXN0YW1wADIwMjQtMDItMDFUMDg6MjQ6NTgrMDA6MDDcInEkAAAAFXRFWHRleGlmOkNvbG9yU3BhY2UANjU1MzUzewBuAAAAIHRFWHRleGlmOkNvbXBvbmVudHNDb25maWd1cmF0aW9uAC4uLmryoWQAAAATdEVYdGV4aWY6RXhpZk9mZnNldAAxMDJzQimnAAAAFXRFWHRleGlmOkV4aWZWZXJzaW9uADAyMTC4dlZ4AAAAGXRFWHRleGlmOkZsYXNoUGl4VmVyc2lvbgAwMTAwEtQorAAAABh0RVh0ZXhpZjpQaXhlbFhEaW1lbnNpb24AMzA4S20cMQAAABh0RVh0ZXhpZjpQaXhlbFlEaW1lbnNpb24AMTI2AGhmrAAAABd0RVh0ZXhpZjpZQ2JDclBvc2l0aW9uaW5nADGsD4BjAAAAAElFTkSuQmCC'
                                        , alignment: 'left', margin: [30]
                                    };
                                    cols[1] = {text: 'Leave Report', alignment: 'right', margin: [0, 0, 20]};
                                    var objHeader = {};
                                    objHeader['columns'] = cols;
                                    doc['footer'] = objHeader;


                                }
                            },
                            {
                                extend: 'spacer',
                                style: 'empty',
                            },
                            {
                                extend: 'excelHtml5',
                                text: 'Excel',
                                title: 'Leave Report : ' + new Date().toDateString(),
                                autoFilter: true,
                                download: 'open',
                                exportOptions: {
                                    columns: [0, ':visible']
                                },
                                filename: 'Leave Report : ' + new Date().toDateString(),


                            },
                            {
                                extend: 'spacer',
                                style: 'empty',
                            },
                            'colvis'

                        ]

                    });
                });

            }else {//leaves applied by a particular employee during a time period
                var url3 = "../controller/holiday_leave_controller.php?status=load_leave_report_date_range_user";

                $.post(url3, {user_id: user_id, startDate: startDate, endDate: endDate}, function (data) {
                    /*show the data that is being responded by server in the div id myfunctions*/
                    $('#leaves-table').parents('div.dataTables_wrapper').first().hide();
                    $("#show-filtered-table").html(data).show();
                    $("#load_data").DataTable({
                        responsive: true,
                        order: [
                            [1, "asc"]
                        ],
                        dom: 'Bfrtip',
                        title: 'Leave report',

                        buttons: [
                            {
                                extend: 'pdfHtml5',
                                text: 'PDF',
                                title: 'Leave Report : ' + new Date().toDateString(),
                                download: 'open',
                                exportOptions: {
                                    columns: [0, ':visible']
                                },
                                filename: 'Leave Report : ' + new Date().toDateString(),


                                customize: function (doc) {

                                    var cols = [];
                                    cols[0] = {
                                        image: 'data:image/png;base64,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giZCvbXX1j9pAFxuwNcNRAhdxgChGN6X2btklponJLlRGx8jeNBs4b3odXcjee9BdRfwhA0NAi+oKl6VwcHBoHpVRPUZYxxVfVzhmclSCd66Xcn2jFmKTetr7BHT+o32TsmAnDTLyNZ13tb8lVDUbjRFX2tj0rB3DOwGHrPfa2x+E3BDI1NLIk0ScA6vOhaLpPfaNWOW2BLH1PQ07atXY9oNJi5SiJ2bmC6XMQu6geBiKYhFEz4bd2qEbNxmfKYF74iBlXXbdjvvKKHJP9/2r5iFPUHoWhzBCocJRW4bwdvSvQuEON3OnOu30NBZLLlJ7d2wgai5GfV+h4g8YAceV9VPisiLzjkQoTo9TZzLoaq3iMgu09YxVb1DVZ8+ODLiCJX3qgwPU8bYFAsD9gUNyj1mytjAfE85QXCnc03oxj1TgMYX2XuU4J4dGT5SZcy2cku3NMD6yr3AA4Q26jwR+QaqX/PevwkQ5/Oo930i8nUDbIJwKzHpnMM55733S/0CUyUTgBto6DTjo8xPMik13pWdbu8iIY6dlhZNBFnqaG0ljmNUdQzYLSLXEoL3ZYhsIwTj9cB2EbmX4CYAP/JJ8pV8S8vR0sQE67u6OHnq1FKPfU/Ski3t8LFj9PX0pP7QQjDhNPh+jBCcKwTzzrr9pIvj6szUFE253ErL+x+hJVsawKmJCda2t4NqnZCqHxaR44SCNWLu/uw48APgWVT/BhQQ4eCRI//1VgbLsLQsqUjdiTxq5cVeEfkEsAfV3yFyj8JrV23d+v1/7NtHel0kblnVzXualv2Nd2DjRgC8zL4aI7IFGBORE6p6ASAuio742txFbOEs+vr+tj+MXzwwQLViHUj6wcXu4xSI45h6tXpWgZXSO/rfBAP2cRmR8JgLppeZBwqFlZbvXaF/AfBCeZNa5f0cAAAAtGVYSWZJSSoACAAAAAYAEgEDAAEAAAABAAAAGgEFAAEAAABWAAAAGwEFAAEAAABeAAAAKAEDAAEAAAACAAAAEwIDAAEAAAABAAAAaYcEAAEAAABmAAAAAAAAAEgAAAABAAAASAAAAAEAAAAGAACQBwAEAAAAMDIxMAGRBwAEAAAAAQIDAACgBwAEAAAAMDEwMAGgAwABAAAA//8AAAKgBAABAAAANAEAAAOgBAABAAAAfgAAAAAAAACom/WPAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDI0LTAyLTAxVDA4OjI0OjQ3KzAwOjAwwIiYMAAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyNC0wMi0wMVQwODoyNDo0NyswMDowMLHVIIwAAAAodEVYdGRhdGU6dGltZXN0YW1wADIwMjQtMDItMDFUMDg6MjQ6NTgrMDA6MDDcInEkAAAAFXRFWHRleGlmOkNvbG9yU3BhY2UANjU1MzUzewBuAAAAIHRFWHRleGlmOkNvbXBvbmVudHNDb25maWd1cmF0aW9uAC4uLmryoWQAAAATdEVYdGV4aWY6RXhpZk9mZnNldAAxMDJzQimnAAAAFXRFWHRleGlmOkV4aWZWZXJzaW9uADAyMTC4dlZ4AAAAGXRFWHRleGlmOkZsYXNoUGl4VmVyc2lvbgAwMTAwEtQorAAAABh0RVh0ZXhpZjpQaXhlbFhEaW1lbnNpb24AMzA4S20cMQAAABh0RVh0ZXhpZjpQaXhlbFlEaW1lbnNpb24AMTI2AGhmrAAAABd0RVh0ZXhpZjpZQ2JDclBvc2l0aW9uaW5nADGsD4BjAAAAAElFTkSuQmCC'
                                        , alignment: 'left', margin: [30]
                                    };
                                    cols[1] = {text: 'Leave Report', alignment: 'right', margin: [0, 0, 20]};
                                    var objHeader = {};
                                    objHeader['columns'] = cols;
                                    doc['footer'] = objHeader;


                                }
                            },
                            {
                                extend: 'spacer',
                                style: 'empty',
                            },
                            {
                                extend: 'excelHtml5',
                                text: 'Excel',
                                title: 'Leave Report : ' + new Date().toDateString(),
                                autoFilter: true,
                                download: 'open',
                                exportOptions: {
                                    columns: [0, ':visible']
                                },
                                filename: 'Leave Report : ' + new Date().toDateString(),


                            },
                            {
                                extend: 'spacer',
                                style: 'empty',
                            },
                            'colvis'

                        ]

                    });
                });
            }
        }

    };

    //display upcoming leaves
    $(document).ready(function() {
        $('#showUpcoming').on('click', function() {
            $.ajax({
                url: '../controller/holiday_leave_controller.php?status=fetch_upcoming_leaves',
                method: 'GET',
                success: function(response) {
                    $('#leaves-table').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    $('#leaves-table').html('<p>An error occurred while fetching the data.</p>');
                }
            });
        });
    });

    //display past leaves
    $(document).ready(function() {
        $('#showHistory').on('click', function() {
            $.ajax({
                url: '../controller/holiday_leave_controller.php?status=fetch_past_leaves',
                method: 'GET',
                success: function(response) {
                    $('#leaves-table').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    $('#leaves-table').html('<p>An error occurred while fetching the data.</p>');
                }
            });
        });
    });


</script>
</body>

</html>