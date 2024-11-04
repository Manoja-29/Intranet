
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark" data-layout="fluid" data-sidebar-theme="dark" data-sidebar-position="left" data-sidebar-behavior="sticky">
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 5 Admin &amp; Dashboard Template">
    <meta name="author" content="Bootlab">

    <title>Employee | AppStack - Bootstrap 5 Admin &amp; Dashboard Template</title>

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
        .pagination-container {
            display: flex;
            justify-content: right;
            margin-top: 20px;
        }
        .page-item {
            list-style-type: none;
            margin: 0 5px;
        }
        .page-item a {
            cursor: pointer;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            color: #007bff;
            text-decoration: none;
        }
        .page-item.active a {
            background-color: #007bff;
            color: white;
        }
    </style>
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
                <h1 class="h3 mb-3">Team Members</h1>
                <br>
                <div class="row mb-3">
                    <div class="col-5">
                        <input type="text" placeholder="Search by name" class="form-control" name="nameSearch" id="nameSearch" oninput="searchByName()">
                    </div>
                    <div class="col-5">
                        <input type="text" placeholder="Search by role" class="form-control" name="roleSearch" id="roleSearch" oninput="searchByRole()">
                    </div>
                    <div class="col-2 d-flex align-items-end">
                        <input type="hidden" value="<?php echo $user_id ?>" name="user_id" id="user_id">
                        <button class="btn btn-primary shadow-sm me-1" onclick="loadData()">
                            <i class="align-middle" data-feather="filter">&nbsp;</i> 
                        </button>&nbsp;&nbsp;
                        <button class="btn btn-primary shadow-sm" onclick="window.location.reload();">
                            <i class="align-middle" data-feather="refresh-cw">&nbsp;</i> 
                        </button>
                    </div>
                </div>
                <br><br>

                <div class="row" id="user-list">
                
                </div>

                <div class="pagination-container">
                    <ul class="pagination"></ul>
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
    var users = <?php
        $userResult = $userObj->DisplayUsers();
        $users = [];
        while ($userRow = $userResult->fetch_assoc()) {
            $roleId = $userRow["role_id"];
            $roleResult = $userObj->getRoleLevelId($roleId);
            $roleRow = $roleResult->fetch_assoc();
            $userRow['role_name'] = $roleRow['role_name'];
            $users[] = $userRow;
        }
        echo json_encode($users);
    ?>;

    var usersPerPage = 12;
    var currentPage = 1;

    function renderUsers() {
        const start = (currentPage - 1) * usersPerPage;
        const end = start + usersPerPage;
        const paginatedUsers = users.slice(start, end);
        document.getElementById('user-list').innerHTML = '';

        paginatedUsers.forEach(function(user) {
            const userCard = `
                <div class="col-md-4 col-xl-2 user-card" data-name="${user.user_fname} ${user.user_lname}">
                    <div class="card mb-3">
                        <div class="card-body text-center flex-fill">
                            <img src="../view/img/user_images/${user.user_image}" class="img-fluid rounded-circle mb-3 mt-2" width="80" height="80" />
                            <h5 class="card-title mb-1 text-primary">${user.user_fname} ${user.user_lname}</h5>
                            <h6 class="mb-3">EMP - ${user.user_id.padStart(3, '0')}</h6>
                            <div class="text-muted mb-3">
                                <span style="font-size:14px;" data-role="${user.role_name}">${user.role_name}</span>
                            </div>
                            <div class="mb-2">
                                <a class="btn mb-2 btn-pill btn-outline-primary" href="view-employee-profile.php?user_id=${btoa(user.user_id)}">Profile Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            document.getElementById('user-list').insertAdjacentHTML('beforeend', userCard);
        });
    }

    function renderPagination() {
        const totalPages = Math.ceil(users.length / usersPerPage);
        const paginationHTML = [];
        if (currentPage > 1) {
            paginationHTML.push(`<li class="page-item"><a class="page-link" onclick="goToPage(${currentPage - 1})">Previous</a></li>`);
        }
        for (let i = 1; i <= totalPages; i++) {
            paginationHTML.push(`<li class="page-item ${i === currentPage ? 'active' : ''}"><a class="page-link" onclick="goToPage(${i})">${i}</a></li>`);
        }
        if (currentPage < totalPages) {
            paginationHTML.push(`<li class="page-item"><a class="page-link" onclick="goToPage(${currentPage + 1})">Next</a></li>`);
        }
        document.querySelector('.pagination').innerHTML = paginationHTML.join('');
    }

    function goToPage(pageNumber) {
        currentPage = pageNumber;
        renderUsers();
        renderPagination();
    }

    function searchByName() {
        const input = document.getElementById('nameSearch').value.toLowerCase();
        users = users.filter(user => `${user.user_fname} ${user.user_lname}`.toLowerCase().includes(input));
        currentPage = 1;
        renderUsers();
        renderPagination();
    }

    function searchByRole() {
        const input = document.getElementById('roleSearch').value.toLowerCase();
        users = users.filter(user => user.role_name.toLowerCase().includes(input));
        currentPage = 1;
        renderUsers();
        renderPagination();
    }

    renderUsers();
    renderPagination();

</script>

</body>

</html>