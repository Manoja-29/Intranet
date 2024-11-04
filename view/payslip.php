<?php

include "../commons/fpdf186/cellfitscale.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../commons/PHPMailer/src/Exception.php';
require '../commons/PHPMailer/src/PHPMailer.php';
require '../commons/PHPMailer/src/SMTP.php';

require '../commons/vendor/autoload.php';

$payslip_id=$_REQUEST["payslip_id"];
$payslip_id=base64_decode($payslip_id);

$pay_period = $_REQUEST["date"];
include "../model/order_model.php";
$payslipObj=new Order();
$payslipResult=$payslipObj->getPayslipDetails($payslip_id);
$payslipRow=$payslipResult->fetch_assoc();


/*employee details*/
$emp_id=$_REQUEST["emp_id"];
$emp_id=base64_decode($emp_id);
include '../model/user-model.php';

$employeeObj=new User();
$empResult=$employeeObj->ViewIndividualUser($emp_id);
$empRow=$empResult->fetch_assoc();
$emp_name=ucfirst($empRow["user_fname"]);
$emp_lname=ucfirst($empRow["user_lname"]);


$fpdf= new FPDF_CellFit('L','mm','A5');

$fpdf->SetTitle("Payslip");
$fpdf->AddPage();

$fpdf->SetFont("Arial","B","12");
$fpdf->Cell(0,-4,"PAYSLIP",0,"1","R");
$fpdf->Cell(0,1,"",0,"1","R");/*space*/
$fpdf->SetFont("Arial","","7");
$fpdf->Cell(189,8, $payslipRow["payslip_number"] ,0,"1","R");

$fpdf->Cell(0,2,"",0,"1","R");/*space*/

$fpdf->SetFont("Arial","B","16");
$fpdf->SetFont("Arial","","11");
$fpdf->Image("img/tc-logo.png",10,1,30);
$fpdf->SetTextColor(255,255,255);
$fpdf->SetFillColor(1, 24, 60);
$fpdf->Cell(85,10," Employee ",0,"0","L",TRUE);
$fpdf->SetFillColor(0, 0, 0);
$fpdf->Cell(45,10,"",0,"0","L");
$fpdf->SetFillColor(1, 24, 60);
$fpdf->Cell(60,10," Payslip Details ",0,"1","l",TRUE);
$fpdf->SetTextColor(0,0,0);

$fpdf->SetFont("Arial","","9");
$fpdf->CellFitScale(50,10," Name: $emp_name $emp_lname ",0,"0","L");
$fpdf->Cell(28,10,"",0,"0","");
$fpdf->CellFitScale(85,10,"Pay Period : ".$payslipRow["pay_period"],0,"1","R");


$fpdf->CellFitScale(80,6," Employee ID : EMP - ". sprintf('%03d', $empRow["user_id"]),0,"0","L");
$fpdf->Cell(51,6,"",0,"0","L");
$fpdf->Cell(70,6,"Pay Day : ". $payslipRow["pay_date"],0,"1","L");

$fpdf->Cell(30,3,"",0,"0","L");
$fpdf->Cell(50,3,"",0,"1","L");
$fpdf->Cell(0,3,"",0,"1","L");


$fpdf->SetTextColor(255,255,255);
$fpdf->SetFillColor(1, 24, 60);
$fpdf->CellFitScale(137,10," Description",0,"0","L",TRUE);
$fpdf->Cell(40,10,"",0,"0","L",TRUE);
$fpdf->CellFitScale(0,10,"Amount",0,"1","",TRUE);
$fpdf->SetTextColor(0,0,0);

$ciphering = "AES-128-CTR";

$decryption_iv = 'rqEJKQ+COwSInxjv';

// Store the decryption key
$decryption_key = "A$6Q{5M*AMsT,VRPQ@M5-=x>Y.^nQh9n";
$options = 0;

// Use openssl_decrypt() function to decrypt the data

$salary = number_format(openssl_decrypt($payslipRow["amount"], $ciphering, $decryption_key, $options, $decryption_iv)).'.00';
$travel_allowance = number_format(openssl_decrypt($payslipRow["travel_allowance"], $ciphering, $decryption_key, $options, $decryption_iv)).'.00';
$incentive = number_format(openssl_decrypt($payslipRow["incentives"], $ciphering, $decryption_key, $options, $decryption_iv)).'.00';
$tax = number_format(openssl_decrypt($payslipRow["tax"], $ciphering, $decryption_key, $options, $decryption_iv)).'.00';
$epf8 = number_format(openssl_decrypt($payslipRow["epf8"], $ciphering, $decryption_key, $options, $decryption_iv)).'.00';
$total_amount = number_format(openssl_decrypt($payslipRow["total_amount"], $ciphering, $decryption_key, $options, $decryption_iv)).'.00';
$epf12 = number_format(openssl_decrypt($payslipRow["epf12"], $ciphering, $decryption_key, $options, $decryption_iv)).'.00';
$etf3 = number_format(openssl_decrypt($payslipRow["etf3"], $ciphering, $decryption_key, $options, $decryption_iv)).'.00';




