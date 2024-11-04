<?php
include "../commons/session.php";
include '../model/user-model.php';

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

<!--<nav id="sidebar" class="sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="dashboard.php">
            <img src="img/TC-logo-white.png" width="150px">
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Pages
            </li>
            <li class="sidebar-item active">
                <a href="dashboard.php" class="sidebar-link">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <?php if ($userLevelId == 3): ?>  
            <li class="sidebar-item">
                <a href="pages-profile.php" class="sidebar-link"> 
                <i class="align-middle" data-feather="user"></i><span class="align-middle">My Profile</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="user-attendance.php" class="sidebar-link">
                <i class="align-middle" data-feather="calendar"></i><span class="align-middle">My Attendance</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a data-bs-target="#leaves" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="check-square"></i> <span class="align-middle">Leaves & Holidays</span>
                </a>
                <ul id="leaves" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class="sidebar-link" href="leave-dashboard.php">My Leaves & Holidays</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="add-leave.php">Request Leaves</a></li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a href="display-team.php" class="sidebar-link">
                <i class="align-middle" data-feather="calendar"></i><span class="align-middle">Employee List</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if ($userLevelId == 1 || $userLevelId == 2): ?>
            <li class="sidebar-item">
                <a data-bs-target="#users" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">Users</span>
                </a>
                <ul id="users" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class="sidebar-link" href="pages-profile.php">My Profile</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="add-user.php">New Employee</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="display-team.php">Employee List</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="team.php">Employee Management</a></li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a data-bs-target="#attendance" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="calendar"></i> <span class="align-middle">Attendance</span>
                </a>
                <ul id="attendance" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class="sidebar-link" href="user-attendance.php">My Attendance</a></li>

                    <li class="sidebar-item"><a class="sidebar-link" href="display-attendance.php">Employee Attendance</a></li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a data-bs-target="#leaves" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="check-square"></i> <span class="align-middle">Leaves & Holidays</span>
                </a>
                <ul id="leaves" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class="sidebar-link" href="leave-dashboard.php">My Leaves & Holidays</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="add-leave.php">Request Leaves</a></li>

                    <li class="sidebar-item"><a class="sidebar-link" href="add-holidays.php">Holidays</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="leaves-report.php">Leaves Reports</a></li>
                </ul>
            </li>
            <?php endif; ?>
            
            <?php if ($userLevelId == 1): ?>
            <li class="sidebar-item">
                <a data-bs-target="#payslips" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="dollar-sign"></i> <span class="align-middle">Payroll Management</span>
                </a>
                <ul id="payslips" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class="sidebar-link" href="add-payslip.php">Generate Payslip</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="display-payslips.php">Payslip Manager</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="payroll.php">Payroll Details</a></li>
                </ul>
            </li>
            <?php endif; ?>
            
            <?php if ($userLevelId == 1 || $userLevelId == 2): ?>
            <li class="sidebar-item">
                <a data-bs-target="#settings" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="settings"></i> <span class="align-middle">Admin Settings</span>
                </a>
                <ul id="settings" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class="sidebar-link" href="admin-settings.php">General</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="add-admin-leave.php">Manage Leaves</a></li>
                </ul>
            </li>
            <?php endif; ?>
        </ul>
        
    </div>
</nav>-->


<nav id="sidebar" class="sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="dashboard.php">
            <img src="img/TC-logo-white.png" width="150px">
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">Pages</li>
            
            <li class="sidebar-item <?php echo ($currentPage == 'dashboard.php') ? 'active' : ''; ?>">
                <a href="dashboard.php" class="sidebar-link">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <?php if ($userLevelId == 3): ?>  
            <li class="sidebar-item <?php echo ($currentPage == 'pages-profile.php') ? 'active' : ''; ?>">
                <a href="pages-profile.php" class="sidebar-link"> 
                    <i class="align-middle" data-feather="user"></i><span class="align-middle">My Profile</span>
                </a>
            </li>

            <li class="sidebar-item <?php echo ($currentPage == 'user-attendance.php') ? 'active' : ''; ?>">
                <a href="user-attendance.php" class="sidebar-link">
                    <i class="align-middle" data-feather="calendar"></i><span class="align-middle">My Attendance</span>
                </a>
            </li>

            <li class="sidebar-item <?php echo ($currentPage == 'display-team.php') ? 'active' : ''; ?>">
                <a href="display-team.php" class="sidebar-link">
                    <i class="align-middle" data-feather="users"></i><span class="align-middle">Team</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a data-bs-target="#leaves" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="check-square"></i> <span class="align-middle">Leaves & Holidays</span>
                </a>
                <ul id="leaves" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class="sidebar-link" href="leave-dashboard.php">My Leaves & Holidays</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="add-leave.php">Request Leaves</a></li>
                </ul>
            </li>
            <?php endif; ?>

            <?php if ($userLevelId == 1 || $userLevelId == 2): ?>
            <li class="sidebar-item <?php echo ($currentPage == 'pages-profile.php') ? 'active' : ''; ?>">
                <a href="pages-profile.php" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">My Profile</span>
                </a>
            </li>

            <li class="sidebar-item <?php echo ($currentPage == 'user-attendance.php') ? 'active' : ''; ?>">
                <a href="user-attendance.php" class="sidebar-link">
                    <i class="align-middle" data-feather="calendar"></i><span class="align-middle">My Attendance</span>
                </a>
            </li>

            <li class="sidebar-item <?php echo ($currentPage == 'display-team.php') ? 'active' : ''; ?>">
                <a href="display-team.php" class="sidebar-link">
                    <i class="align-middle" data-feather="users"></i><span class="align-middle">Team</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a data-bs-target="#leaves" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="check-square"></i> <span class="align-middle">Leaves & Holidays</span>
                </a>
                <ul id="leaves" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class="sidebar-link" href="leave-dashboard.php">My Leaves & Holidays</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="add-leave.php">Request Leaves</a></li>
                </ul>
            </li>
            <?php endif; ?>

            <?php if ($userLevelId == 1 || $userLevelId == 2): ?>
            <li class="sidebar-item <?php echo ($currentPage == 'admin-dashboard.php') ? 'active' : ''; ?>">
                <a href="admin-dashboard.php" class="sidebar-link">
                    <i class="align-middle" data-feather="settings"></i><span class="align-middle">Admin Setting</span>
                </a>
            </li>
            <!-- <li class="sidebar-item">
                <a data-bs-target="#settings" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="settings"></i> <span class="align-middle">Admin Settings</span>
                </a>
                <ul id="settings" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class="sidebar-link" href="team.php">Manage Employee</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="display-attendance.php">Manage Attendance</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="leaves-report.php">Manage Leaves</a></li>
                    <?php if ($userLevelId == 1): ?>
                    <li class="sidebar-item"><a class="sidebar-link" href="payroll.php">Manage Payrolls</a></li>
                    <?php endif; ?>
                    <li class="sidebar-item"><a class="sidebar-link" href="admin-settings.php">Delete Records</a></li>
                </ul>
            </li> -->
            <?php endif; ?>
        </ul>
        
    </div>
</nav>