<?php
include_once "../commons/dbConnection.php";
$dbConnObj= new dbConnection();
class Login{
    public function addLogin($login_username,$login_password,$login_status,$user_id){
        $con=$GLOBALS['con'];
        $sql="insert into login(login_username,login_password,login_status,user_id) 
              VALUES 
              ('$login_username','$login_password','$login_status','$user_id')";

        $results=$con->query($sql) or die($con->error);
        $insertId=$con->insert_id;
        return $insertId;
    }

    public function validateLogin($username,$password){
        $con=$GLOBALS['con'];
        $sql="select * from user u,login l 
        WHERE u.user_id=l.user_id
        AND l.login_username='$username'
        AND l.login_password='$password' AND user_status='1'";
        $result=$con->query($sql);

        /*var dump is used to obtain the structure of the result*/
/*        var_dump($result);*/
        return $result;


    }
    public function getLoginDetails(){
        $con=$GLOBALS['con'];
        $sql="select * from login";
        $results=$con->query($sql);
        return $results;
    }
    public function getUser($userID){
        $con=$GLOBALS['con'];
        $sql="select * from user where user_id='$userID'";
        $results=$con->query($sql);
        return $results;
    }

    function editUserPassword($password,$userId){
        $con=$GLOBALS['con'];
        $sql="update login SET `login_password`='$password' where user_id='$userId'";

        $result=$con->query($sql) or die($con->error);


    }


}


?>