<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 5 Admin &amp; Dashboard Template">
    <meta name="author" content="Bootlab">

    <title>Payslips</title>

    <link rel="canonical" href="https://appstack.bootlab.io/pages-clients.html" />
    <link rel="shortcut icon" href="img/favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- Choose your prefered color scheme -->
    <link href="css/light.css" rel="stylesheet">
    <!-- <link href="css/dark.css" rel="stylesheet"> -->

    <!-- BEGIN SETTINGS -->
    <!-- Remove this after purchasing -->
<!--    <link class="js-stylesheet" href="css/light.css" rel="stylesheet">-->
<!--    <script src="js/settings.js"></script>-->
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
    include "../model/order_model.php";
    $orderObj=new Order();
    $orderResult=$orderObj->getAllOrders();
    include "../model/employee_model.php";
    $employeeObj=new Employee();
    ?>
    <div class="main">
        <?php
        include_once "topbar.php";
        ?>
        <main class="content">
            <div class="container-fluid p-0">

                <h1 class="h3 mb-3">Payslips</h1>

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

                            <div class="col-md-12"><div id="alertDiv"></div> </div>
                        </div>

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


                                    while ($OrderRow=$orderResult->fetch_assoc()){


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
        // Datatables clients
        $("#datatables-clients").DataTable({
            responsive: true,
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