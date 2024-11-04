<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 5 Admin &amp; Dashboard Template">
    <meta name="author" content="Bootlab">

    <title>Attendance</title>

    <link rel="canonical" href="https://appstack.bootlab.io/forms-layouts.html" />
    <link rel="shortcut icon" href="img/favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- Choose your prefered color scheme -->
    <!-- <link href="css/light.css" rel="stylesheet"> -->
    <!-- <link href="css/dark.css" rel="stylesheet"> -->

    <!-- BEGIN SETTINGS -->
    <!-- Remove this after purchasing -->
    <link class="js-stylesheet" href="css/light.css" rel="stylesheet">
    <script src="js/settings.js"></script>
    <!-- END SETTINGS -->
</head>
<!--
  HOW TO USE:
  data-theme: default (default), dark, light
  data-layout: fluid (default), boxed
  data-sidebar-position: left (default), right
  data-sidebar-behavior: sticky (default), fixed, compact
-->

<body data-theme="colored" data-layout="fluid" data-sidebar-position="left" data-sidebar-behavior="sticky">
<div class="wrapper">
    <?php
    include_once "sidebar.php";
    $user_id=$_REQUEST["user_id"];
    $user_id2=base64_decode($user_id);

    $date=$_REQUEST["date"];

    include "../model/attendance_model.php";
    $attendanceObj=new Attendance();
    $attendanceResult=$attendanceObj->getParicularUserAttendance($user_id2,$date);
    $attendanceRow=$attendanceResult->fetch_assoc();

    ?>
    <div class="main">
        <?php
        include_once "topbar.php";
        ?>
        <main class="content">
            <div class="container-fluid p-0">

                <h1 class="h3 mb-3">User Attendance</h1>


                <form method="post" enctype="multipart/form-data" id="addOrder" action="../controller/attendance_controller.php?status=edit_attendance">
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

                            <div class="col-md-12"><div id="alertDiv"></div> </div>
                        </div>
                        <div class="col-12 col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Attendance Details</h5>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <div class="form-floating">
                                                    <input class="form-control" name="date_added" type="text" value= "<?php echo 'EMP - '.sprintf('%03d',$attendanceRow["user_id"]); ?>"  readonly required>
                                                    <label for="floatingInput1">Employee ID</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" type="hidden" readonly value="<?php echo $attendanceRow["user_id"]; ?>" name="user_id">

                                                    <input class="form-control" type="text" readonly value="<?php echo $attendanceRow["user_fname"].' '.$attendanceRow["user_lname"]; ?>" name="user_name">
                                                    <label for="floatingInput1">User Name</label>
                                                </div>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <div class="form-floating">
                                                    <input class="form-control" name="date_added" type="text" value="<?php echo $attendanceRow["date"] ?>"  readonly required>
                                                    <label for="floatingInput1">Date</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <div class="form-floating">
                                                <input type="text" readonly id="update_date" value="<?php echo $attendanceRow["updated_date"] ?>" class="form-control input-lg" name="update_date" required>
                                                    <label for="floatingInput1">Update Date</label>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        
                                        <div class="mb-4 row">
                                            <div class="col-sm-10 ml-sm-auto">
                                                <button type="reset" class="btn btn-success">Reset</button>
                                            </div>
                                        </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Edit</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Check In</label>
                                                <input type="time" class="form-control"  value="<?php echo $attendanceRow["check_in"] ?>" name="check_in" id="check_in">
                                                <p id="checkInError"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <label class="form-label">Check Out</label>
                                                <input type="time" value="<?php echo $attendanceRow["check_out"] ?>" class="form-control" name="check_out" id="check_out">
                                                <p id="checkOutError"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-0">
                                        <p>Reason for update</p>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="text" id="update_reason" value="<?php echo $attendanceRow["update_reason"] ?>" class="form-control input-lg" name="update_reason" required>
                                            <label for="floatingSelectGrid">Reason for update</label>
                                        </div>
                                    </div>
                                    </div>
                                    </div>

                                    <div id="earnings-deductions">
                                        <div class="row">
                                            <br><br>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="col-sm-10 ml-sm-auto">
                                            <button ID="updtebtn" type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>

            </div>
        </main>

        <footer class="footer">
            <div class="container-fluid">
                <div class="row text-muted">
                    <div class="col-6 text-start">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a class="text-muted" href="#">Support</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="text-muted" href="#">Help Center</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="text-muted" href="#">Privacy</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="text-muted" href="#">Terms of Service</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-6 text-end">
                        <p class="mb-0">
                            &copy; 2023 - <a href="index.html" class="text-muted">AppStack</a>
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script type="text/javascript" src="js/orderValidation.js"></script>
<script src="js/app.js"></script>
<script type="text/javascript">
        $('#check_in').keyup(function(){
            var check_in = document.getElementById("check_in").value;
            var validTime = /((1[0-2]|0?[1-9]):([0-5][0-9]) ?([AP][M]))/;

            if(check_in.match(validTime))
            {
                document.getElementById("checkInError").innerHTML = "Valid";
                document.getElementById("checkInError").style.color = 'green';
                document.getElementById("updtebtn").disabled=false;

            }
            else{
                document.getElementById("checkInError").innerHTML = "Invalid time. Eg : 09:00 AM";
                document.getElementById("checkInError").style.color = 'red';
                document.getElementById("updtebtn").disabled=true;

            }
        });


        $('#check_out').keyup(function(){
            var check_out = document.getElementById("check_out").value;
            var validTime = /((1[0-2]|0?[1-9]):([0-5][0-9]) ?([AP][M]))/;
            if(check_out.match(validTime))
            {
                document.getElementById("checkOutError").innerHTML = "Valid";
                document.getElementById("checkOutError").style.color = 'green';
                document.getElementById("updtebtn").disabled=false;


            }
            else{
                document.getElementById("checkOutError").innerHTML = "Invalid time. Eg : 09:00 AM";
                document.getElementById("checkOutError").style.color = 'red';
                document.getElementById("updtebtn").disabled=true;

            }
        });
    $("#payslipNo").val("TC - 20E - "+$("#payslipId").val());

    checkExist= function () {

        var value = $('#driver_Name2').val();
        var driverEmployeeID2=($('#driverName2 [value="' + value + '"]').data('value'));
        if(driverEmployeeID2=="")
        {
            $("#alertDiv").html("Please type the contact number!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#tel1").focus();
            return false;
        }
        else {


            var url = "../controller/order_controller.php?status=check_emp";

            $.post(url, {driverEmployeeID2: driverEmployeeID2}, function (data) {
                /*show the data that is being responded by server in the div id myfunctions*/
                $("#earnings-deductions").html(data).show();
            });
        }

    };

    function checkvalue()
    {
        $(function(){/*order*/
            $('#tax, #incentices').keyup(function(){

                var salary = parseFloat($('#Amount').val()) || 0;
                var tax = parseFloat($('#tax').val()) || 0;
                var incentives = parseFloat($('#incentices').val()) || 0;
                var epf8 = parseFloat($('#EPF8').val()) || 0;
                var travelallowance = parseFloat($('#travelallowance').val()) || 0;

                $('#TotAmount').val( (salary + travelallowance + incentives) - (tax + epf8));
            });
        });

        var tax = document.getElementById("tax").value;
        var btn=document.getElementById("btn");

        if(tax>=0)
        {
            document.getElementById("MinusError").innerHTML = "Valid amount" ;
            document.getElementById("MinusError").style.color = 'green';
            document.getElementById("btn").disabled=false;
            $("#TotAmount").val(tax);

        }
        else
        {
            document.getElementById("MinusError").innerHTML = "Invalid amount" ;
            document.getElementById("MinusError").style.color = 'red';
            document.getElementById("btn").disabled=true;
        }


    }
</script>

</body>

</html>