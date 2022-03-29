<?php  
include 'config.php';

$ReqId = $_GET['ReqId'] ?? '';
$sql = "select ReqId, ReqNumber, userId, departmentId, ReqDate from Requsition where ReqId=$ReqId";
$result = sqlsrv_query($conn, $sql);


$sql2 = "select itemdescription, expectedprice, actualprice, quantity,supplier,suppliername,departmentId,approvequoteid,amount from Requisitionlines where ReqId=$ReqId";
$stmt = sqlsrv_query($conn, $sql2);
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Document</title>
</head>

   <!-- use this field to generate data from the database as per the reqno inserted by the user, use js to hide
        after click  to generate the req form  for approvals -->
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
                            <a class="nav-link" href="requestsent.php">
                                <div class="sb-nav-link-icon "><i class="fas fa-table"></i></div>
                                Requests Sent
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
   <!-- //Our code -->
   <div id="layoutSidenav_content">
   <main>
    <div class="container-fluid px-4 py-4">
        <div class="card mb-4">
    <form action="updateform.php" method="post" id= "update_form" >
        <div id = "requisition_header">
            <?php
            while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ) {?>
            <h1>REQUISITION FORM</h1>
        <!-- Fetching the reqnumber from the database giving it a readonly attribute -->
             <label>REQUISITION NUMBER:</label><input type="text" name="Reqnumber" id="reqno" value = "<?php echo $row['ReqNumber'] ?>" readonly/>
            <br/>
            <label>DATE REQUESTED:</label>
            
            <input type="text"  name="Reqdate" id = "datereq" value = "<?php echo  $row['ReqDate']->format('d/m/Y')?>" readonly/><br/>
            <label>USER ID:</label>
                   <input type="text"  name="userid" id = "userid" value ="<?php echo $row['userId'] ?>" readonly/>
            <br/>
            <label>DEPARTMENT:</label>
            <input type="text"  name="department2" id = "department2" value ="<?php echo $row['departmentId'] ?>" readonly/> <br/>    
          <?php }?>
            </div>
        </div>
        <hr>
        <div class = "input--field">
            <table class = "table table-bordered" id = "table_field">
                <tr>
                    <th hidden><input type="checkbox" class="itemrow" name="checkall" id="checkall" hidden/></th>
                    <th>Item Description</th>
                    <th>Quantity</th>
                    <th>Expected Price</th>
                    <th>Actual Price</th>
                    <th>Supplier</th>
                    <th>Supplier Name</th>
                    <th>Approve quote_id</th>
                    <th>Department_id</th>
                    <th>Amount</th>
                    <th>Status</th>
                    
                </tr>
                    <?php
                    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) { ?>
                            <tr>
                            <td hidden><input type="checkbox" class="itemrow" id="itemrow1" hidden/></td>
                            <td><input id="itemdescription1" class = "form-control " type="text" name = "itemdescription[]" value = "<?php echo $row['itemdescription']; ?>" /></td>
                            <td><input id="quantity1" class = "form-control" type="number"  name = "quantity[]"  value = "<?php echo $row['quantity'] ?>" /></td>
                            <td><input id="expectedprice1" class = "form-control" type="number"  name = "expectedprice[]" value = "<?php echo $row['expectedprice'] ?>"  /></td>
                            <td><input id="actualprice1" class = "form-control" type="number"  name = "actualprice[]" value = "<?php echo $row['actualprice'] ?>" /></td>
                            <td><input id="supplier1" class = "form-control" type="text"  name = "supplier[]" value = "<?php echo $row['supplier'] ?>"  /></td>
                            <td><input id="suppliername1" class = "form-control" type="text"  name = "suppliername[]" value = "<?php echo $row['suppliername'] ?>" /></td>
                            <td><input id="approvequoteid1" class = "form-control" type="text"  name = "approvequoteid[]"  value = "<?php echo $row['approvequoteid'] ?>" /></td>
                            <td><input id="department1" class = "form-control" type="text"  name = "department[]" value = "<?php echo $row['departmentId'] ?>" readonly /></td>
                            <td><input id="amount1" class = "form-control" type="number"  name = "amount[]" value = "<?php echo $row['amount'] ?>" /></td>
                            <td>
                                <select id="choice1" name = "choice[]" style ="width:124px" class = "form-control">
                                <option value = " " selected>Approve Item</option>   
                                <option value = "approved">Approved</option>
                                <option value = "rejected">Rejected</option>
                                </select>
                            </td>
                        </tr>
                    <?php } ?>
            </table>
            <center>
            <button class = "btn btn-success" type = "submit" name = "update" id = "save">Update Data</button>
            </center>
        </div>
</body>
</html>

