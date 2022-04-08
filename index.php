<?php
    
    include 'config.php';
    $sql = "select ReqId, ReqNumber, username, ct.description, ReqDate from Requsition rn join cplusers cs
    on rn.userId = cs.userId join cpldepartment ct on rn.departmentId = ct.departmentId";
    $result = sqlsrv_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>PMS</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">PMS</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <div class = "input group">     
                <button type="button" class="btn btn-light mx-3 d-flex justify-content-center align-items-center" style = "position: relative; height: 24px; width: 24px;"><i class="fa-solid fa-bell"></i>
                <span class= "position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
                </button>
            </div>

            <ul class="navbar-nav ms-auto ms-md-0 me-2 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="#!">Logout</a></li>
                    </ul>
                </li>
            </ul>

        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link" href="Requisition.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Create Requisition
                            </a>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-plus"></i></div>
                                Create
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="suppliersform.php">New Supplier</a>
                                    <a class="nav-link" href="quotation.php">New Quotation</a>
                                    <a class="nav-link" href="approvergroup.php">New Approver Group</a>
                                    <a class="nav-link" href="department.php">New Department</a>
                                </nav>
                            </div>
                            <!-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages"> -->
                                <!-- <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Pages
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                            </div> -->
                            <a class="nav-link" href="requestsent.php">
                                <div class="sb-nav-link-icon "><i class="fas fa-table"></i></div>
                                Requests Sent
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4 py-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Requests
                            </div>
                            <div class="card-body">
                            <table class="table table-hover" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Requisition Number</th>
                                        <th scope="col">User</th>
                                        <th scope="col">Department</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <?php 
                                
                                while( $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                               
                                    ?>
                                    <tr>
                                        <td><?php echo $row['ReqId']?></td>
                                        <td><?php echo $row['ReqNumber'] ?></td>
                                        <td><?php echo $row['username']?></td>
                                        <td><?php echo $row['description']?></td>
                                        <td><?php echo $row['ReqDate']->format('d/m/Y')?></td>
                                        <td><a href = 'viewform.php?ReqId=<?php echo $row["ReqId"]; ?>'class = "btn btn-primary" >View</a></td>
                                    </tr>
                                    <?php } ?>
                            </table>    
                            </div>
                        </div>
                    </div>
                </main>
            </div>
           
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
<?php 
include('config.php');



?>