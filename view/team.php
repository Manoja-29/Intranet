<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 5 Admin &amp; Dashboard Template">
    <meta name="author" content="Bootlab">

    <title>Clients | AppStack - Bootstrap 5 Admin &amp; Dashboard Template</title>

    <link rel="canonical" href="https://appstack.bootlab.io/pages-clients.html" />
    <link rel="shortcut icon" href="img/favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- Choose your prefered color scheme -->
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
        include "../includes/bootstrap_includes_css.php";
        $userObj=new User();

        $role_id=$_SESSION['user']['role_id'];
        $roleResult=$userObj->getRoleLevelId($role_id);
        $roleRow=$roleResult->fetch_assoc();
        $roleId=$roleRow['role_level_id_test'];

        ?>
        <main class="content">
            <div class="container-fluid p-0">

                <div class="row mb-2 mb-xl-3">
                    <div class="col-auto d-none d-sm-block">
                        <h3>Team</h3>
                    </div>

                    <div class="col-auto ms-auto text-end mt-n1">
                        <div class="dropdown me-2 d-inline-block position-relative">
                            <a class="btn mb-2 btn-primary" style="padding: 5px 15px;" href="add-user.php">+ New Employee</a>
                        </div>
                    </div>
                </div>

                <!-- <h1 class="h3 mb-3">Team</h1> -->

                <div class="row">
                    <div class="col-xl-12">
                        <div class="row">
                            <?php
                            //        check if msg is available
                            if(isset($_GET['msg'])){

                                ?>
                                <div class="col-md-12">
                                    <div class="alert alert-success alert-dismissible" role="alert">
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

                            <div class="col-md-12"><div id="alertDiv"></div> </div>
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
                                <h5 class="card-title mb-0">Team</h5>
                            </div>
                            <div class="card-body">
                                <table id="datatables-clients" class="table table-striped" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th></th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $userResult=$userObj->DisplayUsers();
                                    while ($userRow=$userResult->fetch_assoc()) {

                                    $userId=$userRow['user_id'];
                                    $userId=base64_encode($userId);
                                    ?>
                                    <tr>
                                        <td><?php echo base64_decode($userId)?></td>
                                        <td><img src="../view/img/user_images/<?php echo $userRow["user_image"]; ?>" width="32" height="32" class="rounded-circle my-n1" alt="Avatar"></td>
                                        <td><?php echo $userRow["user_fname"].' '.$userRow["user_lname"]?></td>
                                        <td><?php echo $userRow["user_email"]?></td>
                                        <td><?php echo $userRow["role_name"]?></td>
                                        <td><?php
                                                if($userRow['user_status'] == "0")
                                                {
                                                    ?>

                                                    <a style="width: 120px" <?php if ($roleId == 3){ ?> onclick="return false;" <?php   } ?> href=../controller/user_controller.php?status=activateUser&user_id=<?php echo $userId; ?>" class="badge bg-success">
                                                                        <span class="glyphicon glyphicon-refresh"></span>
                                                                        &nbsp;Activate

                                                                    </a>
                                                    &nbsp;

                                                    <?php
                                                }

                                                ?>
                                                                <!--Deactivation-->
                                                <!--when user is active deactivate using deactivate button-->
                                                                <?php
                                                                if($userRow['user_status'] == "1")
                                                                {
                                                                    ?>

                                                                    <a <?php if ($roleId == 3){ ?> onclick="return false;" <?php   } ?> style="width: 120px" href="../controller/user_controller.php?status=deactivateUser&user_id=<?php echo $userId; ?>" class="badge bg-danger">
                                                                        <span class="glyphicon glyphicon-refresh"></span>
                                                                        &nbsp;Deactivate

                                                                    </a>
                                                                    <?php
                                                                }
                                                                ?>
                                        </td>
                                        <td>
                                            <a class="badge bg-info" href="view-user.php?user_id=<?php echo $userId ?>">Edit Details</a>
                                        </td>
                                    </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Datatables clients
        $("#datatables-clients").DataTable({
            responsive: true,
            order: [
                [1, "asc"]
            ]
        });
    });
</script>
</body>

</html>