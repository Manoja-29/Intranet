<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 2/1/2020
 * Time: 3:27 PM
 */
include_once '../commons/dbConnection.php';
/*creating an object using the class in dbconnection and get the database connection*/
$dbConnObj=new dbConnection();

class HolidayLeave{
    public function addHoliday($holidayName,$Date,$typeString){
        $con=$GLOBALS['con'];
        $sql="insert into holidays(
            holiday_name,
            date,
            holiday_type)             
            VALUES (               
            '$holidayName',
            '$Date',
            '$typeString')";

        $results=$con->query($sql) or die($con->error);
        $insertId=$con->insert_id;
        return $insertId;
    }
    public function getHolidays(){
        $con=$GLOBALS["con"];
        $sql="SELECT * FROM holidays";
        $result=$con->query($sql);
        return $result;
    }

    public function getParticularHoliday($holiday_id){
        $con=$GLOBALS["con"];
        $sql="SELECT * FROM holidays where holiday_id='$holiday_id'";
        $result=$con->query($sql);
        return $result;
    }

    public function getHolidayTotal(){
        $con=$GLOBALS["con"];
        $sql="SELECT count(*) as holidayCount FROM holidays";
        $result=$con->query($sql);
        

        if ($result && $result->num_rows > 0) {
            $totalHoliday = $result->fetch_assoc();
            $holidayCount = $totalHoliday['holidayCount'];
        } else {
            return 0;
        }

        $currentYear = date('Y');

        // get total days in the current year
        $isLeapYear = (($currentYear % 4 == 0) && ($currentYear % 100 != 0)) || ($currentYear % 400 == 0);
        $totalDaysInYear = $isLeapYear ? 366 : 365;

        $holidayPercentage = round(($holidayCount / $totalDaysInYear) * 100 , 2);

        return [
            'holidayCount' => $holidayCount,
            'holidayPercentage' => $holidayPercentage
        ];
    }
    function updateHoliday($holidayID, $holiday_desc, $holiday_date, $holiday_types_string) {
        $con = $GLOBALS['con'];
    
        $sql = "UPDATE holidays SET 
                holiday_name = '$holiday_desc',
                date = '$holiday_date',
                holiday_type = '$holiday_types_string'
                WHERE holiday_id = '$holidayID'";
    
        $result = $con->query($sql) or die($con->error);
    }
    public function getLeaves($user_id){
        $con=$GLOBALS["con"];
        $sql="SELECT * FROM leaves l,user u where l.user_id='$user_id' and l.user_id=u.user_id";
        $result=$con->query($sql);
        return $result;
    }
    public function getAllLeaves(){
        $con=$GLOBALS["con"];
        $sql="SELECT * FROM leaves a, user u WHERE a.user_id=u.user_id";
        $result=$con->query($sql);
        return $result;
    }
    public function getLeaveUpdate($user_id,$leave_id){
        $con=$GLOBALS["con"];
        $sql="SELECT * FROM leaves where user_id='$user_id' and leave_id='$leave_id'";
        $result=$con->query($sql);
        return $result;
    }
    public function addLeave($user_id,$leavetype,$reason, $leaveDate,$leaveDuration,$applied_date,$first_second){
        $con=$GLOBALS['con'];
        $sql="insert into leaves(
            user_id,
            leave_type,
            reason,
            date, 
            first_second,
            full_half_day,
            applied_date)             
            VALUES (
            '$user_id',
            '$leavetype',
            '$reason',
            '$leaveDate',
            '$first_second',
            '$leaveDuration',
            '$applied_date'
            )";

        $results=$con->query($sql) or die($con->error);
        $insertId=$con->insert_id;
        return $insertId;
    }

    function updateLeave($leaveID,$reason,$date,$leave_type, $full_half_day, $first_second){
        $con=$GLOBALS['con'];

        $sql = "UPDATE leaves SET "
            . "leave_id='$leaveID',"
            . "reason='$reason',"
            . "leave_type='$leave_type',"
            . "full_half_day='$full_half_day',"
            . "first_second='$first_second',"
            . "date='$date'"
            . "WHERE leave_id ='$leaveID'";

        $result=$con->query($sql) or die($con->error);
    }
    function getleavetypes(){

        $con=$GLOBALS["con"];
        $sql="SELECT * FROM `leave_type`";
        $result=$con->query($sql);
        return $result;
    }
    function getappliedleaves($start_date,$end_date,$user_id){

        $con=$GLOBALS["con"];
        $sql="SELECT * FROM `leaves` WHERE date BETWEEN '$start_date' AND '$end_date' AND user_id='$user_id';";
        $result=$con->query($sql);
        return $result;
    }
    function updateLeaveStatus($user_id,$date,$status){
        $con=$GLOBALS['con'];

        $sql = "UPDATE leaves SET leave_status='$status' WHERE date ='$date' AND user_id='$user_id'";
        $result=$con->query($sql) or die($con->error);
    }
    function getleavecount(){ //for every leave type
        $con=$GLOBALS['con'];

        $sql = "SELECT COUNT( CASE WHEN leave_type = 1 THEN 1 END ) AS annual, COUNT( CASE WHEN leave_type = 2 THEN 1 END ) AS casual, COUNT( CASE WHEN leave_type = 3 THEN 1 END ) AS sick FROM leaves;";
        $result=$con->query($sql);
        return $result;
    }
    function getleaveFullOrHalfcount($userId){ //Get half day and full day separately for every leave type
        $con=$GLOBALS['con'];

        $sql = "SELECT COUNT( CASE WHEN full_half_day = 1 AND `leave_type`=1 AND user_id='$userId' THEN 1 END ) AS fulldayAnnual, COUNT( CASE WHEN full_half_day = 2 AND `leave_type`=1 AND user_id='$userId' THEN 1 END ) AS halfdayAnnual, COUNT( CASE WHEN full_half_day = 1 AND `leave_type`=2 AND user_id='$userId' THEN 1 END ) AS fulldayCasual, COUNT( CASE WHEN full_half_day = 2 AND `leave_type`=2 AND user_id='$userId' THEN 1 END ) AS halfdayCasual, COUNT( CASE WHEN full_half_day = 1 AND `leave_type`=3 AND user_id='$userId' THEN 1 END ) AS fulldaySick, COUNT( CASE WHEN full_half_day = 2 AND `leave_type`=3 AND user_id='$userId' THEN 1 END ) AS halfdaySick FROM leaves;";
        $result=$con->query($sql);
        return $result;
    }

    public function deleteLeaveRequest($leave_id)
    {
        $con=$GLOBALS['con'];
        $sql="DELETE FROM leaves where leave_id='$leave_id'";
        $results=$con->query($sql);
    }
    public function getUserLeavesDateRangeOnly($startDate,$endDate){
        $con=$GLOBALS['con'];
        $sql="SELECT * FROM leaves a, user u WHERE a.date BETWEEN '$startDate' AND '$endDate' AND a.user_id=u.user_id";
        $result=$con->query($sql);
        return $result;

    }
    public function getUserLeavesDateRange($userid,$startDate,$endDate){
        $con=$GLOBALS['con'];
        $sql="SELECT * FROM leaves a, user u WHERE a.user_id='$userid' AND a.date BETWEEN '$startDate' AND '$endDate' AND a.user_id=u.user_id";
        $result=$con->query($sql);
        return $result;

    }
    public function getUserLeavesDateRangeCount($userid,$startDate,$endDate){
        $con=$GLOBALS['con'];
        $sql="SELECT count(*) as leaveCount FROM leaves a, user u WHERE a.user_id='$userid' AND a.date BETWEEN '$startDate' AND '$endDate' AND a.user_id=u.user_id";
        $result=$con->query($sql);
        return $result;

    }

    public function fetchUpcomingLeaves()//fetch upcoming leaves
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM leaves a JOIN user u ON a.user_id = u.user_id WHERE a.date > CURRENT_DATE() ORDER BY a.date ASC";
        $result = $con->query($sql);
        return $result;
    }
    public function fetchPastLeaves()//fetch past leaves
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM leaves a JOIN user u ON a.user_id = u.user_id WHERE a.date < CURRENT_DATE() ORDER BY a.date DESC";
        $result = $con->query($sql);
        return $result;
    }

    function getLeaveDateRange($startLeaveDate,$endLeaveDate){
        $con=$GLOBALS['con'];
        $sql="SELECT * FROM leaves a JOIN user u ON a.user_id = u.user_id WHERE a.date BETWEEN '$startLeaveDate' AND '$endLeaveDate'";
        $result=$con->query($sql);
        return $result;
    }
    
    function deleteLeaves($startLeaveDate, $endLeaveDate){
        $con = $GLOBALS['con'];
    
        $sql = "DELETE FROM leaves WHERE date BETWEEN '$startLeaveDate' AND '$endLeaveDate'";
    
        if ($con->query($sql) === TRUE) {
            return true; 
        } else {
            error_log("Error deleting leave records: " . $con->error);
            return false;
        }
    }

    function fetchUpcomingHoliday(){
        $con=$GLOBALS['con'];
        $sql="SELECT * FROM holidays WHERE date > CURRENT_DATE() ORDER BY date ASC";
        $result=$con->query($sql);
        return $result;
    }

    function getTodayLeave(){
        $con=$GLOBALS['con'];
        $sql="SELECT * FROM leaves a JOIN user u on a.user_id = u.user_id where date = CURRENT_DATE()";
        $result=$con->query($sql);
        return $result;
    }

    function checkCurrentMonthHoliday(){
        $con=$GLOBALS['con'];
        
        $currentYear = date('Y');
        $currentMonth = date('m');

        $sql = "SELECT * FROM holidays WHERE MONTH(date) = '$currentMonth' AND YEAR(date) = '$currentYear'";
        $result = $con->query($sql);
        $totalHolidays = $result->num_rows;
        return $totalHolidays;
    }

    function checkCurrentMonthLeaves($user_id){
        $con=$GLOBALS['con'];
        
        $currentYear = date('Y');
        $currentMonth = date('m');

        $sql = "SELECT COUNT(*) as totalLeaves FROM user u, leaves l WHERE u.user_id=l.user_id AND l.user_id='$user_id' AND 
                MONTH(date) = '$currentMonth' AND YEAR(date) = '$currentYear'";

        $results=$con->query($sql);
        $row = $results->fetch_assoc();
        return $row['totalLeaves'];
    }

    function checkTodayHoliday(){
        $con=$GLOBALS['con'];

        $currentYear = date('Y');
        $currentMonth = date('m');
        $today = date('d');

        $sql = "SELECT * FROM holidays where DAY(date)='$today' AND MONTH(date)='$currentMonth' AND YEAR(date)='$currentYear'";
        $result=$con->query($sql);
        return $result->num_rows > 0;
    }
    


}
?>