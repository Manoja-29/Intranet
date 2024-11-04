<?php
include '../commons/session.php';
//ini_set("memory_limit","200GB");
use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if(isset($_REQUEST["status"]))
{
    include '../model/login_model.php';
    $loginObj = new Login();

    include '../model/attendance_model.php';
    $attendanceObj=new Attendance();

    include '../model/user-model.php';
    $userObj = new User();
    //using the model in controller
    $status=$_REQUEST["status"];

    switch ($status) {

        case "add_login":
            $username=$_POST["username"];
            $password=$_POST["password"];
            echo "</br>";
            $login_pw=sha1($password);/*convert nic to sha1 format to store in database as passwords are stored in that format*/

            $result=$loginObj->validateLogin($username,$login_pw);

            if($result->num_rows == 1){

                $userRow=$result->fetch_assoc();

                    $user_id=$userRow["user_id"];
                    $role_id=$userRow["user_role"];  ///  getRoleId
                    $firstname=$userRow["user_fname"];
                    $lastname=$userRow["user_lname"];

                $userArray=array(
                        "user_id"=>$user_id,
                        "firstname"=>$firstname,
                        "lastname"=>$lastname,
                        "role_id"=>$role_id
                );
                $_SESSION['loggedin'] = True;
                $_SESSION['user']=$userArray;


                /*Removed cookies for security purposes
                 * if( ($_POST['remember_me']==1) || ($_POST['remember_me']=='on')) {
                    $hour = time() + (3600 * 24 * 30);
                    setcookie('username', $username, $hour,'/');
                    setcookie('password', $password, $hour,'/');
                    setcookie('active', 1, $hour,'/');
                }*/

                    ?>
                <script>
                    window.location = "../view/dashboard.php?login=true";
                </script>

                <?php


            }
            else{
                $msg = "Login failed. Please check the credentials";
                $msg = base64_encode($msg);
                ?>

                <script>
                    window.location = "../view/login.php?msg=<?php echo $msg;?>";
                </script>
                <?php
            }
            break;

        case "logout":

            session_destroy();

            ?>
            <script> window.location="../view/login.php"</script>
            <?php

            break;

        case "verify_account":

            echo "test";
            echo $Recovery_username=$_POST["email"];
            $userResult=$userObj->getUsersbyEmail($Recovery_username);

            if ($userResult->num_rows > 0) {
                echo "test";
                $userRow = $userResult->fetch_assoc();
                echo $user_id = $userRow["user_id"];
                $user_name=$userRow["user_fname"];

                $string = "encrypted_id=$user_id";
                $string = base64_encode($string);
                $url = "http://localhost/intranet-test/view/confirm_password.php?status=recovery&code=$string";


                require '../commons/PHPMailer/src/Exception.php';
                require '../commons/PHPMailer/src/PHPMailer.php';
                require '../commons/PHPMailer/src/SMTP.php';

                require '../commons/vendor/autoload.php';
                $mail = new PHPMailer(true);

                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'mail.technicalcreatives.lk';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'payslip@technicalcreatives.lk';                     //SMTP username
                $mail->Password   = 'Bef=ED+y}M@H';                               //SMTP password
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;
                //Recipients
                $mail->setFrom('payslip@technicalcreatives.lk', 'Mailer');
                $mail->addAddress($Recovery_username, $user_name);     //Add a recipient
                $mail->addReplyTo('payslip@technicalcreatives.lk', 'Information');
                //    $mail->addCC('cc@example.com');
                //    $mail->addBCC('bcc@example.com');

                $mail->Subject = 'Account recovery email';/*subject of mail*/

                //Content
                $mail->isHTML(true); //Set email format to HTML
                $mail->Subject = 'Account recovery';
                $mail->Body    = 'Dear'." ".  $user_name.","."</br></br>".
                    'We hope this email finds you well. It has come to our attention that there might be an issue with accessing your 
                     account ' .".</br></br>" .'If you have forgotten your password or are having trouble logging in, 
                     please follow the steps below to initiate the account recovery process:'.".</br>"." <ul><Li>Visit our login page: <a href=\"$url\">link</a></Li>
                     <Li>Enter the new password</Li>
                     <Li>Click on the 'Forgot Password' link.</Li>
                     </ul>
                      </br><img src='../view/img/tc-logo.png'>".'We appreciate your 
                      prompt attention to this matter. <br><br>Best regards,<br>Technical Creatives APAC (Pvt)Ltd';
                $mail->send();
                global $message;
                if(!$mail->Send()) {
                    $message =  "Could not send. Mailer Error: " . $mail->ErrorInfo;
                } else {
                    $message = "Email sent!";
                }

                $msg="Mail sent successfully";
                $msg=base64_encode($msg);

                ?>
                <!--            once email is sent we will be directed to landing page which consists of the alert -->
                <script>

                    window.location = "../view/pages-reset-password.php?msg=<?php echo $msg ?>"

                </script>

                <?php
            }
            else{
                $msg="Please check the email or if the account is active";
                $msg=base64_encode($msg);
                ?>
                <!--once email is sent we will be directed to landing page which consists of the alert -->
                <script>

                    window.location = "../view/pages-reset-password.php?msg=<?php echo $msg ?>"

                </script>

                <?php
            }

            break;

        case "change_password":
            echo $user_id=$_POST["user_id"];
            echo $password=$_POST["n_password"];

            echo $new_password=base64_encode($password);/*convert password */
            $userObj->updatePassword($user_id,$new_password);

            echo $password=sha1($password);/*convert password to sha1 format to store in database*/
            $result=$loginObj->editUserPassword($password,$user_id);

            ?>

            <!--    once password is changed -->
            <script>
                window.location = "../view/login.php?update=true"
            </script>
            <?php



            break;





    }
}

?>