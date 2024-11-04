<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <form class="d-none d-sm-inline-block">
        <div class="input-group input-group-navbar">
            <input type="text" class="form-control" placeholder="Search…" aria-label="Search">
            <button class="btn" type="button">
                <i class="align-middle" data-feather="search"></i>
            </button>
        </div>
    </form>

    <ul class="navbar-nav">

    </ul>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">

            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                </a>
                <?php
                if (!isset($_SESSION['user']))
                {
                    header('Location: login.php');
                }
                $firstname=$_SESSION["user"]["firstname"];
                $lastname=$_SESSION["user"]["lastname"];
                $user_id=$_SESSION["user"]["user_id"];

                $userObj=new User();
                $userResult= $userObj->viewUser($user_id);
                $userRow=$userResult->fetch_assoc();

                ?>
                <!--Saving user ID for the reference of attendance in session-->
                <input type="hidden" placeholder="Enter Username" id= "uname" name="uname" value="<?php echo $user_id?>" required>

                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                    <img src="img/user_images/<?php echo $userRow["user_image"]; ?>" class="avatar img-fluid rounded-circle me-1" alt="Chris Wood" /> <span class="text-dark"><?php echo $firstname." ".$lastname ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                   <a class="dropdown-item" href="pages-profile.php"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
<!--                    <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="pie-chart"></i> Analytics</a>-->
<!--                    <div class="dropdown-divider"></div>-->
<!--                    <a class="dropdown-item" href="pages-settings.html">Settings & Privacy</a>-->
<!--                    <a class="dropdown-item" href="#">Help</a>-->
                    <a class="dropdown-item" href="../controller/login_controller.php?status=logout">Sign out</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<script type="text/javascript">
    var username = document.getElementById('uname').value;

    sessionStorage.setItem('currentloggedin',username);

</script>
