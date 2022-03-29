
<?php
include('phpfunctions.php');

if(isset($_POST["submit"])) {
    $groupname = $_POST['groupname'] ?? '';
    $selectdep = $_POST['selectdep'] ?? 0;
    $selectusers = $_POST['selectusers'] ?? 0;
    $role = $_POST['role'] ?? '';
    $createdon = $_POST['createdon'] ?? 0;
    $modifiedon = $_POST['modifiedon'] ?? 0;


    $sql3 = " INSERT INTO cplapprovergroup(userId, description, departmentId,role,created_on,modified_on) 
    VALUES ('$selectusers', '$groupname', '$selectdep', '$role',getdate(), getdate())";
 
    $result = sqlsrv_query($conn, $sql3);
    
if($result) {
    echo '<script language="javascript">';
    echo 'alert("message successfully sent")';
    echo '</script>';
  }else{
    die( print_r( sqlsrv_errors(), true));
  }
// print_r($selectusers);
// print_r($groupname);
// print_r($selectdep);
// print_r($role);
}
// PRINT OUT //
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link href="css/styles.css" rel="stylesheet" />
<!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
    <title>Aprrover group</title>

   
</head>

<script type = "text/javascript">
     $(document).ready(function () {
        $('select').selectpicker();
    });

</script>
<body style = "background: #f0f0f0" class="sb-nav-fixed">
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
                    <a class="nav-link" href="requestsent.php">
                        <div class="sb-nav-link-icon "><i class="fas fa-table"></i></div>
                        Requests Sent
                    </a>
                </div>
            </div>
        </nav>
    </div>
            <!-- Our code -->
    <div id="layoutSidenav_content">
        <main>
            <div class = "container">
                <div class = "row justify-content-center">
                    <div class = "col-md-8">
                        <div class = "card mt-5">
                            <div class = "card-header text-center">
                                <h3>Approver Groups</h3>
                            </div>
                        <div class = "card-body">
                            <form action = "" method = "post">
                                <div class = "col-md-12">
                                    <div class="mb-3">
                                        <label for=" " class="form-label">Group Name:</label>
                                        <input type="text" class="form-control" name = "groupname">
                                    </div>
                                    <div class = "mb-3">
                                        <label for=" " class="form-label">Select department:</label>
                                            <select class = "select form-control" title = "Select department..." name = "selectdep">
                                                <?php echo $option;?>
                                            </select>
                                    </div>
                                    <div class = "mb-3">
                                        <label for=" " class="form-label">Select Users:</label>
                                            <select class="selectpicker form-control" multiple title="Select Users..." name = "selectusers">
                                                <?php echo $options; ?>
                                            </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for=" " class="form-label">Role:</label>
                                            <select>
                                            
                                            </select>
                                    </div>
                                </div>
                                    <center>
                                        <button type = "submit" class = "btn btn-primary" value = "submit" name="submit" id="submit">Submit</button>
                                    </center>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<script src="js/scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>