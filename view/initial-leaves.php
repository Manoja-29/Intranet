<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 5 Admin &amp; Dashboard Template">
    <meta name="author" content="Bootlab">

    <title>Initial Leaves</title>

    <link rel="canonical" href="https://appstack.bootlab.io/forms-layouts.html" />
    <link rel="shortcut icon" href="img/favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <link href="css/light.css" rel="stylesheet">

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
    $holidayResult=$holidayObj->getHolidays();
    ?>
    <div class="main">
        <?php
        include_once "topbar.php";
        ?>
        <main class="content">
            <div class="container-fluid p-0">

                <h1 class="h3 mb-3">Holidays</h1>
                <form method="post" enctype="multipart/form-data" id="initial_leaves" action="../controller/holiday_leave_controller.php?status=add_holiday_leave">
                    <div class="row">
                        <div class="row">
                            <?php
                            //        check if msg is available
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
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Annual Leaves</h5>
                                    <h6 class="card-subtitle text-muted">Add Holidays</h6>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">User</label>
                                                <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Holiday">
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Leave type</label>
                                                <input type="text" class="form-control" id="leave_type" name="leave_type" value="Annual">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-12 col-md-12">
                                                <label class="form-label">Number of leaves</label>
                                                <input type="text" class="form-control" id="number_leaves" name="number_leaves" value="14">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="mb-3 col-md-5">
                                            </div>
                                            <div class="mb-3 col-md-1">
                                                <button type="Submit" class="btn btn-primary">Submit</button>
                                            </div>
                                            <div class="mb-3 col-md-1">
                                                <button type="reset" class="btn btn-success">Reset</button>
                                            </div>
                                            <div class="mb-3 col-md-5">
                                            </div>
                                        </div>


                                    </form>
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
                                <h5 class="card-title mb-0">Annual Holidays</h5>
                            </div>
                            <table class="table table-borderless my-0" id="holidays-table">
                                <thead>
                                <tr>
                                    <th class="d-none d-xxl-table-cell">Description</th>
                                    <th class="d-none d-xl-table-cell">Date</th>
                                    <th>Status</th>
                                    <th class="d-none d-xl-table-cell text-end">Action</th>
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
                                ?>

                                </tbody>
                            </table>
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

<script type="text/javascript">

    $("#initial_leaves").submit(function (){

        var user_name=$("#user_name").val();
        var leave_type=$("#leave_type").val();
        var number_leaves=$("#number_leaves").val();

        if(user_name=="")
        {
            $("#alertDiv").html("User name cannot be empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#user_name").focus();
            return false;
        }
        if(leave_type=="")
        {
            $("#alertDiv").html("Leave type cannot be empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#leave_type").focus();
            return false;
        }

        if(number_leaves=="")
        {
            $("#alertDiv").html("Number of leaves cannot be empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#number_leaves").focus();
            return false;
        }

    })


</script>

</body>

</html>