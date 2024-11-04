<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 5 Admin &amp; Dashboard Template">
    <meta name="author" content="Bootlab">

    <title>Profile | AppStack - Bootstrap 5 Admin &amp; Dashboard Template</title>
    <link rel="canonical" href="https://appstack.bootlab.io/dashboard-default.html" />
    <link rel="shortcut icon" href="img/favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <link href="css/light.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
</head>

<body data-theme="colored" data-layout="fluid" data-sidebar-position="left" data-sidebar-behavior="sticky">
<div class="wrapper">
    <?php
    include_once "sidebar.php";
    ?>
    <div class="main">
    <?php
        include_once "topbar.php";
        $user_id=$_SESSION["user"]["user_id"];

        $userObj=new User();
        $userResult= $userObj->viewUser($user_id);
        $userRow=$userResult->fetch_assoc();

        $role_id=$_SESSION['user']['role_id'];
        $roleResult=$userObj->getRoleLevelId($role_id);
        $roleRow=$roleResult->fetch_assoc();
        $roleId=$roleRow['role_level_id_test'];
    ?>

    <main class="content">
    <div class="container-fluid p-0">
        <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-none d-sm-block">
                <h3>My Profile</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-6 col-xl-4 d-flex">
                <div class="card flex-fill w-100">

                    <div class="card-header">
                        <div class="card-actions float-end">
                            <div class="dropdown position-relative">
                                <?php
                                    $user_id_encoded=base64_encode($user_id); 
                                ?>  
                                <ul class="list-unstyled mb-2">
                                <li class="mb-1">
                                    <a href="view-user-employee.php?user_id=<?php echo $user_id_encoded; ?>">
                                        <span data-feather="edit"></span>
                                    </a>
                                </li>
                                </ul>
                            </div>
                        </div>
                        <h5 class="card-title mb-0">Profile</h5>
                    </div>

                    <div class="card-body text-center">
						<img src="../view/img/user_images/<?php echo $userRow["user_image"]; ?>" alt="Stacie Hall" class="img-fluid rounded-circle mb-3" width="130" height="130" />
						<h5 class="card-title mb-1"><?php echo $userRow["user_fname"]." ".$userRow["user_lname"]?></h5>
                        <h6 class="card- mb-2">EMP - <?php echo sprintf('%03d', $userRow["user_id"]); ?></h6>

                        <div class="text-muted mb-3">
                            <span style="font-size:18px;">
                            <?php
                                $roleId=$userRow["role_id"];
                                $roleResult= $userObj->getRoleLevelId($roleId);
                                $roleRow=$roleResult->fetch_assoc();
                                echo $roleRow["role_name"];
                            ?>
                            </span>
                        </div>

						<div>
                            <dt>Status</dt>
                            <dd>
                                <span class="badge bg-info mb-1">
                                 <?php
                                 if($userRow["user_status"]==0){
                                     echo 'Inactive';
                                 }
                                 else{
                                     echo 'Active';
                                 }
                                 ?>
                                </span>
                            </dd>
						</div>
					</div>

                    <hr class="my-0" />
						<div class="card-body">
							<h5 class="h6 card-title mb-2">Qualification/Skills</h5>
                            <ul class="list-unstyled mb-1"><li class="mb-1"><span class="align-middle fas fa-fw fa-graduation-cap"></span>
                                <a href="#"><?php echo $userRow["Qualification"]?></a>
                            </li></ul>
						</div>
					<hr class="my-0" />
						<div class="card-body">
							<h5 class="h6 card-title mb-2">About</h5>
							<ul class="list-unstyled mb-1">
                                <li class="mb-2"><span data-feather="map-pin" class="feather-sm me-1"></span> From <a href="#"><?php echo $userRow["employee_city"]?></a></li>
								<li class="mb-2"><span data-feather="phone" class="feather-sm me-1"></span> Contact at <a href="#"><?php echo $userRow["user_cno1"]?></a></li>
                                <li class="mb-1"><span data-feather="mail" class="feather-sm me-0"></span> <a href="mailto:<?php $userRow["user_email"] ?>"><?php echo $userRow["user_email"]?></a></li>
                            </ul>
						</div>
                </div>
            </div>
    
            <div class="col-12 col-lg-8 d-flex">
				<div class="card flex-fill w-100">
					<div class="card-header">
                        <div class="card-actions float-end">
                            <div class="dropdown position-relative">
                                <?php
                                    $user_id_encoded=base64_encode($user_id); 
                                ?>  
                                <ul class="list-unstyled mb-2">
                                <li class="mb-1">
                                    <a href="view-user-employee.php?user_id=<?php echo $user_id_encoded; ?>">
                                        <span data-feather="edit"></span>
                                    </a>
                                </li>
                                </ul>
                            </div>
                        </div>
						<ul class="nav nav-tabs card-header-tabs pull-right" role="tablist">
							<li class="nav-item" role="presentation">
								<a class="nav-link active" data-bs-toggle="tab" href="#tab-1" aria-selected="true" role="tab">Personal Details</a>
							</li>
							<li class="nav-item" role="presentation">
								<a class="nav-link" data-bs-toggle="tab" href="#tab-2" aria-selected="false" role="tab" tabindex="-1">Bank Details</a>
							</li>
							<li class="nav-item" role="presentation">
								<a class="nav-link" data-bs-toggle="tab" href="#tab-3" aria-selected="false" tabindex="-1" role="tab">Security Info</a>
							</li>
						</ul>
					</div>

					<div class="card-body">
						<div class="tab-content">
                            <!-- Personal Details -->
							<div class="tab-pane fade active show" id="tab-1" role="tabpanel">
                                <div style="text-align:center; ">
                                    <img src="img/photos/personal.png" width="60" height="60" alt="user">
                                </div>
                                <br><br>
                                <dl class="row">
                                    <div class="d-flex">
                                        <dt class="col-4 col-xxl-2 mb-0">First Name :</dt>
                                        <dd class="col-8 col-xxl-4 mb-0">
                                            <p class="mb-1"><?php echo $userRow["user_fname"] ?></p>
                                        </dd>
                                        <dt class="col-4 col-xxl-2 mb-0">Last Name :</dt>
                                        <dd class="col-8 col-xxl-9 mb-0">
                                            <p class="mb-1"><?php echo $userRow["user_lname"] ?></p>
                                        </dd>
                                    </div>
                                </dl>
                                <hr>
                                <dl class="row">
                                    <dt class="col-4 col-xxl-2 mb-0 mt-1">Personal Email :</dt>
                                    <dd class="col-8 col-xxl-9 mb-0 mt-1">
                                        <p class="mb-1"><?php echo $userRow["user_per_email"] ?></p>
                                    </dd>
                                </dl>
                                <hr>
                                <dl class="row">
                                    <dt class="col-4 col-xxl-2 mb-0 mt-1">Address :</dt>
                                    <dd class="col-8 col-xxl-9 mb-0 mt-1">
                                        <p class="mb-1"><?php echo $userRow["employee_address"].', '. $userRow["employee_city"] ?></p>
                                    </dd>
                                </dl>
                                <hr>
                                <dl class="row">
                                    <dt class="col-4 col-xxl-2 mb-0 mt-1">Province :</dt>
                                    <dd class="col-8 col-xxl-9 mb-0 mt-1">
                                        <p class="mb-1"><?php echo $userRow["province"].' Province' ?></p>
                                    </dd>
                                </dl>
                                <hr>
                                <dl class="row">
                                    <div class="d-flex">
                                        <dt class="col-4 col-xxl-2 mb-0 mt-1">Date of Birth :</dt>
                                        <dd class="col-8 col-xxl-4 mb-0 mt-1">
                                            <p class="mb-1"><?php echo $userRow["user_dob"] ?></p>
                                        </dd>
                                        <dt class="col-4 col-xxl-2 mb-0 mt-1">NIC :</dt>
                                        <dd class="col-8 col-xxl-9 mb-0 mt-1">
                                            <p class="mb-1"><?php echo $userRow["user_nic"] ?></p>
                                        </dd>
                                    </div>
                                </dl>
                                <hr>
                                <dl class="row">
                                    <div class="d-flex">
                                        <dt class="col-4 col-xxl-2 mb-0 mt-1">Marital Status :</dt>
                                        <dd class="col-8 col-xxl-4 mb-0 mt-1">
                                            <p class="mb-1">
                                            <?php 
                                                if($userRow["user_marital"]==1){
                                                    echo 'Single';
                                                }
                                                else{
                                                    echo 'Married';
                                                }
                                            ?></p>
                                        </dd>
                                        <dt class="col-4 col-xxl-2 mb-0 mt-1">Gender :</dt>
                                        <dd class="col-8 col-xxl-9 mb-0 mt-1">
                                            <p class="mb-1">
                                            <?php 
                                                if($userRow["user_gender"]==0){
                                                    echo 'Male';
                                                }
                                                else{
                                                    echo 'Female';
                                                }
                                            ?></p>
                                        </dd>
                                    </div>
                                </dl>
                                <hr>
						    </div>
                            
                            <!--Bank Details -->
							<div class="tab-pane fade" id="tab-2" role="tabpanel">
                                <div style="text-align:center; ">
                                    <img src="img/photos/bank.png" width="60" height="60" alt="bank">
                                </div>
                                <br><br>

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

                                <dl class="row">
                                    <div class="d-flex">
                                        <dt class="col-4 col-xxl-2 mb-0 mt-1">Basic Salary :</dt>
                                        <dd class="col-8 col-xxl-4 mb-0 mt-1">
                                            <p class="mb-1"><?php echo $salary ?></p>
                                        </dd>
                                        <dt class="col-4 col-xxl-2 mb-0 mt-1">Travel Allowance :</dt>
                                        <dd class="col-8 col-xxl-4 mb-0 mt-1">
                                            <p class="mb-1"><?php echo $travel_allowance ?></p>
                                        </dd>
                                    </div>
                                </dl>
                                <hr>
                                <dl class="row">
                                    <div class="d-flex">
                                        <dt class="col-4 col-xxl-4 mb-0 mt-1">Account Holder Name :</dt>
                                        <dd class="col-8 col-xxl-9 mb-0 mt-1">
                                            <p class="mb-1"><?php echo $account_holder ?></p>
                                        </dd>
                                    </div>
                                </dl>
                                <hr>
                                <dl class="row">
                                    <div class="d-flex">
                                        <dt class="col-4 col-xxl-2 mb-0 mt-1">Bank Name :</dt>
                                        <dd class="col-8 col-xxl-9 mb-0 mt-1">
                                            <p class="mb-1"><?php echo $bank ?></p>
                                        </dd>
                                    </div>
                                </dl>
                                <hr>
                                <dl class="row">
                                    <dt class="col-4 col-xxl-2 mb-0 mt-1">Account No :</dt>
                                    <dd class="col-8 col-xxl-4 mb-0 mt-1">
                                        <p class="mb-1"><?php echo $bank_ac ?></p>
                                    </dd>
                                </dl>
                                <hr>
                                <dl class="row">
                                    <div class="d-flex">
                                        <dt class="col-4 col-xxl-2 mb-0 mt-1">Branch :</dt>
                                        <dd class="col-8 col-xxl-4 mb-0 mt-1">
                                            <p class="mb-1"><?php echo $branch ?></p>
                                        </dd>
                                        <dt class="col-4 col-xxl-2 mb-0 mt-1">Bank Code :</dt>
                                        <dd class="col-8 col-xxl-4 mb-0 mt-1">
                                            <p class="mb-1"><?php echo $bank_code ?></p>
                                        </dd>
                                    </div>
                                </dl>
                                <hr>
						    </div>

                            <!--Security -->
						    <div class="tab-pane fade" id="tab-3" role="tabpanel">
                                <div style="text-align:center; ">
                                    <img src="img/photos/lock.png" width="60" height="60" alt="security">
                                </div>
                                <br><br>
                                <dl class="row">
                                    <dt class="col-4 col-xxl-3 mb-0 mt-1">Username / Email :</dt>
                                    <dd class="col-8 col-xxl-9 mb-0 mt-1">
                                        <p class="mb-1"><?php echo $userRow["user_email"] ?></p>
                                    </dd>
                                </dl>
                                <hr>
                                <dl class="row">
                                    <dt class="col-4 col-xxl-3 mb-0 mt-1">Password :</dt>
                                    <dd class="col-8 col-xxl-9 mb-0 mt-1">
                                        <?php
                                            $password= base64_decode($userRow["password"]);
                                        ?>
                                        <p class="mb-1"><?php echo $password ?></p>
                                    </dd>
                                </dl>
                                <hr>
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
