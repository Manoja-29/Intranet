<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 5 Admin &amp; Dashboard Template">
    <meta name="author" content="Bootlab">

    <title>Payslip</title>

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

<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-behavior="sticky">
<div class="wrapper">
    <?php
    include_once "sidebar.php";
    $payslip_id=$_REQUEST["payslip_id"];
    $payslip_id=base64_decode($payslip_id);

    include "../model/order_model.php";
    $payslipObj=new Order();
    $payslipResult=$payslipObj->getPayslipDetails($payslip_id);
    $payslipRow=$payslipResult->fetch_assoc();

    /*employee details*/
    $emp_id=$_REQUEST["emp_id"];
    $emp_id=base64_decode($emp_id);

    include_once "../model/user-model.php";
    $userObj=new User();

    $empResult=$userObj->viewUser($emp_id);

    $empRow=$empResult->fetch_assoc();
    $emp_name=ucfirst($empRow["user_fname"]);
    $emp_lname=ucfirst($empRow["user_lname"]);
    ?>
    <div class="main">
        <?php
        include_once "topbar.php";
        ?>
        <main class="content">
            <div class="container-fluid p-0">

                <h1 class="h3 mb-3">Payslip #<?php echo $payslip_id?></h1>
                <?php
                $emp_id_encoded= base64_encode($emp_id);
                $payslip_id_encoded= base64_encode($payslip_id);

                ?>
                <h4  style="font-weight: bold"><a href="edit-payslip.php?payslip_id=<?php echo $payslip_id_encoded?>&emp_id=<?php echo $emp_id_encoded; ?>" class="text-primary"><span class="glyphicon glyphicon-edit ">&nbspEdit</span></a></h4>

                <form method="post" enctype="multipart/form-data" id="addOrder" action="../controller/order_controller.php?status=add_order">
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
                                    <h5 class="card-title">Generate payslip</h5>
                                    <h6 class="card-subtitle text-muted">Monthly</h6>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" type="text" placeholder="Readonly input" value="<?php echo $payslip_id; ?>" name="payslipId" id="payslipId">
                                                    <label for="floatingInput1">Payslip ID</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" type="text" name="payslipNo" value="<?php echo $payslipRow["payslip_number"] ?>" placeholder="Readonly input" readonly>
                                                    <label for="floatingInput1">Payslip #</label>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Pay Period</label>
                                                    <input type="month" class="form-control" value="<?php echo $payslipRow["pay_period"] ?>" name="payperiod" id="payperiod">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Pay Date</label>
                                                    <input type="date" value="01-06-2017" class="form-control" name="payDate" id="payDate">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="mb-3">
                                            <label class="form-label">Additional Description</label>
                                            <textarea class="form-control" name="description" id="description" placeholder="Textarea" rows="2"></textarea>
                                        </div>

                                        <div class="mb-3 row">
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
                                    <h5 class="card-title">Earnings & Deductions</h5>
                                    <h6 class="card-subtitle text-muted">Employee details</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input list="driverName2"  id="driver_Name2" class="form-control input-lg" name="driver_Name2" oninput="search()">
                                                <datalist id="driverName2" name="test">
                                                    <?php
                                                    while ($empRow=$empResult->fetch_assoc()){
                                                        ?>
                                                        <option data-value="<?php echo $empRow["user_id"] ?>" value="<?php echo $empRow["user_fname"]." ".$empRow["user_lname"]." - #".$empRow["user_id"]; ?>"></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </datalist>
                                                <label for="floatingSelectGrid">Employee</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" class="btn btn-outline-info btn-lg" onclick="checkExist()"> <span class="glyphicon glyphicon-arrow-right"></span>&nbsp&nbspCheck details</button>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" id="recalculate" class="btn btn-outline-success" > <span class="glyphicon glyphicon-arrow-right"></span>&nbsp&nbspRecalculate</button>
                                        </div>
                                    </div>
                                    <br>
                                    <div id="earnings-deductions">
                                        <input value="" type="hidden" id="driverEmployeeID2" name="driverEmployeeID2">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input class="form-control" id="Amount" name="amount" type="text" readonly>
                                                    <label for="floatingInput1">Basic Salary</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input class="form-control" type="text" name="travelallowance" readonly id="travelallowance" min="0">
                                                    <label for="floatingInput1">Travel Allowance</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input class="form-control" type="text" name="incentices" id="incentices" min="0" oninput="checkvalue()">
                                                    <label for="floatingInput1">Incentive</label>
                                                </div>

                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input class="form-control" type="text" name="tax" id="tax" oninput="checkvalue()"  min="0">
                                                    <label for="floatingInput1">Payee Tax</label>
                                                </div>
                                                <p id="MinusError" style="font-size: 12px"></p>

                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input class="form-control" type="text" name="EPF8" id="EPF8" min="0" readonly>
                                                    <label for="floatingInput1">EPF Employee(8%)</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input class="form-control" type="text" name="EPF12" id="EPF12" min="0"  readonly>
                                                    <label for="floatingInput1">EPF Employer(12%)</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input class="form-control" type="text" name="etf" id="etf" min="0"  readonly>
                                                    <label for="floatingInput1">ETF Employer(3%)</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input class="form-control" name="TotAmount" id="TotAmount" type="text" min="0" readonly>
                                                    <label for="floatingInput1">Total Amount</label>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="col-sm-10 ml-sm-auto">
                                            <button type="submit" class="btn btn-primary">Submit</button>
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
    $("#payslipNo").val("TC - 20E - "+$("#payslipId").val());

    $("#recalculate").click(function (){
        var salary = parseFloat($('#Amount').val()) || 0; //basic salary
        var travelallowance = parseFloat($('#travelallowance').val()) || 0;
        var tax = parseFloat($('#tax').val()) || 0;
        var CalculatedIncentives = salary*0.25;
        var calculatedEPF8 = salary*0.08;
        var calculatedEPF12 = salary*0.12;
        var calculatedETF = salary*0.03;

        $('#incentices').val(CalculatedIncentives);
        $('#EPF8').val(calculatedEPF8);
        $('#EPF12').val(calculatedEPF12);
        $('#etf').val(calculatedETF);

        $('#TotAmount').val( (salary + travelallowance + CalculatedIncentives) - (tax + calculatedEPF8));

    })
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