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
    <link href="css/light.css" rel="stylesheet">
    <link href="css/clock.css" rel="stylesheet">

</head>


<body data-theme="colored" data-layout="fluid" data-sidebar-position="left" data-sidebar-behavior="sticky">
<div class="wrapper">
    <?php
    include_once "sidebar.php";
    ?>
    <div class="main">
        <?php
        include_once "topbar.php";
        include '../model/attendance_model.php';
        $attendanceObj=new Attendance();
        /*Insert a row for attendance*/


        date_default_timezone_set('Asia/Colombo');
        $logged_userId=$_SESSION['user']['user_id'];

        $userObj=new User();
        $userResult= $userObj->viewUser($logged_userId);
        $userRow=$userResult->fetch_assoc();

        $birthResult = $userObj->getUpcomingBirthday();
        $todayBirth = $userObj->getTodayBirthday();

        $dateToday=date("Y-m-d");

        $checkedout=$attendanceObj->CheckUserAttendance($logged_userId,$dateToday);
        if($checkedout == true){
            /*insert*/
            $signedIn=$attendanceObj->addAttendance($logged_userId,$dateToday);

        }
        $attendanceResult=$attendanceObj->getUserSpecificAttendance($logged_userId);

        include "../model/holiday-leave-model.php";
        $holidayObj=new HolidayLeave();

        $holidayData=$holidayObj->getHolidayTotal();
        $holidayResult=$holidayObj->fetchUpcomingLeaves();

        $leaveData = $holidayObj->getLeaveData($user_id);
        $leaveDetails = $holidayObj->getLeaveDistribution($user_id);
        /*end*/
        ?>
        <main class="content">
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
                        <h3>Dashboard</h3>
                    </div>

                    <div class="col-auto ms-auto text-end mt-n1">
                        <div class="dropdown me-2 d-inline-block position-relative">
                            <div id="checked-in" style="padding: 5px 15px 5px 15px"></div>
                        </div>
                        <div class="dropdown me-2 d-inline-block position-relative">
                            <div id="users-present"></div>
                        </div>
                        <div class="dropdown me-2 d-inline-block position-relative">
                            <div id="users-absent"></div>
                        </div>

                        <div class="dropdown me-2 d-inline-block position-relative">
                            <a class="btn btn-light bg-white shadow-sm" href="#"  >
                                <i class="align-middle mt-n1" data-feather="calendar"></i> Today
                            </a>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-6 col-xxl-3 d-flex">
                        <div class="card illustration flex-fill">
                            <div class="card-body p-0 d-flex flex-fill">
                                <div class="row g-0 w-100">
                                    <div class="col-7">
                                        <div class="illustration-text p-3 m-1">
                                            <h4 class="illustration-text">Welcome Back, <?php echo $userRow['user_fname']?></h4>
                                            <p class="mb-0">Intranet Dashboard</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-sm-6 col-xxl-3 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-4">
                                <div class="d-flex align-items-start">
                                    <div class="flex-grow-1">
                                        <h3 class="mb-2"><?php echo $holidayData["holidayCount"];?></h3>
                                        <p class="mb-2">Holidays</p>
                                        <div class="mb-0">
                                            <span class="badge badge-soft-success me-2"><?php echo $holidayData['holidayPercentage'] . "%"?> </span>
                                            <span class="text-muted"> <?php echo date("Y"); ?> Holiday Count</span>
                                        </div>
                                    </div>
                                    <div class="d-inline-block ms-3">
                                        <div class="stat">
                                            <i class="align-middle text-success" data-feather="calendar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-xxl-3 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-4">
                                <div class="d-flex align-items-start">
                                    <div class="flex-grow-1">
                                        <h3 class="mb-2"><?php echo $leaveData['appliedLeave'];?></h3>
                                        <p class="mb-2">Applied Leaves</p>
                                        <div class="mb-0">
                                            <span class="badge badge-soft-danger me-2"><?php echo $leaveData['appliedLeavePercentage']."%"?> </span>
                                            <span class="text-muted">Starting from <?php echo date("Y"); ?></span>
                                        </div>
                                    </div>
                                    <div class="d-inline-block ms-3">
                                        <div class="stat">
                                            <i class="align-middle text-danger" data-feather="check-circle"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-xxl-3 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-4">
                                <div class="d-flex align-items-start">
                                    <div class="flex-grow-1">
                                        <h3 class="mb-2"><?php echo $leaveData['availableLeaves'];?></h3>
                                        <p class="mb-2">Available Leaves</p>
                                        <div class="mb-0">
                                            <span class="badge badge-soft-success me-2"><?php echo $leaveData['availableLeavePercentage']."%"?> </span>
                                            <span class="text-muted">Starting from <?php echo date("Y"); ?></span>
                                        </div>
                                    </div>
                                    <div class="d-inline-block ms-3">
                                        <div class="stat">
                                            <i class="align-middle text-info" data-feather="activity"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                            <h5 class="card-title mb-0">Work Hours</h5>
                        </div>
                        <div class="outer-circle">
                            <div class="inner-circle" id="displayWatch">
                                <span class="text hour" id="hour">00 :&nbsp;</span>
                                <span class="text minute" id="minute"> 00 :&nbsp;</span>
                                <span class="text sec" id="second"> 00</span>
                                <div class="time-label">Hrs</div>
                            </div>
                        </div>
                        <table style="margin-top: 10px; margin-left: 50px; margin-bottom:30px">
                            <thead>
                                <th>Today :</th>
                                <th>Checked In :</th>
                            </thead>
                            <tbody>
                                <td><?php echo date(' jS F Y'); ?></td>
                                <td id="currentTime"> </td>
                            </tbody>
                        </table>
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
                                    <h5 class="card-title mb-0">Attendance</h5>
                                </div>
                                <div class="card-body">
                                    <table id="datatables-attendance" class="table" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Check In</th>
                                            <th>Check Out</th>
                                            <th>Entry</th>
                                            <th>Exit</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        while ($OrderRow=$attendanceResult->fetch_assoc()){
                                            ?>
                                            <tr>
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
                                                <td>
                                                    <?php
                                                    date_default_timezone_set('Asia/Colombo');
                                                    $check_in=$OrderRow["check_in"];
                                                    $time1 = strtotime('08:00 AM');
                                                    $time2 = strtotime($OrderRow["check_in"]);
                                                    $time_def = ($time1-$time2)/60; //minutes
                                                    //
                                                    if ($check_in == ''){
                                                        echo '<span class="text-danger">Absent</span>';
                                                    }else{
                                                        if ($time_def>1) {
                                                            echo '<span class="text-success">+'. intdiv($time_def, 60).'H +'. ($time_def % 60).'M'.'</span>';
                                                        }else{
                                                            echo '<span class="text-danger">'. intdiv($time_def, 60).'H '. ($time_def % 60).'M'.'</span>';

                                                        }
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    date_default_timezone_set('Asia/Colombo');

                                                    $check_out=$OrderRow["check_out"];
                                                    $time3 = strtotime('05:00 PM');
                                                    $time4 = strtotime($OrderRow["check_out"]);
                                                    $time_def2 = ($time4-$time3)/60;

                                                    if ($check_out == ''){
                                                        echo '<span class="text-danger">Absent</span>';
                                                    }else {
                                                        if ($time_def2 > 1) {
                                                            echo '<span class="text-success">+' . intdiv($time_def2, 60) . 'H +' . ($time_def2 % 60) . 'M' . '</span>';
                                                        } else {
                                                            echo '<span class="text-danger">' . intdiv($time_def2, 60) . 'H ' . ($time_def2 % 60) . 'M' . '</span>';

                                                        }
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
                                <h5 class="card-title mb-0">Leave Report</h5>
                            </div>
                            <div class="d-flex flex-column align-items-start mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="outer-circle1">
                                        <div class="inner-circle1" id="displayWatch">
                                            <span class="text1"><?php echo $leaveDetails['annualLeave']?></span>
                                        </div>
                                    </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="ml-3">
                                        <strong style="font-size:16px">Annual Leave</strong>
                                        <div class="text-muted text-sm" style="font-size:15px">Available <?php echo $leaveDetails['availableAnnual']." Day(s)"?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-column align-items-start mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="outer-circle2">
                                        <div class="inner-circle1" id="displayWatch">
                                            <span class="text2"><?php echo $leaveDetails['casualLeave']?></span>
                                        </div>
                                    </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="ml-3">
                                        <strong style="font-size:16px">Casual Leave</strong>
                                        <div class="text-muted text-sm" style="font-size:15px">Available <?php echo $leaveDetails['availableCasual']." Day(s)"?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-column align-items-start mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="outer-circle3">
                                    <div class="inner-circle1" id="displayWatch">
                                        <span class="text3"><?php echo $leaveDetails['sickLeave']?></span>
                                    </div>
                                    </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="ml-3">
                                    <strong style="font-size:16px">Sick Leave</strong>
                                    <div class="text-muted text-sm" style="font-size:15px">Available <?php echo $leaveDetails['availableSick']." Day(s)"?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
                                <h5 class="card-title mb-0">Birthdays</h5>
                            </div>      
                                <div class="card-body d-flex">
									<div class="align-self-center w-100">										
										<div style="text-align: center;">
                                        <?php 
                                            $today = date('Y-m-d'); 
                                            $todayResult = $todayBirth->fetch_assoc();

                                           /* if (!$todayResult) {
                                                echo "<p>No results from query.</p>";
                                            } else {
                                                echo "<p>Fetched Result: " . print_r($todayResult, true) . "</p>";
                                            }*/

                                            if ($todayResult) {

                                                $dobWithoutYear = $todayResult['dob_without_year'];
                                                $todayMonthDay = date('m-d');

                                                if ($dobWithoutYear == $todayMonthDay) {
                                                    ?>
                                                    <img src="../view/img/user_images/<?php echo $todayResult["user_image"]; ?>" width="150" height="150" class="rounded-circle my-n1" alt="Avatar"> 
                                                    <div class="text-muted text-sm mt-4" style="font-size:20px">
                                                    🎉Today is <?php echo $todayResult['user_fname'] ."'s". " Birthday !🎉"; ?>
                                                    </div>
                                                    <?php 
                                                }
                                            } else {
                                            ?>
                                            <img src="../view/img/photos/balloons.png" width="100" height="110" alt="birthday">
                                                    <div class="text-muted text-sm mt-4" style="font-size:20px">No Birthdays Today</div>
                                                <?php 
                                                    }
                                                ?>
										</div>

										<table class="table mb-1 mt-2">
											<thead>
												<tr>
													<th><strong style="font-size:14px">Upcoming</strong></th>
												</tr>
											</thead>                                                       
											<tbody>
                                            <?php 
                                                while($upcomingBirth = $birthResult->fetch_assoc() ){
                                            ?>
												<tr>
													<td><?php echo $user_fname=$upcomingBirth['user_fname'] . " " . $user_lname=$upcomingBirth['user_lname'];?></td>
                                                    <td class="text-center"><?php echo '<span style="color:blue;">'.$user_dob = date('l', strtotime($upcomingBirth['user_dob'])); ?></td>
													<td class="text-end"><?php echo $user_dob = date('F jS', strtotime($upcomingBirth['user_dob'])); ?></td>
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
								<h5 class="card-title mb-0">Upcoming Holidays</h5>
							</div>

							<div class="card-body d-flex">
								<div class="align-self-center w-100">
                                    <div style="text-align: center;">
										<div class="chart chart-xs">
                                            <img src="../view/img/photos/party.png" width="110" height="110" alt="birthday">
										</div>
									</div>
									<table class="table mb-0">
										<thead>
											<tr>
												<th>Leave Type</th>
												<th class="text-end">Days</th>
												<th class="text-end">Percentage</th>
											</tr>
										</thead>
									    <tbody>
											<tr>
												<td><i class="fas fa-square-full text-primary"></i> Annual</td>
												<td class="text-end"><?php echo $leaveDetails['annualApplied']?></td>
												<td class="text-end <?php echo $leaveDetails['annualLeavePercentage'] < 0 ? 'text-danger' : 'text-success'; ?>">
                                                    <?php echo $leaveDetails['annualLeavePercentage'].'%'?>
                                                </td>
											</tr>
											<tr>
												<td><i class="fas fa-square-full text-warning"></i> Casual</td>
												<td class="text-end"><?php echo $leaveDetails['casualApplied']?></td>
                                                <td class="text-end <?php echo $leaveDetails['casualLeavePercentage'] < 0 ? 'text-danger' : 'text-success'; ?>">
                                                    <?php echo $leaveDetails['casualLeavePercentage'].'%'?>
                                                </td>
											</tr>
											<tr>
												<td><i class="fas fa-square-full text-danger"></i> Sick</td>
												<td class="text-end"><?php echo $leaveDetails['sickApplied']?></td>
                                                <td class="text-end <?php echo $leaveDetails['sickLeavePercentage'] < 0 ? 'text-danger' : 'text-success'; ?>">
                                                    <?php echo $leaveDetails['sickLeavePercentage'].'%'?>
                                                </td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
                </div>

                <div class="row">
                    <div class="col-12 col-xl-4 d-none d-xl-flex">
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
								<h5 class="card-title mb-0">Applied Leaves</h5>
							</div>

							<div class="card-body d-flex">
								<div class="align-self-center w-100">
									<div class="py-3">
										<div class="chart chart-xs">
											<canvas id="chartjs-dashboard-pie"></canvas>
										</div>
									</div>
									<table class="table mb-0">
										<thead>
											<tr>
												<th>Leave Type</th>
												<th class="text-end">Days</th>
												<th class="text-end">Percentage</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><i class="fas fa-square-full text-primary"></i> Annual</td>
												<td class="text-end"><?php echo $leaveDetails['annualApplied']?></td>
												<td class="text-end <?php echo $leaveDetails['annualLeavePercentage'] < 0 ? 'text-danger' : 'text-success'; ?>">
                                                    <?php echo $leaveDetails['annualLeavePercentage'].'%'?>
                                                </td>
											</tr>
											<tr>
												<td><i class="fas fa-square-full text-warning"></i> Casual</td>
												<td class="text-end"><?php echo $leaveDetails['casualApplied']?></td>
                                                <td class="text-end <?php echo $leaveDetails['casualLeavePercentage'] < 0 ? 'text-danger' : 'text-success'; ?>">
                                                    <?php echo $leaveDetails['casualLeavePercentage'].'%'?>
                                                </td>
											</tr>
											<tr>
												<td><i class="fas fa-square-full text-danger"></i> Sick</td>
												<td class="text-end"><?php echo $leaveDetails['sickApplied']?></td>
                                                <td class="text-end <?php echo $leaveDetails['sickLeavePercentage'] < 0 ? 'text-danger' : 'text-success'; ?>">
                                                    <?php echo $leaveDetails['sickLeavePercentage'].'%'?>
                                                </td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
                    
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

                    <div class="col-12 col-xl-4 d-none d-xl-flex">
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
									<h5 class="card-title mb-0">Upcoming Leaves</h5>
								</div>
								<div class="card-body d-flex">
									<div class="align-self-center w-100">
                                    <div style="text-align: center;">
											<div class="chart chart-xs">
                                            <img src="../view/img/photos/leave.png" width="110" height="110" alt="birthday">
											</div>
										</div>
                                        <table id="datatables-leave" class="table" style="width:100%">
											<thead>
												<tr>
													<th>Employee Name</th>
													<th class="text-end">Date</th>
												</tr>
											</thead>
											<tbody>
                                            <?php
                                                while($upcomingLeave = $holidayResult->fetch_assoc()){
                                            ?>
												<tr>
													<td><?php echo $upcomingLeave['user_fname'].' '.$upcomingLeave['user_lname']?></td>
													<td class="text-end"><?php 
                                                    echo date('l, jS F', strtotime($upcomingLeave['date']));?></td>
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
<script src="js/attendanceValidation.js"></script>

<script>

    $("#datatables-attendance").DataTable({
        pageLength: 5,
        lengthChange: false,
        bFilter: false,
        autoWidth: false
    });

    $("#datatables-leave").DataTable({
        pageLength: 3,
        lengthChange: false,
        bFilter: false,
        autoWidth: false
    });

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
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        $("#datetimepicker-dashboard").datetimepicker({
            inline: true,
            sideBySide: false,
            format: "L"
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var leaveDetails = <?php echo json_encode($leaveDetails); ?>;

        new Chart(document.getElementById("chartjs-dashboard-pie"), {
            type: "pie",
            data: {
                labels: ["Annual", "Casual", "Sick"],
                datasets: [{
                    data: [
                        leaveDetails.annualLeavePercentage || 0,
                        leaveDetails.casualLeavePercentage || 0,
                        leaveDetails.sickLeavePercentage || 0
                    ],
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
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        $("#datatables-dashboard-projects").DataTable({
            pageLength: 5,
            lengthChange: false,
            bFilter: false,
            autoWidth: false
        });
    });
</script>


</body>

</html>
