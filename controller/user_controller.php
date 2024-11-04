<?php
include "../commons/session.php";
if (!isset($_SESSION['user']))
{
    header('Location: login.php');
}
$firstname=$_SESSION['user']['firstname'];
$lastname=$_SESSION['user']['lastname'];
$user_id=$_SESSION['user']['user_id'];

//ini_set("memory_limit","200GB");

if(isset($_REQUEST["status"]))
{
    include '../model/user-model.php';
    $userObj = new User();

    include '../model/login_model.php';
    $loginObj = new Login();

    //using the model in controller
    $status=$_REQUEST["status"];
    switch ($status) {


        case "getfunctions":
            $roleId=$_POST["role_id"] ;

            $moduleResult=$userObj->getModulesByRole($roleId);/*to get the modules using the role id*/
            ?>
            <div class="row">
            <?php

            $mCounter=0; /*to make a new row after 3 modules are mentioned*/
            while($mRow=  $moduleResult->fetch_assoc())
            {

                $moduleId=$mRow["module_id"];/*to get the functions get the module id and pass it to moduleId variable*/

                $functionResult=$userObj->getModuleFunctions($moduleId);/*get the functions*/

                $mCounter++;
                ?>
                <div class="col-md-3">
                    <label class="control-label"><?php echo $mRow["module_name"];  ?></label>
                    <br/>
                    <?php

                    while($funRow=$functionResult->fetch_assoc())
                    {
                        /*checked is mentioned to ensure all the checkboxes are checked by default*/
                        ?>
                        <input type="checkbox" class="chkbx"  name="myfunctions[]" value="<?php  echo $funRow["function_id"]; ?>" checked="checked"/>
                        <?php

                        echo $funRow["function_name"];/*display functions relevant to particular module,under the module name*/
                        //checked is used to tick all
                        ?>
                        <br/>
                        <?php
                    }
                    ?>
                </div>
                <?php
                /*to move to next row when 3 modules are mentioned*/
                if($mCounter%4==0)
                {
                    ?>
                    </div>
                    <div class="row">
                    <?php
                }

                ?>

                <?php
            }
            ?>
            </div>
            <?php

            break;


        case "add_user":


            echo  $firstName=$_POST["fname"];
            echo "<br/>";

            echo $lastName=$_POST["lname"];
            echo "<br/>";
            echo $nic=$_POST["unic"];

            echo "<br/>";

            echo $password=$_POST["validation-password"];

            echo "<br/>";

            echo $gender=$_POST["gender"];

            echo "<br/>";


            echo $cno1=$_POST["tel1"];

            echo "<br/>";

            echo $cno2=$_POST["tel2"];

            echo "<br/>";


            echo $email=$_POST["uemail"];
            echo "<br/>";

            echo $pemail=$_POST["pemail"];
            echo "<br/>";

            echo $birth=$_POST["birth"];
            echo "<br/>";

            echo $marital=$_POST["marital"];
            echo "<br/>";

            echo $joinDate=$_POST["joinDate"];
            echo "<br/>";

            echo $exitDate=$_POST["exitDate"];
            echo "<br/>";

            echo $userRole=$_POST["user_role"];

            echo $address=$_POST["address"];
            echo $city=$_POST["Hometown"];
            echo $province=$_POST["province"];
            echo $basicSalary=$_POST["salary"];
            echo $travel_allowance=$_POST["travel_allowance"];
            echo $bankAC=$_POST["bank_ac"];
            echo $qualification=$_POST["Qualification"];

            echo $account_holder=$_POST["account_holder"];
            echo $bank=$_POST["bank"];
            echo $branch=$_POST["branch"];
            echo $bank_code=$_POST["bank_code"];

            echo $annual=$_POST["annual"];
            echo $casual=$_POST["casual"];
            echo $sick=$_POST["sick"];

            echo "<br/>";

            try{


                if($firstName==""){
                    throw new exception("Firstname is empty");
                }
                if($lastName==""){
                    throw new exception("Lastname is empty");
                }
                if($email==""){
                    throw new exception("Email is empty");
                }
                if($password==""){
                    throw new exception("Password is empty");
                }
                if($gender==""){
                    throw new exception("Gender is empty");
                }
                if($nic==""){
                    throw new exception("Nic is empty");
                }
                if($cno1==""){
                    throw new exception("Contact number is empty");
                }
                if($userRole==""){
                    throw new exception("User role is empty");
                }

                if ($_FILES['uimg']['name']!='')
                {
                    $img=$_FILES['uimg']['name'];
                    $img="".time()."-".$img;
                    $tmp_location=$_FILES['uimg']['tmp_name'];
                    $destination="../view/img/user_images/$img";
                    move_uploaded_file($tmp_location,$destination);
                }
                else{
                    $img="defaultImage.jpg";

                }
                $isValid=$userObj->validateEmail($email);
                if($isValid==false){
                    throw new exception("Email address is already taken");

                }

                $isValid=$userObj->validateContactNumber($cno1);
                if($isValid==false){
                    throw new exception("Contact Number is already taken");
                }
                echo $password_encoded=base64_encode($password);

                // Store the cipher method
                $ciphering = "AES-128-CTR";

                // Use OpenSSl Encryption method
                $iv_length = openssl_cipher_iv_length($ciphering);
                $options = 0;

                // Non-NULL Initialization Vector for encryption
                $encryption_iv = 'rqEJKQ+COwSInxjv';

                // Store the encryption key
                $encryption_key = "A$6Q{5M*AMsT,VRPQ@M5-=x>Y.^nQh9n";

                // Use openssl_encrypt() function to encrypt the data
                $basicSalary_encrypted = openssl_encrypt($basicSalary, $ciphering, $encryption_key, $options, $encryption_iv);
                $travel_allowance_encrypted = openssl_encrypt($travel_allowance, $ciphering, $encryption_key, $options, $encryption_iv);
                $bankAC_encrypted = openssl_encrypt($bankAC, $ciphering, $encryption_key, $options, $encryption_iv);
                $account_holder_encrypted = openssl_encrypt($account_holder, $ciphering, $encryption_key, $options, $encryption_iv);
                $bank_encrypted = openssl_encrypt($bank, $ciphering, $encryption_key, $options, $encryption_iv);
                $branch_encrypted = openssl_encrypt($branch, $ciphering, $encryption_key, $options, $encryption_iv);
                $bank_code_encrypted = openssl_encrypt($bank_code, $ciphering, $encryption_key, $options, $encryption_iv);


                $userId=$userObj->addUser($firstName,$lastName,$nic,$img,$password_encoded,$gender,1,$cno1,$cno2,$email,$userRole,$pemail,$birth,$marital,$joinDate,$exitDate);
                $employeeID = $userObj->addAddiotionalUserDetails($userId,$address, $city, $province, $basicSalary_encrypted, $travel_allowance_encrypted, $bankAC_encrypted,
                    $qualification,$account_holder_encrypted,$bank_encrypted,$branch_encrypted,$bank_code_encrypted,$annual,$casual,$sick);

                echo "<hr/>";

                if($userId>0){/*check if user is available*/

                    $login_pw=sha1($password);
                    $loginObj->addLogin($email,$login_pw,1,$userId);


                    $msg="successfully inserted";
                    $msg=base64_encode($msg);

                    ?>
                    <script>
                        window.location = "../view/team.php?msg=<?php echo $msg; ?>"
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
                    window.location = "../view/add-user.php?msg=<?php echo $msg;?>"
                </script>

                <?php

            }

            break;


        case "deactivateUser";

            $_GET["user_id"];
            $userId=$_GET["user_id"];

            /*decode the encoded value to normal numeric value*/
            $userId= base64_decode($userId);


            $userObj->deactivateUser($userId);
            $msg="User Deactivated successfully";
            $msg= base64_encode($msg);
            ?>
            <script>
                window.location = "../view/team.php?msg=<?php echo $msg; ?>"
            </script>

            <?php


            break;

        case "activateUser";

            $_REQUEST['user_id'];
            $userId=$_REQUEST['user_id'];
            /*decode the encoded value to normal numeric value*/
            echo $userId= base64_decode($userId);

            $userObj->activateUser($userId);
            $msg="User activated successfully";
            $msg=base64_encode($msg);
            ?>
            <script>
                window.location = "../view/team.php?msg=<?php echo $msg; ?>"
            </script>

            <?php

            break;

        case  "edit_user";
            echo $userId=$_POST["editUserID"];
            echo "<br/>";

            echo  $firstName=$_POST["fname"];
            echo "<br/>";

            echo $lastName=$_POST["lname"];
            echo "<br/>";
            echo $nic=$_POST["unic"];

            echo "<br/>";

            echo $old_password=$_POST["password"];
            echo $password=$_POST["new_password"];

            echo "<br/>";

            echo $gender=$_POST["Gender"];

            echo "<br/>";


            echo $cno1=$_POST["tel1"];

            echo "<br/>";

            echo $cno2=$_POST["tel2"];

            echo "<br/>";


            echo $email=$_POST["uemail"];
            echo "<br/>";

            echo $pemail=$_POST["pemail"];
            echo "<br/>";

            echo $birth=$_POST["birth"];
            echo "<br/>";

            echo $marital=$_POST["marital"];
            echo "<br/>";

            echo $userJoin=$_POST["userJoin"];
            echo "<br/>";

            echo $userExit=$_POST["userExit"];
            echo "<br/>";

            echo $userRole=$_POST["user_role"];

            echo $salary=$_POST["salary"];
            echo $bank_ac=$_POST["bank_ac"];
            echo $address=$_POST["address"];
            echo $city=$_POST["city"];
            echo $province=$_POST["province"];
            echo $travel_allowance=$_POST["travel_allowance"];
            echo $Qualification=$_POST["Qualification"];

            echo $account_holder=$_POST["account_holder"];
            echo $bank=$_POST["bank"];
            echo $branch=$_POST["branch"];
            echo $bank_code=$_POST["bank_code"];

            echo $annual=$_POST["annual"];
            echo $casual=$_POST["casual"];
            echo $sick=$_POST["sick"];

            try{

                if($firstName==""){
                    throw new exception("Firstname is empty");
                }
                if($lastName==""){
                    throw new exception("Lastname is empty");
                }
                if($email==""){
                    throw new exception("Email is empty");
                }

                if($gender==""){
                    throw new exception("Gender is empty");
                }
                if($nic==""){
                    throw new exception("NIC is empty");
                }
                if($cno1==""){
                    throw new exception("Contact number is empty");
                }

                $patnic="/^[0-9]{9}[vVxX]|[0-9]{9}$/";
                $patemail="/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z]{2,6})+$/";

                if(!preg_match($patnic,$nic)){
                    throw new exception("NIC is invalid");
                }


                if(!preg_match($patemail,$email)){
                    throw new exception("email is invalid");
                }


                if ($_FILES['uimg']['name']!='')
                {
                    $img=$_FILES['uimg']['name'];
                    $img="".time()."-".$img;
                    $tmp_location=$_FILES['uimg']['tmp_name'];
                    $destination="../view/img/user_images/$img";
                    move_uploaded_file($tmp_location,$destination);
                }
                else{
                    $img="defaultImage.jpg";

                }
                $isValid=$userObj->updateEmailValidation($userId,$email);
                if($isValid==false){
                    throw new exception("Email address is already taken");

                }

                $isValid=$userObj->updatePhoneValidation($userId,$cno1);
                if($isValid==false){
                    throw new exception("Contact Number is already taken");
                }
                if($password==""){
                    echo $old_password=base64_encode($old_password);/*convert password to sha1 format to store in database as passwords are stored in that format*/
                    $userObj->updateUser($userId,$firstName,$lastName,$email,$img,$nic,$old_password,$gender,$userRole,$cno1,$cno2,$pemail,$birth,$marital,$userJoin,$userExit);
                }
                else{
                    echo $new_password=base64_encode($password);/*convert password to sha1 format to store in database as passwords are stored in that format*/

                    $userObj->updateUser($userId,$firstName,$lastName,$email,$img,$nic,$new_password,$gender,$userRole,$cno1,$cno2,$pemail,$birth,$marital,$userJoin,$userExit);
                    echo $password=sha1($password);/*convert password to sha1 format to store in database as passwords are stored in that format*/
                    $result=$loginObj->editUserPassword($password,$userId);
                }
                // Store the cipher method
                $ciphering = "AES-128-CTR";

                // Use OpenSSl Encryption method
                $iv_length = openssl_cipher_iv_length($ciphering);
                $options = 0;

                // Non-NULL Initialization Vector for encryption
                $encryption_iv = 'rqEJKQ+COwSInxjv';

                // Store the encryption key
                $encryption_key = "A$6Q{5M*AMsT,VRPQ@M5-=x>Y.^nQh9n";

                // Use openssl_encrypt() function to encrypt the data
                $basicSalary_encrypted = openssl_encrypt($salary, $ciphering, $encryption_key, $options, $encryption_iv);
                $travel_allowance_encrypted = openssl_encrypt($travel_allowance, $ciphering, $encryption_key, $options, $encryption_iv);
                $bankAC_encrypted = openssl_encrypt($bank_ac, $ciphering, $encryption_key, $options, $encryption_iv);
                $account_holder_encrypted = openssl_encrypt($account_holder, $ciphering, $encryption_key, $options, $encryption_iv);
                $bank_encrypted = openssl_encrypt($bank, $ciphering, $encryption_key, $options, $encryption_iv);
                $branch_encrypted = openssl_encrypt($branch, $ciphering, $encryption_key, $options, $encryption_iv);
                $bank_code_encrypted = openssl_encrypt($bank_code, $ciphering, $encryption_key, $options, $encryption_iv);

                $userObj->updateUserAddDetails($userId,$basicSalary_encrypted,$bankAC_encrypted,$address,$city,$province,$travel_allowance_encrypted,$Qualification,$account_holder_encrypted,$bank_encrypted,$branch_encrypted,$bank_code_encrypted,$annual,$casual,$sick);


                echo "<hr/>";

                if($userId>0){/*check if user is available*/

                    $msg="successfully updated user $firstName $lastName";
                    $msg=base64_encode($msg);

                    ?>
                    <script>
                        window.location = "../view/team.php?msg=<?php echo $msg; ?>&user_id=<?php echo $userId; ?>"
                    </script>

                    <?php

                }

            }
            catch (exception $exception)
            {
                $msg=$exception->getMessage();
                $msg=base64_encode($msg);
                $userId2=base64_encode($userId);

                ?>
                <script>
                    window.location = "../view/view-user.php?msg=<?php echo $msg; ?>&user_id=<?php echo $userId2; ?>"
                </script>

                <?php
            }

            break;

        case  "edit_user_employee";
            echo $userId=$_POST["editUserID"];
            echo "<br/>";

            echo  $firstName=$_POST["fname"];
            echo "<br/>";

            echo $lastName=$_POST["lname"];
            echo "<br/>";
            echo $nic=$_POST["unic"];

            echo "<br/>";

            echo $old_password=$_POST["password"];
            echo $password=$_POST["new_password"];

            echo "<br/>";

            echo $gender=$_POST["Gender"];

            echo "<br/>";


            echo $cno1=$_POST["tel1"];

            echo "<br/>";

            echo $cno2=$_POST["tel2"];

            echo "<br/>";


            echo $email=$_POST["uemail"];
            echo "<br/>";

            echo $pemail=$_POST["pemail"];
            echo "<br/>";

            echo $birth=$_POST["birth"];
            echo "<br/>";

            echo $marital=$_POST["marital"];
            echo "<br/>";

            echo $userJoin=$_POST["userJoin"];
            echo "<br/>";

            echo $userExit=$_POST["userExit"];
            echo "<br/>";
            echo $userRole=$_POST["user_role"];

            echo $salary=$_POST["salary"];
            echo $bank_ac=$_POST["bank_ac"];
            echo $address=$_POST["address"];
            echo $city=$_POST["city"];
            echo $province=$_POST["province"];
            echo $travel_allowance=$_POST["travel_allowance"];
            echo $Qualification=$_POST["Qualification"];

            echo $account_holder=$_POST["account_holder"];
            echo $bank=$_POST["bank"];
            echo $branch=$_POST["branch"];
            echo $bank_code=$_POST["bank_code"];

            echo $annual=$_POST["annual"];
            echo $casual=$_POST["casual"];
            echo $sick=$_POST["sick"];

            try{

                if($firstName==""){
                    throw new exception("Firstname is empty");
                }
                if($lastName==""){
                    throw new exception("Lastname is empty");
                }
                if($email==""){
                    throw new exception("Email is empty");
                }

                if($gender==""){
                    throw new exception("Gender is empty");
                }
                if($nic==""){
                    throw new exception("NIC is empty");
                }
                if($cno1==""){
                    throw new exception("Contact number is empty");
                }

                $patnic="/^[0-9]{9}[vVxX]|[0-9]{9}$/";
                $patemail="/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z]{2,6})+$/";

                if(!preg_match($patnic,$nic)){
                    throw new exception("NIC is invalid");
                }


                if(!preg_match($patemail,$email)){
                    throw new exception("email is invalid");
                }


                if ($_FILES['uimg']['name']!='')
                {
                    $img=$_FILES['uimg']['name'];
                    $img="".time()."-".$img;
                    $tmp_location=$_FILES['uimg']['tmp_name'];
                    $destination="../view/img/user_images/$img";
                    move_uploaded_file($tmp_location,$destination);
                }
                else{
                    $img="defaultImage.jpg";

                }
                $isValid=$userObj->updateEmailValidation($userId,$email);
                if($isValid==false){
                    throw new exception("Email address is already taken");

                }

                $isValid=$userObj->updatePhoneValidation($userId,$cno1);
                if($isValid==false){
                    throw new exception("Contact Number is already taken");
                }
                if($password==""){
                    echo $old_password=base64_encode($old_password);/*convert password to sha1 format to store in database as passwords are stored in that format*/
                    $userObj->updateUser($userId,$firstName,$lastName,$email,$img,$nic,$old_password,$gender,$userRole,$cno1,$cno2,$pemail,$birth,$marital,$userJoin,$userExit);
                }
                else{
                    echo $new_password=base64_encode($password);/*convert password to sha1 format to store in database as passwords are stored in that format*/

                    $userObj->updateUser($userId,$firstName,$lastName,$email,$img,$nic,$new_password,$gender,$userRole,$cno1,$cno2,$pemail,$birth,$marital,$userJoin,$userExit);
                    echo $password=sha1($password);/*convert password to sha1 format to store in database as passwords are stored in that format*/
                    $result=$loginObj->editUserPassword($password,$userId);
                }
                // Store the cipher method
                $ciphering = "AES-128-CTR";

                // Use OpenSSl Encryption method
                $iv_length = openssl_cipher_iv_length($ciphering);
                $options = 0;

                // Non-NULL Initialization Vector for encryption
                $encryption_iv = 'rqEJKQ+COwSInxjv';

                // Store the encryption key
                $encryption_key = "A$6Q{5M*AMsT,VRPQ@M5-=x>Y.^nQh9n";

                // Use openssl_encrypt() function to encrypt the data
                $basicSalary_encrypted = openssl_encrypt($salary, $ciphering, $encryption_key, $options, $encryption_iv);
                $travel_allowance_encrypted = openssl_encrypt($travel_allowance, $ciphering, $encryption_key, $options, $encryption_iv);
                $bankAC_encrypted = openssl_encrypt($bank_ac, $ciphering, $encryption_key, $options, $encryption_iv);
                $account_holder_encrypted = openssl_encrypt($account_holder, $ciphering, $encryption_key, $options, $encryption_iv);
                $bank_encrypted = openssl_encrypt($bank, $ciphering, $encryption_key, $options, $encryption_iv);
                $branch_encrypted = openssl_encrypt($branch, $ciphering, $encryption_key, $options, $encryption_iv);
                $bank_code_encrypted = openssl_encrypt($bank_code, $ciphering, $encryption_key, $options, $encryption_iv);

                $userObj->updateUserAddDetails($userId,$basicSalary_encrypted,$bankAC_encrypted,$address,$city,$province,$travel_allowance_encrypted,$Qualification,$account_holder_encrypted,$bank_encrypted,$branch_encrypted,$bank_code_encrypted,$annual,$casual,$sick);


                echo "<hr/>";

                if($userId>0){/*check if user is available*/

                    $msg="successfully updated user $firstName $lastName";
                    $msg=base64_encode($msg);

                    ?>
                    <script>
                        window.location = "../view/pages-profile.php?msg=<?php echo $msg; ?>&user_id=<?php echo $userId; ?>"
                    </script>

                    <?php

                }

            }
            catch (exception $exception)
            {
                $msg=$exception->getMessage();
                $msg=base64_encode($msg);
                $userId2=base64_encode($userId);

                ?>
                <script>
                    window.location = "../view/view-user-employee.php?msg=<?php echo $msg; ?>&user_id=<?php echo $userId2; ?>"
                </script>

                <?php
            }

            break;

            case "add-role";

            echo $roleName = $_POST["role_name"];
            echo $roleLevel = $_POST["role_level_id"];
            echo $roleStatus = $_POST["role_status"];

            try{
                if($roleName==""){
                    throw new exception("Role name is empty");
                }
                if($roleLevel==""){
                    throw new exception("Role Level is empty");
                }
                if($roleStatus==""){
                    throw new exception("Role status is empty");
                }

                $roleId = $userObj->addRole($roleName, $roleLevel, $roleStatus);
                if($roleId>0){
                    $msg="Successfully added";
                    $msg=base64_encode($msg);
                    ?>
                    <script>
                        window.location = "../view/add-user.php?msg=<?php echo $msg; ?>"
                    </script>
                    <?php
                }   
            }
            catch(exception $exception){
                $msg=$exception->getMessage();
                $msg=base64_encode($msg);
                ?>
                <script>
                    window.location = "../view/add-user.php?msg=<?php echo $msg; ?>"
                </script>
                <?php
            }                

    }
}

?>