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
</head>

<body data-theme="colored" data-layout="fluid" data-sidebar-position="left" data-sidebar-behavior="sticky">
<div class="wrapper">
    <?php
    include_once "sidebar.php";
    ?>
    <div class="main">
    <?php
        include_once "../model/user-model.php";
        $userObj=new User();

        include_once "topbar.php";
        $user_id=$_SESSION['user']['user_id'];

        $role_id=$_SESSION['user']['role_id'];

        if (!isset($_SESSION['user']))/*if not logged in redirect to the login page*/
        {
            header('Location: login.php');
        }else
        {
            $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);/*get current URL*/

            $userObj = new User();
            $roleLevelResult=$userObj->getRoleLevelId($role_id); /*Get User Role ID*/
            $userLevelIdRow=$roleLevelResult->fetch_assoc();
            $userLevelId=$userLevelIdRow["role_level_id_test"];

            $stack = array();
            $roleUrlResult=$userObj->getUserLevelUrls($userLevelId);
        }

        $currentPage = basename($_SERVER['PHP_SELF']);
    ?>
        <main class="content">
            <div class="container-fluid p-0">

                <div class="row">
                    <?php
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
                        <div id="alertDiv" style="padding: 10px">

                        </div>
                    </div>
                </div>

                <div class="row mb-2 mb-xl-3">
                    <div class="col-auto d-none d-sm-block">
                        <h3>Admin Dashboard</h3>
                    </div>
                </div>
             

                <div class="row">
                    <div class="col-12 col-sm-6 col-xxl-4 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-4">
                                <div class="d-flex align-item-start">
                                    <div class="flex-grow-1">
                                        <h4 class="mb-2 text-center">Employee Management</h4><br>
                                        <div style="text-align: center;">
                                            <a href="team.php">
                                                <img src="img/photos/team.png" width="90" height="90" alt="annual">
                                            </a>
                                        </div>
                                        <div class="mt-3 text-center" style="font-size:15px;">
                                            <a href="team.php"><p class="badge badge-soft-success me-2"> Click here </p></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-xxl-4 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-4">
                                <div class="d-flex align-items-start">
                                    <div class="flex-grow-1">
                                        <h4 class="mb-2 text-center">Attendance Tracker</h4><br>
                                        <div style="text-align: center;">
                                            <a href="display-attendance.php">
                                                <img src="img/photos/casual.png" width="90" height="90" alt="annual">
                                            </a>
                                        </div>
                                        <div class="mt-3 text-center" style="font-size:15px;">
                                            <a href="display-attendance.php"><p class="badge badge-soft-success me-2"> Click here </p></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-xxl-4 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-4">
                                <div class="d-flex align-items-start">
                                    <div class="flex-grow-1">
                                        <h4 class="mb-2 text-center">Leave Management</h4><br>
                                        <div style="text-align: center;">
                                            <a href="add-admin-leave.php">
                                                <img src="img/photos/annual.png" width="90" height="90" alt="annual">
                                            </a>
                                        </div>
                                        <div class="mt-3 text-center" style="font-size:15px;">
                                            <a href="add-admin-leave.php"><p class="badge badge-soft-success me-2"> Click here </p></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-6 col-xxl-4 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-4">
                                <div class="d-flex align-items-start">
                                    <div class="flex-grow-1">
                                        <h4 class="mb-2 text-center">Manage Holidays</h4><br>
                                        <div style="text-align: center;">
                                            <a href="add-holidays.php">
                                                <img src="img/photos/holiday.png" width="90" height="90" alt="annual">
                                            </a>
                                        </div>
                                        <div class="mt-3 text-center" style="font-size:15px;">
                                            <a href="add-holidays.php"><p class="badge badge-soft-success me-2"> Click here </p></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($userLevelId == 1): ?>
                    <div class="col-12 col-sm-6 col-xxl-4 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-4">
                                <div class="d-flex align-items-start">
                                    <div class="flex-grow-1">
                                        <h4 class="mb-2 text-center">Manage Employee Payroll</h4><br>
                                        <div style="text-align: center;">
                                            <a href="payroll.php">
                                                <img src="img/photos/pay.png" width="90" height="90" alt="annual">
                                            </a>
                                        </div>
                                        <div class="mt-3 text-center" style="font-size:15px;">
                                            <a href="payroll.php"><p class="badge badge-soft-success me-2"> Click here </p></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="col-12 col-sm-6 col-xxl-4 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-4">
                                <div class="d-flex align-items-start">
                                    <div class="flex-grow-1">
                                        <h4 class="mb-2 text-center">Record Cleanup</h4><br>
                                        <div style="text-align: center;">
                                            <a href="admin-settings.php">
                                                <img src="img/photos/delete.png" width="90" height="90" alt="annual">
                                            </a>
                                        </div>
                                        <div class="mt-3 text-center" style="font-size:15px;">
                                            <a href="admin-settings.php"><p class="badge badge-soft-success me-2"> Click here </p></a>
                                        </div>
                                    </div>
                                </div>
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