$fpdf->SetFont("Arial","","8");
$fpdf->CellFitScale(130,7," + Basic Salary  ","L","0","L");/*description*/
$fpdf->CellFitScale(60,7,'LKR '.$salary,"R","1","R");/*line total*/
$fpdf->CellFitScale(130,7," + Travel Allowance  ","L","0","L");/*description*/
$fpdf->CellFitScale(60,7,'LKR '.$travel_allowance,"R","1","R");/*line total*/
$fpdf->CellFitScale(129,7," + Incentive  ","L B","0","L");/*description*/
$fpdf->CellFitScale(61,7,'LKR '.$incentive,"R B","1","R");/*line total*/

$fpdf->CellFitScale(131,7," - Payee Tax  ","L","0","L");/*description*/
$fpdf->CellFitScale(59,7,'LKR '.'('.$tax.')',"R","1","R");/*line total*/
$fpdf->CellFitScale(130,7," - EPF Employee 8%  ","L B","0","L");/*description*/
$fpdf->CellFitScale(60,7,'LKR '.'('.$epf8.')',"R B","1","R");/*line total*/

$fpdf->Cell(40,10,"",0,"1","L");/*space after table*/

$fpdf->SetTextColor(255,255,255);
$fpdf->SetFillColor(1, 24, 60);
$fpdf->CellFitScale(90,6," SIGNATURE",1,"0","L",TRUE);
$fpdf->SetTextColor(0,0,0);

$amount=3+4;
$fpdf->Cell(40,5,"",0,"0","R");
$fpdf->CellFitScale(39,5,"Take Home",0,"0","L");
$fpdf->CellFitScale(0,5,'LKR '.$total_amount,0,"1","R");
$fpdf->Cell(90,1,"",0,"1","L");/*empty box after description*/
$fpdf->CellFitScale(90,18," ",1,"0","L");/*box after description*/
$fpdf->Cell(40,5,"",0,"0","L");

$amount2="8";
$fpdf->SetTextColor(0,0,0);
$fpdf->CellFitScale(40,10,"EPF Employer 12%",0,"0","L");
$fpdf->CellFitScale(0,10,'LKR '.$epf12,0,"1","R");
$fpdf->Cell(130,5,"",0,"0","L");
$fpdf->CellFitScale(42,5,"ETF Employer 3%",0,"0","L");
$fpdf->CellFitScale(0,5,'LKR '.$etf3,0,"1","R");

$payslip_id=base64_encode($payslip_id);

$dir="documents/payslips/";
$filename=$emp_name.' Pay Slip - '.$pay_period.' '.$payslip_id.".pdf";
$fpdf->Output(); /*open in browser*/
$fpdf->Output('F', $dir.$filename, true); /*save to the folder*/


$userResult= $employeeObj->viewUser($emp_id);
$userRow=$userResult->fetch_assoc();
$user_email=$userRow["user_email"];
$user_name=$userRow["user_fname"];
$mail = new PHPMailer(true);

$mail->isSMTP();                                            //Send using SMTP
$mail->Host       = 'mail.technicalcreatives.lk';                     //Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
$mail->Username   = 'payslip@technicalcreatives.lk';                     //SMTP username
$mail->Password   = 'Bef=ED+y}M@H';                               //SMTP password
$mail->SMTPSecure = 'tls';
$mail->Port       = 587;
//Recipients
$mail->setFrom('payslip@technicalcreatives.lk', 'TC Intranet');
$mail->addAddress($user_email, $user_name);     //Add a recipient
$mail->addReplyTo('payslip@technicalcreatives.lk', 'Information');
//    $mail->addCC('cc@example.com');
//    $mail->addBCC('bcc@example.com');

$mail->AddAttachment('../view/documents/payslips/'.$filename, $filename,$encoding = 'base64', $type = 'application/pdf');

//Content
$mail->isHTML(true); //Set email format to HTML
$mail->Subject = $user_name.' Pay Slip '.' - '.$pay_period;
$mail->Body    = 'Dear'." ".  $user_name.","."</br></br>".
    'Please find attached the <b>Pay Slip for '.  $pay_period .".</b></br>" .
    'If you have any questions, do not hesitate to contact us.'. "</b></br></br>" .
    'Regards,'."</br>".
    'TC APAC Management'."</br></br>";
$mail->send();
/*global $message;
if(!$mail->Send()) {
    $message =  "Invoice could not be send. Mailer Error: " . $mail->ErrorInfo;
} else {
    $message = "Invoice sent!";
}*/





