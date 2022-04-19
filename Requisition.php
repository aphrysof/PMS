<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <title>REQ FORM</title>
</head>

<style>
    .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn){
        width: 100%;
    }
</style>
  <!-- Using jquery to add input fields and remove them dynamically inside a table -->
  <?php
     include 'phpfunctions.php';
     ?> 
    <script type = "text/javascript">
          $(document).ready(function(){
           
            //Get the number of rows
            var count = $(".itemrow").length;
            var x = 1;
            //to add rows
            $('#add').click(function () {
                
                //counter
                count++;
                var html = '<tr><td hidden><input id="itemrow'+count+'" class = "itemrow" type="checkbox"  name = "itemrow" hidden/></td><td><input class = "form-control" id="itemdescription'+count+'" type="text"  name = "itemdescription[]" required/></td>';
                html += '<td><input id="quantity'+count+'" class = "form-control" type="text"  name = "quantity[]" required/></td>';

                $(document).on('keyup','#quantity'+count+',#actualprice'+count+'', function(){
                    var qty = $('#quantity'+count+'').val();
                    var price =$('#actualprice'+count+'').val();
                    var amount  = qty * price;
                    $('#amount'+count+'').val(parseFloat(amount.toFixed(2)));

                });
                html += '<td><input id="actualprice'+count+'" class = "form-control" type="text"  name = "actualprice[]"/></td><td><input id="supplier'+count+'" class = "form-control" type="text"  name = "supplier[]" /></td><td><input class = "form-control" type="text" id="suppliername'+count+'" name = "suppliername[]" required/></td>';
               html +=' <td><select id="department'+count+'" name="department1[]" style="height:5%;" class="form-select" onchange="document.write<?php readdepartment();?></select></td><td><input class = "form-control" type="text" id="amount'+count+'"  name = "amount[]" required/></td></td><td><button class = "btn btn-danger d-flex align-items-center" id = "remove" name = "remove"><i class="fa-solid fa-minus"></i> Item</button></td></tr>';
                $("#table_field").append(html);

            });
            //to remove rows
            $('#table_field').on('click', '#remove',function () {
                $(this).closest('tr').remove();
            });
            
            // closest-method searches through these elements and their ancestors in the DOM tree and constructs a new jQuery object from the matching elements


          $("#actualprice1 ,#quantity1" ).on('keyup', function() { 

            var qty = $("#quantity1").val();
            var price =$("#actualprice1").val();
            var amount  = qty * price;
            $("#amount1").val(parseFloat(amount.toFixed(2)));

            });  
            
        });
    </script>
<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="#">PMS</a>
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
    <form method = "post" action = "insertreq.php">
    <div class = "card">
             <div class="card-header text-center">
                <h3>Create Requisition</h3>
            </div>
            <div class="card-body">
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label ms-4" >Req Number:</label>
                     <div class="col-sm-3">
                    <input type="text" type="text" name="Reqnumber" id="Reqnumber" class = "form-control" value ='<?php
                    include('config.php');
                    $sql = "select ('REQ' + cast(format(nextno,'00000') as varchar)) as reqnumber from cplreqdf"; 
                    $stmt = sqlsrv_query($conn,$sql);
                    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {
                            echo $row["reqnumber"];
                    }
                    sqlsrv_close($conn); 
                    ?>' disabled>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label ms-4">Date:</label>
                        <div class="col-sm-3">
                        <input type="text" class="form-control" id="date" name = "date" value = "
                        <?php
                        echo date('Y/m/d'); 
                        ?>
                        " disabled>
                        </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label ms-4">Select Department:</label>
                     <div class="col-sm-3">
                     <?php
                    include('config.php');
                    $sql = "select * from cpldepartment";
                    $stmt = sqlsrv_query($conn, $sql);
                    if($stmt) {
                        echo "<select name ='department2' id ='department2' class = 'form-select' data-live-search='true'  required>";
                        echo "<option value = 0 hidden>Select Department</option>";
                        while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                        echo "<option value = " .$row["departmentId"] . "> " .$row["description"]."</option>";
                        }
                       echo "</select>";
                    }
                    sqlsrv_close($conn);
                    ?>
                    </div>
                </div>
                <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label ms-4">Select User:</label>
                            <div class="col-sm-3"> 
                                <?php
                                    include('config.php');
                                    $sql = "select * from cplusers";
                                    $stmt = sqlsrv_query($conn, $sql);
                                    if($stmt) {
                                        echo "<select name = 'userid' id = 'userid' class = 'form-select'  required>";
                                        echo "<option value = 0 hidden>Select user</option>";
                                        while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                        echo "<option value = " .$row["userId"] . "> " .$row["username"]."</option>";
                                        }
                                    echo "</select>";
                                    }
                                    sqlsrv_close($conn);
                                 ?>  
                            </div> 
                        </div>
            </div>
            <hr>
                <div  class = "input--field">
                <table class = "table table-bordered" id = "table_field">
                <tr>
                    <th hidden><input type="checkbox" class="itemrow" name="checkall" id="checkall"  hidden/></th>
                    <th>Item Description</th>
                    <th>Quantity</th>
                    <th>Unit price</th>
                    <th>Supplier</th>
                    <th>Supplier Name</th>
                    <th>Department_id</th>
                    <th>Amount</th>
                    <th></th>
                </tr>
                <tr>
                    <td hidden><input type="checkbox" class="itemrow" id="itemrow1" hidden/></td>
                    <td><input id="itemdescription1" class = "form-control " type="text" name = "itemdescription[]" required/></td>
                    <td><input id="quantity1" class = "form-control" type="text"  name = "quantity[]" required/></td>
                    <td><input id="actualprice1" class = "form-control" type="text"  name = "actualprice[]" /></td>
                    <td><input id="supplier1" class = "form-control" type="text"  name = "supplier[]" /></td>
                    <td><input id="suppliername1" class = "form-control" type="text"  name = "suppliername[]" required/></td>
                    <!-- <a href = 'viewform.php?ReqId=<?php echo $row["ReqId"]; ?>'class = "btn btn-primary" >View</a> -->
                    <td><?php
                        include('config.php');
                        $sql = "select * from cpldepartment";
                        $stmt = sqlsrv_query($conn, $sql);
                        if($stmt) {
                            echo "<select class = 'form-select' name ='department1[]' id ='department1'  required>";
                            while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                            echo "<option value = '" .$row["departmentId"] . "'> " .$row["description"]."</option>";
                            }
                        echo "</select>";
                        }
                        sqlsrv_close($conn);
                    ?></td>
                    <td><input id="amount1" class = "form-control" type="text"  name = "amount[]"  required/></td>
                    <td><button class = "btn btn-danger d-flex align-items-center"  id ="add" name = "add"><i class="fa-solid fa-plus"></i> Item</button></td>   
                </tr>
            </table>
            <center>
            <button class = "btn btn-success"  name = "submit" id = "submit" type = "submit">Save Data</button>
            </center>
                </div>
        </div>
    </form> 
    </div>
    </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>


 


