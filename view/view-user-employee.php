<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 5 Admin &amp; Dashboard Template">
    <meta name="author" content="Bootlab">

    <title>Settings | AppStack - Bootstrap 5 Admin &amp; Dashboard Template</title>

    <link rel="canonical" href="https://appstack.bootlab.io/pages-settings.html" />
    <link rel="shortcut icon" href="img/favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- Choose your prefered color scheme -->
    <!-- <link href="css/light.css" rel="stylesheet"> -->
    <!-- <link href="css/dark.css" rel="stylesheet"> -->

    <!-- BEGIN SETTINGS -->
    <!-- Remove this after purchasing -->
    <link class="js-stylesheet" href="css/light.css" rel="stylesheet">
    <script src="js/settings.js"></script>
    <!-- END SETTINGS -->
</head>
<!--
  HOW TO USE:
  data-theme: default (default), dark, light
  data-layout: fluid (default), boxed
  data-sidebar-position: left (default), right
  data-sidebar-behavior: sticky (default), fixed, compact
-->

<body data-theme="colored" data-layout="fluid" data-sidebar-position="left" data-sidebar-behavior="sticky">
<div class="wrapper">
    <?php
    include "sidebar.php";

    ?>
    <div class="main">
        <?php
        include_once "topbar.php";
        ?>

        <main class="content">
            <div class="container-fluid p-0">

                <h1 class="h3 mb-3">Settings </h1>

                <div class="row">
                    <div class="row">
                        <?php
                        //        check if msg is available
                        if(isset($_GET['msg'])){
                            ?>
                            <div class="col-md-12">
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <div class="alert-message">
                                        <strong>Hello there!</strong>  <?php
                                        $msg=$_REQUEST['msg'];
                                        $msg=base64_decode($msg);
                                        echo $msg;
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }

                        ?>

                        <div class="col-md-12">
                            <div id="alertDiv">

                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-xl-2">

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Profile Settings</h5>
                            </div>

                            <div class="list-group list-group-flush" role="tablist">
                                <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#account" role="tab">
                                    Account
                                </a>
                                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#password" role="tab">
                                    Password
                                </a>
                                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#private" role="tab">
                                    Private Info
                                </a>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-9 col-xl-10">
                        <form method="post" enctype="multipart/form-data" id="editUser" action="../controller/user_controller.php?status=edit_user_employee">

                            <div class="tab-content">
                                <?php
                                $userObj=new User();
                                $userId=$_REQUEST['user_id'];
                                $userId= base64_decode($userId);
                                $userResult= $userObj->viewUser($userId);
                                $userRow=$userResult->fetch_assoc();
                                $roleResult=$userObj->getUserRoles();
                                ?>
                                <div class="tab-pane fade show active" id="account" role="tabpanel">

                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-actions float-end">
                                                <div class="dropdown position-relative">
                                                    <a href="#" data-bs-toggle="dropdown" data-bs-display="static">
                                                        <i class="align-middle" data-feather="more-horizontal"></i>
                                                    </a>

                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="#">Action</a>
                                                        <a class="dropdown-item" href="#">Another action</a>
                                                        <a class="dropdown-item" href="#">Something else here</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <h5 class="card-title mb-0">Public info</h5>
                                        </div>
                                        <input type="hidden" name="editUserID" value="<?php echo $userId ?>">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="mb-3 error-placeholder">
                                                        <label for="inputFirstName" class="form-label">First name*</label>
                                                        <input name="fname" type="text" class="form-control required" value="<?php echo $userRow["user_fname"] ?>" id="fname" placeholder="First name" required>
                                                    </div>

                                                    <div class="mb-3 error-placeholder">
                                                        <label for="inputLastName" class="form-label">Last name*</label>
                                                        <input name="lname" type="text" class="form-control required" value="<?php echo $userRow["user_lname"] ?>" id="lname" placeholder="Last name" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-center">
                                                        <img id="prev_img" src="../view/img/user_images/<?php echo $userRow["user_image"]; ?>" class="rounded-circle img-responsive mt-2" width="128" height="128" />
                                                        <div class="mt-2">
                                                                        <span class="btn btn-primary"><i class="fas fa-upload"></i>
                                                                            <input type="file" style="opacity:0;position: absolute; color: white" name="uimg" id="uimg" onchange="readURL(this)"/>
                                                                        Upload</span>
                                                        </div>
                                                        <small>For best results, use an image at least 128px by 128px in .jpg format</small>
                                                    </div>
                                                </div>

                                            </div>
                                            <button type="submit" class="btn btn-primary">Save changes</button>


                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-actions float-end">
                                                <div class="dropdown position-relative">
                                                    <a href="#" data-bs-toggle="dropdown" data-bs-display="static">
                                                        <i class="align-middle" data-feather="more-horizontal"></i>
                                                    </a>

                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="#">Action</a>
                                                        <a class="dropdown-item" href="#">Another action</a>
                                                        <a class="dropdown-item" href="#">Something else here</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <h5 class="card-title mb-0">Private info</h5>
                                        </div>
                                        <div class="card-body">

                                            <div class="row">
                                                <div class="mb-3 col-md-6 error-placeholder">
                                                    <label for="inputUsername" class="form-label">Contact Number 1*</label>
                                                    <input type="text" id="tel1" class="form-control required" value="<?php echo $userRow["user_cno1"] ?>" oninput="checkTel1()" name="tel1" required >
                                                    <p id="Tel1error" class="text-danger"></p>

                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="inputLastName" class="form-label">Contact Number 2</label>
                                                    <input type="text" class="form-control" id="tel2" value="<?php echo $userRow["user_cno2"] ?>" oninput="checkTel2()" name="tel2" >
                                                    <p id="Tel2error" class="text-danger"></p>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-md-6 error-placeholder" >
                                                    <label for="inputEmail4" class="form-label">Office Email*</label>
                                                    <input type="email" class="form-control required" id="uemail" value="<?php echo $userRow["user_email"] ?>" name="uemail" pattern=".+technicalcreatives\.com" placeholder="Default@technicalcreatives.com" required>
                                                </div>
                                                <div class="mb-3 col-md-6 error-placeholder">
                                                    <label for="inputEmail4" class="form-label">Personal Email*</label>
                                                    <input type="email" class="form-control" id="pemail" value="<?php echo $userRow["user_per_email"] ?>" name="pemail" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" placeholder="Default@gmail.com">
                                                    <br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-md-6 error-placeholder" >
                                                    <label for="inputEmail4" class="form-label">Date of Birth</label>
                                                    <input id="dob" type="date" class="form-control" value="<?php echo $userRow["user_dob"] ?>" name="birth">
                                                </div>
                                                <div class="mb-3 col-md-6 error-placeholder">
                                                    <label for="inputAddress2" class="form-label">NIC*</label>
                                                    <input id="unic" type="text" class="form-control required" value="<?php echo $userRow["user_nic"] ?>" oninput="checknic()" name="unic" placeholder="NIC" required>
                                                    <p id="nicError" class="text-danger"></p>

                                                </div>
                                            </div>
                                            <div class="mb-3 error-placeholder">
                                                <label for="inputAddress" class="form-label ">Address</label>
                                                <textarea id="address" name="address" rows="2" class="form-control required" required><?php echo $userRow["employee_address"]?></textarea>

                                            </div>

                                            <div class="row">
                                                <div class="mb-3 col-md-3">
                                                    <label for="inputCity" class="form-label">District</label>
                                                    <select id="inputCity" name="city" class="form-control">
                                                        <option value="" selected="selected">Choose...</option>
                                                        <option value="Ampara" <?php if($userRow["employee_city"] == 'Ampara') echo 'selected="selected"';?>>Ampara</option>
                                                        <option value="Anuradhapura" <?php if($userRow["employee_city"] == 'Anuradhapura') echo 'selected="selected"';?>>Anuradhapura</option>
                                                        <option value="Badulla" <?php if($userRow["employee_city"] == 'Badulla') echo 'selected="selected"';?>>Badulla</option>
                                                        <option value="Batticaloa" <?php if($userRow["employee_city"] == 'Batticaloa') echo 'selected="selected"';?>>Batticaloa</option>
                                                        <option value="Colombo" <?php if($userRow["employee_city"] == 'Colombo') echo 'selected="selected"';?>>Colombo</option>
                                                        <option value="Galle" <?php if($userRow["employee_city"] == 'Galle') echo 'selected="selected"';?>>Galle</option>
                                                        <option value="Gampaha" <?php if($userRow["employee_city"] == 'Gampaha') echo 'selected="selected"';?>>Gampaha</option>
                                                        <option value="Hambantota" <?php if($userRow["employee_city"] == 'Hambantota') echo 'selected="selected"';?>>Hambantota</option>
                                                        <option value="Jaffna" <?php if($userRow["employee_city"] == 'Jaffna') echo 'selected="selected"';?>>Jaffna</option>
                                                        <option value="Kalutara" <?php if($userRow["employee_city"] == 'Kalutara') echo 'selected="selected"';?>>Kalutara</option>
                                                        <option value="Kandy" <?php if($userRow["employee_city"] == 'Kandy') echo 'selected="selected"';?>>Kandy</option>
                                                        <option value="Kegalle" <?php if($userRow["employee_city"] == 'Kegalle') echo 'selected="selected"';?>>Kegalle</option>
                                                        <option value="Kilinochchi" <?php if($userRow["employee_city"] == 'Kilinochchi') echo 'selected="selected"';?>>Kilinochchi</option>
                                                        <option value="Kurunegala" <?php if($userRow["employee_city"] == 'Kurunegala') echo 'selected="selected"';?>>Kurunegala</option>
                                                        <option value="Mannar" <?php if($userRow["employee_city"] == 'Mannar') echo 'selected="selected"';?>>Mannar</option>
                                                        <option value="Matale" <?php if($userRow["employee_city"] == 'Matale') echo 'selected="selected"';?>>Matale</option>
                                                        <option value="Matara" <?php if($userRow["employee_city"] == 'Matara') echo 'selected="selected"';?>>Matara</option>
                                                        <option value="Monaragala" <?php if($userRow["employee_city"] == 'Monaragala') echo 'selected="selected"';?>>Monaragala</option>
                                                        <option value="Mullaitivu" <?php if($userRow["employee_city"] == 'Mullaitivu') echo 'selected="selected"';?>>Mullaitivu</option>
                                                        <option value="Nuwara-Eliya" <?php if($userRow["employee_city"] == 'Nuwara-Eliya') echo 'selected="selected"';?>>Nuwara Eliya</option>
                                                        <option value="Polonnaruwa" <?php if($userRow["employee_city"] == 'Polonnaruwa') echo 'selected="selected"';?>>Polonnaruwa</option>
                                                        <option value="Puttalam" <?php if($userRow["employee_city"] == 'Puttalam') echo 'selected="selected"';?>>Puttalam</option>
                                                        <option value="Ratnapura" <?php if($userRow["employee_city"] == 'Ratnapura') echo 'selected="selected"';?>>Ratnapura</option>
                                                        <option value="Trincomalee" <?php if($userRow["employee_city"] == 'Trincomalee') echo 'selected="selected"';?>>Trincomalee</option>
                                                        <option value="Vavuniya" <?php if($userRow["employee_city"] == 'Vavuniya') echo 'selected="selected"';?>>Vavuniya</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3 col-md-3">
                                                    <label for="inputState" class="form-label">Province</label>
                                                    <select id="inputProvince" name="province" class="form-control">
                                                        <option value="" selected="selected">Choose...</option>
                                                        <option value="Central" <?php if($userRow["province"] == 'Central') echo 'selected="selected"';?>>Central</option>
                                                        <option value="Eastern" <?php if($userRow["province"] == 'Eastern') echo 'selected="selected"';?>>Eastern</option>
                                                        <option value="North Central" <?php if($userRow["province"] == 'North Central') echo 'selected="selected"';?>>North Central</option>
                                                        <option value="Northern" <?php if($userRow["province"] == 'Northern') echo 'selected="selected"';?>>Northern</option>
                                                        <option value="North Western" <?php if($userRow["province"] == 'North Western') echo 'selected="selected"';?>>North Western</option>
                                                        <option value="Sabaragamuwa" <?php if($userRow["province"] == 'Sabaragamuwa') echo 'selected="selected"';?>>Sabaragamuwa</option>
                                                        <option value="Southern" <?php if($userRow["province"] == 'Southern') echo 'selected="selected"';?>>Southern</option>
                                                        <option value="Uva" <?php if($userRow["province"] == 'Uva') echo 'selected="selected"';?>>Uva</option>
                                                        <option value="Western" <?php if($userRow["province"] == 'Western') echo 'selected="selected"';?>>Western</option>
                                                    </select>
                                                </div>
                                               
                                                <div class="mb-3 col-md-3">
                                                    <label for="marital" class="form-label">Marital Status</label>
                                                    <select id="marital" name="marital" class="form-control">
                                                        <option value="" selected="selected">Select Option</option>
                                                        <option value="single" <?php if($userRow["user_marital"] == 'single') echo 'selected="selected"'; ?>>Single</option>
                                                        <option value="married" <?php if($userRow["user_marital"] == 'married') echo 'selected="selected"'; ?>>Married</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3 col-md-3">
                                                    <label for="ugender" class="text-muted" style="
                    color: #888;
                    font-family: 'Lato', 'sans-serif';">User Gender*</label>
                                                    <br><br>
                                                    <p>
                                                        <input type="radio" name="Gender" id="male" value="0"
                                                            <?php
                                                            if($userRow["user_gender"]==0){
                                                                ?>
                                                                checked="checked"
                                                                <?php
                                                            }
                                                            ?>
                                                        />&nbsp;<label class="control-label" >Male</label>
                                                        &nbsp;
                                                        <input type="radio" id="female" name="Gender" value="1"
                                                            <?php
                                                            if($userRow["user_gender"]==1){
                                                                ?>
                                                                checked="checked"
                                                                <?php
                                                            }
                                                            ?>


                                                        />&nbsp;<label class="control-label" >Female</label>
                                                    </p>
                                                </div>


                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-md-6 error-placeholder" >
                                                    <label for="inputJoin" class="form-label">Date of Join*</label>
                                                    <input id="joinDate" type="date" class="form-control required" value="<?php echo $userRow["user_join"] ?>" name="userJoin" required>

                                                </div>
                                                <div class="mb-3 col-md-6 error-placeholder">
                                                    <label for="inputLeave" class="form-label">Date of Leave</label>
                                                    <input id="exitDate" type="date" class="form-control" value="<?php echo $userRow["user_exit"] ?>" name="userExit">
                                                </div>
                                            </div><br>
                                            <button type="submit" class="btn btn-primary">Save changes</button>

                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="password" role="tabpanel">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Password</h5>
                                            <?php
                                            $password= base64_decode($userRow["password"]);

                                            ?>


                                            <div class="mb-3">
                                                <label for="inputPasswordCurrent" class="form-label">Current password</label>
                                                <input type="password" class="form-control" readonly id="inputPasswordCurrent" name="password" value="<?php echo $password ?>">
                                                <input type="checkbox" onclick="passwordFunction()">&nbspShow Password
                                                <small><a href="#">Forgot your password?</a></small>
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputPasswordNew" class="form-label">New password</label>
                                                <input type="password" name="new_password" class="form-control" id="inputPasswordNew">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save changes</button>


                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="private" role="tabpanel">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Private Info</h5>

                                            <div class="row">
                                                <div class="mb-12 col-md-12 error-placeholder">
                                                    <label for="inputLastName" class="form-label">User Role</label>
                                                    <select class="form-control" name="user_role" id="user_role" readonly>
                                                        <?php
                                                        while ($role_row=$roleResult->fetch_assoc()) {
                                                            ?>
                                                            <!--value is similar to ID attribute-->
                                                            <option value="<?php echo $role_row["role_id"];?>"
                                                                <?php
                                                                if ($role_row["role_id"]==$userRow["role_id"])
                                                                {
                                                                    ?>
                                                                    selected="selected"

                                                                    <?php
                                                                }
                                                                ?>
                                                            >
                                                                <?php
                                                                echo $role_row["role_name"]; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <?php
                                                $ciphering = "AES-128-CTR";

                                                $decryption_iv = 'rqEJKQ+COwSInxjv';

                                                // Store the decryption key
                                                $decryption_key = "A$6Q{5M*AMsT,VRPQ@M5-=x>Y.^nQh9n";
                                                $options = 0;

                                                // Use openssl_decrypt() function to decrypt the data

                                                $salary=openssl_decrypt ($userRow["salary"], $ciphering, $decryption_key, $options, $decryption_iv);
                                                $travel_allowance=openssl_decrypt ($userRow["travel_allowance"], $ciphering, $decryption_key, $options, $decryption_iv);
                                                $bank_ac=openssl_decrypt ($userRow["bank_ac"], $ciphering, $decryption_key, $options, $decryption_iv);
                                                $account_holder=openssl_decrypt ($userRow["account_holder"], $ciphering, $decryption_key, $options, $decryption_iv);
                                                $bank=openssl_decrypt ($userRow["bank"], $ciphering, $decryption_key, $options, $decryption_iv);
                                                $branch=openssl_decrypt ($userRow["branch"], $ciphering, $decryption_key, $options, $decryption_iv);
                                                $bank_code=openssl_decrypt ($userRow["bank_code"], $ciphering, $decryption_key, $options, $decryption_iv);


                                                ?>

                                                <div class="mb-3 col-md-6 error-placeholder">
                                                    <label for="inputUsername" class="form-label">Salary</label>
                                                    <input type="text" class="form-control required" readonly id="salary" value="<?php echo $salary?>" name="salary" placeholder="Eg : 100 000" required>
                                                </div>
                                                <div class="mb-3 col-md-6 error-placeholder">
                                                    <label for="inputLastName" class="form-label">Travel Allowance</label>
                                                    <input id="travel_allowance" name="travel_allowance" readonly type="text" value="<?php echo $travel_allowance?>" class="form-control required" placeholder="Eg : 2000" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label for="inputLastName" class="form-label">Qualifications / Skills</label>
                                                    <input type="text" class="form-control" id="Qualification" value="<?php echo $userRow["Qualification"]?>" name="Qualification" placeholder="Last name">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="inputUsername" class="form-label">Account Number </label>
                                                    <input type="text" class="form-control " id="bank_ac" value="<?php echo $bank_ac?>" name="bank_ac" placeholder="Account number">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label for="inputUsername" class="form-label">Account Holder Name</label>
                                                    <input type="text" class="form-control " id="account_holder" value="<?php echo $account_holder?>" name="account_holder" placeholder="Name">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="inputLastName" class="form-label">Bank Name</label>
                                                    <input type="text" class="form-control" id="bank" value="<?php echo $bank?>" name="bank" >
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label for="inputUsername" class="form-label">Branch </label>
                                                    <input type="text" class="form-control " id="branch" value="<?php echo $branch?>" name="branch">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="inputLastName" class="form-label">Bank code</label>

                                                    <input type="text" class="form-control" id="bank_code" value="<?php echo $bank_code?>" name="bank_code">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-2 col-md-4">
                                                    <label class="form-label">Number of Annual </label>
                                                    <input type="text" class="form-control" readonly value="<?php echo $userRow["initial_annual"]?>" id="annual" name="annual">
                                                </div>
                                                <div class="mb-2 col-md-4">
                                                    <label class="form-label">Number of Casual</label>
                                                    <input type="text" class="form-control" readonly value="<?php echo $userRow["initial_casual"]?>" id="casual" name="casual">
                                                </div>
                                                <div class="mb-2 col-md-4">
                                                    <label class="form-label">Number of Sick</label>
                                                    <input type="text" class="form-control" readonly value="<?php echo $userRow["initial_sick"]?>" id="sick" name="sick">
                                                </div>
                                            </div>
                                            <br>
                                            <button type="submit" class="btn btn-primary">Save changes</button>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </main>
        <?php
        include "footer.php";
        ?>

    </div>
</div>

<script src="js/app.js"></script>
<script type="text/javascript">
    function passwordFunction() {
        var x = document.getElementById("inputPasswordCurrent");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    function readURL(input) {
        /*if file isn't empty*/
        if (input.files && input.files[0]) {
            /*javascript will read this object*/
            var reader = new FileReader();
            /*reader will load the file*/
            reader.onload = function (e) {
                $('#prev_img')
                    /*we are uplloading the loaded image into src,temperory path assigned to attribute src*/
                    .attr('src', e.target.result)
                    .height(128)
                    .width(128);
            };
            /*finally calling the function*/
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
</body>

</html>