<?php
//ini_set("memory_limit","200GB");

if(isset($_REQUEST["status"]))
{
    include '../model/attendance_model.php';
    $attendanceObj=new Attendance();
    //using the model in controller
    $status=$_REQUEST["status"];
    switch ($status) {

        case "check_login":
            $user_id=$_POST["user_id"];

            date_default_timezone_set('Asia/Kolkata');
            $check_in_time=date('H:i');

                /*If current user has already checked in for the day (check user_id and date) display ajax section*/

                ?>
                <div id="display-loggedIn">
                    <h2 class="heading">Attendance</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <hr>
                            <button class="btn btn-success btn-block" id="checkin" type="submit">Check-in</button>
                            <button class="btn btn-success btn-block" disabled id="test-checkin" type="submit">Test check-in button</button>
                        </div>
                        <div class="col-md-6">
                            <hr>
                            <button class="btn btn-danger btn-block" name="checkout" type="submit">Check-out</button>
                        </div>
                    </div>
                    <input type="hidden" name="check-in-time" value="<?php echo $check_in_time ?>">
                    <br>
                    <div class="form-group">
                        <input type="hidden" id="user_id" class="floatLabel" name="user_id" value="<?php echo $user_id?>">
                        <h3>Checked in at <?php echo $check_in_time.'am' ?></h3>
                        <br><br>
                        <?php
                        $attendanceResult = $attendanceObj->getAttendanceDetails();
                        ?>
                        <table class="table table-striped" id="example">
                            <thead>
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Check-in</th>
                                <th scope="col">Check-out</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            while ($userRow=$attendanceResult->fetch_assoc()) {
                                ?>
                                <tr>
                                <td><?php echo $userRow["date"]?></td>
                                <td><?php echo $userRow["check_in"].'am'?></td>
                                <td><?php echo $userRow["check_out"].'pm'?></td>
                            </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php
                $attendanceID = $attendanceObj->addAttendance($user_id, $check_in_time);
/*              $msg="Successfully checked in";
                $msg=base64_encode($msg);

                */?>
            <?php
            ?>
            <script>
                $(document).ready(function () {
                $("#example").dataTable();

                });
            </script>

            <?php

            break;

        case "add_attendance": /*update check out*/

            echo $user_id=$_POST["user_id"];
            echo "<br/>";

            date_default_timezone_set('Asia/Kolkata');
            echo $check_out_time=date('H:i');
            echo "<br/>";

            $dateToday=date("Y-m-d");

            try{

                if($user_id==""){
                    throw new exception("Please login");
                }

                if($check_out_time==""){
                    throw new exception("Check out time is empty");
                }


                $checkedout=$attendanceObj->userCheckedOut($user_id,$dateToday);
                if($checkedout==false){
                    throw new exception("Already checked out");
                }

                $attendanceID = $attendanceObj->updateCheckout($check_out_time, $user_id, $dateToday);

                $msg="Successfully logged out";
                $msg=base64_encode($msg);

                ?>
                <script>
                     window.location = "../view/add-attendance.php?msg=<?php echo $msg; ?>"
                </script>
                <?php

            }

            catch (Exception $exception)
            {
                $msg=$exception->getMessage();
                $msg=base64_encode($msg);

                ?>
              <script>
                    window.location = "../view/add-attendance.php?msg=<?php echo $msg; ?>"
                </script>

                <?php
            }

            break;

        case "edit_attendance":

            echo $user_id = $_POST['user_id'];
            echo $check_in= $_POST['check_in'];
            echo $check_out = $_POST['check_out'];
            echo $update_reason = $_POST['update_reason'];
            $status=1;
            echo $updated_date=$_POST['date_added'];

            $attendanceObj->updateAttendance($user_id,$check_in,$check_out,$status,$update_reason,$updated_date);

            if($user_id>0){/*check if user is available*/
                $msg="Successfully Updated";
                $msg=base64_encode($msg);
                ?>
                <script>
                    window.location = "../view/display-attendance.php?msg=<?php echo $msg; ?>"
                </script>

                <?php
            }

            break;

        case "load_user_data":
            $user_id=$_POST["user_id"];

            $attendanceResult=$attendanceObj->getUserAttendance($user_id);
            ?>
            <table id="load_data" class="table" style="width:100%">
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
                            //
                            if ($check_in == ''){
                                echo '<span class="text-danger">Absent</span>';
                            }else{
                                if ($time_def>1) {
                                    echo '<span class="text-success">+'. intdiv($time_def, 60).'H +'. ($time_def % 60).'M'.'</span>';
                                }else{
                                    echo '<span class="text-danger">'. intdiv($time_def, 60).'H '. ($time_def % 60).'M'.'</span>';

                                }
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
                                if ($time_def2 > 1) {
                                    echo '<span class="text-success">+' . intdiv($time_def2, 60) . 'H +' . ($time_def2 % 60) . 'M' . '</span>';
                                } else {
                                    echo '<span class="text-danger">' . intdiv($time_def2, 60) . 'H ' . ($time_def2 % 60) . 'M' . '</span>';

                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            $updatestatus=$OrderRow["update_status"];
                            if ($updatestatus==1){
                                ?>
                                <span class="fas fa-circle chat-offline"></span><span class="text-white">E</span>
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
            <p><?php echo '<span class="text-danger">*Please select a duration to populate the summary of entry and exit</span>'?></p>
            <?php
            break;

        case "load_user_date_range":

            $user_id=$_POST["user_id"];
            $startDate=$_POST["startDate"];
            $endDate=$_POST["endDate"];

            $attendanceResult=$attendanceObj->getUserAttendanceDateRange($user_id,$startDate,$endDate);
            ?>
            <div id="show-filtered-table">
                <table id="load_data" class="table" style="width:100%">
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
                        <th>Entry(Minutes)</th>
                        <th>Exit(Minutes)</th>
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
                            <td>
                                <?php
                                $updatestatus=$OrderRow["update_status"];
                                if ($updatestatus==1){
                                    ?>
                                    <span class="fas fa-circle chat-offline"></span><span class="text-white">E</span>
                                    <?php
                                }else{
                                    ?>
                                    <span class="fas fa-circle chat-online"> </span>

                                    <?php
                                }
                                ?>
                            </td>
                            <td> <?php
                                date_default_timezone_set('Asia/Colombo');
                                $check_in=$OrderRow["check_in"];
                                $time1 = strtotime('08:00 AM');
                                $time2 = strtotime($OrderRow["check_in"]);
                                $time_def = ($time1-$time2)/60; //minutes
                                //
                                if ($check_in == ''){
                                    echo 0;
                                }else{
                                    echo $time_def;
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
                                    echo 0;
                                }else {
                                    echo $time_def2;

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
                <br><br>
                <div class="col-lg-12 col-xxl-12">
                    <div class="card">
                        <div class="card-header bg-light">
                            <div class="card-actions float-end">

                            </div>
                            <h5 class="card-title mb-0">Summary</h5>
                        </div>

                        <div class="card-body">

                            <dl class="row">
                                <dt class="col-1 col-xxl-1"><b>Check In :</b></dt>
                                <dd class="col-3 col-xxl-3">
                                    <p class="mb-1"><span id="val"></span></p>
                                </dd>

                                <dt class="col-1 col-xxl-1"><b>Check Out :</b></dt>
                                <dd class="col-3 col-xxl-3">
                                    <p class="mb-1"><span id="val2"></span></p>
                                </dd>

                                <dt class="col-1 col-xxl-1"><b>Time Period:</b></dt>
                                <dd class="col-3 col-xxl-3">
                                    <p class="mb-1" id="time-period"><?Php echo $startDate.' to '.$endDate?></p>
                                </dd>
                            </dl>

                        </div>
                    </div>

                </div>

                <script>

                    //check in
                   var table = document.getElementById("load_data"), sumVal = 0;
                   for(var i = 1; i < table.rows.length; i++)
                   {
                       var tableValue = parseFloat(table.rows[i].cells[8].innerHTML)

                       if (tableValue<1){
                           sumVal = sumVal + tableValue;

                           var hours = sumVal / 60;
                           var minutes = sumVal % 60;
                           if(sumVal>1){
                               document.getElementById("val").innerHTML = Math.floor(hours)+' Hours '+minutes+' Minutes early';
                               document.getElementById("val").style.color = 'green';

                           }else{
                               document.getElementById("val").innerHTML = Math.trunc(hours)+' Hours '+minutes+' Minutes late';
                               document.getElementById("val").style.color = 'red';

                           }

                       }


                   }


                   //check out
                   var table2 = document.getElementById("load_data"), sumVal2 = 0;
                   for(var x = 1; x < table.rows.length; x++)
                   {
                       var tableValueCheckout=parseFloat(table.rows[x].cells[9].innerHTML);

                       if (tableValueCheckout<1) {
                           sumVal2 = sumVal2 + tableValueCheckout;

                           var outhours = sumVal2 / 60;
                           var outminutes = sumVal2 % 60;
                           if(sumVal2>1){
                               document.getElementById("val2").innerHTML = Math.floor(outhours)+' Hours '+outminutes+' Minutes late';
                               document.getElementById("val2").style.color = 'green';

                           }else{
                               document.getElementById("val2").innerHTML = Math.trunc(outhours)+' Hours '+outminutes+' Minutes early';
                               document.getElementById("val2").style.color = 'red';

                           }
                       }
                   }


                    //start and end date
                   var enddate = document.getElementsByTagName('p')[0].innerHTML;
                    document.getElementById('p')[0].style.color = 'blue';


                </script>

            </div>


            <?php
            break;
            
            case "load_attendance_user_date":

                $user_id=$_POST["user_id"];
                $startDate=$_POST["startDate"];
                $endDate=$_POST["endDate"];
    
                $attendanceResult=$attendanceObj->getUserAttendanceDateRange($user_id,$startDate,$endDate);
                ?>
                <div id="show-filtered-table">
                <table id="datatables-loadData" class="table" style="width:100%">
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
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
    
                <?php
                break;

            case "load_user_date":

                $user_id=$_POST["user_id"];
                $startDate=$_POST["startDate"];
                $endDate=$_POST["endDate"];
    
                $attendanceResult=$attendanceObj->getUserAttendanceDateRange($user_id,$startDate,$endDate);
                ?>
                <div id="show-filtered-table">
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
                    <br><br>
                    <div class="col-lg-12 col-xxl-12">
                        <div class="card">
                            <div class="card-header bg-light">
                                <div class="card-actions float-end">
    
                                </div>
                                <h5 class="card-title mb-0">Summary</h5>
                            </div>
    
                            <div class="card-body">
    
                                <dl class="row">
                                    <dt class="col-1 col-xxl-1"><b>Check In :</b></dt>
                                    <dd class="col-3 col-xxl-3">
                                        <p class="mb-1"><span id="val"></span></p>
                                    </dd>
    
                                    <dt class="col-1 col-xxl-1"><b>Check Out :</b></dt>
                                    <dd class="col-3 col-xxl-3">
                                        <p class="mb-1"><span id="val2"></span></p>
                                    </dd>
    
                                    <dt class="col-1 col-xxl-1"><b>Time Period:</b></dt>
                                    <dd class="col-3 col-xxl-3">
                                        <p class="mb-1" id="time-period"><?Php echo $startDate.' to '.$endDate?></p>
                                    </dd>
                                </dl>
    
                            </div>
                        </div>
    
                    </div>
    
                    <script>
    
                        //check in
                       var table = document.getElementById("load_data"), sumVal = 0;
                       for(var i = 1; i < table.rows.length; i++)
                       {
                           var tableValue = parseFloat(table.rows[i].cells[8].innerHTML)
    
                           if (tableValue<1){
                               sumVal = sumVal + tableValue;
    
                               var hours = sumVal / 60;
                               var minutes = sumVal % 60;
                               if(sumVal>1){
                                   document.getElementById("val").innerHTML = Math.floor(hours)+' Hours '+minutes+' Minutes early';
                                   document.getElementById("val").style.color = 'green';
    
                               }else{
                                   document.getElementById("val").innerHTML = Math.trunc(hours)+' Hours '+minutes+' Minutes late';
                                   document.getElementById("val").style.color = 'red';
    
                               }
    
                           }
    
    
                       }
    
    
                       //check out
                       var table2 = document.getElementById("load_data"), sumVal2 = 0;
                       for(var x = 1; x < table.rows.length; x++)
                       {
                           var tableValueCheckout=parseFloat(table.rows[x].cells[9].innerHTML);
    
                           if (tableValueCheckout<1) {
                               sumVal2 = sumVal2 + tableValueCheckout;
    
                               var outhours = sumVal2 / 60;
                               var outminutes = sumVal2 % 60;
                               if(sumVal2>1){
                                   document.getElementById("val2").innerHTML = Math.floor(outhours)+' Hours '+outminutes+' Minutes late';
                                   document.getElementById("val2").style.color = 'green';
    
                               }else{
                                   document.getElementById("val2").innerHTML = Math.trunc(outhours)+' Hours '+outminutes+' Minutes early';
                                   document.getElementById("val2").style.color = 'red';
    
                               }
                           }
                       }
    
                        //start and end date
                       var enddate = document.getElementsByTagName('p')[0].innerHTML;
                        document.getElementById('p')[0].style.color = 'blue';
    
                    </script>
    
                </div>
    
                <?php
                break;

                case "load_date_range":

                    $startDate=$_POST["startDate"];
                    $endDate=$_POST["endDate"];
        
                    $attendanceResult=$attendanceObj->getAttendanceDateRange($startDate,$endDate);
                    ?>
                    <div id="show-filtered-table">
                        <table id="load_data1" class="table" style="width:100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Date</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                            </tr>
                            </thead>
                        <tbody>
                            <?php
        
                            while ($OrderRow=$attendanceResult->fetch_assoc()){      
                                ?>
                                <tr>
                                    <td><?php echo $OrderRow["attendance_id"]; ?></td>
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
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    
                        <br><br>
                    </div>
                    <?php
                    break;

                    case "deleteAttendance":
                        if (isset($_POST['startDate'], $_POST['endDate'])) {
                            $startDate = $_POST['startDate'];
                            $endDate = $_POST['endDate'];
                    
                            if (!empty($startDate) && !empty($endDate)) {
                                if (DateTime::createFromFormat('Y-m-d', $startDate) && DateTime::createFromFormat('Y-m-d', $endDate)) {
                                    $deleteResult = $attendanceObj->deleteAttendanceByDateRange($startDate, $endDate);
                    
                                    if ($deleteResult) {
                                        echo "success";
                                    } else {
                                        echo "error: Unable to delete records.";
                                    }
                                } else {
                                    echo "error: Invalid date format. Please use YYYY-MM-DD.";
                                }
                            } else {
                                echo "error: Start date and end date are required.";
                            }
                        } else {
                            echo "error: Start date and end date are required.";
                        }
                        break;

        }
    }

?>