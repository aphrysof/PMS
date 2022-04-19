<?php
session_start();
?>
<!DOCTYPE html>
<ht6ml lang="en">
    <head>
        <title>Department Form</title>
        <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <link href="css/styles.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
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
                   <span class = 'text-light'>Welcome <?php echo $_SESSION['users'];?> !</span>
                </div>
            </form>
            <!-- Navbar-->
            <div class = "input group">     
                <button type="button" class="btn btn-light mx-3 d-flex justify-content-center align-items-center" style = "position: relative; height: 24px; width: 24px;"><i class="fa-solid fa-bell"></i>
                <span class= "position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
                </button>
            </div>
            <a href = "logout.php" class = "btn btn-primary mx-3" >LOG OUT</a>
        </nav>
<div id="layoutSidenav">
  <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
          <div class="sb-sidenav-menu">
              <div class="nav">
                  <div class="sb-sidenav-menu-heading">Core</div>
                  <a class="nav-link" href="home.php">
                      <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                      Dashboard
                  </a>
                  <a class="nav-link" href="Requisition.php">
                      <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                      Create Requisition
                  </a>
                  <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="true" aria-controls="collapseLayouts">
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
            <!-- Our code  -->
  <div id="layoutSidenav_content">
    <main>
      <div class="container"> 
        <div class = "row justify-content-center">
           <div class = "col-md-8">
              <div class = "card mt-5">
                <div class = "card-header text-center"> 
                  <h2>New Department</h2>
                </div>
               <div class = "card-body">
                 <form action="" method = "post">
                    <div class="form-group">
                       <label for="">Department ID</label>
                           <input type="text" class="form-control" name="Dep_id" required>
                     </div>
                     <div class="form-group">
                       <label for="">Description</label>
                          <input type="text" class="form-control" name="Department_description" required>
                      </div>
                     <center>
                        <input type="submit" class="btn btn-primary" value="create" name = "submit" id = "submit">
                     </center>
                  </form>
               </div> 
             </div>
            </div>
         </div>
        </div>
    </main>
  </div>
<script src="js/scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</html>
</body>

<?php
include('config.php'); 
if(isset($_POST['submit'])){

  $Dep_id=$_POST['Dep_id'];
  $Department_description=$_POST ['Department_description'];
 $insert ="INSERT INTO cpldepartment(departmentId,description,Created_on,Modified_on) VALUES ('$Dep_id','$Department_description', getdate(), getdate())";

 $st=sqlsrv_query($conn,$insert);
 
    if($st){
        echo '<script language="javascript">';
        echo 'alert("message successfully sent")';
        echo '</script>';;
    }else{
      die( print_r( sqlsrv_errors(), true));
    }
}
?>
