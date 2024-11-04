<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Bootstrap 5 Admin &amp; Dashboard Template">
	<meta name="author" content="Bootlab">

	<title>Reset Password | AppStack - Bootstrap 5 Admin &amp; Dashboard Template</title>

	<link rel="canonical" href="https://appstack.bootlab.io/pages-reset-password.html" />
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

<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-behavior="sticky">
	<div class="main d-flex justify-content-center w-100">
		<main class="content d-flex p-0">
			<div class="container d-flex flex-column">
				<div class="row h-100">
					<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
						<div class="d-table-cell align-middle">

							<div class="text-center mt-4">
								<h1 class="h2">Reset password</h1>
								<p class="lead">
									Enter your email to reset your password.
								</p>
							</div>

							<div class="card">
								<div class="card-body">
									<div class="m-sm-3">
										<form action="../controller/login_controller.php?status=verify_account" method="post" enctype="multipart/form-data">
                                            <?php
                                            //        check if msg is available
                                            if(isset($_GET['msg'])){

                                                ?>
                                                <div class="col-md-12">
                                                    <div class="alert alert-primary alert-dismissible" role="alert">
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <div class="alert-message">
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
                                            <div class="mb-3">
												<label class="form-label">Email</label>
												<input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" />
											</div>
											<div class="d-grid gap-2 mt-3">
												<button type="submit" class="btn btn-lg btn-primary">Reset password</button>
											</div>
										</form>
									</div>
								</div>
							</div>
							<div class="text-center mb-3">
								Don't have an account? <a href="pages-sign-up.html">Sign up</a>
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