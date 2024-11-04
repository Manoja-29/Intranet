<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 5 Admin &amp; Dashboard Template">
    <meta name="author" content="Bootlab">

    <title>Holiday | AppStack - Bootstrap 5 Admin &amp; Dashboard Template</title>
    <link rel="canonical" href="https://appstack.bootlab.io/dashboard-default.html" />
    <link rel="shortcut icon" href="img/favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <link href="css/light.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
</head>

<body data-theme="colored" data-layout="fluid" data-sidebar-position="left" data-sidebar-behavior="sticky">
<div class="wrapper">
    <?php
    include_once "sidebar.php";
    ?>
    <div class="main">
    <?php 
        include_once "topbar.php";
        include "../model/holiday-leave-model.php";
        $holidayObj = new HolidayLeave();
        $holidayResult = $holidayObj->getHolidays();
    ?>

    <main class="content">
        <div class="container-fluid p-0">
        <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-none d-sm-block">
                <h3>Manage Holidays</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-5 col-lg-4 col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Add Holiday</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data" id="addHolidays" action="../controller/holiday_leave_controller.php?status=add_holiday_leave">
                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label class="form-label">Holiday Name</label>
                                    <input type="text" class="form-control" id="holiday" name="holiday_desc" placeholder="Description">
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Date</label>
                                    <input type="date" class="form-control" id="holiday_date" name="holiday_date">
                                </div>
                            </div>
							    <label class="form-label">Holiday Type</label><br>
                                    <input type="checkbox" class="form-check-input" value='1' name="holiday_type[]">
                                    <span class="form-check-label">Public</span>&nbsp;&nbsp;
                                    <input type="checkbox" class="form-check-input" value='2' name="holiday_type[]">
                                    <span class="form-check-label">Mercantile </span>&nbsp;&nbsp;
                                    <input type="checkbox" class="form-check-input" value='3' name="holiday_type[]">
                                    <span class="form-check-label">Bank </span>&nbsp;&nbsp;
                                    <input type="checkbox" class="form-check-input" value='4' name="holiday_type[]">
                                    <span class="form-check-label">Special </span>
                                </label>

                            <div class="row mt-4">
                                <div class="mb-3 col-md-1">
                                    <button type="Submit" class="btn btn-primary">Submit</button>
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="mb-3 col-md-1">
                                    <button type="reset" class="btn btn-success">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="card">
					<div class="card-header">
						<ul class="nav nav-tabs card-header-tabs pull-right" role="tablist">
							<li class="nav-item" role="presentation">
								<a class="nav-link active" data-bs-toggle="tab" href="#tab-1" aria-selected="true" role="tab">Past Holiday</a>
							</li>
							<li class="nav-item" role="presentation">
								<a class="nav-link" data-bs-toggle="tab" href="#tab-2" aria-selected="false" role="tab" tabindex="-1">Upcoming Holiday</a>
							</li>
						</ul>
					</div>

					<div class="card-body">
						<div class="tab-content">
                            <!-- Past Holiday -->
							<div class="tab-pane fade active show" id="tab-1" role="tabpanel">
                                <div class="body">
                                    <table class="table my-0" id="holidays-past">
                                        <thead>
                                        <tr>
                                            <th class="d-none d-xxl-table-cell">Description</th>
                                            <th class="d-none d-xl-table-cell">Date</th>
                                            <th>Holiday Type</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            while ($holidayRow=$holidayResult->fetch_assoc()){
                                                date_default_timezone_set('Asia/Colombo');
                                                $dateToday=date("Y-m-d");

                                                if($holidayRow['date']<$dateToday){
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
                                                <td class="d-none d-xl-table-cell">
                                                    <div class="text-muted">
                                                        <?php
                                                            $holidayTypes = explode(',', $holidayRow['holiday_type']);

                                                            foreach ($holidayTypes as $type) {
                                                                if ($type == 1) {
                                                                    echo 'Public Holiday<br>';
                                                                } elseif ($type == 2) {
                                                                    echo 'Mercantile Holiday<br>';
                                                                } elseif ($type == 3) {
                                                                    echo 'Bank Holiday<br>';
                                                                } else {
                                                                    echo 'Special Holiday<br>';
                                                                }
                                                            }
                                                        ?>
                                                    </div>
                                                </td>
                                                <td class="d-none d-xl-table-cell text-end">
                                                    <?Php
                                                        $holiday_id=$holidayRow["holiday_id"];
                                                        $holiday_id=base64_encode($holiday_id);
                                                    ?>
                                                    <a href="edit-holidays.php?holiday_id=<?php echo $holiday_id ?>" class="btn btn-light">&nbspEdit</a>
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
                            <?php
                                $holidayResult = $holidayObj->getHolidays();
                            ?>
                            <!--Future Holiday -->
							<div class="tab-pane fade" id="tab-2" role="tabpanel">    
                                <div class="body">
                                <table class="table my-0" id="upcoming">
                                        <thead>
                                        <tr>
                                            <th class="d-none d-xxl-table-cell">Description</th>
                                            <th class="d-none d-xl-table-cell">Date</th>
                                            <th>Holiday Type</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            while ($holidayRow=$holidayResult->fetch_assoc()){
                                                date_default_timezone_set('Asia/Colombo');
                                                $dateToday=date("Y-m-d");

                                                if($holidayRow['date']>$dateToday){
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
                                                <td class="d-none d-xl-table-cell">
                                                    <div class="text-muted">
                                                        <?php
                                                            $holidayTypes = explode(',', $holidayRow['holiday_type']);

                                                            foreach ($holidayTypes as $type) {
                                                                if ($type == 1) {
                                                                    echo 'Public Holiday<br>';
                                                                } elseif ($type == 2) {
                                                                    echo 'Mercantile Holiday<br>';
                                                                } elseif ($type == 3) {
                                                                    echo 'Bank Holiday<br>';
                                                                } else {
                                                                    echo 'Special Holiday<br>';
                                                                }
                                                            }
                                                        ?>
                                                    </div>
                                                </td>
                                                <td class="d-none d-xl-table-cell text-end">
                                                    <?Php
                                                        $holiday_id=$holidayRow["holiday_id"];
                                                        $holiday_id=base64_encode($holiday_id);
                                                    ?>
                                                    <a href="edit-holidays.php?holiday_id=<?php echo $holiday_id ?>" class="btn btn-light">&nbspEdit</a>
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
				</div>
			</div>

            <div class="col-10 col-lg-4 col-xl-6 d-flex">
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

        </div>

        </div>
    </main>

    <?php
    include "footer.php";
    ?>
    </div>
</div>

<script src="js/app.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var calendarEl = document.getElementById('datetimepicker-dashboard');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            themeSystem: 'bootstrap',
            initialView: 'dayGridMonth',
            initialDate: '2024-10-01',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: ''
            },
            events: [
                <?php 
                $events = [];
                $holidayResult = $holidayObj->getHolidays();
                while ($holidayRow = $holidayResult->fetch_assoc()) {
                    $events[] = "{ 
                        title: '" . addslashes($holidayRow['holiday_name']) . "', 
                        start: '" . $holidayRow['date'] . "', 
                        backgroundColor: '#F3C623', 
                        borderColor: '#F3C623'
                    }";
                }
                echo implode(',', $events); 
                ?>
            ],
            eventColor: '#378006',
        });

        setTimeout(function() {
            calendar.render();
        }, 250);
    });

    $("#holidays-past").DataTable({
        responsive: true,
        pageLength: 3,
        order: [
            [1, "asc"]
        ]
    });

    $("#upcoming").DataTable({
        responsive: false,
        pageLength: 3,
        order: [
            [1, "asc"]
        ]
    });
</script>

</body>
</html>
