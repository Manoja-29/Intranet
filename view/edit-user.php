<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 5 Admin &amp; Dashboard Template">
    <meta name="author" content="Bootlab">

    <title>Settings | AppStack - Bootstrap 5 Admin &amp; Dashboard Template</title>

    <link rel="canonical" href="https://appstack.bootlab.io/forms-wizard.html" />
    <link rel="canonical" href="https://appstack.bootlab.io/pages-settings.html" />
    <link rel="shortcut icon" href="img/favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- Choose your prefered color scheme -->
    <link href="css/light.css" rel="stylesheet">
    <!-- <link href="css/dark.css" rel="stylesheet"> -->

    <!-- BEGIN SETTINGS -->
    <!-- Remove this after purchasing -->
    <!--    <link class="js-stylesheet" href="css/light.css" rel="stylesheet">-->
    <!--    <script src="js/settings.js"></script>-->
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
    include_once "sidebar.php";
    ?>
    <div class="main">
        <?php
        include_once "topbar.php";
        ?>
        <main class="content">
            <div class="container-fluid p-0">

                <div class="row">
                    <div class="col-12">
                        <main class="content">
                            <div class="container-fluid p-0">

                                <div class="row">
                                    <h1 class="h3 mb-3">User Profile</h1>

                                    <div class="col-12">
                                        <form id="smartwizard-validation" class="wizard wizard-primary" action="javascript:void(0)">
                                            <ul class="nav">
                                                <li class="nav-item"><a class="nav-link" href="#validation-step-1">Account<br /><small>Public Info</small></a></li>
                                                <li class="nav-item"><a class="nav-link" href="#validation-step-2">Password<br /><small>Personal Info</small></a></li>
                                                <li class="nav-item"><a class="nav-link" href="#validation-step-3">Bank Details<br /><small>Personal Info</small></a></li>
                                            </ul>

                                            <div class="tab-content">
                                                <div id="validation-step-1" class="tab-pane" role="tabpanel">
                                                    <div class="mb-3 error-placeholder">
                                                        <label class="form-label">User name
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input name="wizard-userName" type="text" class="form-control required">
                                                    </div>
                                                    <div class="mb-3 error-placeholder">
                                                        <label class="form-label">Password
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input name="wizard-password" type="text" class="form-control required">
                                                    </div>
                                                    <div class="mb-0 error-placeholder">
                                                        <label class="form-label">Confirm Password
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input name="wizard-confirm" type="text" class="form-control required">
                                                    </div>
                                                </div>
                                                <div id="validation-step-2" class="tab-pane" role="tabpanel">
                                                    <div class="mb-3 error-placeholder">
                                                        <label class="form-label">First name
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input name="wizard-name" type="text" class="form-control required">
                                                    </div>
                                                    <div class="mb-3 error-placeholder">
                                                        <label class="form-label">Last name
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input name="wizard-surname" type="text" class="form-control required">
                                                    </div>
                                                    <div class="mb-3 error-placeholder">
                                                        <label class="form-label">Email
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input name="wizard-email" type="text" class="form-control required email">
                                                    </div>
                                                    <div class="mb-0 error-placeholder">
                                                        <label class="form-label">Address</label>
                                                        <input name="wizard-address" type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div id="validation-step-3" class="tab-pane" role="tabpanel">
                                                    <div class="mb-3 error-placeholder">
                                                        <label class="form-check">
                                                            <input type="checkbox" class="form-check-input">
                                                            <span class="form-check-label">I agree with the Terms and Conditions</span>
                                                        </label>
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
                <div class="row">
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
                                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#" role="tab">
                                    Privacy and safety
                                </a>
                                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#" role="tab">
                                    Email notifications
                                </a>
                                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#" role="tab">
                                    Web notifications
                                </a>
                                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#" role="tab">
                                    Widgets
                                </a>
                                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#" role="tab">
                                    Your data
                                </a>
                                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#" role="tab">
                                    Delete account
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9 col-xl-10">
                        <div class="tab-content">
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
                                    <div class="card-body">
                                        <form>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="mb-3">
                                                        <label for="inputFirstName" class="form-label">First name</label>
                                                        <input type="text" class="form-control" id="inputFirstName" placeholder="First name">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="inputLastName" class="form-label">Last name</label>
                                                        <input type="text" class="form-control" id="inputLastName" placeholder="Last name">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-center">
                                                        <img alt="Chris Wood" src="img/avatars/avatar.jpg" class="rounded-circle img-responsive mt-2" width="128" height="128" />
                                                        <div class="mt-2">
                                                            <span class="btn btn-primary"><i class="fas fa-upload"></i> Upload</span>
                                                        </div>
                                                        <small>For best results, use an image at least 128px by 128px in .jpg format</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label for="inputUsername" class="form-label">Contact Number 1</label>
                                                    <input type="text" class="form-control" id="tel1" >
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="inputLastName" class="form-label">Contact Number 2</label>
                                                    <input type="text" class="form-control" id="tel2" >
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputEmail4" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputAddress2" class="form-label">NIC</label>
                                                <input type="text" class="form-control" id="inputAddress2" placeholder="NIC">
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputAddress" class="form-label">Address</label>
                                                <textarea rows="2" class="form-control" id="inputBio" placeholder="Number/Apartment/Floor"></textarea>

                                            </div>

                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label for="inputCity" class="form-label">City</label>
                                                    <input type="text" class="form-control" id="inputCity">
                                                </div>
                                                <div class="mb-3 col-md-4">
                                                    <label for="inputState" class="form-label">State</label>
                                                    <select id="inputState" class="form-control">
                                                        <option selected>Choose...</option>
                                                        <option>...</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3 col-md-2">
                                                    <label for="inputZip" class="form-label">Zip</label>
                                                    <input type="text" class="form-control" id="inputZip">
                                                </div>
                                            </div>

                                        </form>

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
                                        <form>
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label for="inputUsername" class="form-label">Password </label>
                                                    <input type="password" class="form-control" id="inputAddress">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="inputLastName" class="form-label">User Role</label>
                                                    <select id="inputState" class="form-control">
                                                        <option selected>Choose...</option>
                                                        <option>...</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label for="inputUsername" class="form-label">Salary</label>
                                                    <input type="text" class="form-control" id="inputAddress" placeholder="Eg : 100 000">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="inputLastName" class="form-label">Travel Allowance</label>
                                                    <input type="text" class="form-control" id="inputLastName" placeholder="Eg : 2000">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label for="inputUsername" class="form-label">Bank </label>
                                                    <input type="text" class="form-control" id="inputAddress" placeholder="Account/Bank/Branch">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="inputLastName" class="form-label">Qualifications / Skills</label>
                                                    <input type="text" class="form-control" id="inputLastName" placeholder="Last name">
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </form>

                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="password" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Password</h5>

                                        <form>

                                            <div class="mb-3">
                                                <label for="inputPasswordNew" class="form-label">New password</label>
                                                <input type="password" class="form-control" id="new-password" onkeyup='checkPassword();'>
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputPasswordNew2" class="form-label">Verify password</label>
                                                <input type="password" class="form-control" id="confirm_new_password" onkeyup='checkPassword();'>
                                                <span id='message'></span>

                                            </div>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>

        <footer class="footer">
            <div class="container-fluid">
                <div class="row text-muted">
                    <div class="col-6 text-start">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a class="text-muted" href="#">Support</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="text-muted" href="#">Help Center</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="text-muted" href="#">Privacy</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="text-muted" href="#">Terms of Service</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-6 text-end">
                        <p class="mb-0">
                            &copy; 2023 - <a href="index.html" class="text-muted">AppStack</a>
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>

