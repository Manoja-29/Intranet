<?php
session_start();
include "../model/employee_model.php";
$employeeObj=new Employee();

if(isset($_REQUEST["status"]))
{
    include '../model/order_model.php';
    $orderObj=new Order();

    //using the model in controller
    $status=$_REQUEST["status"];
    switch ($status) {

        case "add_employee":

            echo $EmpID = $_POST["EmpID"];
            echo $Empfname = $_POST["Empfname"];
            echo $Emplname = $_POST["Emplname"];
            echo $EmpRef = $_POST["EmpRef"];
            echo $Empdob = $_POST["Empdob"];
            echo $gender = $_POST["gender"];
            echo $Empemail = $_POST["Empemail"];
            echo $Emptel1 = $_POST["Emptel1"];
            echo $Empnic = $_POST["Empnic"];
            echo $Hometown = $_POST["Hometown"];


            echo $EmergencyContact = $_POST["EmergencyContact"];
            echo $EmergencyEmail = $_POST["EmergencyEmail"];
            echo $bankAC = $_POST["bankAC"];
            echo $basicSalary = $_POST["basicSalary"];
            echo $travel_allowance = $_POST["travelallowance"];


            echo $JobPosition = $_POST["JobPosition"];
            echo $WorkStartDate = $_POST["WorkStartDate"];

            try{

                if($Empfname==""){
                    throw new exception("Employee name is empty");
                }
                if($Empdob==""){
                    throw new exception("Date of birth is empty");
                }
                if($gender==""){
                    throw new exception("Gender is empty");
                }
                if($Empemail==""){
                    throw new exception("Email is empty");
                }
                if($gender==""){
                    throw new exception("gender is empty");
                }
                if($Empnic==""){
                    throw new exception("NIC is empty");
                }
                if($Emptel1==""){
                    throw new exception("Contact is empty");
                }
                if($Hometown==""){
                    throw new exception("Hometown is empty");
                }



                $employeeID = $employeeObj->addEmployee($EmpRef, $Empfname, $Emplname, $Empdob, $gender, $Empnic, $JobPosition, $Emptel1, $Empemail,
                        $Hometown, $basicSalary, $travel_allowance, $EmergencyContact, $EmergencyEmail, $bankAC, $WorkStartDate);

                if($employeeID>0){
                    $msg="successfully added";
                    $msg=base64_encode($msg);

                    ?>
                    <script>
                        window.location = "../view/display-all-employees.php?msg=<?php echo $msg; ?>"
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
                    window.location = "../view/add-employee.php?msg=<?php echo $msg; ?>"
                </script>

                <?php

            }
            break;


        case "edit_emp":

            echo $employeeID1 = $_REQUEST['employeeID'];
            echo $employeeID=base64_decode($employeeID1);
            echo $editEmpfname = $_POST['editEmpfname'];
            echo $editEmplname = $_POST['editEmplname'];
            echo $editEmpEmergEmail = $_POST['editEmpEmergEmail'];


            echo $EmpaddressCity = $_POST['EmpaddressCity'];
            echo $editEmpStartDate = $_POST['editEmpStartDate'];

            echo $editEmpEmail = $_POST['editEmpEmail'];
            echo $editEmptel = $_POST['editEmptel'];
            echo $editEmpDob = $_POST['editEmpDob'];
            echo $edittravel_allowance = $_POST['travel_allowance'];
            echo $editEmergencyContact = $_POST['EmergencyContact'];
            echo $editbank_ac = $_POST['bank_ac'];
            echo $editsalary = $_POST['salary'];

            echo $editEmpNIC = $_POST['editEmpNIC'];

            $employeeObj->updateEmployee($employeeID,$editEmpfname,$editEmplname,$editEmpEmergEmail,$EmpaddressCity,$editEmpStartDate,$editEmpEmail,$editEmptel,$editEmpDob,$editEmpNIC,
                $editsalary,$edittravel_allowance,$editEmergencyContact,$editbank_ac);

            if($employeeID>0){/*check if user is available*/
                $msg="successfully Updated";
                $msg=base64_encode($msg);
                ?>
                <script>
                    window.location = "../view/display-all-employees.php?msg=<?php echo $msg; ?>"
                </script>

                <?php

            }

            break;

        case "removeEmployee":

            $emp_id=$_POST["emp_id"];
            $employeeObj->deleteEmployee($emp_id);

            $msg="successfully Deleted";
            $msg=base64_encode($msg);

            ?>
            <script>
                window.location = "../view/display-all-employees.php?msg=<?php echo $msg; ?>"
            </script>

            <?php


            break;
    }
}


