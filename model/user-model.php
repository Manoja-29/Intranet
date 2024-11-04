<?php
include_once "../commons/dbConnection.php";
$dbConnObj= new dbConnection();
class User{

    function updateEmailValidation($userId,$email){
        $con=$GLOBALS['con'];
        $sql="select 1 from user where user_email ='$email' AND user_id!='$userId'";
        $result=$con->query($sql);

        if($result->num_rows>0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    function validateEmail($email){
        $con=$GLOBALS['con'];
        $sql="select 1 from user where user_email ='$email'";
        $result=$con->query($sql);

        if($result->num_rows>0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    function validateContactNumber($cno1){
        $con=$GLOBALS['con'];
        $sql="select 1 from user where user_cno1 ='$cno1'";
        $result=$con->query($sql);

        if($result->num_rows>0)
        {
            return false;
        }
        else
        {
            return true;
        }

    }

    function updatePhoneValidation($userId,$cno1){
        $con=$GLOBALS['con'];
        $sql="select 1 from user where user_cno1 ='$cno1' AND user_id!='$userId'";
        $result=$con->query($sql);

        if($result->num_rows>0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
        public function addUser($fname,
                                $lname,
                                $unic,
                                $uimg,
                                $dob,
                                $gender,
                                $ustatus,
                                $tel1,
                                $tel2,
                                $uemail,
                                $user_role,
                                $pemail,
                                $birth,
                                $marital,
                                $joinDate,
                                $exitDate){
        $con=$GLOBALS['con'];
        $sql="insert into user(
                               user_fname,
                                user_lname,
                                user_nic,
                                user_image,
                                password,
                                user_gender,
                                user_status,
                                user_cno1,
                                user_cno2,                              
                                user_email,
                                user_role,
                                user_per_email,
                                user_dob,
                                user_marital,
                                user_join,
                                user_exit) VALUES (
                                '$fname','$lname','$unic','$uimg','$dob','$gender','1','$tel1','$tel2','$uemail','$user_role','$pemail','$birth','$marital','$joinDate','$exitDate')";

        $results=$con->query($sql) or die($con->error);
        $insertId=$con->insert_id;
        return $insertId;
    }
    public function addAddiotionalUserDetails(
        $user_id,$address, $city, $province, $basicSalary, $travel_allowance, $bankAC, $qualification,$account_holder,$bank,$branch,$bank_code, $annual, $casual, $sick){
        $con=$GLOBALS['con'];
        $sql="insert into user_details_additional(
            user_id,employee_address,
            employee_city,
            province,
            salary,
            travel_allowance,
            bank_ac,
            Qualification,
            account_holder,
            bank,
            branch,
            bank_code,
            initial_annual,
            initial_casual,
            initial_sick
            ) 
            VALUES (  
            '$user_id',
            '$address',
            '$city',
            '$province',
            '$basicSalary',
            '$travel_allowance',
            '$bankAC',
            '$qualification',
            '$account_holder',
            '$bank',
            '$branch',
            '$bank_code',
            '$annual',
            '$casual',
            '$sick'
           )";

        $results=$con->query($sql) or die($con->error);
        $insertId=$con->insert_id;
        return $insertId;
    }
    public function ViewUserAdditionalDetails($user_id){
        $con=$GLOBALS["con"];
        $sql="SELECT * FROM user_details_additional where user_id='$user_id'";
        $result=$con->query($sql);
        return $result;
    }
    public function ViewIndividualUser($user_id){
        $con=$GLOBALS["con"];
        $sql="SELECT * FROM `user`u,user_details_additional r where u.`user_id`='$user_id' AND r.`user_id`='$user_id'";
        $result=$con->query($sql);
        return $result;
    }
    public function getUsersbyEmail($Recovery_username){
            $con=$GLOBALS['con'];
            $sql="select * from user WHERE user_email='$Recovery_username'AND user_status=1";
            $results=$con->query($sql);
            return $results;
    }
    function DisplayAllUsers(){
        $con=$GLOBALS['con'];
        $sql="SELECT * FROM `user`u,user_details_additional r where u.`user_id`=r.user_id AND u.`user_status`='1'";
        $result=$con->query($sql);
        /*directly convert to result*/
        return $result;
    }

    public function getAllUsers(){
        $con=$GLOBALS['con'];
        $sql="select * from user u,role r where u.user_role=r.role_id AND u.user_status='1'";
        $results=$con->query($sql);
        return $results;
    }
    public function getUserRoles()
    {
        $con=$GLOBALS['con'];
        $sql="SELECT * FROM role WHERE role_status='1'";
        $results=$con->query($sql);
        return $results;

    }
    public function getRoleLevelId($role_id)
    {
        $con=$GLOBALS['con'];
        $sql="SELECT *, r.role_level_id as role_level_id_test from `role` r WHERE r.role_id='$role_id'";
        $results=$con->query($sql);
        return $results;
    }
    public function getUserLevelUrls($role_level_id)
    {
        $con=$GLOBALS['con'];
        $sql="SELECT * from user_permissions WHERE user_role_id='$role_level_id';";
        $results=$con->query($sql);
        return $results;
    }
    public function getModulesByRole($roleId)
    {
        $con=$GLOBALS['con'];
        $sql="SELECT * FROM module m, module_role r WHERE m.module_id=r.module_id AND r.role_id='$roleId'";
        $results=$con->query($sql);
        return $results;
    }
    /*functions relevant to particular modules*/

    function getModuleFunctions($moduleId)
    {
        $con=$GLOBALS['con'];
        $sql="SELECT * FROM function WHERE module_id='$moduleId'";
        $results=$con->query($sql);
        return $results;

    }

    function addFunction($user_id,$function_id){
        $con=$GLOBALS['con'];
        $sql="insert into function_user(user_id,function_id)VALUES ('$user_id','$function_id')";
        $con->query($sql);

    }


    public function updatePassword($user_id,$new_password){
        $con=$GLOBALS["con"];
        $sql="UPDATE user SET `password`='$new_password' WHERE user_id='$user_id'";
        $result=$con->query($sql);
        return $result;
    }

    function getActiveUserCount(){
        $con=$GLOBALS["con"];
        $sql="select count(user_id) as countactiveuser from user WHERE user_status='1'";
//        $sql="select * from user WHERE user_status='1'";


        $result=$con->query($sql);
//        alias-countactiveuser
        $row=$result->fetch_assoc();
        $activeusercount=$row["countactiveuser"];
        return $activeusercount;


    }
    function getDeactiveUserCount(){
        $con=$GLOBALS["con"];
        $sql="select count(user_id) as deactiveuser from user WHERE user_status='0'";
//        $sql="select * from user WHERE user_status='1'";

        $result=$con->query($sql);
//        alias-countactiveuser
        $row=$result->fetch_assoc();
        $activeusercount=$row["deactiveuser"];
        return $activeusercount;
    }

    function deactivateUser($userId){

        $con=$GLOBALS['con'];
        $sql="update user SET user_status='0' where user_id='$userId'";
        $result=$con->query($sql);
        return $result;
    }

    function activateUser($userId){
        $con=$GLOBALS['con'];
        $sql="update user SET user_status='1' where user_id='$userId'";
        $result=$con->query($sql);
        return $result;

    }
    function viewUser($userId){
        $con=$GLOBALS['con'];
        $sql="SELECT * from user u,role r,user_details_additional a WHERE u.user_role=r.role_id AND u.user_id='$userId' AND a.user_id='$userId'";
        $result=$con->query($sql);
        return $result;
    }

    function updateUser(
        $userId,$user_fname,$user_lname, $user_email, $user_image, $user_nic, $user_password, $user_gender, $user_role, $user_cno1,$user_cno2,
        $user_per_email,$user_dob, $user_marital, $user_join, $user_exit
    ){
        $con=$GLOBALS['con'];

        if($user_image!="defaultImage.jpg") {
            $sql = "UPDATE user  SET "
                . "user_fname='$user_fname',"
                . "user_lname='$user_lname',"
                . "user_email='$user_email',"
                . "user_image='$user_image',"
                . "user_nic='$user_nic',"
                . "password='$user_password',"
                . "user_gender='$user_gender',"
                . "user_role='$user_role',"
                . "user_cno1='$user_cno1',"
                . "user_cno2='$user_cno2',"
                . "user_per_email='$user_per_email',"
                . "user_dob='$user_dob',"
                . "user_marital='$user_marital',"
                . "user_join='$user_join',"
                . "user_exit='$user_exit'"
                . "WHERE user_id='$userId'";
        }
        else{
            $sql = "UPDATE user SET "
                . "user_fname='$user_fname',"
                . "user_lname='$user_lname',"
                . "user_email='$user_email',"
                . "user_nic='$user_nic',"
                . "password='$user_password',"
                . "user_gender='$user_gender',"
                . "user_role='$user_role',"
                . "user_cno1='$user_cno1',"
                . "user_cno2='$user_cno2',"
                . "user_per_email='$user_per_email',"
                . "user_dob='$user_dob',"
                . "user_marital='$user_marital',"
                . "user_join='$user_join',"
                . "user_exit='$user_exit'"
                . "WHERE user_id='$userId'";
        }
        $result=$con->query($sql) or die($con->error);
    }
    function updateUserAddDetails($userId,$salary,$bank_ac,$address,$city,$province,$travel_allowance,$Qualification,$account_holder,$bank,$branch,$bank_code,$annual,$casual,$sick){
        $con=$GLOBALS['con'];

            $sql = "UPDATE user_details_additional u  SET "
                . "salary='$salary',"
                . "bank_ac='$bank_ac',"
                . "employee_address='$address',"
                . "employee_city='$city',"
                . "province='$province',"
                . "travel_allowance='$travel_allowance',"
                . "Qualification='$Qualification',"
                . "account_holder='$account_holder',"
                . "bank='$bank',"
                . "branch='$branch',"
                . "bank_code='$bank_code',"
                . "initial_annual='$annual',"
                . "initial_casual='$casual',"
                . "initial_sick='$sick'"
                . "WHERE user_id='$userId'";
        $result=$con->query($sql) or die($con->error);
    }

    /*for dashboard*/
    function userCount(){
        $con=$GLOBALS['con'];
        $sql="SELECT COUNT(user_id) as count FROM `user` WHERE user_status='1'";
        $result=$con->query($sql);
        /*directly convert to result*/
        return $result;
    }

    function DisplayUsers(){
        $con=$GLOBALS['con'];
        //$sql="SELECT * FROM `user`u,role r where u.`user_role`=r.role_id && u.`user_status`='1'";
        $sql="SELECT * from user u,role r,user_details_additional a WHERE u.user_role=r.role_id AND u.user_id=a.user_id AND u.user_status='1'";
        $result=$con->query($sql);
        return $result;
    }

    public function DisplayTeam($limit = null, $offset = null) {
        $con = $GLOBALS['con'];
        $sql = "SELECT * FROM user u, role r, user_details_additional a 
                WHERE u.user_role = r.role_id 
                AND u.user_id = a.user_id 
                AND u.user_status = '1'";
    
        // Add LIMIT and OFFSET if they are provided
        if ($limit !== null) {
            $sql .= " LIMIT $limit";
        }
        
        if ($offset !== null) {
            $sql .= " OFFSET $offset";
        }
    
        $result = $con->query($sql);
        return $result;
    }

    function getUserName($user_id){
        $con=$GLOBALS['con'];
        $sql="SELECT * FROM `user`u where user_id='$user_id'";
        $result=$con->query($sql);
        /*directly convert to result*/
        return $result;
    }

    function getUserBasedAdditionalDetails($user_id){
        $con=$GLOBALS['con'];
        $sql="SELECT * FROM `user_details_additional` WHERE `user_id`='$user_id';";
        $result=$con->query($sql);
        /*directly convert to result*/
        return $result;
    }
    function getUserRoleName($role_id){
        $con=$GLOBALS['con'];
        $sql="SELECT * FROM `role` WHERE `role_id`='$role_id'";
        $result=$con->query($sql);
        /*directly convert to result*/
        return $result;
    }

    function getUpcomingBirthday(){
        $con=$GLOBALS['con'];
        $sql="SELECT *,DATE_FORMAT(user_dob, '%m-%d') as dob_without_year 
            FROM user 
            WHERE DATE_FORMAT(user_dob, '%m-%d') >= DATE_FORMAT(CURDATE(), '%m-%d') 
            ORDER BY dob_without_year ASC
            LIMIT 3";
        $result=$con->query($sql);
        return $result;
    }

    function getTodayBirthday() {
        $con = $GLOBALS['con'];
        $sql = "SELECT *, DATE_FORMAT(user_dob, '%m-%d') AS dob_without_year 
                FROM user 
                WHERE DATE_FORMAT(user_dob, '%m-%d') = DATE_FORMAT(CURDATE(), '%m-%d')";
        $result = $con->query($sql);
        return $result;
    }

    function addRole($roleName, $roleLevel, $roleStatus){
        $con=$GLOBALS['con'];
        $sql = "INSERT INTO role(role_name,role_level_id,role_status)values($roleName,$roleLevel,$roleStatus)";
        $result=$con->query($sql);
        return $result;
    }

}


?>