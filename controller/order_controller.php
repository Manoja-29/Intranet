<?php
include "../commons/session.php";

if (!isset($_SESSION['user']))
{
    header('Location: login.php');
}
$firstname=$_SESSION['user']['firstname'];
$lastname=$_SESSION['user']['lastname'];
$user_id=$_SESSION['user']['user_id'];

if(isset($_REQUEST["status"]))
{
    include '../model/order_model.php';
    $orderObj=new Order();

    include '../model/user-model.php';
    $userObj = new User();

    include "../model/employee_model.php";
    $employeeObj=new Employee();

    //using the model in controller
    $status=$_REQUEST["status"];
    switch ($status) {

        case "check_emp": /*Check if employee(user) exists and display salary information*/
            $emp_id=$_POST["driverEmployeeID2"];
            $userResult=$userObj->ViewUserAdditionalDetails($emp_id);

            if($userResult->num_rows>0){
                $empRow = $userResult->fetch_assoc();
                $existingEmpID=$empRow["user_id"];
                /*display existing customer details*/

                $ciphering = "AES-128-CTR";

                $decryption_iv = 'rqEJKQ+COwSInxjv';

                // Store the decryption key
                $decryption_key = "A$6Q{5M*AMsT,VRPQ@M5-=x>Y.^nQh9n";
                $options = 0;

                // Use openssl_decrypt() function to decrypt the data

                $salary=openssl_decrypt ($empRow["salary"], $ciphering, $decryption_key, $options, $decryption_iv);
                $travel_allowance=openssl_decrypt ($empRow["travel_allowance"], $ciphering, $decryption_key, $options, $decryption_iv);

                ?>

                <div id="earnings-deductions">
                    <input value="" type="hidden" id="driverEmployeeID2" name="driverEmployeeID2">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input class="form-control" name="Amount" value="<?php echo $salary ?>" id="Amount" type="text" placeholder="Readonly input">
                                <label for="floatingInput1">Basic Salary</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input class="form-control" type="text" name="travelallowance" value="<?php echo $travel_allowance?>" readonly id="travelallowance" min="0">
                                <label for="floatingInput1">Travel Allowance</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input class="form-control" type="text" name="incentices" id="incentices" value="<?php echo $salary * 0.25 ?>" min="0" >
                                <label for="floatingInput1">Incentive</label>
                            </div>

                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input class="form-control" type="text" name="tax" id="tax" oninput="checkvalue()" placeholder="Payee Tax" oninput="checkvalue()" min="0">
                                <label for="floatingInput1">Payee Tax</label>
                            </div>
                            <p id="MinusError"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input class="form-control" type="text" name="EPF8" id="EPF8" min="0" placeholder="Readonly input" value="<?php echo $salary * 0.08 ?>" readonly>
                                <label for="floatingInput1">EPF Employee(8%)</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input class="form-control" type="text" name="EPF12" id="EPF12" min="0" placeholder="Readonly input" value="<?php echo $salary * 0.12 ?>" readonly>
                                <label for="floatingInput1">EPF Employer(12%)</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input class="form-control" type="text" name="etf" id="etf" min="0" placeholder="Readonly input" value="<?php echo $salary * 0.03 ?>" readonly>
                                <label for="floatingInput1">ETF Employer(3%)</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input class="form-control" name="TotAmount" id="TotAmount" type="text" min="0" readonly>
                                <label for="floatingInput1">Total Amount</label>
                            </div>
                        </div>

                    </div>
                    <br>

                </div>
                <script type="text/javascript">
                    $("#leaves-div").show();

                </script>
                <?php

                /*insert only the order details as customer details already exist*/

            }

            break;
        /*add payslip*/
        case "add_order":

            $emp_id=$_POST["driver_Name2"];
            $employee_id = preg_replace('/[^0-9]/',' ', $emp_id);

            $payslip_number=$_POST["payslipNo"];
            "<br/>";

            $pay_period=$_POST["payperiod"];
            "<br/>";

            $pay_date=$_POST["payDate"];
            "<br/>";

            $order_description=$_POST["description"];
            "<br/>";

            $amount=$_POST["Amount"];
            "<br/>";
            $travel_allowance=$_POST["travelallowance"];
            "<br/>";
            $incentives=$_POST["incentices"];
            "<br/>";

            $tax=$_POST["tax"];
            "<br/>";
            $total_amount=$_POST["TotAmount"];
            "<br/>";

            $epf8=$_POST["EPF8"];
            "<br/>";

            $epf12=$_POST["EPF12"];
            "<br/>";

            $etf3=$_POST["etf"];
            "<br/>";


            try{
                $isValid=$orderObj->checkPayslipPeriodExists($pay_period,$employee_id);
                if($isValid==true){
                    throw new exception("Payslip has already been created for $pay_period ");


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
                $amount_encrypted = openssl_encrypt($amount, $ciphering, $encryption_key, $options, $encryption_iv);
                $travel_allowance_encrypted = openssl_encrypt($travel_allowance, $ciphering, $encryption_key, $options, $encryption_iv);
                $tax_encrypted = openssl_encrypt($tax, $ciphering, $encryption_key, $options, $encryption_iv);
                $total_amount_encrypted = openssl_encrypt($total_amount, $ciphering, $encryption_key, $options, $encryption_iv);
                $incentives_encrypted = openssl_encrypt($incentives, $ciphering, $encryption_key, $options, $encryption_iv);
                $epf8_encrypted = openssl_encrypt($epf8, $ciphering, $encryption_key, $options, $encryption_iv);
                $epf12_encrypted = openssl_encrypt($epf12, $ciphering, $encryption_key, $options, $encryption_iv);
                $etf3_encrypted = openssl_encrypt($etf3, $ciphering, $encryption_key, $options, $encryption_iv);


                /*Add payslip details*/
                $payslip_id2=$orderObj->addExistingCustomerOrder($employee_id,
                    $payslip_number,
                    $pay_period,
                    $pay_date,
                    $order_description,
                    $amount_encrypted,
                    $travel_allowance_encrypted,
                    $tax_encrypted,
                    $total_amount_encrypted,
                    $incentives_encrypted,
                    $epf8_encrypted,
                    $epf12_encrypted,
                    $etf3_encrypted);

                    $employee_id_encoded = $employee_id;
                    $employee_id_encoded = base64_encode($employee_id_encoded);

                    $payslip_id_encoded = $payslip_id2;
                    $payslip_id_encoded = base64_encode($payslip_id_encoded);

                    $msgsuccess="Successfully created payslip. Click";
                    $msgsuccess=base64_encode($msgsuccess);

                    ?>
                    <script>
                        window.location = "../view/add-payslip.php?msgsuccess=<?php echo $msgsuccess; ?>&payslip_id=<?php echo $payslip_id_encoded ?>&emp_id=<?php echo $employee_id_encoded;?>&date=<?php echo $pay_period ?>"
                    </script>

                    <?php


            }

            catch (Exception $exception)
            {
                $msg=$exception->getMessage();
                $msg=base64_encode($msg);

            ?>
                <script>
                   window.location = "../view/add-payslip.php?msg=<?php echo $msg; ?>"
               </script>

            <?php
            }

            break;

        case "edit_payslip":

            echo $payslip_id=$_POST["payslipId"];
            "<br/>";

            $payslip_number=$_POST["payslipNo"];
            "<br/>";

            $pay_period=$_POST["payperiod"];
            "<br/>";

            $pay_date=$_POST["payDate"];
            "<br/>";

            $order_description=$_POST["description"];
            "<br/>";

            $amount=$_POST["Amount"];
            "<br/>";
            $travel_allowance=$_POST["travelallowance"];
            "<br/>";
            $incentives=$_POST["incentices"];
            "<br/>";

            $tax=$_POST["tax"];
            "<br/>";
            $total_amount=$_POST["TotAmount"];
            "<br/>";

            $epf8=$_POST["EPF8"];
            "<br/>";

            $epf12=$_POST["EPF12"];
            "<br/>";

            $etf3=$_POST["etf"];
            "<br/>";

            try{
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
                $amount_encrypted = openssl_encrypt($amount, $ciphering, $encryption_key, $options, $encryption_iv);
                $travel_allowance_encrypted = openssl_encrypt($travel_allowance, $ciphering, $encryption_key, $options, $encryption_iv);
                $tax_encrypted = openssl_encrypt($tax, $ciphering, $encryption_key, $options, $encryption_iv);
                $total_amount_encrypted = openssl_encrypt($total_amount, $ciphering, $encryption_key, $options, $encryption_iv);
                $incentives_encrypted = openssl_encrypt($incentives, $ciphering, $encryption_key, $options, $encryption_iv);
                $epf8_encrypted = openssl_encrypt($epf8, $ciphering, $encryption_key, $options, $encryption_iv);
                $epf12_encrypted = openssl_encrypt($epf12, $ciphering, $encryption_key, $options, $encryption_iv);
                $etf3_encrypted = openssl_encrypt($etf3, $ciphering, $encryption_key, $options, $encryption_iv);

                $orderObj->updatePayslip($payslip_id,
                    $pay_period,
                    $pay_date,
                    $order_description,
                    $amount_encrypted,
                    $travel_allowance_encrypted,
                    $tax_encrypted,
                    $total_amount_encrypted,
                    $incentives_encrypted,
                    $epf8_encrypted,
                    $epf12_encrypted,
                    $etf3_encrypted);

                $payslip_id_encoded = $payslip_id;
                $payslip_id_encoded = base64_encode($payslip_id_encoded);

                $msg = "successfully updated";
                $msg = base64_encode($msg);

                ?>
                <script>
                    window.location = "../view/display-payslips.php?msg=<?php echo $msg; ?>"
                </script>

                <?php
            }

            catch (Exception $exception)
            {
                $msg=$exception->getMessage();
                $msg=base64_encode($msg);

                ?>
                <script>
                    window.location = "../view/editOrder.php?msg=<?php echo $msg; ?>"
                </script>

                <?php
            }

            break;

        case "remove_payslip":

            $payslip_id=$_POST["payslip_id"];

            try{
            $deleted=$orderObj->deletePayslip($payslip_id);

            $msg="successfully Deleted";
            $msg=base64_encode($msg);

            ?>
            <script>
                window.location = "../view/display-payslips.php?msg=<?php echo $msg; ?>"
            </script>

            <?php
            } catch (Exception $exception)
            {
                $msg=$exception->getMessage();
                $msg=base64_encode($msg);

                ?>
                <script>
                    window.location = "../view/display-payslips.php?msg=<?php echo $msg; ?>"
                </script>

                <?php
            }


            break;

        case "load_payroll_date_range":

            $payperiod=$_POST["payperiod"];

            $payrollResult=$orderObj->getPayrollDateRange($payperiod);
            ?>
            <div id="show-filtered-table">
                <table id="load_data" class="table" style="width:100%">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Employee No</th>
                        <th>NIC</th>
                        <th>Basic Salary </th>
                        <th>Allowance </th>
                        <th>Incentives </th>
                        <th>Gross Salary</th>
                        <th>Payee</th>
                        <th>8%</th>
                        <th>12%</th>
                        <th>3%</th>
                        <th>20%</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    while ($payrollRow=$payrollResult->fetch_assoc()){

                        $payslip_id=$payrollRow["payment_id"];
                        $payslip_id_encoded=base64_encode($payslip_id);

                        ?>
                        <tr>
                            <td>
                                <?php
                                include_once "../model/user-model.php";
                                $userObj=new User();

                                $emp_id=$payrollRow["employee_id"];
                                $emp_id_encoded=base64_encode($emp_id);
                                $empResult=$userObj->viewUser($emp_id);

                                $empRow=$empResult->fetch_assoc();
                                $emp_name=$empRow["user_fname"];
                                $emp_lname=$empRow["user_lname"];
                                echo ucfirst($emp_name) ." ".ucfirst($emp_lname);
                                ?>
                            </td>
                            <td><?php echo $emp_id ?></td>
                            <td><?php echo $empRow["user_nic"]; ?></td>
                            <?php

                            $ciphering = "AES-128-CTR";
                            $decryption_iv = 'rqEJKQ+COwSInxjv';

                            // Store the decryption key
                            $decryption_key = "A$6Q{5M*AMsT,VRPQ@M5-=x>Y.^nQh9n";
                            $options = 0;

                            // Use openssl_decrypt() function to decrypt the data
                            $salary = openssl_decrypt($payrollRow["amount"], $ciphering, $decryption_key, $options, $decryption_iv);
                            $total_amount = openssl_decrypt($payrollRow["total_amount"], $ciphering, $decryption_key, $options, $decryption_iv);
                            $incentive = openssl_decrypt($payrollRow["incentives"], $ciphering, $decryption_key, $options, $decryption_iv);
                            $travel_allowance = openssl_decrypt($payrollRow["travel_allowance"], $ciphering, $decryption_key, $options, $decryption_iv);
                            $tax= openssl_decrypt($payrollRow["tax"], $ciphering, $decryption_key, $options, $decryption_iv);
                            $epf8 = openssl_decrypt($payrollRow["epf8"], $ciphering, $decryption_key, $options, $decryption_iv);
                            $epf12 = openssl_decrypt($payrollRow["epf12"], $ciphering, $decryption_key, $options, $decryption_iv);
                            $etf3 = openssl_decrypt($payrollRow["etf3"], $ciphering, $decryption_key, $options, $decryption_iv);
                            ?>

                            <td><?php echo $salary ?></td>
                            <td><?php echo $travel_allowance ?></td>
                            <td><?php echo $incentive ?></td>
                            <td><?php echo $salary+$travel_allowance+$incentive ?></td>
                            <td><?php echo $tax ?></td>
                            <td><?php echo $epf8 ?></td>
                            <td><?php echo $epf12 ?></td>
                            <td><?php echo $etf3 ?></td>
                            <td><?php echo $epf8+$epf12 ?></td>
                        </tr>
                        <?php

                    }
                    ?>

                    </tbody>
                </table>
                <br>
            </div>


            <?php
            break;
            
    }
}

?>