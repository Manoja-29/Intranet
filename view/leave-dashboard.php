<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 5 Admin &amp; Dashboard Template">
    <meta name="author" content="Bootlab">

    <title>Default Dashboard | AppStack - Bootstrap 5 Admin &amp; Dashboard Template</title>

    <link rel="canonical" href="https://appstack.bootlab.io/dashboard-default.html" />
    <link rel="shortcut icon" href="img/favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <!-- Choose your prefered color scheme -->
    <link href="css/light.css" rel="stylesheet">
    <style type="text/css">
        .status{
            padding: 10px;
            width: 120px;
        }
    </style>
</head>


<body data-theme="colored" data-layout="fluid" data-sidebar-position="left" data-sidebar-behavior="sticky">
<div class="wrapper">
    <?php
    include_once "sidebar.php";
    ?>
    <div class="main">
        <?php
        include_once "../model/user-model.php";
        $userObj=new User();

        include_once "topbar.php";
        include '../model/attendance_model.php';
        $attendanceObj=new Attendance();

        date_default_timezone_set('Asia/Colombo');
        $logged_userId=$_SESSION['user']['user_id'];
        $dateToday=date("Y-m-d");

        $checkedout=$attendanceObj->CheckUserAttendance($logged_userId,$dateToday);
        if($checkedout == true){
            /*insert*/
            $signedIn=$attendanceObj->addAttendance($logged_userId,$dateToday);

        }
        include "../model/holiday-leave-model.php";
        $holidayObj=new HolidayLeave();
        $holidayResult=$holidayObj->getHolidays();

        $user_id=$_SESSION['user']['user_id'];

        /*end*/
        ?>
        <main class="content">
            <div class="container-fluid p-0">

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
                        <div id="alertDiv" style="padding: 10px">

                        </div>
                    </div>
                </div>

                <div class="row mb-2 mb-xl-3">
                    <div class="col-auto d-none d-sm-block">
                        <h3>Leaves & Holidays</h3>
                    </div>

                    <div class="col-auto ms-auto text-end mt-n1">
                        <div class="dropdown me-2 d-inline-block position-relative">
                            <a class="btn mb-2 btn-primary" style="padding: 5px 15px;" href="add-leave.php">+ Apply Leave</a>
                        </div>
                    </div>
                </div>
                <?php

                $leaveCountResult=$holidayObj->getleaveFullOrHalfcount($user_id);
                $leaveCountRow=$leaveCountResult->fetch_assoc();

                $userBasedResults=$userObj->getUserBasedAdditionalDetails($user_id);
                $userBasedRow=$userBasedResults->fetch_assoc();
            
                //fetch initial leaves
                $initialAnnual = $userBasedRow['initial_annual']; 
                $initialCasual = $userBasedRow['initial_casual'];
                $initialSick = $userBasedRow['initial_sick'];

                $TotInitial = ($initialAnnual+$initialCasual+$initialSick);//get initial leaves total
                
                //fetch applied leaves
                $Annual=$leaveCountRow['fulldayAnnual']+($leaveCountRow['halfdayAnnual']/2);
                $applyCasual=$leaveCountRow['fulldayCasual']+($leaveCountRow['halfdayCasual']/2);
                $sick=$casual=$leaveCountRow['fulldaySick']+($leaveCountRow['halfdaySick']/2);

                $TotAppliedLeaves=($Annual+$sick+$applyCasual); //get applied leaves total
                $TotalAppliedPercentage=round(($TotAppliedLeaves/$TotInitial) * 100 , 2);
                
                //fetch available leaves
                $availableAnnual = $initialAnnual - $Annual;
                $availableCasual = $initialCasual - $applyCasual;
                $availableSick = $initialSick - $sick;

                $TotalAvailable = $availableAnnual + $availableCasual + $availableSick;//get total available leaves
                $TotAvailablePercentage = round(($TotalAvailable / $TotInitial) * 100 , 2);

                ?>
                <div class="row">
                    <div class="col-12 col-sm-6 col-xxl-4 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-4">
                                <div class="d-flex align-items-start">
                                    <div class="flex-grow-1">
                                        <h4 class="mb-2 text-left">Annual Leave</h4><br>
                                        <div style="text-align: center;">
                                            <img src="img/photos/annual.png" width="90" height="90" alt="annual">
                                        </div>
                                        <div class="mt-3" style="font-size:15px; display: flex; justify-content: space-between; align-items: center;">
                                            <p class="mb-2" style="margin-right: 10px;"> Available: 
                                                <span class="badge badge-soft-success me-2"><?php echo $availableAnnual ?> leaves </span>
                                            </p>
                                            <p class="mb-2"> Applied: 
                                                <span class="badge badge-soft-danger me-2"><?php echo $Annual ?> leaves </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="d-inline-block ms-3">
                                        <div class="stat">
                                            <h3 style="text-align:center; color:blue;"><?php echo $initialAnnual?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-xxl-4 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-4">
                                <div class="d-flex align-items-start">
                                    <div class="flex-grow-1">
                                        <h4 class="mb-2 text-left">Casual Leave</h4><br>
                                        <div style="text-align: center;">
                                            <img src="img/photos/casual.png" width="90" height="90" alt="annual">
                                        </div>
                                        <div class="mt-3" style="font-size:15px; display: flex; justify-content: space-between; align-items: center;">
                                            <p class="mb-2" style="margin-right: 10px;"> Available: 
                                                <span class="badge badge-soft-success me-2"><?php echo $availableCasual ?> leaves </span>
                                            </p>
                                            <p class="mb-2"> Applied: 
                                                <span class="badge badge-soft-danger me-2"><?php echo $applyCasual ?> leaves </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="d-inline-block ms-3">
                                        <div class="stat">
                                            <h3 style="text-align:center; color:blue;"><?php echo $initialCasual?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-xxl-4 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-4">
                                <div class="d-flex align-items-start">
                                    <div class="flex-grow-1">
                                        <h4 class="mb-2 text-left">Sick Leave</h4><br>
                                        <div style="text-align: center;">
                                            <img src="img/photos/sick.png" width="90" height="90" alt="annual">
                                        </div>
                                        <div class="mt-3" style="font-size:15px; display: flex; justify-content: space-between; align-items: center;">
                                            <p class="mb-2" style="margin-right: 10px;"> Available: 
                                                <span class="badge badge-soft-success me-2"><?php echo $availableSick ?> leaves </span>
                                            </p>
                                            <p class="mb-2"> Applied: 
                                                <span class="badge badge-soft-danger me-2"><?php echo $sick ?> leaves </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="d-inline-block ms-3">
                                        <div class="stat">
                                            <h3 style="text-align:center; color:blue;"><?php echo $initialSick?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="card flex-fill">
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
                        <h5 class="card-title mb-0">All Leaves</h5><br>
                    </div>
                    <div class="card-body">
                        <table class=" table my-0" id="leaves-table">
                            <thead>
                            <tr>
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
                            $leaveResult=$holidayObj->getLeaves($user_id);

                            while ($leaveRow=$leaveResult->fetch_assoc()){

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
                    </div>
                    <br>
                </div>
                
                <div class="row">
                    <div class="col-12 col-lg-6 col-xl-4 d-flex">
                        <div class="card flex-fill">
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
                                <h5 class="card-title mb-0">Calendar</h5>
                            </div>
                            <div class="card-body d-flex">
                                <div class="align-self-center w-100">
                                    <div class="chart">
                                        <div id="datetimepicker-dashboard"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-8 d-flex">
                        <div class="card flex-fill w-100">
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
                                <h5 class="card-title mb-0">Holidays</h5>
                            </div>

                            <div class="card-body">
                                <table class="table my-0" id="holidays-table">
                                    <thead>
                                    <tr>
                                        <th class="d-none d-xxl-table-cell">Description</th>
                                        <th class="d-none d-xl-table-cell">Date</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while ($holidayRow=$holidayResult->fetch_assoc()){

                                        ?>
                                        <tr>
                                            <td class="d-none d-xxl-table-cell">
                                                <div class="text-muted">
                                                    <?php
                                                    echo $holidayRow['holiday_name'];
                                                    ?>
                                                </div>
                                            </td>
                                            <td class="d-none d-xl-table-cell">
                                                <div class="text-muted">
                                                    <?php
                                                    echo $holidayRow['date'];
                                                    ?>
                                                </div>
                                            </td>
                                            <td>
                                                <?php
                                                date_default_timezone_set('Asia/Colombo');
                                                $dateToday=date("Y-m-d");

                                                if($holidayRow['date']>$dateToday){
                                                    ?>
                                                    <i class="fas fa-square-full text-success"></i>  Upcoming

                                                    <?php
                                                }else{
                                                    ?>
                                                    <i class="fas fa-square-full text-danger"></i>  History

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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Bar chart
        new Chart(document.getElementById("chartjs-dashboard-bar"), {
            type: "bar",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Last year",
                    backgroundColor: window.theme.primary,
                    borderColor: window.theme.primary,
                    hoverBackgroundColor: window.theme.primary,
                    hoverBorderColor: window.theme.primary,
                    data: [54, 67, 41, 55, 62, 45, 55, 73, 60, 76, 48, 79],
                    barPercentage: .325,
                    categoryPercentage: .5
                }, {
                    label: "This year",
                    backgroundColor: window.theme["primary-light"],
                    borderColor: window.theme["primary-light"],
                    hoverBackgroundColor: window.theme["primary-light"],
                    hoverBorderColor: window.theme["primary-light"],
                    data: [69, 66, 24, 48, 52, 51, 44, 53, 62, 79, 51, 68],
                    barPercentage: .325,
                    categoryPercentage: .5
                }]
            },
            options: {
                maintainAspectRatio: false,
                cornerRadius: 15,
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            stepSize: 20
                        },
                        stacked: true,
                    }],
                    xAxes: [{
                        gridLines: {
                            color: "transparent"
                        },
                        stacked: true,
                    }]
                }
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        $("#datetimepicker-dashboard").datetimepicker({
            inline: true,
            sideBySide: false,
            format: "L"
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        // Pie chart
        new Chart(document.getElementById("chartjs-dashboard-pie"), {
            type: "pie",
            data: {
                labels: ["Direct", "Affiliate", "E-mail", "Other"],
                datasets: [{
                    data: [2602, 1253, 541, 1465],
                    backgroundColor: [
                        window.theme.primary,
                        window.theme.warning,
                        window.theme.danger,
                        "#E8EAED"
                    ],
                    borderWidth: 5,
                    borderColor: window.theme.white
                }]
            },
            options: {
                responsive: !window.MSInputMethodContext,
                maintainAspectRatio: false,
                cutoutPercentage: 70,
                legend: {
                    display: false
                }
            }
        });
    });

    $("#leaves-table").DataTable({
        responsive: true,
        pageLength: 5,
        order: [
            [0, "desc"]
        ]
    });
    $("#holidays-table").DataTable({
        responsive: true,
        pageLength: 5,
        order: [
            [1, "desc"]
        ]
    });
</script>


</body>

</html>