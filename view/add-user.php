<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 5 Admin &amp; Dashboard Template">
    <meta name="author" content="Bootlab">

    <title>User</title>

    <link rel="canonical" href="https://appstack.bootlab.io/forms-wizard.html" />
    <link rel="canonical" href="https://appstack.bootlab.io/pages-settings.html" />
    <link rel="shortcut icon" href="img/favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="css/light.css" rel="stylesheet">
</head>


<body data-theme="colored" data-layout="fluid" data-sidebar-position="left" data-sidebar-behavior="sticky">
<div class="wrapper">
    <?php
    include_once "sidebar.php";



    ?>
    <div class="main">
        <?php
        include_once "topbar.php";
        ?>
        <main class="content">
            <div class="container-fluid p-0">

                <div class="row mb-0 mb-xl-2">
                    <div class="col-auto d-none d-sm-block">
                        <h3>Add New Employee</h3>
                    </div>

                    <div class="col-auto ms-auto text-end mt-n1">
                        <div class="dropdown me-2 d-inline-block position-relative">
                            <a class="btn mb-2 btn-primary" style="padding: 5px 15px;" href="team.php">Employee List</a>
                        </div>
                    </div>
                </div>


                <?php
                    if(isset($_GET['msg'])){
                ?>
                <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <div class="alert-message">
                            <strong>Hello there!</strong>  
                            <?php
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
                                
                                
                <div class="row">
                    <div class="col-12">
                        <form action="../controller/user_controller.php?status=add_user" id="smartwizard-validation" enctype="multipart/form-data" method="post" class="wizard wizard-primary" >
                            <ul class="nav">
                                <li class="nav-item"><a class="nav-link" href="#validation-step-1">Account<br /><small>Public Info</small></a></li>
                                <li class="nav-item"><a class="nav-link" href="#validation-step-2">Privacy & Safety<br /><small>Passwords & User Level</small></a></li>
                                <li class="nav-item"><a class="nav-link" href="#validation-step-3">Bank Details<br /><small>Personal Info</small></a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="validation-step-1" class="tab-pane" role="tabpanel"><br>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3 error-placeholder">
                                                <label for="inputFirstName" class="form-label">First name</label>
                                                <input name="fname" type="text" class="form-control required" id="fname" placeholder="First name" required>
                                            </div>

                                            <div class="mb-3 error-placeholder">
                                                <label for="inputLastName" class="form-label">Last name</label>
                                                <input name="lname" type="text" class="form-control required" id="lname" placeholder="Last name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="text-center">
                                                <img alt="Chris Wood" id="prev_img" src="img/user_images/defaultImage.jpg" class="rounded-circle img-responsive mt-2" width="128" height="128" />
                                                <div class="mt-2">
                                                    <span class="btn btn-primary"><i class="fas fa-upload"></i>
                                                        <input type="file" style="opacity:0;position: absolute; color: white" name="uimg" id="uimg" onchange="readURL(this)"/>
                                                    Upload</span>
                                                </div>
                                                <small>For best results, use an image at least 128px by 128px in .jpg format</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="mb-3 col-md-6 error-placeholder">
                                            <label for="inputUsername" class="form-label">Contact Number 1</label>
                                            <input type="text" id="tel1" class="form-control required" oninput="checkTel1()" name="tel1" required >
                                            <p id="Tel1error"></p>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="inputLastName" class="form-label">Contact Number 2</label>
                                            <input type="text" class="form-control" id="tel2" oninput="checkTel2()" name="tel2" >
                                            <p id="Tel2error"></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="mb-3 col-md-6 error-placeholder" >
                                            <label for="inputEmail4" class="form-label">Email</label>
                                            <input type="email" class="form-control required" id="uemail" name="uemail" pattern=".+technicalcreatives\.com" placeholder="Default@technicalcreatives.com" required>
                                        </div>
                                        <div class="mb-3 col-md-6 error-placeholder" >
                                            <label for="inputEmail4" class="form-label">Personal Email</label>
                                            <input type="email" class="form-control" id="pemail" name="pemail" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" placeholder="Default@gmail.com">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-6 error-placeholder" >
                                            <label for="inputEmail4" class="form-label">Date of Birth</label>
                                            <input type="date" value="01-06-2017" class="form-control" max="<?php echo date("Y-m-d") ?>" id="dob" name="birth">
                                        </div>
                                        <div class="mb-3 col-md-6 error-placeholder">
                                            <label for="inputAddress2" class="form-label">NIC</label>
                                            <input id="unic" type="text" class="form-control required" oninput="checknic()" name="unic" placeholder="NIC" required>
                                            <p id="nicError"></p>
                                        </div>
                                        </div>
                                        <div class="mb-3 error-placeholder">
                                            <label for="inputAddress" class="form-label ">Address</label>
                                            <textarea id="address" name="address" rows="2" class="form-control required" placeholder="Number/Apartment/Floor" required></textarea>
                                        </div>

                                    <div class="row">
                                        <div class="mb-6 col-md-6">
                                            <label for="inputCity" class="form-label">District</label>
                                            <select id="inputCity" name="HomeTown" class="form-control">
                                                <option value="" selected="selected">Choose...</option>
                                                <option value="Ampara">Ampara</option>
                                                <option value="Anuradhapura">Anuradhapura</option>
                                                <option value="Badulla">Badulla</option>
                                                <option value="Batticaloa">Batticaloa</option>
                                                <option value="Colombo">Colombo</option>
                                                <option value="Galle">Galle</option>
                                                <option value="Gampaha">Gampaha</option>
                                                <option value="Hambantota">Hambantota</option>
                                                <option value="Jaffna">Jaffna</option>
                                                <option value="Kalutara">Kalutara</option>
                                                <option value="Kandy">Kandy</option>
                                                <option value="Kegalle">Kegalle</option>
                                                <option value="Kilinochchi">Kilinochchi</option>
                                                <option value="Kurunegala">Kurunegala</option>
                                                <option value="Mannar">Mannar</option>
                                                <option value="Matale">Matale</option>
                                                <option value="Matara">Matara</option>
                                                <option value="Monaragala">Monaragala</option>
                                                <option value="Mullaitivu">Mullaitivu</option>
                                                <option value="Nuwara-Eliya">Nuwara Eliya</option>
                                                <option value="Polonnaruwa">Polonnaruwa</option>
                                                <option value="Puttalam">Puttalam</option>
                                                <option value="Ratnapura">Ratnapura</option>
                                                <option value="Trincomalee">Trincomalee</option>
                                                <option value="Vavuniya">Vavuniya</option>
                                            </select>
                                        </div>
                                        <div class="mb-6 col-md-6">
                                            <label for="inputState" class="form-label">Province</label>
                                            <select id="province" name="province" class="form-control">
                                                <option value="" selected="selected">Choose...</option>
                                                <option value="central">Central</option>
                                                <option value="eastern">Eastern</option>
                                                <option value="northCentral">North Central</option>
                                                <option value="northern">Northern</option>
                                                <option value="northWestern">North Western</option>
                                                <option value="sabaragamuwa">Sabaragamuwa</option>
                                                <option value="southern">Southern</option>
                                                <option value="uva">Uva</option>
                                                <option value="western">Western</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="mb-3 col-md-3">
                                            <label for="marital" class="form-label">Marital Status</label>
                                            <select id="marital" name="marital" class="form-control">
                                                <option value="" selected="selected">Select Option</option>
                                                <option value="1">Single</option>
                                                <option value="2">Married</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="ugender" class="text-muted" style="color: #888;font-family: 'Lato', 'sans-serif';">User Gender</label><br><br>
                                            <input type="radio" value="male" id="male"  name="gender" checked="checked">&nbsp<label class="text-muted">Male</label>
                                            <input type="radio" value="female" id="female"  name="gender">&nbsp<label class="text-muted">Female</label>
                                        </div>
                                        <div class="mb-3 col-md-3 error-placeholder" >
                                            <label for="inputJoin" class="form-label">Date of Join</label>
                                            <input type="date" value="01-06-2017" class="form-control required" max="<?php echo date("Y-m-d") ?>" id="joinDate" name="joinDate" required>
                                        </div>
                                        <div class="mb-3 col-md-3 error-placeholder">
                                            <label for="inputLeave" class="form-label">Date of Leave</label>
                                            <input type="date" value="01-06-2017" class="form-control" max="<?php echo date("Y-m-d") ?>" id="exitDate" name="exitDate">
                                        </div>
                                    </div>
                                    </div>

                                    <!-- <div id="validation-step-2" class="tab-pane" role="tabpanel">
                                        <div class="row">
                                            <div class="mb-3 col-md-6 error-placeholder">
                                                <label for="inputUsername" class="form-label">Password </label>
                                                <input id="psw" name="validation-password" type="password" required="required" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                                            </div>

                                            <div class="mb-3 col-md-6 error-placeholder">
                                                <label for="inputLastName" class="form-label">User Role</label>
                                                <select id="user_role" name="user_role" class="form-control">
                                                    <?php

                                                    $UserObj = new User();
                                                    $UserResult = $UserObj->GetUserRoles();
                                                    while ($role_row = $UserResult->fetch_assoc()) {
                                                    ?>
                                                    <option value="<?php echo $role_row["role_id"];?>">

                                                        <?php echo $role_row["role_name"];
                                                        }
                                                        ?>
                                                    </option>
                                                </select><br>
                                                <p> &nbsp;<a href="">Add new role ?</a></p>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div id="validation-step-2" class="tab-pane" role="tabpanel">
                                        <div class="row">
                                            <div class="mb-3 col-md-6 error-placeholder">
                                                <label for="inputUsername" class="form-label">Password </label>
                                                <input id="psw" name="validation-password" type="password" required="required" class="form-control" 
                                                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                                                    title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                                            </div>

                                            <div class="mb-3 col-md-6 error-placeholder">
                                                <label for="inputLastName" class="form-label">User Role</label>
                                                <select id="user_role" name="user_role" class="form-control">
                                                    <?php
                                                        $UserObj = new User();
                                                        $UserResult = $UserObj->GetUserRoles();
                                                        while ($role_row = $UserResult->fetch_assoc()) {
                                                    ?>
                                                        <option value="<?php echo $role_row["role_id"];?>">
                                                            <?php echo $role_row["role_name"]; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                <br>
                                                <p> &nbsp;<a href="#" data-bs-toggle="modal" data-bs-target="#addRoleModal">Add new role?</a></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addRoleModalLabel">Add New Role</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="addRoleForm" method="post" action="../controller/user_controller/add-role">
                                                        <div class="mb-3">
                                                            <label for="role_name" class="form-label">Role Name</label>
                                                            <input type="text" class="form-control" id="role_name" name="role_name" required>
                                                            <input type="text" class="form-control" value="1" name="role_status" hidden required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="role_level" class="form-label">Role Level</label>
                                                            <Select class="form-control" id="role_level" name="role_level" required>
                                                                <option>Select level...</option>
                                                                <option value="1">Admin</option>
                                                                <option value="2">Manager</option>
                                                                <option value="3">User</option>
                                                            </Select>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save Role</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="validation-step-3" class="tab-pane" role="tabpanel">
                                        <div class="row">
                                            <div class="mb-3 col-md-6 error-placeholder">
                                                <label for="inputUsername" class="form-label">Salary</label>
                                                <input type="number" class="form-control required" id="salary" name="salary" placeholder="Eg : 100 000" required>
                                            </div>
                                            <div class="mb-3 col-md-6 error-placeholder">
                                                <label for="inputLastName" class="form-label">Travel Allowance</label>
                                                <input id="travel_allowance" name="travel_allowance" type="number" class="form-control required" placeholder="Eg : 2000" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="inputLastName" class="form-label">Qualifications / Skills</label>
                                                <input type="text" class="form-control" id="Qualification" name="Qualification" placeholder="Qualifications">
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="inputUsername" class="form-label">Account Number</label>
                                                <input type="text" class="form-control " id="bank_ac" name="bank_ac" placeholder="Account number">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="inputUsername" class="form-label">Account Holder Name</label>
                                                <input type="text" class="form-control " id="account_holder" name="account_holder" placeholder="Name">
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="inputLastName" class="form-label">Bank Name</label>
                                                <input type="text" class="form-control" id="bank" name="bank" >
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="inputUsername" class="form-label">Branch </label>
                                                <input type="text" class="form-control " id="branch" name="branch">
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="inputLastName" class="form-label">Bank code</label>
                                                <input type="text" class="form-control" id="bank_code" name="bank_code">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-2 col-md-4">
                                                <label class="form-label">Number of Annual </label>
                                                <input type="text" class="form-control " id="annual" name="annual">
                                            </div>
                                            <div class="mb-2 col-md-4">
                                                <label class="form-label">Number of Casual</label>
                                                <input type="text" class="form-control" id="casual" name="casual">
                                            </div>
                                            <div class="mb-2 col-md-4">
                                                <label class="form-label">Number of Sick</label>
                                                <input type="text" class="form-control" id="sick" name="sick">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>

            </div>
        </main>
    </div>

    </div>

    </div>
</main>

        <?Php
        include "footer.php";
        ?>
    </div>
</div>

<script src="js/app.js"></script>

</body>
<script type="text/javascript" src="js/user_validation.js"></script>
<script type="text/javascript" src="js/client_validation.js"></script>

<script>


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

    document.addEventListener("DOMContentLoaded", function() {


        // Validation
        var $validationForm = $("#smartwizard-validation");
        $validationForm.validate({
            errorPlacement: function errorPlacement(error, element) {
                $(element).parents(".error-placeholder").append(
                    error.addClass("invalid-feedback small d-block")
                )
            },
            highlight: function(element) {
                $(element).addClass("is-invalid");
            },
            unhighlight: function(element) {
                $(element).removeClass("is-invalid");
            },
            rules: {
                "wizard-confirm": {
                    equalTo: "input[name=\"wizard-password\"]"
                },
                "validation-required": {
                    required: true
                },
                "validation-password": {
                    required: true,
                    minlength: 6,
                    maxlength: 20
                }
            },
        });
        $validationForm
            .smartWizard({
                autoAdjustHeight: false,
                backButtonSupport: false,
                useURLhash: false,
                showStepURLhash: false,
                toolbarSettings: {
                    toolbarExtraButtons: [$("<button class=\"btn btn-submit btn-primary\" id=\'btn\' type=\"submit\">Finish</button>")]
                }
            })
            .on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
                if (stepDirection === 1) {
                    return $validationForm.valid();
                }
                return true;
            });
        $validationForm.find(".btn-submit").on("click", function() {
            if (!$validationForm.valid()) {
                return;
            }
            alert("Great! The form is valid and ready to submit.");
        });
    });

</script>

</html>