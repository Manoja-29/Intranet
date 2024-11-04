<?php
include_once "../commons/dbConnection.php";
$dbConnObj= new dbConnection();
class Employee{

    public function getcurrentID(){
        $con=$GLOBALS["con"];
        $sql="SELECT MAX(employee_id) AS maxID FROM `employee`";
        $result=$con->query($sql);

        if($result->num_rows==0){
            return 1;
        }
        else{
            $maxrow=$result->fetch_assoc();
            $maxIDcount=$maxrow['maxID'];
            return $maxIDcount+1;
        }
    }
    public function getAllRole(){
        $con=$GLOBALS["con"];
        $sql="SELECT * from role";
        $result=$con->query($sql);
        return $result;
    }

    public function addEmployee(
            $employee_reference,
            $employee_name,
            $emp_lname,
            $Emp_dob,
            $gender,
            $employee_nic,
            $employee_designation,
            $employee_cno,
            $Employee_email,
            $employee_city,
            $salary,
            $travel_allowance,
            $EmergencyContact,
            $emergency_email,
            $bank_ac,
            $work_start_date){
        $con=$GLOBALS['con'];
        $sql="insert into employee(
            employee_reference,
            employee_name,
            emp_lname,
            Emp_dob,
            gender,
            employee_nic,
            employee_designation,
            employee_cno,
            Employee_email,
            employee_city,
            salary,
            travel_allowance,
            EmergencyContact,
            emergency_email,
            bank_ac,
            work_start_date
            ) 
            VALUES (               
            '$employee_reference',
            '$employee_name',
            '$emp_lname',
            '$Emp_dob',
            '$gender',
            '$employee_nic',
            '$employee_designation',
            '$employee_cno',
            '$Employee_email',
            '$employee_city',
            '$salary',
            '$travel_allowance',
            '$EmergencyContact',
            '$emergency_email',
            '$bank_ac',
            '$work_start_date'
           )";

        $results=$con->query($sql) or die($con->error);
        $insertId=$con->insert_id;
        return $insertId;
    }
    public function getAllEmployees(){
        $con=$GLOBALS["con"];
        $sql="SELECT * FROM employee";
        $result=$con->query($sql);
        return $result;
    }

    public function getEmployeeSalary($empID,$startDate,$endDate){
        $con=$GLOBALS["con"];
        $sql="SELECT SUM(`rate`) as sumrate,e.*,c.* FROM courier_schedule_order o , courier_schedule c,employee e WHERE c.`courier_id`=o.`courier_id` AND e.employee_id=c.driver_employee_id AND c.driver_employee_id='$empID' AND date_start_time BETWEEN '$startDate' AND '$endDate' GROUP BY c.courier_id";
        $result=$con->query($sql);
        return $result;
    }
    public function ViewEmployee($emp_id){
        $con=$GLOBALS["con"];
        $sql="SELECT * FROM employee where employee_id='$emp_id'";
        $result=$con->query($sql);
        return $result;
    }
    public function deleteEmployee($employee_id)
    {
        $con=$GLOBALS['con'];
        $sql="DELETE FROM employee where employee_id='$employee_id'";
        $results=$con->query($sql);
    }
    function updateEmployee($employeeID,$editEmpfname,$editEmplname,$editEmpEmergEmail,$EmpaddressCity,$editEmpStartDate,$editEmpEmail,$editEmptel,$editEmpDob,$editEmpNIC,
        $editsalary,$edittravel_allowance,$editEmergencyContact,$editbank_ac){
        $con=$GLOBALS['con'];

        $sql = "UPDATE employee SET "
            . "employee_name='$editEmpfname',"
            . "emp_lname='$editEmplname',"
            . "emergency_email='$editEmpEmergEmail',"
            . "employee_city='$EmpaddressCity',"
            . "work_start_date='$editEmpStartDate',"
            . "Employee_email='$editEmpEmail',"
            . "employee_cno='$editEmptel',"
            . "Emp_dob='$editEmpDob',"
            . "employee_nic='$editEmpNIC',"
            . "salary='$editsalary',"
            . "travel_allowance='$edittravel_allowance',"
            . "EmergencyContact='$editEmergencyContact',"
            . "bank_ac='$editbank_ac'"

            . "WHERE employee_id ='$employeeID '";

        $result=$con->query($sql) or die($con->error);
    }
    public function getPerformance($startDate,$EndDate,$empID){
        $con=$GLOBALS["con"];
        $sql="SELECT * FROM `driver_rating` r,employee e WHERE r.`driver_employee_id`=e.employee_id AND r.`driver_employee_id`='$empID' AND r.`date` BETWEEN '$startDate' AND  '$EndDate' GROUP BY r.`driver_rating_id` DESC LIMIT 0,1";
        $result=$con->query($sql);
        return $result;
    }
}


?>