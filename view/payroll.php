<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 5 Admin &amp; Dashboard Template">
    <meta name="author" content="Bootlab">

    <title>Payroll</title>

    <link rel="canonical" href="https://appstack.bootlab.io/pages-clients.html" />
    <link rel="shortcut icon" href="img/favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet">

    <link href="css/light.css" rel="stylesheet">

</head>
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

                <div class="row mb-2 mb-xl-3">
                    <div class="col-auto d-none d-sm-block">
                        <h3>Payroll</h3>
                    </div>

                    <div class="col-auto ms-auto text-end mt-n1">
                        <div class="dropdown me-2 d-inline-block position-relative">
                            <a class="btn mb-2 btn-primary" style="padding: 5px 15px;" href="add-payslip.php">+ Add Payslip</a>
                        </div>
                    </div>
                </div>

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
                                <h5 class="card-title mb-0">Payroll Summary</h5>
                            </div>
                            <div class="card-header">

                            <div class="row">
                                    <div class="col-3">
                                        <p style="font-size: 16px">Please select a month : </p>

                                    </div>
                                    <div class="col-7">
                                        <input type="month" value="01-06-2017" max="<?php echo date("Y-m-d") ?>" class="form-control form-control-lg" name="payperiod" id="payperiod">

                                    </div>
                                    <div class="col-1">
                                    </div>
                                    <div class="col-1">
                                        <div>
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
                                <table id="datatables-payroll" class="table table-striped" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Employee No</th>
                                        <th>NIC</th>
                                        <th>Basic Salary </th>
                                        <th>Allowance </th>
                                        <th>Incentives </th>
                                        <th>Gross Salary</th>
                                        <th>Payee</th>
                                        <th style="mso-number-format:'\@'">8%</th>
                                        <th>12%</th>
                                        <th>3%</th>
                                        <th>20%</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php


                                    while ($OrderRow=$orderResult->fetch_assoc()){


                                        $payslip_id=$OrderRow["payment_id"];
                                        $payslip_id_encoded=base64_encode($payslip_id);

                                        ?>
                                        <tr>
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
                                                ?>
                                            </td>
                                            <td><?php echo 'EMP - ' . sprintf('%03d', $emp_id) ; ?></td>
                                            <td><?php echo $empRow["user_nic"]; ?></td>
                                             <?php

                                                $ciphering = "AES-128-CTR";
                                                $decryption_iv = 'rqEJKQ+COwSInxjv';

                                                // Store the decryption key
                                                $decryption_key = "A$6Q{5M*AMsT,VRPQ@M5-=x>Y.^nQh9n";
                                                $options = 0;

                                                // Use openssl_decrypt() function to decrypt the data
                                                $salary = openssl_decrypt($OrderRow["amount"], $ciphering, $decryption_key, $options, $decryption_iv);
                                                $total_amount = openssl_decrypt($OrderRow["total_amount"], $ciphering, $decryption_key, $options, $decryption_iv);
                                                $incentive = openssl_decrypt($OrderRow["incentives"], $ciphering, $decryption_key, $options, $decryption_iv);
                                                $travel_allowance = openssl_decrypt($OrderRow["travel_allowance"], $ciphering, $decryption_key, $options, $decryption_iv);
                                                $tax= openssl_decrypt($OrderRow["tax"], $ciphering, $decryption_key, $options, $decryption_iv);
                                                $epf8 = openssl_decrypt($OrderRow["epf8"], $ciphering, $decryption_key, $options, $decryption_iv);
                                                $epf12 = openssl_decrypt($OrderRow["epf12"], $ciphering, $decryption_key, $options, $decryption_iv);
                                                $etf3 = openssl_decrypt($OrderRow["etf3"], $ciphering, $decryption_key, $options, $decryption_iv);

                                                $gross = $salary+$travel_allowance+$incentive;
                                                $epf20 = $epf8+$epf12;

                                                $formatted_basic = number_format((float)$salary, 2, '.', ',');
                                                $formatted_total = number_format((float)$total_amount, 2, '.', ',');
                                                $formatted_incentive = number_format((float)$incentive, 2, '.', ',');
                                                $formatted_travel = number_format((float)$travel_allowance, 2, '.', ',');
                                                $formatted_tax = number_format((float)$tax, 2, '.', ',');
                                                $formatted_epf8 = number_format((float)$epf8, 2, '.', ',');
                                                $formatted_epf12 = number_format((float)$epf12, 2, '.', ',');
                                                $formatted_etf3 = number_format((float)$etf3, 2, '.', ',');
                                                $formattedgross = number_format((float)$gross, 2, '.', ',');
                                                $formattedepf20 = number_format((float)$epf20, 2, '.', ',');
                                             ?>

                                            <td><?php echo $formatted_basic ?></td>
                                            <td><?php echo $formatted_travel ?></td>
                                            <td><?php echo $formatted_incentive ?></td>
                                            <td><?php echo $formattedgross ?></td>
                                            <td><?php echo $formatted_tax ?></td>
                                            <td><?php echo $formatted_epf8 ?></td>
                                            <td><?php echo $formatted_epf12 ?></td>
                                            <td><?php echo $formatted_etf3 ?></td>
                                            <td><?php echo $formattedepf20 ?></td>
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
        </main>
        <?Php
        include "footer.php";
        ?>
    </div>
</div>

<script src="js/app.js"></script>

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
    document.addEventListener("DOMContentLoaded", function() {

        // Datatables clients
        $("#datatables-payroll").DataTable({
            responsive: true,
            order: [
                [1, "desc"]
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    download: 'open',
                    exportOptions: {
                        columns: [ 0, ':visible' ]
                    },
                    title: 'EPF & ETF Calculation',
                    filename: 'Payroll',


                    customize: function ( doc ) {

                        var cols = [];
                        cols[0] = {image: 'data:image/png;base64,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giZCvbXX1j9pAFxuwNcNRAhdxgChGN6X2btklponJLlRGx8jeNBs4b3odXcjee9BdRfwhA0NAi+oKl6VwcHBoHpVRPUZYxxVfVzhmclSCd66Xcn2jFmKTetr7BHT+o32TsmAnDTLyNZ13tb8lVDUbjRFX2tj0rB3DOwGHrPfa2x+E3BDI1NLIk0ScA6vOhaLpPfaNWOW2BLH1PQ07atXY9oNJi5SiJ2bmC6XMQu6geBiKYhFEz4bd2qEbNxmfKYF74iBlXXbdjvvKKHJP9/2r5iFPUHoWhzBCocJRW4bwdvSvQuEON3OnOu30NBZLLlJ7d2wgai5GfV+h4g8YAceV9VPisiLzjkQoTo9TZzLoaq3iMgu09YxVb1DVZ8+ODLiCJX3qgwPU8bYFAsD9gUNyj1mytjAfE85QXCnc03oxj1TgMYX2XuU4J4dGT5SZcy2cku3NMD6yr3AA4Q26jwR+QaqX/PevwkQ5/Oo930i8nUDbIJwKzHpnMM55733S/0CUyUTgBto6DTjo8xPMik13pWdbu8iIY6dlhZNBFnqaG0ljmNUdQzYLSLXEoL3ZYhsIwTj9cB2EbmX4CYAP/JJ8pV8S8vR0sQE67u6OHnq1FKPfU/Ski3t8LFj9PX0pP7QQjDhNPh+jBCcKwTzzrr9pIvj6szUFE253ErL+x+hJVsawKmJCda2t4NqnZCqHxaR44SCNWLu/uw48APgWVT/BhQQ4eCRI//1VgbLsLQsqUjdiTxq5cVeEfkEsAfV3yFyj8JrV23d+v1/7NtHel0kblnVzXualv2Nd2DjRgC8zL4aI7IFGBORE6p6ASAuio742txFbOEs+vr+tj+MXzwwQLViHUj6wcXu4xSI45h6tXpWgZXSO/rfBAP2cRmR8JgLppeZBwqFlZbvXaF/AfBCeZNa5f0cAAAAtGVYSWZJSSoACAAAAAYAEgEDAAEAAAABAAAAGgEFAAEAAABWAAAAGwEFAAEAAABeAAAAKAEDAAEAAAACAAAAEwIDAAEAAAABAAAAaYcEAAEAAABmAAAAAAAAAEgAAAABAAAASAAAAAEAAAAGAACQBwAEAAAAMDIxMAGRBwAEAAAAAQIDAACgBwAEAAAAMDEwMAGgAwABAAAA//8AAAKgBAABAAAANAEAAAOgBAABAAAAfgAAAAAAAACom/WPAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDI0LTAyLTAxVDA4OjI0OjQ3KzAwOjAwwIiYMAAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyNC0wMi0wMVQwODoyNDo0NyswMDowMLHVIIwAAAAodEVYdGRhdGU6dGltZXN0YW1wADIwMjQtMDItMDFUMDg6MjQ6NTgrMDA6MDDcInEkAAAAFXRFWHRleGlmOkNvbG9yU3BhY2UANjU1MzUzewBuAAAAIHRFWHRleGlmOkNvbXBvbmVudHNDb25maWd1cmF0aW9uAC4uLmryoWQAAAATdEVYdGV4aWY6RXhpZk9mZnNldAAxMDJzQimnAAAAFXRFWHRleGlmOkV4aWZWZXJzaW9uADAyMTC4dlZ4AAAAGXRFWHRleGlmOkZsYXNoUGl4VmVyc2lvbgAwMTAwEtQorAAAABh0RVh0ZXhpZjpQaXhlbFhEaW1lbnNpb24AMzA4S20cMQAAABh0RVh0ZXhpZjpQaXhlbFlEaW1lbnNpb24AMTI2AGhmrAAAABd0RVh0ZXhpZjpZQ2JDclBvc2l0aW9uaW5nADGsD4BjAAAAAElFTkSuQmCC'
                            , alignment: 'left', margin:[30] };
                        cols[1] = {text: 'Payroll Report', alignment: 'right', margin:[0,0,20] };
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
                    autoFilter: true,
                    download: 'open',
                    header: true,
                    exportOptions: {
                        columns: [ 0, ':visible' ],
                        charSet: "utf-8",
                        
                    },
                    title: 'EPF & ETF Calculation',
                    filename: 'Payroll',
                    customizeData: function (data) {
                        for (var i = 0; i < data.header.length; i++) {
                                data.header[i] = '\u200C' + data.header[i];
                        }
                    }
                },
                {
                    extend: 'spacer',
                    style: 'empty',
                },
                'colvis',
            ]

        });

    });
    loadData= function () {

        var payperiod = $('#payperiod').val();

        var payperiodmonth = new Date(payperiod);
        var yearmonth = payperiodmonth.toLocaleString('default', { year: "numeric", month: 'long' });

        var url2 = "../controller/order_controller.php?status=load_payroll_date_range";

        $.post(url2, {payperiod:payperiod}, function (data) {
            /*show the data that is being responded by server in the div id myfunctions*/
            $('#datatables-payroll').parents('div.dataTables_wrapper').first().hide();
            $("#show-filtered-table").html(data).show();
            $("#load_data").DataTable({
                responsive: true,
                order: [
                    [1, "asc"]
                ],
                dom: 'Bfrtip',

                buttons: [
                    {
                        extend: 'pdfHtml5',
                        text: 'PDF',
                        title: 'EPF & ETF calculation for the month of ' + yearmonth,
                        download: 'open',
                        exportOptions: {
                            columns: [ 0, ':visible' ]
                        },
                        filename: 'Payroll_'+ yearmonth,

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
                        title: 'EPF & ETF calculation for the month of ' + yearmonth,
                        autoFilter: true,
                        download: 'open',
                        exportOptions: {
                            columns: [ 0, ':visible' ]
                        },
                        filename: 'Payroll_' + yearmonth,
                        customizeData: function (data) {
                            for (var i = 0; i < data.header.length; i++) {
                                data.header[i] = '\u200C' + data.header[i];
                            }
                        }

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

</script>
</body>

</html>