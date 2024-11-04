<?php
include '../commons/session.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Bootstrap 5 Admin &amp; Dashboard Template">
	<meta name="author" content="Bootlab">

	<title>Sign In | Technical Creatives APAC (Pvt) Ltd</title>

	<link rel="canonical" href="https://appstack.bootlab.io/pages-sign-in.html" />
	<link rel="shortcut icon" href="img/TC-logo-white.png">

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

<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-behavior="sticky">
	<div class="main d-flex justify-content-center w-100">
		<main class="content d-flex p-0">
			<div class="container d-flex flex-column">
				<div class="row h-100">
					<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">

                        <div class="d-table-cell align-middle">

							<div class="text-center mt-4">
								<h1 class="h2">Technical Creatives APAC (Pvt) Ltd</h1>
								<p class="lead">
									Sign in to your account to continue
								</p>
							</div>
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

							<div class="card">
								<div class="card-body">
									<div class="m-sm-3">
										<div class="row">
											<div class="col">
												<hr>
											</div>
											<div class="col-auto text-uppercase d-flex align-items-center">Or</div>
											<div class="col">
												<hr>
											</div>
										</div>
										<form action="../controller/login_controller.php?status=add_login" method="post" enctype="multipart/form-data" id="loginform">
											<div class="mb-3">
												<label class="form-label">Email</label>
												<input class="form-control form-control-lg" type="email" name="username" placeholder="Enter your email" />
											</div>
											<div class="mb-3">
												<label class="form-label">Password</label>
												<input class="form-control form-control-lg" type="password" name="password" placeholder="Enter your password" />
												<small>
                                            <a href="pages-reset-password.php" style="font-size: 13px">Forgot password?</a>
                                          </small>
											</div>
											<div>
												<div class="form-check align-items-center">
													<input id="customControlInline" type="checkbox" class="form-check-input" name="remember_me">
													<label class="form-check-label text-small" for="customControlInline">Remember me</label>
												</div>
											</div>
											<div class="d-grid gap-2 mt-3">
												<button class="btn btn-lg btn-primary" type="submit">Sign in</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
	</div>

	<script src="js/app.js"></script>

</body>

</html>