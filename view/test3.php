<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 5 Admin &amp; Dashboard Template">
    <meta name="author" content="Bootlab">

    <title>Attendance | AppStack - Bootstrap 5 Admin &amp; Dashboard Template</title>
    <link rel="canonical" href="https://appstack.bootlab.io/pages-clients.html" />
    <link rel="shortcut icon" href="img/favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="css/light.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

    <style>
        .previous {
            color: black;
            font-weight: bold;
            font-size: 30px;
        }

        .next {
            color: black;
            font-weight: bold;
            font-size: 30px;
        }

        .week-attendance {
            text-align: center;
            background-color: #f9fafc;
            display: flex; 
            align-items: center; 
            justify-content: center; 
            padding: 10px; 
        }

        .week-attendance span {
            font-size: 18px;
            margin: 0 10px; 
        }
    
        .present-bg {
            background-color: #46d492;
        }

        .absent-bg {
            background-color: #e86f6f;
        }

        .pending-bg {
            background-color: #D3D3D3;
        }

        .holiday-bg {
            background-color: #cf7fdb;
        }
       
        .weekend-bg {
            background-color: #f7eb83;
        }
    
    </style>

</head>

<body data-theme="colored" data-layout="fluid" data-sidebar-position="left" data-sidebar-behavior="sticky">
<div class="wrapper">
    <?php
    include_once "sidebar.php";
    include "../model/attendance_model.php";
    $user_id=$_SESSION['user']['user_id'];

    date_default_timezone_set('Asia/Colombo');
    $logged_userId=$_SESSION['user']['user_id'];

    $userObj=new User();
    $userResult= $userObj->viewUser($logged_userId);
    $userRow=$userResult->fetch_assoc();

    $attendanceObj=new Attendance();

    $attendanceResult=$attendanceObj->getUserSpecificAttendance($user_id);
    $weekResult=$attendanceObj->getUserWeekAttendance($user_id);

    $presentDays=$attendanceObj->getUserAttendanceforMonth($user_id);

    include "../model/employee_model.php";
    $employeeObj=new Employee();

    include "../model/holiday-leave-model.php";
        $holidayObj=new HolidayLeave();
        $holiday=$holidayObj->fetchUpcomingHoliday();

        $holidayCount=$holidayObj->checkCurrentMonthHoliday();  
        $leaveCount=$holidayObj->checkCurrentMonthLeaves($user_id);
        //$checkHoliday=$holidayObj->checkTodayHoliday();
        $checkHoliday=$holidayObj->getHolidays();
 
        $holidays = [];
        while ($holiday1 = $checkHoliday->fetch_assoc()) {
            $holidays[] = (new DateTime($holiday1['date']))->format('Y-m-d');
        }
    ?>
    <div class="main">
        <?php
        include_once "topbar.php";
        ?>
        <main class="content">
            <div class="container-fluid p-0">
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

                            <div class="col-md-12">
                                <div id="alertDiv"></div> 
                            </div>
                        </div>

                        <div class="row mb-2 mb-xl-3">
                            <div class="col-auto d-none d-sm-block">
                                <h3>Attendance</h3>
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
                            </div>
                        </div>

                        <div class="card">
                            <div class="week-attendance">
                                <a href="#" class="previous" onclick="changeWeek(-1)" style="text-decoration:none; display:inline-block; padding: 8px 16px; background-color: transparent;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='transparent';"> &lt; </a>
                                <span id="dateRange">Loading...</span>
                                <a href="#" class="next" onclick="changeWeek(1)" style="text-decoration:none; display:inline-block; padding: 8px 16px; background-color: transparent;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='transparent';"> &gt; </a>
                            </div>

                            <div id="weekDates">Loading attendance...</div>

                            <div class="card-body">
                            <table id="datatables-thisWeek" class="table" style="">
                                <thead>
                                    <tr>
                                        <th width="80"></th>
                                        <th width="90">Check-in</th>
                                        <th></th>
                                        <th width="100">Check Out</th>
                                        <th width="110">Total Hours</th>
                                    </tr>
                                </thead>
                                 <tbody>
                                   <?php 
                                    $daysOfWeek = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']; 
                                    $weekAttendance = []; 
                                    $today = new DateTime(); // Current date
                                    
                                    foreach ($weekResult as $row) {
                                        $date = new DateTime($row['date']);
                                        $weekAttendance[$date->format('D')] = $row; // Map attendance to the day
                                    }
                                    
                                    foreach ($daysOfWeek as $day) {
                                        // Determine the date for this day in the current week
                                        $date = new DateTime();
                                        $dayOfWeek = $date->format('N'); // Get the current day of the week (1 = Monday, 7 = Sunday)
                                        $offset = array_search($day, $daysOfWeek) - ($dayOfWeek - 1);
                                        $currentDayDate = $date->modify("$offset days"); // Store DateTime object
                                    
                                        // Format the date as '10, Thu'
                                        $formattedDate = $currentDayDate->format('j, D'); // 'j' gives day of the month without leading zeros, 'D' gives abbreviated day name
                                    
                                        // Continue your existing logic to render rows...
                                    ?>
                                        <tr>
                                            <td width="80"><strong><?php echo $formattedDate; ?></strong></td>
                                            <td width="90"><?php echo $formattedCheckIn; ?></td>
                                            <td>
                                                <div class="progress" style="height:2px;">
                                                    <div class="progress-bar <?php echo $progressBarClass; ?>" style="width: 100%;">
                                                    </div>
                                                </div>
                                            </td>
                                            <td width="100"><?php echo $formattedCheckOut; ?></td>
                                            <td width="110"><strong><?php echo $totHours; ?> Hrs</strong></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    
                                </tbody> 
                            </table>
                                <div class="d-flex ml-9">
                                    <div style="border-left: 10px solid #46d492; height: 25px;"></div>&nbsp;
                                    <P>Present</P>
                                    <div style="border-left: 10px solid #e86f6f; height: 25px; margin-left:25px;"></div>&nbsp;
                                    <P>Absent</P>
                                    <div style="border-left: 10px solid #cf7fdb; height: 25px; margin-left:25px;"></div>&nbsp;
                                    <P>Holiday</P>
                                    <div style="border-left: 10px solid #f7eb83; height: 25px; margin-left:25px;"></div>&nbsp;
                                    <P>Weekend</P>
                                </div>
                            </div>
                        </div>

                    <div class="row">
                        <div class="col-lg-6 col-xxl-4">
							<div class="card">
								<div class="card-header">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grow-1">
                                            <?php 
                                                $currentMonth = date('n');
                                                $currentYear = date('Y');
                                                $noOfDays = cal_days_in_month(CAL_GREGORIAN, $currentMonth,$currentYear);

                                                $workDays = 0;
                                                
                                                for($day=1; $day <= $noOfDays; $day++){
                                                    // Get the timestamp for the current day
                                                    $timestamp = strtotime("$currentYear-$currentMonth-$day");
                                                    $day_of_week = date('w', $timestamp);

                                                    // Check if it's a weekday (Monday to Friday)
                                                    if ($day_of_week != 0 && $day_of_week != 6) {
                                                        $workDays++;
                                                    }
                                                }
                    
                                                $totWorkDays = $workDays - $holidayCount;
                                                $rate = round(($presentDays / $totWorkDays) * 100, 1);
                                            ?>
                                            <h3 class="mt-2">&nbsp;Attendance Rate</h3>
                                           <p style="font-size:17px; color:#7c7cd6;">&nbsp;<?php echo date('F Y') ?></p>
                                        </div>
                                        <div class="d-inline-block mt-1">
                                            <div class="stat" style="height: 77px; width: 77px;  display: flex; justify-content: center; align-items: center;">
                                                <h3 style="color: blue; font-size: 22px; margin: 0;"><?php echo $rate.'%'?></h3>
                                            </div>
                                        </div>
                                    </div>
								</div>
                                <div class="card-body">
                                    <dl class="row justify-content-center" style="row-gap: 5px; font-size:15px;">
                                        <div class="d-flex justify-content-between">
                                            <dt class="col-6 text-end"><strong>Total Days Present:</strong></dt>
                                            <dd class="col-6 text-start" style="margin-left: 20px;"><?php  echo $presentDays.' Day(s)'?></dd>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <dt class="col-6 text-end"><strong>Total Days Holiday:</strong></dt>
                                            <dd class="col-6 text-start" style="margin-left: 20px;"><?php echo $holidayCount.' Day(s)'?></dd>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <dt class="col-6 text-end mb-1"><strong>Total Days On Leave:</strong></dt>
                                            <dd class="col-6 text-start" style="margin-left: 20px;"><?php  echo $leaveCount.' Day(s)'?></dd>
                                        </div>
                                    </dl>
                                </div>
							</div>

							<div class="card">
                            <div class="card-header">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grow-1">
                                            <h3 class="mb-0 mt-1">&nbsp;Upcoming Holidays</h3>
                                        </div>
                                        <div class="d-inline-block ms-3 mt-1">
                                            <img src="../view/img/photos/party.png" width="50" height="50" alt="birthday">
                                        </div>
                                    </div>
								</div>
								<div class="card-body">
                                <table id="datatables-holiday" class="table">
                                    <thead>
                                        <tr>
                                            <th>Holiday Name</th>
                                            <th class="text-center"></th>
                                            <th class="text-end"></th>
                                        </tr>
                                    </thead>
                                    <tbody>              
                                        <?php 
                                            while($upcomingHoliday = $holiday->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><?php echo $upcomingHoliday['holiday_name']; ?></td>
                                            <td class="text-center"><?php echo date('l', strtotime($upcomingHoliday['date'])); ?></td>
                                            <td class="text-end"><?php echo date('jS F Y', strtotime($upcomingHoliday['date'])); ?></td>
                                        </tr>
                                        <?php 
                                            }
                                        ?>
                                    </tbody>
                                </table>
								</div>
							</div>
						</div>

						<div class="col-lg-6 col-xxl-8">
							<div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-5">
                                            <p>From :</p>
                                            <input type="date" value="01-06-2017" max="<?php echo date("Y-m-d") ?>" class="form-control" name="payDate" id="startDate">
                                        </div>
                                        <div class="col-5">
                                            <p>To :</p>
                                            <input type="date" value="01-06-2017" max="<?php echo date("Y-m-d") ?>" class="form-control" name="payDate" id="endDate">
                                        </div>
                                        <div class="col-1">
                                            <input type="hidden" value="<?php echo $user_id?>" name="user_id" id="user_id">
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
                                                <th>Edit Status</th>
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
                                                        /*if ($time_def>1) {
                                                            echo '<span class="text-success">+'. intdiv($time_def, 60).'H +'. ($time_def % 60).'M'.'</span>';
                                                        }else{
                                                            echo '<span class="text-danger">'. intdiv($time_def, 60).'H '. ($time_def % 60).'M'.'</span>';

                                                        }*/
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
                                                        /*if ($time_def2 > 1) {
                                                            echo '<span class="text-success">+' . intdiv($time_def2, 60) . 'H +' . ($time_def2 % 60) . 'M' . '</span>';
                                                        } else {
                                                            echo '<span class="text-danger">' . intdiv($time_def2, 60) . 'H ' . ($time_def2 % 60) . 'M' . '</span>';

                                                        }*/
                                                        $sign1 = ($time_def2 > 0) ? '+' : '-';
                                                        $abs_time_diff1 = abs($time_def2);
                                                        $hours1 = intdiv($abs_time_diff1, 60);
                                                        $minutes1 = $abs_time_diff1 % 60;
                                                
                                                        $formatted_time1 = sprintf('%s%02d:%02d', $sign1, $hours1, $minutes1);
                                                
                                                        echo '<span class="'.($time_def2 > 0 ? 'text-success' : 'text-danger').'">'.$formatted_time1.'</span>'; 
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $updatestatus=$OrderRow["update_status"];
                                                    if ($updatestatus==1){
                                                        ?>
                                                        <span class="fas fa-circle chat-offline"></span><span class="text-white">Y</span>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <span class="fas fa-circle chat-online"> </span>

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
   function changeWeek(direction) {
    currentWeekOffset += direction;
    updateDateRange();
    fetchAttendanceData(currentWeekOffset); // Fetch updated attendance data
}

function fetchAttendanceData(weekOffset) {
    // Send AJAX request to get attendance data for the specific week
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `fetchAttendance.php?offset=${weekOffset}`, true);
    xhr.onload = function() {
        if (this.status === 200) {
            // Assuming the server returns a JSON object with 'weekResult'
            const response = JSON.parse(this.responseText);
            updateAttendanceTable(response.weekResult); // Call function to update table
        }
    };
    xhr.send();
}

function updateAttendanceTable(weekResult) {
    const tableBody = document.querySelector('#datatables-thisWeek tbody');
    tableBody.innerHTML = ''; // Clear existing rows

    const daysOfWeek = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']; 
    const today = new Date(); // Current date

    // Loop through days of the week to build rows
    daysOfWeek.forEach(day => {
        const date = new Date();
        const dayOfWeek = date.getDay();
        const offset = daysOfWeek.indexOf(day) - (dayOfWeek - 1);
        const currentDayDate = new Date(date);
        currentDayDate.setDate(date.getDate() + offset);

        const formattedDate = currentDayDate.toISOString().split('T')[0]; // Format date to YYYY-MM-DD

        let formattedCheckIn = '-', formattedCheckOut = '-', totHours = '-', progressBarClass = '';
        if (weekResult[formattedDate]) {
            const row = weekResult[formattedDate];
            formattedCheckIn = row.check_in || '-';
            formattedCheckOut = row.check_out || '-';
            // Calculate total hours and determine attendance status...
        }
        // Insert row into table
        const rowHTML = `
            <tr>
                <td width="80"><strong>${formattedDate}</strong></td>
                <td width="90">${formattedCheckIn}</td>
                <td>
                    <div class="progress" style="height:2px;">
                        <div class="progress-bar ${progressBarClass}" style="width: 100%;"></div>
                    </div>
                </td>
                <td width="100">${formattedCheckOut}</td>
                <td width="110"><strong>${totHours} Hrs</strong></td>
            </tr>`;
        tableBody.innerHTML += rowHTML;
    });
}

// Call this function in the onload event or after fetching the initial attendance data
window.onload = function() {
    updateDateRange();
    fetchAttendanceData(currentWeekOffset); // Fetch the initial attendance data
};

</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Datatables clients
        $("#datatables-attendance").DataTable({
            responsive: true,
            pageLength: 7,
            order: [
                [0, "desc"]
            ],
            dom: 'Bfrtip',

            buttons: [
                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    title: 'Attendance Report : ' + new Date().toDateString(),
                    download: 'open',
                    exportOptions: {
                        columns: [ 0, ':visible' ]
                    },
                    filename: 'Attendance Report : ' + new Date().toDateString(),
                    customize: function ( doc ) {

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
                    title: 'Attendance Report : ' + new Date().toDateString(),
                    autoFilter: true,
                    download: 'open',
                    exportOptions: {
                        columns: [ 0, ':visible' ]
                    },
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
        var user_id = $('#user_id').val();
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        // alert(user_id + startDate + endDate);
            var url2 = "../controller/attendance_controller.php?status=load_attendance_user_date";

            $.post(url2, {user_id: user_id,startDate:startDate,endDate:endDate}, function (data) {
                /*show the data that is being responded by server in the div id myfunctions*/
                $('#datatables-attendance').parents('div.dataTables_wrapper').first().hide();
                $("#show-filtered-table").html(data).show();
                $("#datatables-loadData").DataTable({
                    responsive: true,
                    pageLength: 5,
                    order: [
                        [0, "asc"]
                    ],
                    dom: 'Bfrtip',

                    buttons: [
                        {
                            extend: 'pdfHtml5',
                            text: 'PDF',
                            title: 'Attendance Report : ' + new Date().toDateString(),
                            download: 'open',
                            exportOptions: {
                                columns: [ 0, ':visible' ]
                            },
                            filename: 'Attendance Report : ' + new Date().toDateString(),
                            customize: function ( doc ) {

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
                            title: 'Attendance Report : ' + new Date().toDateString(),
                            autoFilter: true,
                            download: 'open',
                            exportOptions: {
                                columns: [ 0, ':visible' ]
                            },
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
    }

    $("#datatables-holiday").DataTable({
        pageLength: 3,
        lengthChange: false,
        bFilter: false,
        autoWidth: false,
        order: [
            [2, "asc"]
        ]
    });
</script>
</body>

</html>