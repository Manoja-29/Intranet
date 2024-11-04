<?php
include_once "../commons/dbConnection.php";
$dbConnObj= new dbConnection();

class Attendance{

    function updateAttendance($user_id,$check_in,$check_out,$status,$update_reason,$date){
        $con=$GLOBALS['con'];

        $sql = "UPDATE attendance SET "
            . "check_in='$check_in',"
            . "check_out='$check_out',"
            . "updated_date=CURRENT_TIMESTAMP,"
            . "update_status='$status',"
            . "update_reason='$update_reason'"

            . "WHERE user_id ='$user_id ' AND `date`='$date'";

        $result=$con->query($sql) or die($con->error);
    }
    public function addAttendance($user_id,$DateToday){
        $con=$GLOBALS['con'];
        $sql="insert into attendance(
            user_id,
            date)             
            VALUES (               
            '$user_id',
            '$DateToday')";

        $results=$con->query($sql) or die($con->error);
        $insertId=$con->insert_id;
        return $insertId;
    }

    public function CheckUserAttendance($userid,$DateToday){
        $con=$GLOBALS['con'];
        $sql="select 1 from attendance where user_id ='$userid' AND `date`='$DateToday'";
        $result=$con->query($sql);

        if($result->num_rows>0)
        {
            return false;
        }
        else
        {
            return true;
        }

    }
    public function CheckedIn($userid,$DateToday){
        $con=$GLOBALS['con'];
        $sql="select 1 from attendance where user_id ='$userid' AND `date`='$DateToday' AND check_in=''";
        $result=$con->query($sql);

        if($result->num_rows>0)
        {
            return false;
        }
        else
        {
            return true;
        }

    }
    public function getAllAttendance(){
        $con=$GLOBALS['con'];
        $sql="SELECT * from user u, attendance a WHERE u.user_id=a.user_id;";
        $results=$con->query($sql);
        return $results;
    }
    public function getUserSpecificAttendance($user_id){
        $con=$GLOBALS['con'];
        $sql="SELECT * from user u, attendance a WHERE u.user_id=a.user_id and a.user_id='$user_id'";
        $results=$con->query($sql);
        return $results;
    }
    public function getUserWeekAttendance($user_id){
        $con=$GLOBALS['con'];
        $sql="SELECT * from user u, attendance a WHERE u.user_id=a.user_id and a.user_id='$user_id' and week(a.date, 1)=week(curdate(),1) AND YEAR(a.date) = YEAR(CURDATE())";
        $results=$con->query($sql);
        return $results;
    }

    public function getUserAttendanceforMonth($user_id){
        $con=$GLOBALS['con'];
        $sql="SELECT COUNT(*) as total_records FROM user u, attendance a WHERE u.user_id=a.user_id AND a.user_id='$user_id' AND a.is_present='1'";
        $results=$con->query($sql);
        $row = $results->fetch_assoc();
        return $row['total_records'];
    }

    public function CheckedOutForday($userid,$DateToday){
        $con=$GLOBALS['con'];
        $sql="select 1 from attendance where user_id ='$userid' AND `date`='$DateToday' AND check_in is NOT NULL AND check_out is NOT NULL";
        $result=$con->query($sql);

        if($result->num_rows>0)
        {
            return false;
        }
        else
        {
            return true;
        }

    }
    public function getParicularUserAttendance($userid,$DateToday){
        $con=$GLOBALS['con'];
        $sql="SELECT * from user u, attendance a WHERE u.user_id='$userid' and date='$DateToday';";
        $result=$con->query($sql);
        return $result;

    }
    public function getUserAttendance($userid){
        $con=$GLOBALS['con'];
        $sql="SELECT * FROM attendance a, user u WHERE a.user_id='$userid' and a.user_id=u.user_id";
        $result=$con->query($sql);
        return $result;

    }
    public function getUserAttendanceDateRange($userid,$startDate,$endDate){
        $con=$GLOBALS['con'];
        $sql="SELECT * FROM attendance a, user u WHERE a.user_id='$userid' AND a.date BETWEEN '$startDate' AND '$endDate' AND a.user_id=u.user_id";
        $result=$con->query($sql);
        return $result;

    }

    public function getAttendanceDateRange($startDate,$endDate){
        $con=$GLOBALS['con'];
        $sql="SELECT * FROM attendance a JOIN user u ON a.user_id = u.user_id WHERE a.date BETWEEN '$startDate' AND '$endDate'";
        $result=$con->query($sql);
        return $result;
    }

    public function deleteAttendanceByDateRange($startDate, $endDate) {

        $con = $GLOBALS['con'];
        
        $archiveSql = "INSERT INTO attendance (attendance_id, user_id, check_out, check_in, is_present, date, update_reason, update_status, update_date)
                        SELECT attendance_id, user_id, check_out, check_in, is_present, date, update_reason, update_status, update_date
                        FROM attendance 
                        WHERE date BETWEEN '$startDate' AND '$endDate'";
    
        if ($GLOBALS['archiveCon']->query($archiveSql) === TRUE) {
            $deleteSql = "DELETE FROM attendance WHERE date BETWEEN '$startDate' AND '$endDate'";
            $result = $con->query($deleteSql);
            
            return $result;
        } else {
            error_log("Error archiving attendance records: " . $con->error);
            return false;
        }
    }

}


?>