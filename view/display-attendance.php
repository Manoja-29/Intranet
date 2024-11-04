<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 5 Admin &amp; Dashboard Template">
    <meta name="author" content="Bootlab">

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
    include "../model/attendance_model.php";
    $attendanceObj=new Attendance();
    $attendanceResult=$attendanceObj->getAllAttendance();
    include "../model/employee_model.php";
    $employeeObj=new Employee();
    ?>
    <div class="main">
        <?php
        include_once "topbar.php";
        ?>
        <main class="content">
            <div class="container-fluid p-0">

                <h1 class="h3 mb-3">Employee Attendance</h1>

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
                                <!-- <h5 class="card-title mb-0">Attendance</h5> -->

                            </div>
                            <div class="card-header">
                                <div class="row">
                                <div class="col-3">
                                    <p>User :</p>
                                    <select class="form-control mb-3" id="user_id">
                                        <option selected>Select a user</option>
                                        <?php
                                        include "../model/user_modal.php";

                                        $UserObj=new User();
                                        $UserResult=$UserObj->getAllUsers();
                                        while ($user_row=$UserResult->fetch_assoc()) {
                                        ?>
                                        <!--value is similar to ID attribute-->
                                        <option value="<?php echo $user_row["user_id"];?>">

                                            <?php echo $user_row["user_fname"].' '.$user_row["user_lname"];
                                            }
                                            ?>
                                        </option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <p>From :</p>
                                    <input type="date" value="01-06-2017" max="<?php echo date("Y-m-d") ?>" class="form-control" name="payDate" id="startDate">

                                </div>
                                <div class="col-4">
                                    <p>To :</p>
                                    <input type="date" value="01-06-2017" max="<?php echo date("Y-m-d") ?>" class="form-control" name="payDate" id="endDate">

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
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Date</th>
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                        <th>Entry</th>
                                        <th>Exit</th>
                                        <th>Edit Status</th>
                                        <th>Action</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php


                                    while ($OrderRow=$attendanceResult->fetch_assoc()){


                                        ?>
                                        <tr>
                                            <td><?php echo $OrderRow["user_id"]; ?></td>
                                            <td><?php echo $OrderRow["user_fname"].' '.$OrderRow["user_lname"]; ?></td>

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
                                            <td>
                                                <?Php
                                                $user_id=$OrderRow["user_id"];
                                                $user_id=base64_encode($user_id);
                                                ?>
                                                <a href="edit-attendance.php?user_id=<?php echo $user_id ?>&date=<?php echo $OrderRow["date"]?>" class="badge bg-info"><span class="fa fa-edit"></span>&nbsp&nbspEdit</a>

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
        $("#datatables-attendance").DataTable({
            responsive: true,
            order: [
                [2, "desc"]
            ],
            dom: 'Bfrtip',
            title: 'Attendance report',

            buttons: [
            {
                extend: 'pdfHtml5',
                text: 'PDF',
                download: 'open',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                },
                title: 'Attendance Report : ' + new Date().toDateString(),
                filename: 'Attendance Report : ' + new Date().toDateString(),


                customize: function ( doc ) {
                    doc.content[1].alignment = 'center';
                    doc.content[1].margin = [ 20, 0, 20, 0 ] //left, top, right, bottom

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
                autoFilter: true,
                download: 'open',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                },
                title: 'Attendance Report : ' + new Date().toDateString(),
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

        var user_id = $('#user_id').find(":selected").val();
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        // alert(user_id + startDate + endDate);

        if((startDate || endDate ) == "")
        {
            var url = "../controller/attendance_controller.php?status=load_user_data";

            $.post(url, {user_id: user_id}, function (data) {
                /*show the data that is being responded by server in the div id myfunctions*/
                $('#datatables-attendance').parents('div.dataTables_wrapper').first().hide();

                $("#show-filtered-table").html(data).show();
                $("#load_data").DataTable({
                    responsive: true,
                    order: [
                        [1, "desc"]
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
                                cols[0] = {image: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAE0AAAAgCAYAAABXY/U0AAAAIGNIUk0AAHomAACAhAAA+gAAAIDoAAB1MAAA6mAAADqYAAAXcJy6UTwAAAAGYktHRAD/AP8A/6C9p5MAAAAJcEhZcwAACxIAAAsSAdLdfvwAAAAHdElNRQfoAgEIGDq+uxcZAAAAAW9yTlQBz6J3mgAACR1JREFUaN7tmm1snlUZx3/Xue/2edZ1bdfRAWPt2rXjbaABB0gUAUWZaDB8GfhBEoEPviYmauIHY0wk+kWzT5IIifLBtww0SkIkhsBAQYUor3vBrs+2dmNrYev6tE+fPi/3ufxwrru9+5TVFmTF6ZXc6bNzzn3Odf2v93MP/k/LJllssgNY19eHJomtFgRQVQonT9Lb2cmh4eGVluGMk1tssrOnB00SRAQRYeLkSQBEhL7OzsURP4tpgdy93d0BSRFQBdVInLtV4SURKaB6nYqs9d4/KpCoarA+4NCRIystzxmhuHEgcg5VBcgl3tfiKFqPyHcFxoDHEblLYNKJ/Mk5N94Ux8xUq/9TVrcANFUFkZzA9+I4Xg+0AZcA7wNusmVlEfm29/71SrVaVPipQLLSwpwpmmcgfT09AHiIYpGfA3fYVB0YBiaA84DzM689WPf+HieSOBGGDh9eaZnedZpNBAObNgUEVeMILgA6beo4qt9E9SZV/biqbgfuAyo2P354ZCQRoDg5udLynBGK0h9r29pwTU2I6t0ich+wTVVrwLeccz9W1VOqWhaRUVV9UkR6gCuAgc6Ojn6gIPBGcWpqALgS6AcuAjYBvQQrnVkmb93AJCHPLIWE4AkzgF/GWavsveJSFs9amoqA9xiT643pvdVK5beVmRlUFSfBm51zZVQfNCC6FD4IROIcwBQwClSBrcAb9lRNqObMky15mhrmVgEfBlY3jGcpOx4ZuBUDzDXMN73FWLrfWuCqpSI8mwgE8N5TT5JdTXF8K/BZETnanMtNIIJ6z9DwMAN9fXjvQeR1CZppR/UnIvJKEorg4/Z0mfZetiM6gB1AnjnLSYAnCVY5wFwyEWA/0APcboCnSj4CPA98FGg3gNKq51kD4BRwTQZIAU4CLwIfMrDS8SKwD5ZeAMyCpoSiNY6iK4D32/B6RFajWsV7Bnp7qddqRMGizkGklfDe9QoPrcrn39zS38/g0FAqYPp44HKgBDxlwngDajsh0TwC1DK8OYJ7/4G5+CnAzcD1BuTDtk6BjcDV9jsHvAQcsHfEFFIxYFML82ZhW1lG9p9XcjjnSJJkG9BqQ5eJ6s3i3K89kFh3UKtWo6Zc7nbTKoRS5DJgN3ra8NMCXGx7p4LmDcgEONGwPm8gTmQsDbOMtUCBEApSGs1YjyNYe2NmutIASmOXJ1QCYw17LRE0kdTtfqaqz4nIL4BLELnXey/AH03ArqZc7i7gbgKXjwjsFNXnFUhqNdpaWylOTaWWkRV2P/B35mJZYox/ihD0sxaVAtDoNulYYwvoMmurhORTz6yvESx7CBi09YmNtxBcfQNQJrj3abU/y9Dmnh5EJO0G2kXkMUKAB5gG9po19AJbUqYVPu+T5FeoJi6K6up9zjnXPDQ8rMBm4BVjYDVwnf1NAakAfwb6WBjTDpnQrzLfdS4kJIlxQu2YUovxhfH5ATOK9KwpA+vyzDgEi37OQOsnWOwzdvbioGXBA9YJ7ESkndANbGlYVgNeA/Kq+kMRuQgYUtgFfFnC4V+YLpdL+Xyeg/NvQrJnNmpzsbm3Q6fb7x2dswC0gf5+RJWkXm9JkqQSRdFnROSXhLLhnwTr243qA0CLwoyI7ATWEeLMhUAR1R0KexSaE++POufOmmukhZbW3R1uN9xsyOgSka+i+pSHZ0Xkc6iOichtwKcJmlr3FnsfAooK+1T1LoHpQgCtA9hGyHBKcPPXgRd459Z1HsELTphs5xKC/HIK3X9LCxr2wsgIAAObN6eXj280tbZ+p14uI/U6Du53UUTi/UeYa7X2Ab8HjhJi022E2Afwlybnput+lu+rCQllP3PBvEyILS3MdSlVQvbryIzVCbGshRAbyaw9RSiVKszFwRlCUVttUEiz7dWRwSDdO7LxbKIpkulmFoCW0oFCgc3d3STVKmoCO+dQ6E+8307IeABPo/pFnNuLKs1r1lCdnHwIuB+4VGBr3ftrgFdbVq0qTZfLaQ01mjkuB9xJCNY1Y3jM/nbZWFqiHDbhLrUxJSSGA4S6rhk4B3jT1keEAnrazmoi1Hne9q5keDhmyljN/OTzAnAw/UfEIjReLDJRKjFeLNLR1oaLIhTuFNhpB46r6pdE5Hn1niiXo1oqISIjCkUJwG4WkVuAl6MoGpwqlS4k1FDZuihPiIW/IXQQewgue6NZ5HFCRV82sPbYeyWzgiZCvbXX1j9pAFxuwNcNRAhdxgChGN6X2btklponJLlRGx8jeNBs4b3odXcjee9BdRfwhA0NAi+oKl6VwcHBoHpVRPUZYxxVfVzhmclSCd66Xcn2jFmKTetr7BHT+o32TsmAnDTLyNZ13tb8lVDUbjRFX2tj0rB3DOwGHrPfa2x+E3BDI1NLIk0ScA6vOhaLpPfaNWOW2BLH1PQ07atXY9oNJi5SiJ2bmC6XMQu6geBiKYhFEz4bd2qEbNxmfKYF74iBlXXbdjvvKKHJP9/2r5iFPUHoWhzBCocJRW4bwdvSvQuEON3OnOu30NBZLLlJ7d2wgai5GfV+h4g8YAceV9VPisiLzjkQoTo9TZzLoaq3iMgu09YxVb1DVZ8+ODLiCJX3qgwPU8bYFAsD9gUNyj1mytjAfE85QXCnc03oxj1TgMYX2XuU4J4dGT5SZcy2cku3NMD6yr3AA4Q26jwR+QaqX/PevwkQ5/Oo930i8nUDbIJwKzHpnMM55733S/0CUyUTgBto6DTjo8xPMik13pWdbu8iIY6dlhZNBFnqaG0ljmNUdQzYLSLXEoL3ZYhsIwTj9cB2EbmX4CYAP/JJ8pV8S8vR0sQE67u6OHnq1FKPfU/Ski3t8LFj9PX0pP7QQjDhNPh+jBCcKwTzzrr9pIvj6szUFE253ErL+x+hJVsawKmJCda2t4NqnZCqHxaR44SCNWLu/uw48APgWVT/BhQQ4eCRI//1VgbLsLQsqUjdiTxq5cVeEfkEsAfV3yFyj8JrV23d+v1/7NtHel0kblnVzXualv2Nd2DjRgC8zL4aI7IFGBORE6p6ASAuio742txFbOEs+vr+tj+MXzwwQLViHUj6wcXu4xSI45h6tXpWgZXSO/rfBAP2cRmR8JgLppeZBwqFlZbvXaF/AfBCeZNa5f0cAAAAtGVYSWZJSSoACAAAAAYAEgEDAAEAAAABAAAAGgEFAAEAAABWAAAAGwEFAAEAAABeAAAAKAEDAAEAAAACAAAAEwIDAAEAAAABAAAAaYcEAAEAAABmAAAAAAAAAEgAAAABAAAASAAAAAEAAAAGAACQBwAEAAAAMDIxMAGRBwAEAAAAAQIDAACgBwAEAAAAMDEwMAGgAwABAAAA//8AAAKgBAABAAAANAEAAAOgBAABAAAAfgAAAAAAAACom/WPAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDI0LTAyLTAxVDA4OjI0OjQ3KzAwOjAwwIiYMAAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyNC0wMi0wMVQwODoyNDo0NyswMDowMLHVIIwAAAAodEVYdGRhdGU6dGltZXN0YW1wADIwMjQtMDItMDFUMDg6MjQ6NTgrMDA6MDDcInEkAAAAFXRFWHRleGlmOkNvbG9yU3BhY2UANjU1MzUzewBuAAAAIHRFWHRleGlmOkNvbXBvbmVudHNDb25maWd1cmF0aW9uAC4uLmryoWQAAAATdEVYdGV4aWY6RXhpZk9mZnNldAAxMDJzQimnAAAAFXRFWHRleGlmOkV4aWZWZXJzaW9uADAyMTC4dlZ4AAAAGXRFWHRleGlmOkZsYXNoUGl4VmVyc2lvbgAwMTAwEtQorAAAABh0RVh0ZXhpZjpQaXhlbFhEaW1lbnNpb24AMzA4S20cMQAAABh0RVh0ZXhpZjpQaXhlbFlEaW1lbnNpb24AMTI2AGhmrAAAABd0RVh0ZXhpZjpZQ2JDclBvc2l0aW9uaW5nADGsD4BjAAAAAElFTkSuQmCC'
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

        else {

            var url2 = "../controller/attendance_controller.php?status=load_user_date_range";

            $.post(url2, {user_id: user_id,startDate:startDate,endDate:endDate}, function (data) {
                /*show the data that is being responded by server in the div id myfunctions*/
                $('#datatables-attendance').parents('div.dataTables_wrapper').first().hide();
                $("#show-filtered-table").html(data).show();
                $("#load_data").DataTable({
                    responsive: true,
                    order: [
                        [1, "desc"]
                    ],
                    columnDefs: [
                        {
                            target: 8,
                            visible: false,
                        },
                        {
                            target: 9,
                            visible: false,
                        }
                    ],
                    dom: 'Bfrtip',
                    title: 'Attendance report',

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

    };


</script>
</body>

</html>