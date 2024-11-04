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
    $leaveResult=$holidayObj->getAllLeaves();

    ?>

    <div class="main">
        <?php
        include_once "topbar.php";
        ?>
        <main class="content">
            <div class="container-fluid p-0">

            <h1 class="h3 mb-3">Record Cleanup</h1>

<div class="row">
    <div class="row">
        <?php
        //        check if msg is available
        if(isset($_GET['msg'])){
            ?>
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissible" role="alert">
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

        <div class="col-md-12">
            <div id="alertDiv">

            </div>
        </div>
    </div>

    <div class="col-md-3 col-xl-2">

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Attendance & Leaves </h5>
            </div>

            <div class="list-group list-group-flush" role="tablist">
                <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#attendance" role="tab">
                    Attendance
                </a>
                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#leave" role="tab">
                    Leaves
                </a>
                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#payslip" role="tab">
                    Payslips
                </a>
                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#holiday" role="tab">
                    Holidays
                </a>
            </div>
        </div>
    </div>
    
    <!-- -------Attendance---------->
    <div class="col-md-9 col-xl-10">
        <div class="tab-content">
            
            <div class="tab-pane fade show active" id="attendance" role="tabpanel">
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
                        <h5 class="card-title mb-0">Attendance Records</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">

                        <div class="col-4">
                            <p>From :</p>
                            <input type="date" value="01-06-2017" max="<?php echo date("Y-m-d") ?>" class="form-control" name="payDate" id="startDate">
                        </div>
                        <div class="col-4">
                            <p>To :</p>
                            <input type="date" value="01-06-2017" max="<?php echo date("Y-m-d") ?>" class="form-control" name="payDate" id="endDate">
                        </div>

                        <div class="col-1">
                            <div style="padding-top: 35px">
                            <button class="btn btn-primary shadow-sm" onclick="loadAttendanceData()">
                                <i class="align-middle" data-feather="filter">&nbsp;</i>
                            </button>&nbsp
                            <button class="btn btn-primary shadow-sm" onclick="window.location.reload();">
                                <i class="align-middle" data-feather="refresh-cw">&nbsp;</i>
                            </button>
                        </div>
                    </div>
                    </div><br>

                <form id="deleteAttendance">
                    <div class="card-body">
                    <table id="datatables-attendance" class="table" style="width:100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Date</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    while ($OrderRow=$attendanceResult->fetch_assoc()){
                        ?>
                        <tr>
                            <td><?php echo $OrderRow["attendance_id"]; ?></td>
                            <td><?php echo $OrderRow["user_fname"].' '.$OrderRow["user_lname"]; ?></td>

                            <td><?php echo $OrderRow["date"]; echo "<br>"; ?></td>
                            <td><?php
                                $checkin=$OrderRow["check_in"];
                                if ($checkin!='')
                                {
                                    echo $checkin;
                                }else{
                                    echo "Absent";
                                }
                            ?></td>
                            <td><?php
                                $checkout=$OrderRow["check_out"];
                                if ($checkout!=''){
                                    echo $checkout;
                                }else{
                                    echo "Absent";
                                }
                                ?></td> 
                        </tr>
                        <?php

                    }
                    ?>

                    </tbody>
                </table>
                <div id="show-filtered-table">

                </div>
            </div>
        
                    <div>

                    </div>
                        <button type="submit" class="btn btn-danger mb-4" onclick="deleteAttendance()">Delete Records</button>
                    </div>
                </div>
                </form>
            </div>

            <!--************Leaves**************-->
            <div class="tab-pane fade" id="leave" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-0">Leave Records</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">

                        <div class="col-4">
                            <p>From :</p>
                            <input type="date" value="01-06-2017" max="<?php echo date("Y-m-d") ?>" class="form-control" name="payDate" id="startLeaveDate">
                        </div>
                        <div class="col-4">
                            <p>To :</p>
                            <input type="date" value="01-06-2017" max="<?php echo date("Y-m-d") ?>" class="form-control" name="payDate" id="endLeaveDate">
                        </div>

                        <div class="col-1">
                            <div style="padding-top: 35px">
                            <button class="btn btn-primary shadow-sm" onclick="loadLeaveData()">
                                <i class="align-middle" data-feather="filter">&nbsp;</i>
                            </button>&nbsp
                            <button class="btn btn-primary shadow-sm" onclick="window.location.reload();">
                                <i class="align-middle" data-feather="refresh-cw">&nbsp;</i>
                            </button>
                        </div>
                    </div>
                    </div><br>

                <div class="card-body">
                    <table id="datatables-leave" class="table" style="width:100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Employee Name</th>
                            <th>Leave Type</th>
                            <th>Leave Date</th>
                            <th>Reason</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        while ($leaveRow=$leaveResult->fetch_assoc()){

                            ?>
                            <tr>
                                <td><?php echo $leaveRow["leave_id"]; ?></td>
                                <td><?php echo $leaveRow['user_fname'].' '.$leaveRow['user_lname']; ?></td>

                                <td><?php  
                                if($leaveRow["leave_type"]==1){
                                        echo 'Annual leave';
                                    }else if($leaveRow["leave_type"]==2){
                                        echo 'Casual leave';

                                    }else{
                                        echo 'Sick leave';
                                    } 
                                ?></td>
                                <td><?php echo $date=$leaveRow['date'];?></td>
                                <td><?php echo $leaveRow['reason'];?></td> 
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                    
                    <div id="show-filtered-table-leave">
                    
                    </div>
                </div>

                    <div>
                        <button type="submit" class="btn btn-danger mb-4" onclick="deleteLeaves()">Delete Records</button>
                    </div>
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
        $("#datatables-attendance").DataTable({
            pageLength: 10,
            responsive: true,
            order: [
                [1, "asc"]
            ]
        });
    });

    function loadAttendanceData() {
    var startDate = $('#startDate').val();
    var endDate = $('#endDate').val();
    
    if (startDate !== "" && endDate !== "") {
        var url = "../controller/attendance_controller.php?status=load_date_range";
        
        $.post(url, { startDate: startDate, endDate: endDate }, function (data) {
            // Destroy the existing DataTable instance
            var table = $('#datatables-attendance').DataTable();
            table.clear().destroy();
            
            // Replace the HTML with new data and initialize DataTable again
            $("#show-filtered-table").html(data);
            $("#load_data1").DataTable({
                responsive: true,
                order: [[1, "asc"]]
            });
        });
    } else {
        // Handle case where startDate or endDate is missing
        alert("Please select both start and end dates.");
    }
}

