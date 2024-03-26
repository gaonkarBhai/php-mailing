<?php
session_start();
if (!isset($_SESSION['name']))
    header("Location: auth/login.php");
if ($_SESSION['role'] != 0)
    header("Location: adminDashboard.php");
include('./conn.php');

// Fetch all tasks
$sql = "SELECT * FROM `tasks`";
$result = mysqli_query($conn, $sql) or die("Query failed");

// Initialize counters for each category
$countTodo = 0;
$countProgress = 0;
$countReview = 0;
$countDone = 0;

// Loop through the results and count tasks for each category
while ($row = mysqli_fetch_assoc($result)) {
    switch ($row['belong']) {
        case "TODO":
            $countTodo++;
            break;
        case "PROGRESS":
            $countProgress++;
            break;
        case "REVIEW":
            $countReview++;
            break;
        case "DONE":
            $countDone++;
            break;
        default:
            // Handle any other categories if needed
            break;
    }
}

// Now $countTodo, $countProgress, $countReview, $countDone contain the counts for each category
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>PMS-CCT</title>

    <!-- Custom fonts for this template-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/dashboard1.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon">
                    <img width="64" src="https://employee.crisscrosstamizh.in/logo.png" alt="cct">
                </div>
                <div class="sidebar-brand-text mx-3">PMS</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>ISSUES</span>
                </a>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>CODE</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Addons
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Team</span>
                </a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <a href="#" onclick="logout()" class="d-none d-sm-inline-block btn  btn-danger shadow-sm">Logout</a>
            </div>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow" style=".topbar {
    height: 3.375rem;
}">

                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">@<?php echo $_SESSION['name']; ?></span>
                                <img class="img-profile rounded-circle" src="https://cdn-icons-png.flaticon.com/512/149/149071.png">
                            </a>

                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Hello <?php echo $_SESSION['name']; ?>!</h1>

                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Todo</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $countTodo . " Task" ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                In Progress</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $countProgress . " Task" ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">In Review
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $countReview . " Task" ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Done</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $countDone . " Task" ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-xl-3 col-lg-5">

                            <div class="card shadow mb-4 " id="todo-section">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Todo's</h6>
                                    <div class="dropdown no-arrow ">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="flex flex-col" id="todo" ondragover="allowDrop(event)" ondrop="drop(event, 'TODO')">
                                    <!-- dynamic content -->
                                    <?php
                                    mysqli_data_seek($result, 0);
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            if ($row['belong'] == "TODO") {
                                                $draggable = ($row['pid'] == $_SESSION['id']) ? 'draggable="true" ondragstart="drag(event)"' : '';
                                                echo '<div class="m-2 list" onclick="updatePopup(' . $row['id'] . ')" ' . $draggable . ' id="' . $row['id'] . '">
                    <div class="card bg-primary text-white shadow">
                        <div class="card-body">' . $row['name'] . '
                            <div class="text-white-50 small text-sm">' . $row['title'] . '</div>
                        </div>
                    </div>
                </div>';
                                            }
                                        }
                                    }
                                    ?>
                                </div>


                            </div>

                        </div>
                        <div class=" col-xl-3 col-lg-5">
                            <div class="card shadow mb-4 " id="in-progress-section">
                                <div class="card-header  py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">In Progress</h6>
                                </div>
                                <div class="flex flex-col" id="progress" ondragover="allowDrop(event)" ondrop="drop(event, 'PROGRESS')">
                                    <!-- dynamic content -->
                                    <?php
                                    mysqli_data_seek($result, 0);
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            if ($row['belong'] == "PROGRESS") {
                                                $draggable = ($row['pid'] == $_SESSION['id']) ? 'draggable="true" ondragstart="drag(event)"' : '';
                                                echo '<div class="m-2 list" ' . $draggable . ' id="' . $row['id'] . '">
                    <div class="card bg-warning text-white shadow">
                        <div class="card-body">' . $row['name'] . '
                            <div class="text-white-50 small text-sm">' . $row['title'] . '</div>
                        </div>
                    </div>
                </div>';
                                            }
                                        }
                                    }
                                    ?>
                                </div>

                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">In Review</h6>
                                </div>
                                <div class="flex flex-col" id="review" ondragover="allowDrop(event)" ondrop="drop(event, 'REVIEW')">
                                    <!-- dynamic content -->
                                    <?php
                                    mysqli_data_seek($result, 0);
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            if ($row['belong'] == "REVIEW") {
                                                echo '<div class="m-2 list" onclick=updatePopup(' . $row['id'] . ')  id="' . $row['id'] . '">
                        <div class="card bg-info text-white shadow">
                            <div class="card-body">' . $row['name'] . '
                                <div class="text-white-50 small text-sm">' . $row['title'] . '</div>
                            </div>
                        </div>
                    </div>';
                                            }
                                        }
                                    }
                                    ?>
                                </div>

                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-5">
                            <div class="card shadow mb-4 dropzone">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Done</h6>
                                </div>
                                <div class="flex flex-col" id="done" ondragover="allowDrop(event)" ondrop="drop(event, 'DONE')">
                                    <!-- dynamic content -->
                                    <?php
                                    mysqli_data_seek($result, 0);
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            if ($row['belong'] == "DONE") {
                                                echo '<div class="m-2 list" id="' . $row['id'] . '">
                        <div class="card bg-success text-white shadow">
                            <div class="card-body">' . $row['name'] . '
                                <div class="text-white-50 small text-sm">' . $row['title'] . '</div>
                            </div>
                        </div>
                    </div>';
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; PMS 2024</span>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <!-- popup for update task -->
        <div id="popup2" class="popup">
            <div class="popup-content">
                <h4>Details</h4>
                <section>
                    <div class="input-group mb-3">

                        <input type="hidden" id="<?php ?>" name="taskId" value="">
                        <h6 id="updateName">@</h6>
                    </div>
                    <div class="input-group mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Title</label><br>
                        <h2 id="updateTask" name="task">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Description</label><br>
                        <p id="updatedesc"></p>
                    </div>
                </section>
                <button id="closePopup2" class="btn btn-danger">Close</button>
            </div>
        </div>

        <script>
            // to see the details of the work
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('closePopup2').onclick = function() {
                    document.getElementById('popup2').style.display = "none";
                }
                window.onclick = function(event) {
                    if (event.target == document.getElementById('popup2')) {
                        document.getElementById('popup2').style.display = "none";
                    }
                }
            });


            function updatePopup(taskId) {
                // Get the modal
                var upopup = document.getElementById('popup2');
                let updateBtn = document.getElementById('updateBtn');

                upopup.style.display = "block";

                // when popup is appear
                $.ajax({
                    url: 'update.php',
                    type: 'GET',
                    data: {
                        id: taskId,
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            var data = response.data;
                            document.getElementById('updateName').textContent = "@" + data.name;
                            document.getElementById('updateTask').innerHTML = data.title;
                            document.getElementById('updatedesc').innerHTML = data.description;

                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX Error:', textStatus, errorThrown);
                    }
                });
            }



            function logout() {
                $.ajax({
                    url: './auth/logout.php',
                    type: 'GET',
                    success: function(response) {
                        window.location.href = "auth/login.php";
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX Error:', textStatus, errorThrown);
                    }
                });
            }

            // Function to handle drag event
            function drag(ev) {
                ev.dataTransfer.setData("taskID", ev.target.id);
            }
            // Function to allow dropping elements
            function allowDrop(ev) {
                ev.preventDefault();
            }
            // Function to handle drop event
            function drop(ev, category) {
                ev.preventDefault();
                var taskID = ev.dataTransfer.getData("taskID");
                var taskElement = document.getElementById(taskID);
                console.log('Task ID:', taskID, 'Category:', category, 'Task Element:', taskElement);

                var taskId = taskElement.id;
                $.ajax({
                    url: 'update.php',
                    type: 'POST',
                    data: {
                        taskId: taskId,
                        category: category
                    },
                    success: function(response) {
                        // refresh page
                        window.location.href = "./dashboard.php";
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX Error:', textStatus, errorThrown);
                    }
                });

            }
        </script>
</body>

</html>