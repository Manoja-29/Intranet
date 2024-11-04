<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 5 Admin &amp; Dashboard Template">
    <meta name="author" content="Bootlab">

    <title>Leaves</title>

    <link rel="canonical" href="https://appstack.bootlab.io/forms-layouts.html" />
    <link rel="shortcut icon" href="img/favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet">

    <link href="css/light.css" rel="stylesheet">
    <style>
        .datepicker-days table .disabled-date.day {
            background-color: royalblue;
            color: #fff;
        }

        .datepicker table tr td.disabled,
        .datepicker table tr td.disabled:hover {
            background: cornflowerblue;
            color: #fff;
        }
        .datepicker table tr td.today, .datepicker table tr td.today:hover, .datepicker table tr td.today.disabled, .datepicker table tr td.today.disabled:hover {
            /* background-color: #fde19a; */

            background: lightgray;

        }
        .badge{
            padding: 10px;
        }
    </style>

</head>


<body data-theme="colored" data-layout="fluid" data-sidebar-position="left" data-sidebar-behavior="sticky">
<div class="wrapper">
    <?php
    include "../model/order_model.php";
    $orderObj=new Order();

    include "../model/user-model.php";

    $employeeObj=new User();
    $empResult=$employeeObj->DisplayAllUsers();

    include "../model/holiday-leave-model.php";
    $holidayObj=new HolidayLeave();

    $user_id=$_REQUEST["user_id"];
    $user_id=base64_decode($user_id);

    $userObj=new User();
    $userResult= $userObj->viewUser($user_id);
    $userRow=$userResult->fetch_assoc();
    ?>
    <div class="main">
        <main class="content">
            <div class="container-fluid p-0">

                <h1 class="h2 mb-3"> <?php echo $userRow["user_fname"].' '.$userRow["user_lname"] ?></h1>

                <h2 class="h4 mb-3">Leaves Applied on <?php
                    echo (date('D M d Y', strtotime($_REQUEST["applied_date"])));
                    ?></h1><br>
                <form method="post" enctype="multipart/form-data" id="addLeaves" >
                    <div class="row">
                            <?php
                            //        check if msg is available
                            if(isset($_GET['msg'])){

                                ?>
                                    <div class="alert alert-primary alert-dismissible" role="alert">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        <div class="alert-message">
                                            <strong>Hello there!</strong>  <?php
                                            $msg=$_REQUEST['msg'];
                                            $msg=base64_decode($msg);
                                            echo $msg;
                                            ?>
                                        </div>
                                    </div>
                                <?php
                            }

                            ?>

                                <div id="alertDiv" style="padding: 15px">

                                </div>

                        <div class="card flex-fill">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-4">
                                        <h2 class="card-title mb-0">Leave Instance</h2>
                                    </div>
                                    <div class="col-1">From :</div>
                                    <div class="col-3"><?php
                                        $start_date=$_REQUEST["start_date"];

                                        echo (date('D M d Y', strtotime($start_date)));
                                        ?></div>
                                    <div class="col-1">To :</div>
                                    <div class="col-3"><?php
                                        $end_date=$_REQUEST["end_date"];

                                        echo (date('D M d Y', strtotime($end_date)));
                                        ?>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card flex-fill">
                            <div class="card-header">
                                <div class="card-actions float-end">
                                    <div class="dropdown position-relative">
                                        <a href="#" data-bs-toggle="dropdown" data-bs-display="static">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="card-title mb-0">Leaves</h5>
                            </div>
                            <table class="table table-borderless my-0" id="holidays-table">
                                <thead>
                                <tr>
                                    <th class="d-none d-xl-table-cell">Date</th>
                                    <th>Leave type</th>
                                    <th class="d-none d-xl-table-cell">Reason</th>
                                    <th></th>
                                    <th></th>
                                    <th>Status</th>
                                    <th class="d-none d-xl-table-cell text-end">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $leaveappliedResult=$holidayObj->getappliedleaves($start_date,$end_date,$user_id);

                                while ($leaveRow=$leaveappliedResult->fetch_assoc()){

                                    ?>
                                    <tr>

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

                                            }else{
                                                echo 'Sick leave';
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
                                                <span class="badge bg-success"> Request Approved </span>

                                                <?php
                                            }else if($leaveRow['leave_status']==2){
                                                ?>
                                                <span class="badge bg-danger"> Request Declined </span>

                                                <?php
                                            }
                                            else{
                                                ?>
                                                <span class="badge text-bg-warning"> Request Pending </span>

                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td class="d-none d-xl-table-cell text-end">
                                            <?php
                                            if($leaveRow['leave_status'] == 0)//pending
                                            {

                                            ?>

                                            <a style="width: 120px" href="../controller/holiday_leave_controller.php?status=update_user_status&user_id=<?php echo $user_id?>&user_status=<?php echo 1 ?>&date=<?php echo $date?>&start_date=<?php echo $start_date?>&end_date=<?php echo $end_date?>&applied_date=<?Php echo $_REQUEST["applied_date"]?>" class="badge bg-success">
                                                <span class="glyphicon glyphicon-refresh"></span>
                                                &nbsp;Approve

                                            </a>

                                            <?php
                                            }

                                            ?>
                                            <!--Deactivation-->
                                            <!--when user is active deactivate using deactivate button-->
                                            <?php
                                            if($leaveRow['leave_status'] == 1)//approved
                                            {
                                                ?>

                                                <a style="width: 120px" href="../controller/holiday_leave_controller.php?status=update_user_status&user_id=<?php echo $user_id?>&user_status=<?php echo 2 ?>&date=<?php echo $date?>&start_date=<?php echo $start_date?>&end_date=<?php echo $end_date?>&applied_date=<?Php echo $_REQUEST["applied_date"]?>" class="badge bg-danger">
                                                    <span class="glyphicon glyphicon-refresh"></span>
                                                    &nbsp;Disapprove
                                                </a>
                                                <?php
                                            }
                                            ?>

                                            <?php
                                            if($leaveRow['leave_status'] == 2)//disapproved
                                            {
                                                ?>

                                                <a style="width: 120px" href="../controller/holiday_leave_controller.php?status=update_user_status&user_id=<?php echo $user_id?>&user_status=<?php echo 0 ?>&date=<?php echo $date?>&start_date=<?php echo $start_date?>&end_date=<?php echo $end_date?>&applied_date=<?Php echo $_REQUEST["applied_date"]?>" class="badge bg-warning">
                                                    <span class="glyphicon glyphicon-refresh"></span>
                                                    &nbsp;Disapprove
                                                </a>
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
                        </div>
                        <div class="row">
                            <div class="col-md-11"></div>
                            <div class="col-md-1">


                                <a href="../controller/holiday_leave_controller.php?status=email_user_status&user_id=<?php echo $user_id?>&user_status=<?php echo 0 ?>&date=<?php echo $date?>&start_date=<?php echo $start_date?>&end_date=<?php echo $end_date?>&applied_date=<?Php echo $_REQUEST["applied_date"]?>" class="btn btn-primary">Send update</a>
                            </div>
                        </div>

                </form>

            </div>
        </main>
        <?Php
        include "footer.php";
        ?>
    </div>
</div>
<script type="text/javascript" src="js/orderValidation.js"></script>
<script src="js/app.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

<script type="text/javascript">

    //disable dates in bootstrap date picker
    var datesForDisable = <?php echo json_encode($days); ?>;
    //alert(datesForDisable);

    $("#date").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        weekStart: 1,
        todayHighlight: true,
        datesDisabled: datesForDisable,
        daysOfWeekDisabled: [0, 6]
    })

    //disable dates in to - bootstrap date picker
    var datesForDisable2 = <?php echo json_encode($days); ?>;
    $("#date2").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        weekStart: 1,
        todayHighlight: true,
        datesDisabled: datesForDisable2,
        daysOfWeekDisabled: [0, 6]
    })

    //display table onchange date
    function fromDateChange() {
        var datefrom = $("#date").val();
        var dateto = $("#date2").val();

        const date1 = new Date(datefrom);
        const date2 = new Date(dateto);
        const diffTime = Math.abs(date2 - date1);
        const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
        //alert(diffDays);

        if (datefrom==''){ //check if from date is empty

            $("#alertDiv").html("Please select a starting date");
            $("#alertDiv").addClass("alert alert-danger");
            $("#date").focus();
            $("#date2").val('');
            return false;
        }
        else if(date2 < date1){
            $("#alertDiv").html("Please check the dates. Start date must be before end date");
            $("#alertDiv").addClass("alert alert-danger");
            $("#date2").val('');
            $("#date").val('');
            return false;
        }
        else{

            console.log(diffDays + " days"); //number of days within the duration

            function getDatesBetween(startDate, endDate) {
                var dates = [];
                var currentDate = new Date(startDate);

                while (currentDate <= endDate) {
                    dates.push(new Date(currentDate).toDateString());
                    currentDate.setDate(currentDate.getDate() + 1);
                }

                return dates; //Days within the duration

            }

            const startDate = new Date(datefrom);
            const endDate = new Date(dateto);
            console.log(getDatesBetween(startDate, endDate));

            var days="";
            var ar = getDatesBetween(startDate, endDate); //function return array
            for(el in ar){
                days+=ar[el]+",";

            }

            var url = "../controller/holiday_leave_controller.php?status=leave_list";

            $.post(url, {startDate: startDate, endDate: endDate, diffDays: diffDays, days: days}, function (data) {
                /*show the data that is being responded by server in the div id myfunctions*/
                $("#duration-table-div").html(data).show();

            });
        }

    }

    $("#addLeaves").submit(function ()
    {
        var leave_type=$("#leave_type").val();
        var leave_date=$("#leave_date").val();
        var team_email=$("#team_email").val();
        var leave_reason=$("#leave_reason").val();

        if(leave_type=="")
        {
            $("#alertDiv").html("Leave type cannot be empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#leave_type").focus();
            return false;
        }
        if(leave_date=="")
        {
            $("#alertDiv").html("Leave date cannot be empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#leave_date").focus();
            return false;
        }

        if(team_email=="")
        {
            $("#alertDiv").html("Leave email cannot be empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#team_email").focus();
            return false;
        }
        if(leave_reason=="")
        {
            $("#alertDiv").html("Leave reason cannot be empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#leave_reason").focus();
            return false;
        }
    })


</script>

</body>

</html>