<script src="js/app.js"></script>

</body>
<script type="text/javascript" src="js/user_validation.js"></script>

<script>

    document.addEventListener("DOMContentLoaded", function() {
        $("#smartwizard-default-primary").smartWizard({
            theme: "default",
            showStepURLhash: false
        });
        $("#smartwizard-default-success").smartWizard({
            theme: "default",
            showStepURLhash: false
        });
        $("#smartwizard-default-danger").smartWizard({
            theme: "default",
            showStepURLhash: false
        });
        $("#smartwizard-default-warning").smartWizard({
            theme: "default",
            showStepURLhash: false
        });
        $("#smartwizard-arrows-primary").smartWizard({
            theme: "arrows",
            showStepURLhash: false
        });
        $("#smartwizard-arrows-success").smartWizard({
            theme: "arrows",
            showStepURLhash: false
        });
        $("#smartwizard-arrows-danger").smartWizard({
            theme: "arrows",
            showStepURLhash: false
        });
        $("#smartwizard-arrows-warning").smartWizard({
            theme: "arrows",
            showStepURLhash: false
        });
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
                }
            }
        });
        $validationForm
            .smartWizard({
                autoAdjustHeight: false,
                backButtonSupport: false,
                useURLhash: false,
                showStepURLhash: false,
                toolbarSettings: {
                    toolbarExtraButtons: [$("<button class=\"btn btn-submit btn-primary\" type=\"button\">Finish</button>")]
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
            return false;
        });
    });

    $(":input").inputmask();
    $("#tel1").inputmask({"mask": "+99999999999"});

    $(":input").inputmask();
    $("#tel2").inputmask({"mask": "+99999999999"});

    var checkPassword = function() {
        if (document.getElementById('new-password').value ==
            document.getElementById('confirm_new_password').value) {
            document.getElementById('message').style.color = 'green';
            document.getElementById('message').innerHTML = 'matching';
        } else {
            document.getElementById('message').style.color = 'red';
            document.getElementById('message').innerHTML = 'not matching';
        }
    }



</script>

</html>