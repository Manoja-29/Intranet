
<!DOCTYPE html>
<!--
  HOW TO USE:
  data-layout: fluid (default), boxed
  data-sidebar-theme: dark (default), colored, light
  data-sidebar-position: left (default), right
  data-sidebar-behavior: sticky (default), fixed, compact
-->
<html lang="en" data-bs-theme="dark" data-layout="fluid" data-sidebar-theme="dark" data-sidebar-position="left" data-sidebar-behavior="sticky">
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 5 Admin &amp; Dashboard Template">
    <meta name="author" content="Bootlab">

    <title>Default Dashboard | AppStack - Bootstrap 5 Admin &amp; Dashboard Template</title>

    <link rel="canonical" href="https://appstack.bootlab.io/dashboard-default.html" />
    <link rel="shortcut icon" href="img/favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <!-- Choose your prefered color scheme -->
    <link href="css/light.css" rel="stylesheet">
    <style type="text/css">
        .status{
            padding: 10px;
            width: 120px;
        }
    </style>
    <!-- <link href="css/dark.css" rel="stylesheet"> -->

    <!-- BEGIN SETTINGS -->
    <!-- Remove this after purchasing -->
    <!--	<link class="js-stylesheet" href="css/light.css" rel="stylesheet">-->
    <!--	<script src="js/settings.js"></script>-->
    <!-- END SETTINGS -->
</head>


<body data-theme="colored" data-layout="fluid" data-sidebar-position="left" data-sidebar-behavior="sticky">
<body>
<div class="wrapper">
    <?php
    include_once "sidebar.php";
    ?>
    <div class="main">
        <?php
        include_once "../model/user-model.php";
        $userObj=new User();

        include_once "topbar.php";
        ?>

        <main class="content">
            <div class="container-fluid p-0">
                <?php
                $userObj=new User();
                $userId=$_REQUEST['user_id'];
                $userId= base64_decode($userId);
                $userResult= $userObj->viewUser($userId);
                $userRow=$userResult->fetch_assoc();
                ?>
                <h1 class="h3 mb-3">Profile</h1>

                <div class="row">
                    <div class="col-12 col-lg-6 col-xl-4 d-flex">
                        <div class="card flex-fill w-100">

                            <div class="card-header">
                                <h5 class="card-title mb-0">Profile Details</h5>
                            </div>
                            <div class="card-body text-center">
                                <img src="../view/img/user_images/<?php echo $userRow["user_image"]; ?>" class="img-fluid rounded-circle mb-3" width="160" height="160" />
                                <h5 class="card-title mb-1"><?php echo $userRow["user_fname"]." ".$userRow["user_lname"]?></h5>
                                    <h6 class="card- mb-3">EMP - <?php echo sprintf('%03d', $userRow["user_id"]); ?></h6>

                                    <div class="text-muted mb-3"><span style="font-size:18px;">
                                        <?php
                                        $roleId=$userRow["role_id"];
                                        $roleResult= $userObj->getRoleLevelId($roleId);
                                        $roleRow=$roleResult->fetch_assoc();
                                        echo $roleRow["role_name"];
                                        ?>
                                        </span>
                                    </div>

                                <div style="margin-bottom: 30px; margin-top: 30px">
                                    <a class="btn btn-primary btn-sm" href="mailto:<?php $userRow["user_email"] ?>"><span data-feather="mail"></span> Contact</a>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-12 col-lg-8 d-flex">
				        <div class="card flex-fill w-100">
                            <div class="card-header">
                                <div class="card-actions float-end">
                                    <div class="dropdown position-relative">
                                        <a href="#" data-bs-toggle="dropdown" data-bs-display="static">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="more-horizontal" class="lucide lucide-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="card-title mb-0">Information</h5>
                            </div>
                            <div class="card-body">

                                <dl class="row">
                                    <dt class="col-4 col-xxl-3">First Name</dt>
                                    <dd class="col-8 col-xxl-9">
                                        <p class="mb-1"><?php echo $userRow["user_fname"] ?></p>
                                    </dd>

                                    <dt class="col-4 col-xxl-3 mb-0">Last Name</dt>
                                    <dd class="col-8 col-xxl-9 mb-0">
                                        <p class="mb-1"><?php echo $userRow["user_lname"] ?></p>
                                    </dd>
                                </dl>

                                <hr>

                                <dl class="row">
                                    <dt class="col-4 col-xxl-3">Mobile </dt>
                                    <dd class="col-8 col-xxl-9">
                                        <p class="mb-1"><?php echo $userRow["user_cno1"] ?></p>
                                    </dd>

                                   

                                    <dt class="col-4 col-xxl-3 mb-0">Email</dt>
                                    <dd class="col-8 col-xxl-9 mb-0">
                                        <p class="mb-0"><?php echo $userRow["user_email"] ?></p>
                                    </dd>
                                </dl>

                                <hr>

                                <dl class="row">
                                    <dt class="col-4 col-xxl-3">Address</dt>
                                    <dd class="col-8 col-xxl-9">
                                        <p class="mb-0"><?php echo $userRow["employee_address"].', '.$userRow["employee_city"] ?></p>
                                    </dd>
                                    <dt class="col-4 col-xxl-3 mb-0">Province</dt>
                                    <dd class="col-8 col-xxl-9 mb-0">
                                        <p class="mb-0"><?php echo $userRow["province"].' Province' ?></p>
                                    </dd>
                                </dl>

                                <hr>

                                <dl class="row mb-1">
                                    <dt class="col-4 col-xxl-3">Gender</dt>
                                    <dd class="col-8 col-xxl-9">
                                        <p class="mb-0">
                                            <?php
                                            if($userRow["user_gender"]==0){
                                                echo 'Male';
                                            }
                                            else{
                                                echo 'Female';
                                            }
                                            ?>
                                        </p>
                                    </dd>
                                    <dt class="col-4 col-xxl-3">Date of Birth</dt>
                                    <dd class="col-8 col-xxl-9">
                                        <p class="mb-0"><?php echo date('jS F', strtotime($userRow["user_dob"])) ?></p>
                                    </dd>

                                </dl>
                            </div>
                        </div>
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

</html>