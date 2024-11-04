<?php
include_once "../commons/dbConnection.php";
$dbConnObj= new dbConnection();

class Order{

    function checkCnoBulk($cno){
        $con=$GLOBALS['con'];
        $sql="SELECT 1 FROM customer where customer_cno='$cno'";
        $result=$con->query($sql);

        if($result->num_rows>0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function addBulkOrders($order_no,$BL_no,$order_date,$order_item,$delivery_type,$customer_id){
        $con=$GLOBALS['con'];
        $sql="insert into bulk_orders(order_no,BL_no,order_date,order_item,delivery_type,customer_id) 
              VALUES 
              ('$order_no','$BL_no','$order_date','$order_item','$delivery_type','$customer_id')";

        $results=$con->query($sql) or die($con->error);
        $insertId=$con->insert_id;
        return $insertId;
    }
    public function getBulkOrders(){
        $con=$GLOBALS['con'];
        $sql="SELECT * FROM `bulk_orders` b,customer c WHERE b.`customer_id`=c.customer_id";
        $results=$con->query($sql);
        return $results;
    }

    public function getcurrentID(){
        $con=$GLOBALS["con"];
        $sql="SELECT MAX(payment_id) as maxID FROM `employee_payment`";
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
    function checkPayslipPeriodExists($pay_period, $user_id){
        $con=$GLOBALS['con'];
        $sql="SELECT * FROM `employee_payment` WHERE `pay_period`='$pay_period' AND employee_id='$user_id'";
        $result=$con->query($sql);

        if($result->num_rows>0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getAllOrders(){
        $con=$GLOBALS['con'];
        $sql="select * from employee_payment";
        $results=$con->query($sql);
        return $results;
    }
    public function getParticularCustomer($customerId){
        $con=$GLOBALS['con'];
        $sql="select * from customer c where c.customer_id='$customerId'";
        $results=$con->query($sql);
        return $results;
    }
    public function getParticularOrderInfo($orderId){
        $con=$GLOBALS['con'];
        $sql="select * from employee_payment where order_id='$orderId'";
        $results=$con->query($sql);
        return $results;
    }
    public function getPayslipDetails($orderId){
        $con=$GLOBALS['con'];
        $sql="select * from employee_payment where payment_id='$orderId'";
        $results=$con->query($sql);
        return $results;
    }

    public function addExistingCustomerOrder(
            $employee_id,
            $payslip_number,
            $pay_period,
            $pay_date,
            $order_description,
            $amount,
            $travel_allowance,
            $tax,
            $total_amount,
            $incentives,
            $epf8,
            $epf12,
            $etf3){
                    $con=$GLOBALS['con'];
        $sql="insert into employee_payment(
            employee_id,
            payslip_number,
            pay_period,
            pay_date,
            order_description,
            amount,
            travel_allowance,
            tax,
            total_amount,
            incentives,
            epf8,
            epf12,
            etf3) 
            
            VALUES (               
            '$employee_id',
            '$payslip_number',
            '$pay_period',
            '$pay_date',
            '$order_description',
            '$amount',
            '$travel_allowance',
            '$tax',
            '$total_amount',
            '$incentives',
            '$epf8',
            '$epf12',
            '$etf3')";
        $results=$con->query($sql) or die($con->error);
        $insertId=$con->insert_id;
        return $insertId;
    }

    function updatePayslip($payslip_id,
                           $pay_period,
                           $pay_date,
                           $order_description,
                           $amount,
                           $travel_allowance,
                           $tax,
                           $total_amount,
                           $incentives,
                           $epf8,
                           $epf12,
                           $etf3){
        $con=$GLOBALS['con'];

        $sql = "UPDATE employee_payment SET "
            . "pay_period='$pay_period',"
            . "pay_date='$pay_date',"
            . "order_description='$order_description',"
            . "amount='$amount',"
            . "travel_allowance='$travel_allowance',"
            . "tax='$tax',"
            . "total_amount='$total_amount',"
            . "incentives='$incentives',"
            . "epf8='$epf8',"
            . "epf12='$epf12',"
            . "etf3='$etf3'"

            . "WHERE payment_id ='$payslip_id '";

        $result=$con->query($sql) or die($con->error);
    }
    public function deletePayslip($payslip_id)
    {
        $con=$GLOBALS['con'];
        $sql="DELETE FROM employee_payment where payment_id='$payslip_id'";
        $results=$con->query($sql);
    }
    public function getPayrollDateRange($payperiod){
        $con=$GLOBALS['con'];
        $sql="SELECT * FROM employee_payment a WHERE a.pay_period='$payperiod';";
        $result=$con->query($sql);
        return $result;

    }

}


?>