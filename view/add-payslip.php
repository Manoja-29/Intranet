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

    <link href="css/light.css" rel="stylesheet">

</head>

<body data-theme="colored" data-layout="fluid" data-sidebar-position="left" data-sidebar-behavior="sticky">
<div class="wrapper">
    <?php
    include_once "sidebar.php";
    include "../model/order_model.php";
    $orderObj=new Order();
    $displayResult=$orderObj->getAllOrders();

    $employeeObj=new User();
    $empResult=$employeeObj->DisplayAllUsers();

    ?>
    <div class="main">
        <?php
        include_once "topbar.php";
        ?>
        <main class="content">
            <div class="container-fluid p-0">

                <div class="row mb-2 mb-xl-3">
                    <div class="col-auto d-none d-sm-block">
                        <h3>Manage Payslips</h3>
                    </div>

                    <div class="col-auto ms-auto text-end mt-n1">
                        <div class="dropdown me-2 d-inline-block position-relative">
                            <a class="btn mb-2 btn-primary" style="padding: 5px 15px;" href="payroll.php">Payroll Report</a>
                        </div>
                    </div>
                </div>
                <form method="post" enctype="multipart/form-data" id="addPayslip" action="../controller/order_controller.php?status=add_order">
                <div class="row">
                    <div class="row">
                        <?php
                        //Error message
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

                        <!--Success message-->
                        <?php
                        if(isset($_GET['msgsuccess'])){

                            ?>
                            <div class="col-md-12">
                            <div class="alert alert-success alert-dismissible" role="alert" style="padding: 15px">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <div class="alert-success">
                                <strong>Hello there!</strong>  <?php
                                $msg2=$_REQUEST['msgsuccess'];
                                $msg2=base64_decode($msg2);

                                $payslip_id_encoded=$_REQUEST['payslip_id'];
                                $employee_id_encoded=$_REQUEST['emp_id'];
                                $pay_period=$_REQUEST['date'];
                                    echo $msg2
                                    ?>
                                    <a target="_blank" href="../view/print-payslip.php?payslip_id=<?php echo $payslip_id_encoded ?>&emp_id=<?php echo $employee_id_encoded;?>&date=<?php echo $pay_period ?>">here</a>
                                    to view <?php ;
                                ?>
                                </div>
                            </div>
                            </div>
                            <?php
                        }

                        ?>
                        <!--Success message-->


                        <div class="col-md-12">
                            <div id="alertDiv">

                            </div>
                        </div>
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
                                            <input class="form-control" type="text" placeholder="Readonly input" value="<?php echo $orderId=$orderResult=$orderObj->getcurrentID(); ?>" name="payslipId" id="payslipId" readonly>
                                            <label for="floatingInput1">Payslip ID</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control" type="text" name="payslipNo" value="TC - 24 - " id="payslipNo" placeholder="Readonly input" readonly>
                                            <label for="floatingInput1">Payslip #</label>
                                        </div>
                                    </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Pay Period</label>
                                                <input type="month" class="form-control" max="<?php echo date("Y-m") ?>" name="payperiod" id="payperiod">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Pay Date</label>
                                                <input type="date" value="01-06-2017" max="<?php echo date("Y-m-d") ?>" class="form-control" name="payDate" id="payDate">
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
                                            <button type="button" class="btn btn-outline-info" onclick="checkExist()"> <span class="glyphicon glyphicon-arrow-right"></span>&nbsp&nbspCheck details</button>
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
                                                <input class="form-control" id="Amount" name="amount" type="text">
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
                                                <input class="form-control" style="border: 1px solid #D69D85" type="text" name="tax" id="tax" oninput="checkvalue()"  min="0">
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
<!--                                            <div class="col-md-3">-->
<!--                                                <div class="form-floating">-->
<!--                                                    <input class="form-control JoinMe" name="JoinMe" id="JoinMe" type="text" min="0">-->
<!--                                                    <label for="floatingInput1">Total Amount</label>-->
<!--                                                </div>-->
<!--                                            </div>-->
                                    </div>
                                    <br>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="col-sm-10 ml-sm-auto">
                                            <button type="submit" class="btn btn-primary" >Submit</button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="leaves-div">
                    <div class="col-12 col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Calculate base salary</h5>
                                <h6 class="card-subtitle text-muted">Leave details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control" type="number" name="halfday" id="halfday">
                                            <label for="floatingInput1">Number of half day leaves</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control" type="number" name="fullday" id="fullday">
                                            <label for="floatingInput1">Number of full day leaves</label>
                                        </div>
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <button type="button" onclick="calculateLeaveSalary()" class="btn btn-success">Calculate</button>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <p>Deduction for half day : <b><span id="half-day"></span></b> </p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <p>Deduction for full day : <b><span id="full-day"></span></b> </p>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <p>Revised basic salary : <b><span id="final-salary"></span></b> </p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

    
            <!-- -------test ----------->

            <div class="card">
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
                                <h5 class="card-title mb-0">All Payslips</h5>
                            </div>
                            <div class="card-body">
                                <table id="datatables-clients" class="table table-striped" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Payslip No </th>
                                        <th>Employee</th>
                                        <th>Pay Period </th>
                                        <th>Pay Date </th>
                                        <th>Created Date </th>
                                        <th>Basic Salary</th>
                                        <th>Take Home Salary</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while ($OrderRow=$displayResult->fetch_assoc()){
                                    $payslip_id=$OrderRow["payment_id"];
                                    $payslip_id_encoded=base64_encode($payslip_id);
                                    ?>
                                    <tr>
                                        <td><?php echo $OrderRow["payment_id"]; ?></td>
                                        <td><?php echo $OrderRow["payslip_number"]; ?></td>
                                        <td>
                                            <?php
                                            include_once "../model/user-model.php";
                                            $userObj=new User();

                                            $emp_id=$OrderRow["employee_id"];
                                            $emp_id_encoded=base64_encode($emp_id);
                                            $empResult=$userObj->viewUser($emp_id);

                                            $empRow=$empResult->fetch_assoc();
                                            $emp_name=$empRow["user_fname"];
                                            $emp_lname=$empRow["user_lname"];
                                            echo ucfirst($emp_name) ." ".ucfirst($emp_lname);


                                            $ciphering = "AES-128-CTR";

                                            $decryption_iv = 'rqEJKQ+COwSInxjv';

                                            // Store the decryption key
                                            $decryption_key = "A$6Q{5M*AMsT,VRPQ@M5-=x>Y.^nQh9n";
                                            $options = 0;

                                            // Use openssl_decrypt() function to decrypt the data

                                            $salary = openssl_decrypt($OrderRow["amount"], $ciphering, $decryption_key, $options, $decryption_iv);
                                            $formatted_basic = number_format((float)$salary, 2, '.', ',');
                                            $total_amount = openssl_decrypt($OrderRow["total_amount"], $ciphering, $decryption_key, $options, $decryption_iv);
                                            $formatted_salary = number_format((float)$total_amount, 2, '.', ',');

                                            ?>
                                        </td>
                                        <td><?php echo $OrderRow["pay_period"]; ?></td>
                                        <td><?php echo $OrderRow["pay_date"]; ?></td>
                                        <td><?php echo $OrderRow["timestamp"]; ?></td>
                                        <td><?php echo $formatted_basic ?></td>
                                        <td><?php echo $formatted_salary ?></td>
                                        <td>
                                            <?Php
                                            $pay_period=$OrderRow["pay_period"];
                                            ?>
                                            <a href="payslip.php?payslip_id=<?php echo $payslip_id_encoded ?>&emp_id=<?php echo $emp_id_encoded;?>&date=<?php echo $pay_period ?>" target="_blank" class="badge bg-primary">Email payslip</a>
                                        </td>
                                        <td>
                                            <a href="edit-payslip.php?payslip_id=<?php echo $payslip_id_encoded ?>&emp_id=<?php echo $emp_id_encoded;?>" class="badge bg-success">View More</a>
                                        </td>
                                        <td>
                                            <a class="badge bg-info" target="_blank" href="print-payslip.php?payslip_id=<?php echo $payslip_id_encoded ?>&emp_id=<?php echo $emp_id_encoded;?>">Print Payslip </a>
                                        </td>
                                        <td><a onclick="removePayslip(<?php echo $payslip_id ?>)"><span class="badge bg-danger">Remove</span></a></td>
                                    </tr>
                                        <?php

                                    }
                                    ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>

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
    $("#payslipNo").val("TC-24-"+$("#payslipId").val());


    checkExist= function () {

        var value = $('#driver_Name2').val();
        var driverEmployeeID2=($('#driverName2 [value="' + value + '"]').data('value'));

        if(value=="")
        {
            $("#alertDiv").html("Please select an employee!!!");
            $("#alertDiv").addClass("alert alert-danger alert-dismissible");
            $(value).focus();
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

        $('#JoinMe').on('focusout',function(){
            var xyz = $('#JoinMe').val();
            alert(xyz);
            xyz += '%'
            var val = parseFloat(xyz) || 0;
            var salary = parseFloat($('#Amount').val()) || 0;

            var total = val * salary;

            $('#JoinMe').val(total);
        });
        $('#JoinMe').on('focusin',function(){
            var xyz = $('#JoinMe').val();
            xyz = xyz.replace ('%', '');
            var salary = parseFloat($('#Amount').val()) || 0;

            $('#JoinMe').val(xyz);
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

    function calculateLeaveSalary()
    {
                var salary = parseFloat($('#Amount').val()) || 0;
                var halfday = parseFloat($('#halfday').val()) || 0;
                var fullday = parseFloat($('#fullday').val()) || 0;

                var halfdayPay = (salary/60);
                var fulldayPay = (salary/30);
                var finalSalary = salary-((halfday*halfdayPay)+(fullday*fulldayPay));

                alert('Revised basic salary is ' +finalSalary+ '. Please update "Basic Salary" field and recalculate the +-salary')
                $('#half-day').text(halfday*halfdayPay);
                $('#full-day').text(fullday*fulldayPay);
                $('#final-salary').text(finalSalary);


    }

    $("#addPayslip").submit(function (){

        var payDate=$("#payDate").val();
        var payperiod=$("#payperiod").val();
        var description=$("#description").val();
        var Amount=$("#Amount").val();
        var travelallowance=$("#travelallowance").val();
        var incentices=$("#incentices").val();
        var tax=$("#tax").val();
        var EPF8=$("#EPF8").val();
        var EPF12=$("#EPF12").val();
        var etf=$("#etf").val();
        var TotAmount=$("#TotAmount").val();


        if(payperiod=="")
        {
            $("#alertDiv").html("Pay period cannot be empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#payperiod").focus();
            return false;
        }
        if(payDate=="")
        {
            $("#alertDiv").html("Pay date cannot be empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#payDate").focus();
            return false;
        }
        
        if(Amount=="")
        {
            $("#alertDiv").html("Please select an employee!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#Amount").focus();
            return false;
        }


        if(travelallowance=="")
        {
            $("#alertDiv").html("Travel allowance cannot be empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#travelallowance").focus();
            return false;
        }


        if(incentices=="")
        {
            $("#alertDiv").html("Incentives cannot be empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#incentices").focus();
            return false;
        }

        if(tax=="")
        {
            $("#alertDiv").html("Tax cannot be empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#tax").focus();
            return false;
        }


        if(EPF8=="")
        {
            $("#alertDiv").html("EPF cannot be empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#EPF8").focus();
            return false;
        }

        if(EPF12=="")
        {
            $("#alertDiv").html("EPF cannot be empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#EPF12").focus();
            return false;
        }
        if(etf=="")
        {
            $("#alertDiv").html("ETF cannot be empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#etf").focus();
            return false;
        }

        if(TotAmount=="")
        {
            $("#alertDiv").html("Total amount cannot be empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#TotAmount").focus();
            return false;
        }


    })

    $(document).ready(function () {
        $("#leaves-div").hide();

    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Datatables clients
        $("#datatables-clients").DataTable({
            responsive: true,
            pageLength: 8,
            order: [
                [1, "desc"]
            ]
        });
    });

    removePayslip= function (m) {

        var con=confirm("Do you really want to remove this payslip?");
        if(con==true) {

            var url = "../controller/order_controller.php?status=remove_payslip";

            /*ajax request is made*/
            $.post(url, {payslip_id: m}, function (data) {
                /*show the data that is being responded by server in the div id myfunctions*/
                $("#pocontent").html(data).show();
                /*data is fetched from the product controller and subcatdiv is replaced by that value*/
            });
        }
    }

</script>

</body>

</html>