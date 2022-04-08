<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link href="css/styles.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Suppliersform</title>
</head>
<script>
    $(document).ready(function () {
      
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
                <h3>Suppliers Form</h3>
             </div>
            <div class = "card-body">
              <form action = "" method = "post"> 
                  <div class="mb-3 col-md-12">
                   <label class="form-label">Supplier No</label>
                      <input type="text" id = "supplierno" name = "supplierno" class="form-control" placeholder = "" value = "<?php
                       include('config.php');
                       $sql = "select ('SUP' + cast(format(nextno,'00000') as varchar)) as supplierno from cplsupno"; 
                       $stmt = sqlsrv_query($conn,$sql);
                       while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {
                               echo $row["supplierno"];
                       }
                       sqlsrv_close($conn); 
                      ?>" readonly>
                  </div>
                   <div class="mb-3 col-md-12">
                      <input type="text" class="form-control" name= "suppliername"  placeholder = "Supplier Name" >
                    </div>
                    <div class="mb-3 col-md-12">
                      <input type="email" class="form-control" placeholder="supplier@example.com" name = "emailaddress">
                     </div>
                    <div class="mb-3 col-md-12">
                      <input type="text" class="form-control" name = "streetaddress"  placeholder = "streetaddress" >
                    </div>
                     <div class = "row">
                          <div class="col-md-6">
                           <label  class="form-label">City</label>
                             <input type="text" class="form-control" name = "city">
                        </div>
                        <div class="col-md-6">
                          <label  class="form-label">Country</label>
                            <select class="form-select" name = "country">
                              <option selected>Choose...</option>
                              <option>Kenya</option>
                              <option>Uganda</option>
                              <option>Tanzania</option>
                           </select>
                        </div>
                     </div>    
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Telephone</label>
                          <input type="tel" class="form-control" name = "telephone">
                     </div>
                     <center>
                      <input type = "submit" class = "btn btn-primary btn-lg" value = "Submit" name = "submit">
                      </center>
                  </form>
              </div>
            </div>
          </div>
       </div>
      </div>
    </main>
  </div>
</div>
</body>
<script src="js/scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</html>
<?php
include('config.php');
if(isset($_POST['submit'])){

 
$suppliername = $_POST['suppliername'] ?? '';
$emailaddress = $_POST['emailaddress'] ?? '';
$streetaddress = $_POST['streetaddress'] ?? '';
$country = $_POST['country'] ?? '';
$city = $_POST['city'] ?? '';
$telephone = $_POST['telephone'] ?? 0;


$sql = "
DECLARE @sup as varchar(50)

set @sup= (select ('SUP' + cast(format(nextno,'00000') as varchar)) from cplsupno);

INSERT INTO cplsuppliers(suppliernumber,suppliername,Telephone_no,email_address,streetaddress,city,country,created_on,modified_on)
VALUES(@sup,'$suppliername', '$emailaddress','$streetaddress','$country', '$city','$telephone', getdate(), getdate())";

$stmt = sqlsrv_query($conn, $sql);

$updatereqno="

    update cplsupno set nextno=nextno+1 from cplsupno";
    sqlsrv_query($conn, $updatereqno);

if($stmt) {
  echo '<script language="javascript">';
  echo 'alert("message successfully sent")';
  echo '</script>';
}else{
  die( print_r( sqlsrv_errors(), true));
}
}
?>