function deleteAttendance() {
    var startDate = $('#startDate').val();
    var endDate = $('#endDate').val();

    if (startDate !== "" && endDate !== "") {
        if (confirm("Are you sure you want to delete all attendance records from " + startDate + " to " + endDate + "?")) {
            var url1 = "../controller/attendance_controller.php?status=deleteAttendance";

            $.post(url1, {startDate: startDate, endDate: endDate}, function(response) {
                if (response === "success") {
                    alert("Successfully Deleted.");
                    window.location.reload();
                } else {
                    alert("Error Deleting Records");
                }
            });
        }
    } else {
        alert("Please select both start and end dates.");
    }
}
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Datatables clients
        $("#datatables-leave").DataTable({
            pageLength: 10,
            responsive: true,
            order: [
                [1, "asc"]
            ]
        });
    });

    function loadLeaveData() {
    var startLeaveDate = $('#startLeaveDate').val();
    var endLeaveDate = $('#endLeaveDate').val();
    
    if (startLeaveDate !== "" && endLeaveDate !== "") {
        var url = "../controller/holiday_leave_controller.php?status=load_date_range";
        
        $.post(url, { startLeaveDate: startLeaveDate, endLeaveDate: endLeaveDate }, function (data) {
            var table = $('#datatables-leave').DataTable();
            table.clear().destroy();
            
            $("#show-filtered-table-leave").html(data);
            $("#load_data2").DataTable({
                responsive: true,
                order: [[1, "asc"]]
            });
        });
    } else {
        // Handle case where startDate or endDate is missing
        alert("Please select both start and end dates.");
    }
} 
</script>

<script>
    function deleteLeaves() {
    var startLeaveDate = $('#startLeaveDate').val();
    var endLeaveDate = $('#endLeaveDate').val();

    if (startLeaveDate !== "" && endLeaveDate !== "") {
        if (confirm("Are you sure you want to delete selected leave records?")) {
            var url2 = "../controller/holiday_leave_controller.php?status=deleteLeaves";

            $.post(url2, {startLeaveDate: startLeaveDate, endLeaveDate: endLeaveDate}, function(response) {
                if (response === "success") {
                    //alert("Successfully Deleted.");
                    window.location.reload();
                } else {
                    alert("Error Deleting Records");
                }
            });
        }
    } else {
        alert("Please select both start and end dates.");
    }
}
</script>

</body>

</html>