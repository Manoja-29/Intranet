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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
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

        $holiday=$holidayObj->fetchUpcomingHoliday();
        $holidayData=$holidayObj->getHolidayTotal();
        $holidayResult=$holidayObj->fetchUpcomingLeaves();

        $todayLeave = $holidayObj->getTodayLeave();

        $leaveCountResult=$holidayObj->getleaveFullOrHalfcount($user_id);
        $leaveCountRow=$leaveCountResult->fetch_assoc();

        include_once "../model/user-model.php";
        $userObj=new User();

        $userBasedResults=$userObj->getUserBasedAdditionalDetails($user_id);
        $userBasedRow=$userBasedResults->fetch_assoc();

        ?>
        <main class="content">
            <div class="row">
                <?php
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

            <?php 
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

                                    <h3 class="mb-2"><?php echo $TotAppliedLeaves ?></h3>
                                    <p class="mb-2">Applied Leaves</p>
                                    <div class="mb-0">
                                        <span class="badge badge-soft-danger me-2"><?php echo $TotalAppliedPercentage."%"?> </span>
                                        <span class="text-muted">Starting from <?php echo date("Y"); ?></span>
                                    </div>
                                </div>
                                <div class="d-inline-block ms-3">
                                    <div class="stat">
                                        <i class="align-middle text-danger" data-feather="briefcase"></i>
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
                                    <h3 class="mb-2"><?php echo $TotalAvailable ?></h3>
                                    <p class="mb-2">Available Leaves</p>
                                    <div class="mb-0">
                                        <span class="badge badge-soft-success me-2"><?php echo $TotAvailablePercentage."%"?> </span>
                                        <span class="text-muted">Starting from <?php echo date("Y"); ?></span>
                                    </div>
                                </div>
                                <div class="d-inline-block ms-3">
                                    <div class="stat">
                                        <i class="align-middle text-info" data-feather="check-circle"></i>
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
                                                        $sign = ($time_def > 0) ? '+' : '-';
                                                        $abs_time_diff = abs($time_def);
                                                        $hours = intdiv($abs_time_diff, 60);
                                                        $minutes = $abs_time_diff % 60;
                                                
                                                        $formatted_time = sprintf('%s%02d:%02d', $sign, $hours, $minutes);
                                                
                                                        echo '<span class="'.($time_def > 0 ? 'text-success' : 'text-danger').'">'.$formatted_time.'</span>';
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
                                                        $sign1 = ($time_def2 > 0) ? '+' : '-';
                                                        $abs_time_diff1 = abs($time_def2);
                                                        $hours1 = intdiv($abs_time_diff1, 60);
                                                        $minutes1 = $abs_time_diff1 % 60;
                                                
                                                        $formatted_time1 = sprintf('%s%02d:%02d', $sign1, $hours1, $minutes1);
                                                
                                                        echo '<span class="'.($time_def2 > 0 ? 'text-success' : 'text-danger').'">'.$formatted_time1.'</span>'; 
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
                            <?php 
                                
                            ?>
                            <div class="d-flex flex-column align-items-start mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="outer-circle1">
                                        <div class="inner-circle1" id="displayWatch">
                                            <span class="text1"><?php echo $initialAnnual ?></span>
                                        </div>
                                    </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="ml-3">
                                        <strong style="font-size:16px">Annual Leave</strong>
                                         <div class="text-muted text-sm" style="font-size:15px">Available <?php echo $availableAnnual . " Days(s)"?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-column align-items-start mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="outer-circle2">
                                        <div class="inner-circle1" id="displayWatch">
                                            <span class="text2"><?php echo $initialCasual ?></span>
                                        </div>
                                    </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="ml-3">
                                        <strong style="font-size:16px">Casual Leave</strong>
                                        <div class="text-muted text-sm" style="font-size:15px">Available <?php echo $availableCasual . " Day(s)"?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-column align-items-start mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="outer-circle3">
                                    <div class="inner-circle1" id="displayWatch">
                                        <span class="text3"><?php echo $initialSick ?></span>
                                    </div>
                                    </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="ml-3">
                                    <strong style="font-size:16px">Sick Leave</strong>
                                    <div class="text-muted text-sm" style="font-size:15px">Available <?php echo $availableSick . " Day(s)"?></div>
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
                                                    <?php 
                                                        $birthDate = date('m-d', strtotime($upcomingBirth['user_dob'])); 
                                                        $currentYearDate = date('Y') . '-' . $birthDate;
                                                        echo '<td class="text-center"><span style="color:blue;">' . date('l', strtotime($currentYearDate)) . '</span></td>'; 
                                                    ?>
													<td class="text-end"><?php echo $user_dob = date('jS F', strtotime($upcomingBirth['user_dob'])); ?></td>
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
                                    <table id="datatables-holiday" class="table" style="width:100%">
										<thead>
											<tr>
                                                <th>Holiday</th>
												<th class="text-center"></th>
												<th class="text-end">Date</th>
											</tr>
										</thead>
										<tbody>
                                        <?php
                                            while($upcomingHoliday=$holiday->fetch_assoc()){
                                        ?>
											<tr>
                                                <td><?php echo $upcomingHoliday['holiday_name']?></td>
												<td class="text-center"><?php echo date('l', strtotime($upcomingHoliday['date']));?></td>
												<td class="text-end"><?php echo date('jS F Y', strtotime($upcomingHoliday['date']));?></td>
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
								<h5 class="card-title mb-0">On Leave </h5>
							</div>

							<div class="card-body d-flex">
								<div class="align-self-center w-100">
                                    <div style="text-align: center;">
										<div class="chart chart-xs">
                                            <img src="../view/img/photos/leave.png" width="110" height="110" alt="birthday">
										</div>
									</div>
                                    <table id="datatables-holiday" class="table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Employee Name</th>
                                                <th class="text-center"></th>
                                                <th class="text-end"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $hasLeaveRecords = false;

                                            while($AllLeave = $todayLeave->fetch_assoc()){
                                                $hasLeaveRecords = true;
                                            ?>
                                                <tr>
                                                    <td><?php echo $AllLeave['user_fname']." ".$AllLeave['user_lname']; ?></td>
                                                    <td class="text-center"><span style="color:blue;">Today</span></td>
                                                    <td class="text-end"><?php  if($AllLeave["full_half_day"]==1){
                                                                                        echo 'Full Day';
                                                                                    }else{
                                                                                        echo 'Half Day';
                                                                                    }?>
                                                    </td>
                                                </tr>
                                            <?php 
                                            }
                                            if (!$hasLeaveRecords) {
                                            ?>
                                                <tr>
                                                    <td colspan="3" class="text-center">No any leaves</td>
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
                                            <?php
                                                $annualPercentage = $initialAnnual > 0 ? round(($Annual / $initialAnnual) * 100, 2) : 0;
                                                $casualPercentage = $initialCasual > 0 ? round(($casual / $initialCasual) * 100, 2) : 0;
                                                $sickPercentage = $initialSick > 0 ? round(($sick / $initialSick) * 100, 2) : 0;

                                                if($Annual > $initialAnnual) {
                                                    $annualPercentage = $initialAnnual > 0 ? -round((($Annual - $initialAnnual) / $initialAnnual) * 100, 2) : 0;
                                                }
                                                if($casual > $initialCasual) {
                                                    $casualPercentage = $initialCasual > 0 ? -round((($casual - $initialCasual) / $initialCasual) * 100, 2) : 0;
                                                }
                                                if($sick > $initialSick) {
                                                    $sickPercentage = $initialSick > 0 ? -round((($sick - $initialSick) / $initialSick) * 100, 2) : 0;
                                                }
                                            ?>
                                           
											<tr>
												<td><i class="fas fa-square-full text-primary"></i> Annual</td>
												<td class="text-end"><?php echo $Annual ?></td>
												<td class="text-end <?php echo $annualPercentage < 0 ? 'text-danger' : 'text-success'; ?>">
                                                <?php
                                                        echo $annualPercentage . '%';
                                                    ?>
                                                </td>
											</tr>
											<tr>
												<td><i class="fas fa-square-full text-warning"></i> Casual</td>
												<td class="text-end"><?php echo $applyCasual ?></td>
                                                <td class="text-end <?php echo $casualPercentage < 0 ? 'text-danger' : 'text-success'; ?>">
                                                    <?php
                                                        echo $casualPercentage . '%';
                                                    ?>
                                                </td>
											</tr>
											<tr>
												<td><i class="fas fa-square-full text-danger"></i> Sick</td>
												<td class="text-end"><?php echo $sick ?></td>
                                                <td class="text-end <?php echo $sickPercentage < 0 ? 'text-danger' : 'text-success'; ?>">
                                                <?php
                                                    echo $sickPercentage . '%';
                                                ?>
                                                </td>
											</tr>
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
        autoWidth: false,
        order: [
            [0, "desc"]
        ]
    });

    $("#datatables-leave").DataTable({
        pageLength: 3,
        lengthChange: false,
        bFilter: false,
        autoWidth: false
    });

    $("#datatables-holiday").DataTable({
        pageLength: 2,
        lengthChange: false,
        bFilter: false,
        autoWidth: false,
        order: [
            [2, "asc"]
        ]
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
        var annualApplied = <?php echo $Annual; ?>;
        var casualApplied = <?php echo $applyCasual; ?>;
        var sickApplied = <?php echo $sick; ?>;

        new Chart(document.getElementById("chartjs-dashboard-pie"), {
            type: "pie",
            data: {
                labels: ["Annual", "Casual", "Sick"],
                datasets: [{
                    data: [
                        annualApplied || 0,
                        casualApplied || 0,
                        sickApplied || 0
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


</body>

</html>
