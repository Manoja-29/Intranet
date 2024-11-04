<?php
include "../commons/session.php";

include "../model/holiday-leave-model.php";
$holidayObj=new HolidayLeave();

include "../model/user-model.php";
$UserObj=new User();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../commons/PHPMailer/src/Exception.php';
require '../commons/PHPMailer/src/PHPMailer.php';
require '../commons/PHPMailer/src/SMTP.php';
require '../commons/vendor/autoload.php';

if(isset($_REQUEST["status"]))
{
    //using the model in controller
    $status=$_REQUEST["status"];
    switch ($status) {

        case "add_holiday_leave":

            echo $holiday_desc = $_POST["holiday_desc"];
            echo $holiday_date = $_POST["holiday_date"];
            $types = $_POST["holiday_type"];//array

            try{
                if($holiday_desc==""){
                    throw new exception("Holiday description is empty");
                }
                if($holiday_date==""){
                    throw new exception("Holiday date is empty");
                }if(empty($types)){
                    throw new exception("Holiday type is empty");
                }

                $typeString = implode(',', $types);//array to string

                $holidayID = $holidayObj->addHoliday($holiday_desc, $holiday_date, $typeString);

                if($holidayID>0){
                    $msg="Successfully added";
                    $msg=base64_encode($msg);
                    ?>
                    <script>
                        window.location = "../view/add-holidays.php?msg=<?php echo $msg; ?>"
                    </script>

                    <?php
                }
            }
            catch (exception $exception)
            {
                $msg=$exception->getMessage();
                $msg=base64_encode($msg);
                ?>
                <script>
                    window.location = "../view/add-holidays.php?msg=<?php echo $msg; ?>"
                </script>
                <?php
            }
            break;
            
        case "edit_holiday_leave":

            echo $holiday_id = $_POST['holiday_id'];
            echo $holiday_desc = $_POST['holiday_desc'];
            echo $holiday_date = $_POST['holiday_date'];

            if (isset($_POST['holiday_type'])) {
                $holiday_types = $_POST['holiday_type'];
                $holiday_types_string = implode(',', $holiday_types);
            } else {
                $holiday_types_string = '';
            }

            $holidayObj->updateHoliday($holiday_id,$holiday_desc,$holiday_date, $holiday_types_string);

            if($holiday_id>0){/*check if user is available*/
                $msg="successfully Updated";
                $msg=base64_encode($msg);

                $holiday_id=base64_encode($holiday_id);

                ?>
                <script>
                    window.location = "../view/edit-holidays.php?msg=<?php echo $msg; ?>&holiday_id=<?php echo $holiday_id; ?>"
                </script>

                <?php

            }

            break;

        //Get detailed list of applied leaves
        case "leave_list":
            $startDate = $_POST["startDate"];
            $endDate = $_POST["endDate"];
            $diffDays = $_POST["diffDays"];
            $days = $_POST["days"];

            ?>
            <table id="duration-table" class="table table-borderless">
                <thead class="bg-light">
                <tr>
                    <td>Date</td>
                    <td>Duration</td>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                <?php
                $array = explode(',', $days); //split string into array separated by ', '
                $array = array_filter($array, function ($v) { return !preg_match('/^(Sat|Sun)/', $v); });//remove weekends
                $array= array_filter($array, function($value) { return !is_null($value) && $value !== ''; });

                $holiday_result=$holidayObj->getHolidays();
                $holidayDate = "";

                while ($holidayAllRow=$holiday_result->fetch_assoc()){
                    $holidayDate2=$holidayAllRow["date"];
                    $holidayDate .=(date('D M d Y', strtotime($holidayDate2)));
                }
                $holidayDate;

                $count = 0;
                foreach($array as $value) //loop over values
                {
                    if (strpos($holidayDate, $value) == FALSE)  // if holiday exists in applied leave
                    {
                        ?>
                        <tr id="<?php echo $value?>">
                            <td>
                                <input type="text" style="border: white" value="<?php echo $value; ?>" name="tableRow[<?php echo $count; ?>][leavedate]">
                            </td>
                            <td id="<?php echo $value?>">
                                <select class="form-control" id="leave-half-full" name="tableRow[<?php echo $count; ?>][leavehalffull]" required>
                                    <option value="1">Full day</option>
                                    <option value="2">Half day</option>
                                </select>

                            </td>
                            <td id="<?php echo $value?>">
                                <select class="test form-control" id="half-full-day" name="tableRow[<?php echo $count; ?>][halffullday]" disabled required>
                                    <option value="1">First half</option>
                                    <option value="2">Second half</option>
                                </select>
                            </td>

                        </tr>
                        <?php
                    }
                    else{ //if applied leave is on a holiday remove the value from array
                        $key = (array_search($value, $array)) !== false;
                        unset($array[$key]);
                    }
                    $count++;

                }
                ?>

                </tbody>

            </table>
            <p id="result"></p>

            <script>

                var table = new DataTable('#duration-table');

                    $(document).on("change", "#leave-half-full", function(e) {

                        var rowId= e.target.parentNode.id;//row
                        var durationColumnVal = $(this).closest('td select').val();//Duration column

                    if (durationColumnVal == "2"){

                        var id = $(this).closest('td select').attr('id');//Duration column select tag ID
                        //alert(id);
                        $(this).closest('tr').find('#half-full-day').prop( "disabled", false);//enable next column

                        //var numRos = $(this).closest('tr').find('#half-full-day').text();//last column value

                    }else
                    {
                        $(this).closest('tr').find('#half-full-day').prop("disabled", true);//disable next column

                    }
                    });



            </script>
            <?php

            break;

        //Add leaves
        case "add_leave":
            echo $team_email=$_POST["team_email"];
            $tableRow = $_POST['tableRow'];
            $leavetype = $_POST['leave-type'];
            $leaveReason = $_POST['leave_reason'];
            echo $startDate = $_POST["leave_date_from1"];
            echo $endDate = $_POST["leave_date_to1"];
            echo $startDateSick = $_POST["leave_date_from"];
            echo $endDateSick = $_POST["leave_date_to"];

            $user_id=$_POST["user_id"];

            try {
                date_default_timezone_set('Asia/Colombo');

                $dateToday=date("Y-m-d");

                $userResult=$UserObj->getUserName($user_id);
                $userRow=$userResult->fetch_assoc();
                $user_fname=$userRow['user_fname'];

                $userResult= $UserObj->viewUser($user_id);
                $userRow=$userResult->fetch_assoc();
                $user_email=$userRow["user_email"];
                $user_name=$userRow["user_fname"];

                $user_id_encoded=base64_encode($user_id);

                if($startDate==""){
                    echo 'Sick';
                    $url = "localhost/beta-intranet.technicalcreatives.lk/view/approve-leaves.php?user_id=$user_id_encoded&applied_date=$dateToday&start_date=$startDateSick&end_date=$endDateSick";

                }else{
                    echo 'Casual or annual';
                    $url = "localhost/beta-intranet.technicalcreatives.lk/view/approve-leaves.php?user_id=$user_id_encoded&applied_date=$dateToday&start_date=$startDate&end_date=$endDate";

                }

                $mail = new PHPMailer(true);

                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'mail.technicalcreatives.lk';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'leaves@technicalcreatives.lk';                     //SMTP username
                $mail->Password   = 'Leaves@TC2024!!';                               //SMTP password
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;

                //Recipients
                $mail->setFrom('	leaves@technicalcreatives.lk', 'TC Intranet');
                $mail->addAddress($team_email, 'Admin');     //Add a recipient
                $mail->addAddress('manoja@technicalcreatives.com', 'Manoja');
                $mail->addReplyTo('leaves@technicalcreatives.lk', 'Information');


                $mail->isHTML(true); //Set email format to HTML
                $mail->Subject = ' Leave Request for '.$user_fname;
                $mail->Body    = 'Please click '."<a href=\"$url\">here</a>".' to approve/ decline leave request '. "</b></br></br>" .
                    'Regards,'."</br>".
                    'TC APAC Management'."</br></br>";
                $mail->send();

                Foreach($tableRow as $row){
                    echo '<pre>';
                     //echo var_dump($row);
                    echo '</pre>';
                    If(isset($row["leavedate"])){
                        echo $leavedate=$row["leavedate"];
                        $leavedate=(date('Y-m-d', strtotime($leavedate)));

                        echo "</br>";
                        echo $leavfhalfFull=$row["leavehalffull"];
                        echo $half_full_day=$row["halffullday"];

                        if (isset($half_full_day)){
                            $half_full_day;
                        }
                        else{
                            $half_full_day='3';//full day
                        }

                    }else{
                        echo 'fail';
                    }


                    $leaveID = $holidayObj->addLeave($user_id,$leavetype,$leaveReason,$leavedate,$leavfhalfFull,$dateToday,$half_full_day);

                    if($leaveID>0){
                        $msg="Leave request has been sent";
                        $msg=base64_encode($msg);

                        ?>
                        <script>
                            window.location = "../view/add-leave.php?msg=<?php echo $msg; ?>"
                        </script>

                        <?php


                    }

                }

                }
                catch (Exception $exception)
                {
                    $msg=$exception->getMessage();
                    $msg=base64_encode($msg);
                ?>
                    <script>
                        window.location = "../view/add-leave.php?msg=<?php echo $msg; ?>"
                    </script>
                  <?php
                }

            break;

       case "add_leave_by_admin":
                    echo $team_email=$_POST["team_email"];
                    $tableRow = $_POST['tableRow'];
                    $leavetype = $_POST['leave-type'];
                    $leaveReason = $_POST['leave_reason'];
                    echo $startDate = $_POST["leave_date_from1"];
                    echo $endDate = $_POST["leave_date_to1"];
                    echo $startDateSick = $_POST["leave_date_from"];
                    echo $endDateSick = $_POST["leave_date_to"];

                    $user_id=$_POST["user_id"];

                    try {
                        date_default_timezone_set('Asia/Colombo');

                        $dateToday=date("Y-m-d");

                        $userResult=$UserObj->getUserName($user_id);
                        $userRow=$userResult->fetch_assoc();
                        $user_fname=$userRow['user_fname'];

                        $userResult= $UserObj->viewUser($user_id);
                        $userRow=$userResult->fetch_assoc();
                        $user_email=$userRow["user_email"];
                        $user_name=$userRow["user_fname"];

                        $user_id_encoded=base64_encode($user_id);




                            if($startDate==""){
                                echo 'Sick';
                                $url = "localhost/beta-intranet.technicalcreatives.lk/view/approve-leaves.php?user_id=$user_id_encoded&applied_date=$dateToday&start_date=$startDateSick&end_date=$endDateSick";

                            }else{
                                echo 'Casual or annual';
                                $url = "localhost/beta-intranet.technicalcreatives.lk/view/approve-leaves.php?user_id=$user_id_encoded&applied_date=$dateToday&start_date=$startDate&end_date=$endDate";

                            }

                            $mail = new PHPMailer(true);

                            $mail->isSMTP();                                            //Send using SMTP
                            $mail->Host       = 'mail.technicalcreatives.lk';                     //Set the SMTP server to send through
                            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                            $mail->Username   = 'leaves@technicalcreatives.lk';                     //SMTP username
                            $mail->Password   = 'Leaves@TC2024!!';                               //SMTP password
                            $mail->SMTPSecure = 'tls';
                            $mail->Port       = 587;

                            //Recipients
                            $mail->setFrom('	leaves@technicalcreatives.lk', 'TC Intranet');
                            $mail->addAddress($team_email, 'Admin');     //Add a recipient
                            $mail->addAddress('manoja@technicalcreatives.com', 'manoja');
                            $mail->addReplyTo('leaves@technicalcreatives.lk', 'Information');


                            $mail->isHTML(true); //Set email format to HTML
                            $mail->Subject = ' Leave Request for '.$user_fname;
                            $mail->Body    = 'Please click '."<a href=\"$url\">here</a>".' to approve/ decline leave request '. "</b></br></br>" .
                                'Regards,'."</br>".
                                'TC APAC Management'."</br></br>";
                            $mail->send();

                            Foreach($tableRow as $row){
                                echo '<pre>';
                                //echo var_dump($row);
                                echo '</pre>';
                                If(isset($row["leavedate"])){
                                    echo $leavedate=$row["leavedate"];
                                    $leavedate=(date('Y-m-d', strtotime($leavedate)));

                                    echo "</br>";
                                    echo $leavfhalfFull=$row["leavehalffull"];
                                    echo $half_full_day=$row["halffullday"];

                                    if (isset($half_full_day)){
                                        $half_full_day;
                                    }
                                    else{
                                        $half_full_day='3';//full day
                                    }

                                }else{
                                    echo 'fail';
                                }


                            $leaveID = $holidayObj->addLeave($user_id,$leavetype,$leaveReason,$leavedate,$leavfhalfFull,$dateToday,$half_full_day);

                            if($leaveID>0){
                                $msg="Leave request has been sent";
                                $msg=base64_encode($msg);

                                ?>
                                <script>
                                    window.location = "../view/add-admin-leave.php?msg=<?php echo $msg; ?>"
                                </script>

                                <?php


                            }

                        }

                    }
                    catch (Exception $exception)
                    {
                        $msg=$exception->getMessage();
                        $msg=base64_encode($msg);
                        ?>
                        <script>
                            window.location = "../view/add-leave.php?msg=<?php echo $msg; ?>"
                        </script>
                        <?php
                    }

                    break;


        //Approve / Disapprove leaves
        case "update_user_status":
              echo $user_id= $_REQUEST["user_id"];
              echo $status1 = $_REQUEST["user_status"];
              echo $date= $_REQUEST["date"];
                try {

                    $holidayObj->updateLeaveStatus($user_id,$date,$status1);

                    if($status1==0){
                    $user_id_encoded=base64_encode($user_id);
                    echo $startDate=$_REQUEST["start_date"];
                    echo $end_date=$_REQUEST["end_date"];
                    echo $applied_date=$_REQUEST["applied_date"];

                    $msg='Request pending for leave request on '.(date('D M d Y', strtotime($date)));
                    $msg=base64_encode($msg);
                    ?>

                    <script>
                        window.location = "../view/approve-leaves.php?msg=<?php echo $msg; ?>&user_id=<?php echo $user_id_encoded?>&start_date=<?php echo $startDate?>&end_date=<?php echo $end_date?>&applied_date=<?php echo $applied_date?>"
                    </script>
                    <?php
                    }
                    if($status1==1){
                        $user_id_encoded=base64_encode($user_id);
                        echo $startDate=$_REQUEST["start_date"];
                        echo $end_date=$_REQUEST["end_date"];
                        echo $applied_date=$_REQUEST["applied_date"];

                        $msg='Successfully approved leave request on '.(date('D M d Y', strtotime($date)));
                        $msg=base64_encode($msg);
                        ?>

                        <script>
                            window.location = "../view/approve-leaves.php?msg=<?php echo $msg; ?>&user_id=<?php echo $user_id_encoded?>&start_date=<?php echo $startDate?>&end_date=<?php echo $end_date?>&applied_date=<?php echo $applied_date?>"
                        </script>
                        <?php
                    }
                    if($status1==2){
                        $user_id_encoded=base64_encode($user_id);
                        echo $startDate=$_REQUEST["start_date"];
                        echo $end_date=$_REQUEST["end_date"];
                        echo $applied_date=$_REQUEST["applied_date"];

                        $msg='Leave request declined on '.(date('D M d Y', strtotime($date)));
                        $msg=base64_encode($msg);
                        ?>

                        <script>
                            window.location = "../view/approve-leaves.php?msg=<?php echo $msg; ?>&user_id=<?php echo $user_id_encoded?>&start_date=<?php echo $startDate?>&end_date=<?php echo $end_date?>&applied_date=<?php echo $applied_date?>"
                        </script>
                        <?php
                    }
                }catch (Exception $exception)
                {
                    $msg=$exception->getMessage();
                    $msg=base64_encode($msg);
                    ?>

                    <?php
                }


                break;

                //update leave
        case "update_leave":
            echo $leave_id= $_POST["leave_id"];
            echo $user_id= $_POST["user_id"];
            echo $leave_reason = $_POST["leave_reason"];
            echo $leave_date= $_POST["leave_date_from"];
            echo $full_half_day= $_POST["full_half_day"];
            echo $half_full_day= $_POST["half-full-day"];
            echo $leave_type= $_POST["leave_type"];

            try {

                $holidayObj->updateLeave($leave_id,$leave_reason,$leave_date,$leave_type,$full_half_day,$half_full_day);
                if($leave_id>0){

                    $leave_id_encoded=base64_encode($leave_id);
                    $user_id_encoded=base64_encode($user_id);

                    $msg='Leave updated';
                    $msg=base64_encode($msg);
                    ?>

                    <script>
                        window.location = "../view/edit-leaves.php?msg=<?php echo $msg; ?>&leave_id=<?php echo $leave_id_encoded?>&user_id=<?php echo $user_id_encoded?>"
                    </script>
                    <?php
                }

            }catch (Exception $exception)
            {
                $msg=$exception->getMessage();
                $msg=base64_encode($msg);
                ?>

                <?php
            }


            break;

        case "remove_leave":

               $leave_id=$_POST["leave_id"];
                try{
                    $deleted=$holidayObj->deleteLeaveRequest($leave_id);


                } catch (Exception $exception)
                {
                    $msg=$exception->getMessage();
                    $msg=base64_encode($msg);

                    ?>
                    <script>
                        window.location = "../view/add-leave.php?msg=<?php echo $msg; ?>"
                    </script>

                    <?php
                }


                break;

        case "email_user_status":
            $user_id=$_REQUEST["user_id"];
            $start_date=$_REQUEST["start_date"];
            $end_date=$_REQUEST["end_date"];
            $Applied_date=$_REQUEST["applied_date"];

            $userResult= $UserObj->viewUser($user_id);
            $userRow=$userResult->fetch_assoc();
            $user_email=$userRow["user_email"];
            $user_name=$userRow["user_fname"];

            try {
                $user_id_encoded=base64_encode($user_id);

            $approvedLeavesUrl = "localhost/beta-intranet.technicalcreatives.lk/view/approve-leaves.php?user_id=$user_id_encoded&applied_date=$Applied_date&start_date=$start_date&end_date=$end_date";
            $url = "localhost/beta-intranet.technicalcreatives.lk/view/leave-status.php?user_id=$user_id_encoded&applied_date=$Applied_date&start_date=$start_date&end_date=$end_date";
            echo "Email has been sent. Please click <a href='$approvedLeavesUrl'>here</a> to go back";
            

            $mail = new PHPMailer(true);

            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'mail.technicalcreatives.lk';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'leaves@technicalcreatives.lk';                     //SMTP username
            $mail->Password   = 'Leaves@TC2024!!';                               //SMTP password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('leaves@technicalcreatives.lk', 'TC Intranet');
            $mail->addAddress($user_email, $user_name);     //Add a recipient
            $mail->addReplyTo('leaves@technicalcreatives.lk', 'Information');


            $mail->isHTML(true); //Set email format to HTML
            $mail->Subject = ' Status update ';
            $mail->Body    = 'Please click '."<a href=\"$url\">here</a>".' to view recently applied leave status '. "</b></br></br>" .
                'Regards,'."</br>".
                'TC APAC Management'."</br></br>";
            $mail->send();

                $msg='Successfully sent leave status';
                $msg=base64_encode($msg);
            ?>
                <script>
                window.location = "../view/approve-leaves.php?msg=<?php echo $msg; ?>&user_id=<?php echo $user_id_encoded?>&applied_date=<?php echo $Applied_date ?>&start_date=<?php echo $start_date?>&end_date=<?php echo $end_date?>"

                </script>
                <?php

            }
            catch (Exception $exception)
            {
                $msg=$exception->getMessage();
                $msg=base64_encode($msg);
                ?>
                <script>
                    window.location = "../view/approve-leaves.php?msg=<?php echo $msg; ?>&user_id=<?php echo $user_id_encoded?>&applied_date=<?php echo $Applied_date ?>&start_date=<?php echo $start_date?>&end_date=<?php echo $end_date?>"
                </script>
                <?php
            }

            break;

        case "load_leave_report":
            $user_id=$_POST["user_id"];

            $leaveResult=$holidayObj->getLeaves($user_id);

            ?>
            <table id="load_data" class="table table-responsive" style="width:100%">
                <thead>
                <tr>
                    <th>User</th>
                    <th class="d-none d-xl-table-cell">Date</th>
                    <th>Leave type</th>
                    <th class="d-none d-xl-table-cell">Reason</th>
                    <th></th>
                    <th></th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <?php

                while ($leaveRow=$leaveResult->fetch_assoc()){

                    ?>
                    <tr>
                        <td class="d-none d-xl-table-cell">
                            <div class="text-muted">
                                <?php
                                echo $leaveRow['user_fname'].' '.$leaveRow['user_lname'];
                                ?>
                            </div>
                        </td>
                        <td class="d-none d-xl-table-cell">
                            <div class="text-muted">
                                <?php
                                echo $date=$leaveRow['date'];
                                ?>
                            </div>
                        </td>
                        <td>
                            <?php
                            if($leaveRow["leave_type"]==1){
                                echo 'Annual leave';
                            }else if($leaveRow["leave_type"]==2){
                                echo 'Casual leave';

                            }else if($leaveRow["leave_type"]==3){
                                echo 'Sick leave';
                            }else{
                                echo 'Compensatory Leave';
                            }
                            ?>
                        </td>
                        <td><?php
                            echo $leaveRow['reason'];
                            ?>
                        </td>
                        <td>
                                            <?php
                                            if ($leaveRow['full_half_day']==1){
                                                echo 'Full day';
                                            }
                                            else{
                                                echo 'Half day';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($leaveRow['first_second']==1){
                                                echo 'First half';
                                            }
                                            else if($leaveRow['first_second']==2){
                                                echo 'Second half';
                                            }else{
                                                echo '';
                                            }
                                            ?>
                                        </td>
                        <td>
                            <?php

                            if($leaveRow['leave_status']==1){
                                ?>
                                <span class="badge status bg-success"> Request Approved </span>

                                <?php
                            }else if($leaveRow['leave_status']==2){
                                ?>
                                <span class="badge status bg-danger"> Request Declined </span>

                                <?php
                            }
                            else{
                                ?>
                                <span class="badge status text-bg-warning"> Request Pending </span>

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
            <p><?php echo '<span class="text-danger">*Please select a duration to populate the summary</span>'?></p>
            <?php
            break;

        case "load_leave_report_date_range":

            $startDate=$_POST["startDate"];
            $endDate=$_POST["endDate"];

            $leaveDateResult=$holidayObj->getUserLeavesDateRangeOnly($startDate,$endDate);
            ?>
            <table id="load_data" class="table" style="width:100%">
                <thead>
                <tr>
                    <th>User</th>
                    <th>Date</th>
                    <th>Leave type</th>
                    <th>Reason</th>
                    <th></th>
                    <th></th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <?php

                while ($leaveRow=$leaveDateResult->fetch_assoc()){

                    ?>

                    <tr>
                        <td class="d-none d-xl-table-cell">
                            <div class="text-muted">
                                <?php
                                echo $leaveRow['user_fname'].' '.$leaveRow['user_lname'];
                                ?>
                            </div>
                        </td>
                        <td class="d-none d-xl-table-cell">
                            <div class="text-muted">
                                <?php
                                echo $date=$leaveRow['date'];
                                ?>
                            </div>
                        </td>
                        <td>
                            <?php
                            if($leaveRow["leave_type"]==1){
                                echo 'Annual leave';
                            }else if($leaveRow["leave_type"]==2){
                                echo 'Casual leave';

                            }else if($leaveRow["leave_type"]==3){
                                echo 'Sick leave';
                            }else{
                                echo 'Compensatory Leave';
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $leaveRow['reason'];
                            ?>
                        </td>
                        <td>
                                            <?php
                                            if ($leaveRow['full_half_day']==1){
                                                echo 'Full day';
                                            }
                                            else{
                                                echo 'Half day';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($leaveRow['first_second']==1){
                                                echo 'First half';
                                            }
                                            else if($leaveRow['first_second']==2){
                                                echo 'Second half';
                                            }else{
                                                echo '';
                                            }
                                            ?>
                                        </td>
                        <td>
                            <?php

                            if($leaveRow['leave_status']==1){
                                ?>
                                <span class="badge status bg-success"> Request Approved </span>

                                <?php
                            }else if($leaveRow['leave_status']==2){
                                ?>
                                <span class="badge status bg-danger"> Request Declined </span>

                                <?php
                            }
                            else{
                                ?>
                                <span class="badge status text-bg-warning"> Request Pending </span>

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
            <br>

            <?php
            break;

        case "load_leave_report_date_range_user":

            $user_id=$_POST["user_id"];
            $startDate=$_POST["startDate"];
            $endDate=$_POST["endDate"];

            $leaveDateResult=$holidayObj->getUserLeavesDateRange($user_id,$startDate,$endDate);
            ?>
                <table id="load_data" class="table" style="width:100%">
                    <thead>
                    <tr>
                        <th>User</th>
                        <th>Date</th>
                        <th>Leave type</th>
                        <th>Reason</th>
                        <th></th>
                        <th></th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    while ($leaveRow=$leaveDateResult->fetch_assoc()){

                        ?>

                        <tr>
                            <td class="d-none d-xl-table-cell">
                                <div class="text-muted">
                                    <?php
                                    echo $leaveRow['user_fname'].' '.$leaveRow['user_lname'];
                                    ?>
                                </div>
                            </td>
                            <td class="d-none d-xl-table-cell">
                                <div class="text-muted">
                                    <?php
                                    echo $date=$leaveRow['date'];
                                    ?>
                                </div>
                            </td>
                            <td>
                                <?php
                                if($leaveRow["leave_type"]==1){
                                    echo 'Annual leave';
                                }else if($leaveRow["leave_type"]==2){
                                    echo 'Casual leave';

                                }else if($leaveRow["leave_type"]==3){
                                    echo 'Sick leave';
                                }else{
                                    echo 'Compensatory Leave';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $leaveRow['reason'];
                                ?>
                            </td>
                            <td>
                                            <?php
                                            if ($leaveRow['full_half_day']==1){
                                                echo 'Full day';
                                            }
                                            else{
                                                echo 'Half day';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($leaveRow['first_second']==1){
                                                echo 'First half';
                                            }
                                            else if($leaveRow['first_second']==2){
                                                echo 'Second half';
                                            }else{
                                                echo '';
                                            }
                                            ?>
                                        </td>
                            <td>
                                <?php

                                if($leaveRow['leave_status']==1){
                                    ?>
                                    <span class="badge status bg-success"> Request Approved </span>

                                    <?php
                                }else if($leaveRow['leave_status']==2){
                                    ?>
                                    <span class="badge status bg-danger"> Request Declined </span>

                                    <?php
                                }
                                else{
                                    ?>
                                    <span class="badge status text-bg-warning"> Request Pending </span>

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
                                <dt class="col-2 col-xxl-2"><b>Number of Leaves :</b></dt>
                                <dd class="col-3 col-xxl-3">
                                    <p class="mb-1"><span id="val"><?Php
                                            $leaveCountResult=$holidayObj->getUserLeavesDateRangeCount($user_id,$startDate,$endDate);
                                            $leaveCountRow=$leaveCountResult->fetch_assoc();
                                            echo $leaveCountRow["leaveCount"].' leaves';
                                            ?></span></p>
                                </dd>

                                <dt class="col-2 col-xxl-2"><b>Time Period:</b></dt>
                                <dd class="col-3 col-xxl-3">
                                    <p class="mb-1" id="time-period"><?Php echo $startDate.' to '.$endDate?></p>
                                </dd>
                            </dl>

                        </div>
                    </div>

                </div>


            <?php
            break;
                    case "update_user_status_admin":
                        echo $user_id= $_REQUEST["user_id"];
                        echo $status1 = $_REQUEST["user_status"];
                        echo $date= $_REQUEST["date"];
                        try {

                            $holidayObj->updateLeaveStatus($user_id,$date,$status1);

                            if($status1==0){
                                $user_id_encoded=base64_encode($user_id);
                                echo $applied_date=$_REQUEST["applied_date"];

                                $msg='Request pending for leave request on '.(date('D M d Y', strtotime($date)));
                                $msg=base64_encode($msg);
                                ?>

                                <script>
                                    window.location = "../view/add-admin-leave.php?msg=<?php echo $msg; ?>&user_id=<?php echo $user_id_encoded?>&applied_date=<?php echo $applied_date?>"
                                </script>
                                <?php
                            }
                            if($status1==1){
                                $user_id_encoded=base64_encode($user_id);

                                echo $applied_date=$_REQUEST["applied_date"];

                                $msg='Successfully approved leave request on '.(date('D M d Y', strtotime($date)));
                                $msg=base64_encode($msg);
                                ?>

                                <script>
                                    window.location = "../view/add-admin-leave.php?msg=<?php echo $msg; ?>&user_id=<?php echo $user_id_encoded?>&applied_date=<?php echo $applied_date?>"
                                </script>
                                <?php
                            }
                            if($status1==2){
                                $user_id_encoded=base64_encode($user_id);

                                echo $applied_date=$_REQUEST["applied_date"];

                                $msg='Leave request declined on '.(date('D M d Y', strtotime($date)));
                                $msg=base64_encode($msg);
                                ?>

                                <script>
                                    window.location = "../view/add-admin-leave.php?msg=<?php echo $msg; ?>&user_id=<?php echo $user_id_encoded?>&applied_date=<?php echo $applied_date?>"
                                </script>
                                <?php
                            }
                        }catch (Exception $exception)
                        {
                            $msg=$exception->getMessage();
                            $msg=base64_encode($msg);
                            ?>

                            <?php
                        }


                        break;

                        case 'fetch_upcoming_leaves':  //display upcoming leaves
                            $leaveUpcoming = $holidayObj->fetchUpcomingLeaves();
                
                            ?>
                            <table id="load_data" class="table" style="width:100%">
                                <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Date</th>
                                    <th>Leave type</th>
                                    <th>Reason</th>
                                    <th></th>
                                    <th></th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                
                                while ($leaveRow=$leaveUpcoming->fetch_assoc()){
                                    ?>
                                    <tr>
                                        <td class="d-none d-xl-table-cell">
                                            <div class="text-muted">
                                                <?php
                                                echo $leaveRow['user_fname'].' '.$leaveRow['user_lname'];
                                                ?>
                                            </div>
                                        </td>
                                        <td class="d-none d-xl-table-cell">
                                            <div class="text-muted">
                                                <?php
                                                echo $date=$leaveRow['date'];
                                                ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?php
                                            if($leaveRow["leave_type"]==1){
                                                echo 'Annual leave';
                                            }else if($leaveRow["leave_type"]==2){
                                                echo 'Casual leave';
                                            }else if($leaveRow["leave_type"]==3){
                                                echo 'Sick leave';
                                            }else{
                                                echo 'Compensatory Leave';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo $leaveRow['reason'];
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($leaveRow['full_half_day']==1){
                                                echo 'Full day';
                                            }
                                            else{
                                                echo 'Half day';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($leaveRow['first_second']==1){
                                                echo 'First half';
                                            }
                                            else if($leaveRow['first_second']==2){
                                                echo 'Second half';
                                            }else{
                                                echo '';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if($leaveRow['leave_status']==1){
                                                ?>
                                                <span class="badge status bg-success"> Request Approved </span>
                                                <?php
                                            }else if($leaveRow['leave_status']==2){
                                                ?>
                                                <span class="badge status bg-danger"> Request Declined </span>
                                                <?php
                                            }
                                            else{
                                                ?>
                                                <span class="badge status text-bg-warning"> Request Pending </span>
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
                            <br>
                            <?php
                            break;
                
                        case 'fetch_past_leaves'://display past leaves
                            $leavePast = $holidayObj->fetchPastLeaves();
                            ?>
                            <table id="load_data" class="table" style="width:100%">
                                <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Date</th>
                                    <th>Leave type</th>
                                    <th>Reason</th>
                                    <th></th>
                                    <th></th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                while ($leaveRow = $leavePast->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td class="d-none d-xl-table-cell">
                                            <div class="text-muted">
                                                <?php
                                                echo $leaveRow['user_fname'].' '.$leaveRow['user_lname'];
                                                ?>
                                            </div>
                                        </td>
                                        <td class="d-none d-xl-table-cell">
                                            <div class="text-muted">
                                                <?php
                                                echo $date=$leaveRow['date'];
                                                ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?php
                                            if($leaveRow["leave_type"]==1){
                                                echo 'Annual leave';
                                            }else if($leaveRow["leave_type"]==2){
                                                echo 'Casual leave';
                                            }else if($leaveRow["leave_type"]==3){
                                                echo 'Sick leave';
                                            }else{
                                                echo 'Compensatory Leave';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo $leaveRow['reason'];
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($leaveRow['full_half_day']==1){
                                                echo 'Full day';
                                            }
                                            else{
                                                echo 'Half day';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($leaveRow['first_second']==1){
                                                echo 'First half';
                                            }
                                            else if($leaveRow['first_second']==2){
                                                echo 'Second half';
                                            }else{
                                                echo '';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if($leaveRow['leave_status']==1){
                                                ?>
                                                <span class="badge status bg-success"> Request Approved </span>
                                                <?php
                                            }else if($leaveRow['leave_status']==2){
                                                ?>
                                                <span class="badge status bg-danger"> Request Declined </span>
                                                <?php
                                            }
                                            else{
                                                ?>
                                                <span class="badge status text-bg-warning"> Request Pending </span>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <?php
                            break;
            
                            case "load_date_range":

                                $startLeaveDate=$_POST["startLeaveDate"];
                                $endLeaveDate=$_POST["endLeaveDate"];
                                
                                $pastLeave=$holidayObj->getLeaveDateRange($startLeaveDate,$endLeaveDate);
                                ?>
                                <div id="show-filtered-table-leave">
                                    <table id="load_data2" class="table" style="width:100%">
                                        <thead>
                                        <tr>
                                        <th>ID</th>
                                        <th>Employee Name</th>
                                        <th>Leave Type</th>
                                        <th>Leave Date</th>
                                        <th>Reason</th>
                                        </tr>
                                        </thead>
                                    <tbody>
                                        <?php
                    
                        while ($leaveRow=$pastLeave->fetch_assoc()){

                        ?>
                        <tr>
                            <td><?php echo $leaveRow["leave_id"]; ?></td>
                            <td><?php echo $leaveRow['user_fname'].' '.$leaveRow['user_lname']; ?></td>

                            <td><?php  
                            if($leaveRow["leave_type"]==1){
                                    echo 'Annual leave';
                                }else if($leaveRow["leave_type"]==2){
                                    echo 'Casual leave';

                                }else{
                                    echo 'Sick leave';
                                } 
                            ?></td>
                            <td><?php echo $date=$leaveRow['date'];?></td>
                            <td><?php echo $leaveRow['reason'];?></td> 
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

                case "deleteLeaves":
                    $startLeaveDate = $_POST['startLeaveDate'];
                    $endLeaveDate = $_POST['endLeaveDate'];
                    
                    $deleteResult = $holidayObj->deleteLeaves($startLeaveDate, $endLeaveDate);

                    if ($deleteResult) {
                        echo "success";
                    } else {
                        echo "error";
                    }
                break;

    }
}