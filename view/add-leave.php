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
    include "../model/order_model.php";
    $orderObj=new Order();

    $employeeObj=new User();
    $empResult=$employeeObj->DisplayAllUsers();

    include "../model/holiday-leave-model.php";
    $holidayObj=new HolidayLeave();
    ?>
    <div class="main">
        <?php
        include_once "topbar.php";
        ?>
        <main class="content">
            <div class="container-fluid p-0">
            <h1 class="h3 mb-3">Leaves</h1>
                <form method="post" enctype="multipart/form-data" id="addLeaves" action="../controller/holiday_leave_controller.php?status=add_leave">
                    <div class="row">
                        <div class="row">
                            <?php
                            //check if msg is available
                            if(isset($_GET['msg'])){

                                ?>
                                <div class="col-md-12">
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
                                </div>
                                <?php
                            }

                            ?>

                            <div class="col-md-12">
                                <div id="alertDiv" style="padding: 15px">

                                </div>
                            </div>
                        </div>
                    

            <div class="row">
                <div class="col-12 col-lg-6 col-xl-4 d-flex">
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
                            <h5 class="card-title mb-0">Request Leave</h5>
                        </div>
                        <div class="card-body d-flex justify-content-center align-items-center" style="min-height: 200px;">
                            <img src="../view/img/photos/leave.png" class="mx-auto" width="130" height="130" alt="leave">
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-8 d-flex">
                    <div class="card flex-fill w-100">
                        <div class="card-body">
                            <form>
                                <p id="test"></p>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Leave Type</label>
                                        <select class="form-control" id="leave-type" name="leave-type" required>
                                            <option value="0">Please select</option>
                                            <option value="1">Annual Leave</option>
                                            <option value="2">Casual Leave</option>
                                            <option value="3">Sick Leave</option>
                                        </select>
                                    </div>

                                    <?php
                                        $user_id=$_SESSION["user"]["user_id"];
                                    ?>
                                    <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Reason for leave</label>
                                        <input type="text" class="form-control" id="leave_reason" name="leave_reason" required>
                                    </div>

                                </div>
                                <br>

                                <div class="row">
                                    <!-- current date-->
                                    <input type="hidden" id="DateToday" class="form-control" value="<?php echo date('Y-m-d')?>">
                                    <!--date 30 days prior-->                                         
                                    <input type="hidden" id="DatePriorMonth" class="form-control" value="<?php echo date('Y-m-d', strtotime('-30 days'))?>">


                                    <div class="col-md-6">
                                        <label class="form-label">Team Email ID</label>
                                        <input type="text" value="manoja@technicalcreatives.com" class="form-control" id="team_email" name="team_email" placeholder="Email" readonly>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Date (From)</label>
                                        <input id="date" class="form-control date" autocomplete="off" onchange="dateChange()" name="leave_date_from1">
                                        <input id="date-sick" class="form-control" autocomplete="off" onchange="dateChange2()" name="leave_date_from">

                                            <?php
                                                $holiday_result=$holidayObj->getHolidays();
                                                $leave_result=$holidayObj->getLeaves($user_id);

                                                $days = array();

                                                while ($holidayAllRow=$holiday_result->fetch_assoc()){
                                                    $holidayDate=$holidayAllRow["date"];
                                                    array_push($days,$holidayDate);
                                                }
                                                while ($leaveAllRow=$leave_result->fetch_assoc()){
                                                    $holidayDate2=$leaveAllRow["date"];
                                                    $holidayDate2=(date('Y-m-d', strtotime($holidayDate2)));

                                                    array_push($days,$holidayDate2);
                                                }
                                                //print_r ($days);
                                            ?>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Date (To)</label>
                                        <input id="date2" autocomplete="off"  class="form-control" name="leave_date_to1" onchange="ToDateChange()" >
                                        <input id="date2-sick" autocomplete="off"  class="form-control" name="leave_date_to" onchange="ToDateChange2()" >
                                    </div>

                                </div>
                                    <br><br>

                                <div id="duration-table-div" class="table table-borderless">

                                </div>
                                
                                <div class="row">
                                    <div class="mb-1 col-md-9">
                                    </div>
                                    <div class="mb-1 col-md-1">
                                        <button type="reset" class="btn btn-primary">Reset</button>
                                    </div>
                                    <div class="mb-1 col-md-1">
                                        <button type="Submit" class="btn btn-success">Submit</button>
                                    </div>
                                    <div class="mb-1 col-md-5">
                                        
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>              

            <div class="row">
				<div class="col-md-6 d-flex">
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
                            <h6 class="card-title mb-0 float-start">Annual Leave</h6>
                        </div>
						<div class="card-body">
                            <table class="table table-borderless my-0" id="annual-leave-table">
                                <thead>
                                <tr>
                                    <th class="d-none d-xl-table-cell">Date</th>
                                    <th class="d-none d-xl-table-cell">Reason</th>
                                    <th></th>
                                    <th></th>
                                    <th>Status</th>
                                    <th class="d-none d-xl-table-cell text-end">Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                    <?php
                                        $leaveResult=$holidayObj->getLeaves($user_id);
                                        while ($leaveRow=$leaveResult->fetch_assoc()){
                                            if($leaveRow['leave_type']=='1'){

                                    ?>
                                <tr>
                                    <td class="d-none d-xl-table-cell">
                                        <div class="text-muted">
                                            <?php
                                                echo $date=$leaveRow['date'];
                                            ?>
                                        </div>
                                    </td>
                                    <td><?php echo $leaveRow['reason'];?></td>
                                    <td><?php
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
                                    <td class="d-none d-xl-table-cell text-end">
                                        <?Php
                                            $leave_id=$leaveRow["leave_id"];
                                            $leave_id=base64_encode($leave_id);
                                        ?>
                                        <a class="btn mb-2 btn-info" href="edit-leaves.php?leave_id=<?php echo $leave_id ?>"><i class="fas fa-edit"></i></a>
                                    </td>                                    
                                </tr>
                                <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
						</div>
					</div>
				</div>

				<div class="col-md-6 d-flex">
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
                            <h6 class="card-title mb-0 float-start">Casual Leave</h6>
                        </div>
						<div class="card-body">
                            <table class="table table-borderless my-0" id="casual-leave-table">
                                <thead>
                                <tr>
                                    <th class="d-none d-xl-table-cell">Date</th>
                                    <th class="d-none d-xl-table-cell">Reason</th>
                                    <th></th>
                                    <th></th>
                                    <th>Status</th>
                                    <th class="d-none d-xl-table-cell text-end">Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                    <?php
                                        $leaveResult=$holidayObj->getLeaves($user_id);
                                        while ($leaveRow=$leaveResult->fetch_assoc()){
                                            if($leaveRow['leave_type']=='2'){

                                    ?>
                                <tr>
                                    <td class="d-none d-xl-table-cell">
                                        <div class="text-muted">
                                            <?php
                                                echo $date=$leaveRow['date'];
                                            ?>
                                        </div>
                                    </td>
                                    <td><?php echo $leaveRow['reason'];?></td>
                                    <td><?php
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
                                    <td class="d-none d-xl-table-cell text-end">
                                        <?Php
                                            $leave_id=$leaveRow["leave_id"];
                                            $leave_id=base64_encode($leave_id);
                                        ?>
                                        <a class="btn mb-2 btn-info" href="edit-leaves.php?leave_id=<?php echo $leave_id ?>"><i class="fas fa-edit"></i></a>
                                    </td>                                    
                                </tr>
                                <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
						</div>
					</div>
				</div>
			</div>

            <div class="row">
				<div class="col-md-6 d-flex">
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
                            <h6 class="card-title mb-0 float-start">Sick Leave</h6>
                        </div>
						<div class="card-body">
                            <table class="table table-borderless my-0" id="sick-leave-table">
                                <thead>
                                <tr>
                                    <th class="d-none d-xl-table-cell">Date</th>
                                    <th class="d-none d-xl-table-cell">Reason</th>
                                    <th></th>
                                    <th></th>
                                    <th>Status</th>
                                    <th class="d-none d-xl-table-cell text-end">Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                    <?php
                                        $leaveResult=$holidayObj->getLeaves($user_id);
                                        while ($leaveRow=$leaveResult->fetch_assoc()){
                                            if($leaveRow['leave_type']=='3'){

                                    ?>
                                <tr>
                                    <td class="d-none d-xl-table-cell">
                                        <div class="text-muted">
                                            <?php
                                                echo $date=$leaveRow['date'];
                                            ?>
                                        </div>
                                    </td>
                                    <td><?php echo $leaveRow['reason'];?></td>
                                    <td><?php
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
                                    <td class="d-none d-xl-table-cell text-end">
                                        <?Php
                                            $leave_id=$leaveRow["leave_id"];
                                            $leave_id=base64_encode($leave_id);
                                        ?>
                                        <a class="btn mb-2 btn-info" href="edit-leaves.php?leave_id=<?php echo $leave_id ?>"><i class="fas fa-edit"></i></a>
                                    </td>                                    
                                </tr>
                                <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
						</div>
					</div>
				</div>

				<div class="col-md-6 d-flex">
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
                            <h6 class="card-title mb-0 float-start">Compensatory Leave</h6>
                        </div>
						<div class="card-body">
                            <table class="table table-borderless my-0" id="compensatory-leave-table">
                                <thead>
                                <tr>
                                    <th class="d-none d-xl-table-cell">Date</th>
                                    <th class="d-none d-xl-table-cell">Reason</th>
                                    <th></th>
                                    <th></th>
                                    <th>Status</th>
                                    <th class="d-none d-xl-table-cell text-end">Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                    <?php
                                        $leaveResult=$holidayObj->getLeaves($user_id);
                                        while ($leaveRow=$leaveResult->fetch_assoc()){
                                            if($leaveRow['leave_type']=='4'){

                                    ?>
                                <tr>
                                    <td class="d-none d-xl-table-cell">
                                        <div class="text-muted">
                                            <?php
                                                echo $date=$leaveRow['date'];
                                            ?>
                                        </div>
                                    </td>
                                    <td><?php echo $leaveRow['reason'];?></td>
                                    <td><?php
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
                                    <td class="d-none d-xl-table-cell text-end">
                                        <?Php
                                            $leave_id=$leaveRow["leave_id"];
                                            $leave_id=base64_encode($leave_id);
                                        ?>
                                        <a class="btn mb-2 btn-info" href="edit-leaves.php?leave_id=<?php echo $leave_id ?>"><i class="fas fa-edit"></i></a>
                                    </td>                                    
                                </tr>
                                <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
						</div>
					</div>
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

    var datesForDisable = <?php echo json_encode($days); ?>;
    //by default display calendar for annual leaves
    document.getElementById('date-sick').style.display = 'none';
    document.getElementById('date2-sick').style.display = 'none';

    //start date by default
    $("#date").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        weekStart: 1,
        todayHighlight: true,
        datesDisabled: datesForDisable,
        daysOfWeekDisabled: [0, 6],
        startDate: new Date()
    })

    //To date by default
    var datesForDisable2 = <?php echo json_encode($days); ?>;
    $("#date2").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        weekStart: 1,
        todayHighlight: true,
        datesDisabled: datesForDisable2,
        daysOfWeekDisabled: [0, 6],
        startDate: new Date()

    })

    $("#leave-type").change(function () {
        $("#date").val('');
        $("#date2").val('');
        $("#date-sick").val('');
        $("#date2-sick").val('');


        var leavetype=$("#leave-type").val();
        //alert(leavetype);

        if ((leavetype==1) || (leavetype==2)){ //annual and casual

            document.getElementById('date').style.display = 'block';
            document.getElementById('date-sick').style.display = 'none';

            document.getElementById('date2').style.display = 'block';
            document.getElementById('date2-sick').style.display = 'none';

            var datefrom = $("#date").val();
            var dateto = $("#date2").val();

            var DatePriorMonth = $("#DatePriorMonth").val();


            if(leavetype==2){//casual leave

                //date before a month
                $("#date").datepicker('setStartDate', DatePriorMonth);
                $("#date2").datepicker('setStartDate', DatePriorMonth);

            }else{//annual leave
                
                //dates since today
                $("#date").datepicker('setStartDate', new Date());
                $("#date2").datepicker('setStartDate', new Date());

            }

        }else{//sick

            var datefromSick = $("#date").val();
            var datetoSick = $("#date2").val();

            $("#date-sick").datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                weekStart: 1,
                todayHighlight: true,
                datesDisabled: datesForDisable,
                daysOfWeekDisabled: [0, 6]
            })

            $("#date2-sick").datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                weekStart: 1,
                todayHighlight: true,
                datesDisabled: datesForDisable2,
                daysOfWeekDisabled: [0, 6]
            })
            document.getElementById('date-sick').style.display = 'block';
            document.getElementById('date').style.display = 'none';

            document.getElementById('date2-sick').style.display = 'block';
            document.getElementById('date2').style.display = 'none';


        }

    });


    //If "from" date for annual/casual changes
    function dateChange() {
        var leavetype = $("#leave-type").val();
        var datefrom = $("#date").val();

        if(leavetype==0) {
            $("#alertDiv").html("Please select a valid leave type");
            $("#alertDiv").addClass("alert alert-danger");
            $("#date").val('');

        }else if(leavetype==1){
            var diff = Math.floor(
                (
                    Date.parse(datefrom) - Date.parse(document.getElementById("DateToday").value)
                ) / 86400000);
            //alert('Inluding weekend - '+diff)
            if (diff<7){
                $("#alertDiv").html("Annual leave has to be applied 7 days prior!");
                $("#alertDiv").addClass("alert alert-danger");
                $("#date").val('');
            }

        }else if(leavetype==2){

            var diff = Math.floor(
                (
                    Date.parse(datefrom) - Date.parse(document.getElementById("DateToday").value)
                ) / 86400000);
            //alert('Inluding weekend - '+diff)
            if (diff<2){
                $("#alertDiv").html("Casual leave has to be applied 2 days prior!");
                $("#alertDiv").addClass("alert alert-danger");
                $("#date").val('');
            }
        }
    }

    //If "from" date for sick changes
    function dateChange2() {
        var leavetype = $("#leave-type").val();

        if(leavetype==0) {
            $("#alertDiv").html("Please select a valid leave type");
            $("#alertDiv").addClass("alert alert-danger");
            $("#date2").val('');
        }
    }

    function loadSelectedLeaveDates(){
        var datefrom = $("#date").val();
        var dateto = $("#date2").val();

        const date1 = new Date(datefrom);
        const date2 = new Date(dateto);
        const diffTime = Math.abs(date2 - date1);
        const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));

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
    //If "to" date for annual/casual changes

    function ToDateChange() {
        var leavetype = $("#leave-type").val();
        //alert(leavetype)

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

        }else if(leavetype==0){
            $("#alertDiv").html("Please select a valid leave type");
            $("#alertDiv").addClass("alert alert-danger");
            $("#date2").val('');
            $("#date").val('');
            return false;

        }
        else if(leavetype==2){
            if(diffDays>3){
                $("#alertDiv").html("<b>Maximum &nbsp</b> &nbsp only 3 days can be selected for casual leave");
                $("#alertDiv").addClass("alert alert-danger");
                $("#date2").val('');
                return false;
            }else{
                loadSelectedLeaveDates(); //display all the leave dates
            }
        }
        else if(leavetype==1){
            if(diffDays<3){
                $("#alertDiv").html("<b>Minimum &nbsp</b>3 days should be selected for annual leave");
                $("#alertDiv").addClass("alert alert-danger");
                $("#date2").val('');
                return false;

            }else{
                loadSelectedLeaveDates(); //display all the leave dates

            }
        }
        else{
                loadSelectedLeaveDates(); //display all the leave dates

        }

    }

    //If "to" date for sick changes
    function ToDateChange2() {
        var leavetype = $("#leave-type").val();

        var datefrom = $("#date-sick").val();
        var dateto = $("#date2-sick").val();

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
        else if(leavetype==0){
            $("#alertDiv").html("Please select a valid leave type");
            $("#alertDiv").addClass("alert alert-danger");
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
        var leave_type=$("#leave-type").val();
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
        if ((leave_type==0)||(leave_type==1)||(leave_type==2)){ //on submit check if leaves dates are empty


            var CasualAnnualToDate=$("#date2").datepicker("getDate");
            var CasualAnnualFromDate=$("#date").datepicker("getDate");

            if(CasualAnnualToDate==null){
                $("#alertDiv").html("Leave date cannot be empty!!!");
                $("#alertDiv").addClass("alert alert-danger");
                return false;
            }
            if(CasualAnnualFromDate==null){
                $("#alertDiv").html("Leave date cannot be empty!!!");
                $("#alertDiv").addClass("alert alert-danger");
                return false;
            }

        }
        if (leave_type==3){//on submit check if leaves dates are empty

            var sickFromDate=$("#date-sick").datepicker("getDate");
            var sickToDate = $("#date2-sick").datepicker("getDate");

            if (sickToDate ==null) {

                    $("#alertDiv").html("Leave date cannot be empty!!!");
                    $("#alertDiv").addClass("alert alert-danger");
                    return false;
            }
            if(sickFromDate==null){
                $("#alertDiv").html("Leave date cannot be empty!!!");
                $("#alertDiv").addClass("alert alert-danger");
                return false;
            }


        }
    })

    $("#annual-leave-table").DataTable({
        pageLength: 3,
        lengthChange: false,
        bFilter: false,
        autoWidth: false,
        order: [
            [0, "desc"]
        ]
    });

    $("#casual-leave-table").DataTable({
        pageLength: 3,
        lengthChange: false,
        bFilter: false,
        autoWidth: false,
        order: [
            [0, "desc"]
        ]
    });

    $("#sick-leave-table").DataTable({
        pageLength: 3,
        lengthChange: false,
        bFilter: false,
        autoWidth: false,
        order: [
            [0, "desc"]
        ]
    });

    $("#compensatory-leave-table").DataTable({
        pageLength: 3,
        lengthChange: false,
        bFilter: false,
        autoWidth: false,
        order: [
            [0, "desc"]
        ]
    });


</script>

</body>

</html>