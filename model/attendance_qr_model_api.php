<?php
include_once "../commons/dbConnection.php";
$dbConnObj= new dbConnection();

class Qrattendance{
    public function addQrAttendance($user_id,$check_in){
        $con=$GLOBALS['con'];
        $sql="insert into attendance(
            user_id,
            check_in)             
            VALUES (               
            '$user_id',
            '$check_in')";

        $results=$con->query($sql) or die($con->error);
        $insertId=$con->insert_id;
        return $insertId;
    }
    function updateCheckOut($userId,$checkout,$is_present){

        $con=$GLOBALS['con'];

        $sql = "UPDATE attendance  SET "
            . "user_id='$userId',"
            . "check_out='$checkout',"
            . "is_present='$is_present'";

        $result=$con->query($sql) or die($con->error);
    }

    function getAttendanceCount(){
        $con=$GLOBALS["con"];
        $sql="select count(*) as attendance_count from attendance WHERE user_id='1' AND `date`='2024-02-15'";

        $result=$con->query($sql);
        /*directly convert to result*/
        return $result;

    }
    function checkIfPresent(){
        $con=$GLOBALS["con"];
        $sql="SELECT `is_present` from attendance where user_id='2' AND date='2024-03-27'";

        $result=$con->query($sql);
        /*directly convert to result*/
        return $result;

    }




}


?>