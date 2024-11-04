<?php
ini_set("memory_limit","200GB");

if(isset($_REQUEST["status"]))
{
    include "../model/attendance_qr_model_api.php";
    $AttendanceqrObj=new Qrattendance();

    $status=$_REQUEST["status"];

    switch ($status) {

        case "add_qr_attendance":
            $add_qr_userid=$_GET["attendance_id"];
            $qr_userid_decoded=base64_decode($add_qr_userid);

            //get count
            $attedanceRowResult=$AttendanceqrObj->getAttendanceCount();
            $attendanceRow=$attedanceRowResult->fetch_assoc();
            $attendanceCount=$attendanceRow["attendance_count"];

            //check if already check in or not
            $isPresentRowResult=$AttendanceqrObj->checkIfPresent();
            $isPresentRow=$isPresentRowResult->fetch_assoc();
            $isPresent=$isPresentRow["is_present"];

            if ($attendanceCount==0){
                //insert check in
                $AttendanceqrObj->addQrAttendance($qr_userid_decoded,'check in');
                ?>
                <script type="text/javascript">
                    alert('Check in');

                </script>
                <?php
            }
            else{
                //update checkout
                if ($isPresent==0){
                    $AttendanceqrObj->updateCheckOut($qr_userid_decoded,'check out','1');
                }else
                {
                    //multiple entry attempt for check out
                    ?>
                    <script>
                    window.location = "../view/qr-code-reader.php"
                    </script>
                    <?php
                }
                ?>
                <script>
                    alert('Already checked in')
                </script>
                <?php
            }
            break;

            case "check_exist":
                $add_qr_userid=$_GET["attendance_id"];

                //check if already check in or not
                $isPresentRowResult=$AttendanceqrObj->checkIfPresent();
                $isPresentRow=$isPresentRowResult->fetch_assoc();
                $isPresent=$isPresentRow["is_present"];

                if ($isPresent==0)
                {
                    //prompt asking whether to check out
                    echo json_encode(['checkout' => $isPresent]);
                }
                else
                {
                    //multiple entry attempt for check out
                    echo json_encode(['checkout' => $isPresent]);
                }

            break;


    }
}

?>


