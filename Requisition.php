<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/styles.css" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <title>REQ FORM</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
       
    </style>

    <!-- Using jquery to add input fields and remove them dynamically inside a table -->
    <script type = "text/javascript">
          $(document).ready(function(){
            //Get the number of rows
            var count = $(".itemrow").length;
            var x = 1;
            //to add rows
            $('#add').click(function () {
                <?php include('phpfunctions.php');?>
                //counter
                count++;
                var html = '<tr><td hidden><input id="itemrow'+count+'" class = "itemrow" type="checkbox"  name = "itemrow" required hidden/></td><td><input class = "form-control" id="itemdescription'+count+'" type="text"  name = "itemdescription[]" required/></td><td><input id="quantity'+count+'" class = "form-control" type="number"  name = "quantity[]" required/></td><td><input id="expectedprice'+count+'" class = "form-control" type="number"  name = "expectedprice[]" required/></td><td><input id="actualprice'+count+'" class = "form-control" type="number"  name = "actualprice[]"/></td><td><input id="supplier'+count+'" class = "form-control" type="text"  name = "supplier[]" /></td><td><input class = "form-control" type="text" id="suppliername'+count+'" name = "suppliername[]" required/></td><td><input class = "form-control" type="text" id="approvequoteid'+count+'"  name = "approvequoteid[]" /></td><td><SELECT id="department'+count+'" style="height:5%; width:100px;" class="form-control" name="department1[]" onchange="document.write(<?php readdepartment(); ?></SELECT></td><td><input class = "form-control" type="number" id="amount'+count+'"  name = "amount[]" required/></td><td><select name = "choice[]" class = "form-control" disabled id="choice'+count+'" ><option value = " " selected>Approve Item</option><option value = "approved">Approved</option><option value = "rejected">Rejected</option><option value = "pending">Pending</option></select></td><td><input class = "btn btn-warning" type = "button" name = "remove" id = "remove" value = "Remove"></td></tr>';
                $("#table_field").append(html);
            });
            //to remove rows
            $('#table_field').on('click', '#remove',function () {
                $(this).closest('tr').remove();
            })
            
            // closest-method searches through these elements and their ancestors in the DOM tree and constructs a new jQuery object from the matching elements

        });
    </script>

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
    <form action="connector.php" method="POST" id= "insert_form" >
        <div id = "requisition_header">
        <h1>REQUISITION FORM</h1>
        <!-- Fetching the reqnumber from the database giving it a readonly attribute -->
             <label>REQUISITION NUMBER:</label><input type="text" name="Reqnumber" id="reqno" value ='<?php
             include('config.php');
             $sql = "select ('REQ' + cast(format(nextno,'00000') as varchar)) as reqnumber from cplreqdf"; 
             $stmt = sqlsrv_query($conn,$sql);
             while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {
                     echo $row["reqnumber"];
             }
             sqlsrv_close($conn); 
            ?>' readonly/>
            <br/>
            <label>DATE REQUESTED:</label>
            
            <input type="text"  name="Reqdate" id = "datereq"  value = '
            <?php
               echo date('Y-m-d'); 
            ?>
            'readonly/><br/>
            <label>USER ID:</label>
            <?php
                include('config.php');
                $sql = "select * from cplusers";
                $stmt = sqlsrv_query($conn, $sql);
                if($stmt) {
                    echo "<select name = 'userid' id = 'userid'  required>";
                    while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                    echo "<option value = '" .$row["userId"] . "'> " .$row["username"]."</option>";
                    }
                   echo "</select>";
                }
                sqlsrv_close($conn);
            ?>
            <br/>
            <label>DEPARTMENT:</label>
            <?php
                include('config.php');
                $sql = "select * from cpldepartment";
                $stmt = sqlsrv_query($conn, $sql);
                if($stmt) {
                    echo "<select name ='department2' id ='department2'  required>";
                    while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                    echo "<option value = '" .$row["departmentId"] . "'> " .$row["description"]."</option>";
                    }
                   echo "</select>";
                }
                sqlsrv_close($conn);
            ?>
            
            <br/>
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
                    <th>Approve Quote_id</th>
                    <th>Department_id</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                <tr>
                    <td hidden><input type="checkbox" class="itemrow" id="itemrow1" hidden/></td>
                    <td><input id="itemdescription1" class = "form-control " type="text" name = "itemdescription[]" required/></td>
                    <td><input id="quantity1" class = "form-control" type="number"  name = "quantity[]" required/></td>
                    <td><input id="expectedprice1" class = "form-control" type="number"  name = "expectedprice[]" required/></td>
                    <td><input id="actualprice1" class = "form-control" type="number"  name = "actualprice[]" /></td>
                    <td><input id="supplier1" class = "form-control" type="text"  name = "supplier[]" /></td>
                    <td><input id="suppliername1" class = "form-control" type="text"  name = "suppliername[]" required/></td>
                    <td><input id="approvequoteid1" class = "form-control" type="text"  name = "approvequoteid[]" /></td>
                    <td><?php
                        include('config.php');
                        $sql = "select * from cpldepartment";
                        $stmt = sqlsrv_query($conn, $sql);
                        if($stmt) {
                            echo "<select class = 'form-control' name ='department1[]' id ='department1'  required>";
                            while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                            echo "<option value = '" .$row["departmentId"] . "'> " .$row["description"]."</option>";
                            }
                        echo "</select>";
                        }
                        sqlsrv_close($conn);
                    ?></td>
                    <td><input id="amount1" class = "form-control" type="number"  name = "amount[]" required/></td>
                    <td>
                        <select id="choice1" name = "choice[]" style ="width:124px" class = "form-control" disabled>
                        <option value = " " selected>Approve Item</option>   
                        <option value = "approved">Approved</option>
                        <option value = "rejected">Rejected</option>
                        <option value = "pending">Pending</option>
                        </select>
                    </td>
                    <td><input class = "btn btn-danger" type = "button" name = "add" id = "add" value = "Add Row"></td>
                </tr>
            </table>
            <center>
            <button class = "btn btn-success" type = "submit" name = "save" id = "save">Save Data</button>
            </center>
        </div>
        <script>
            $(document).ready(function(){
            $("#save").click(function(){
                var itemdescription=[];
                //push item description array
                $('input[name^="itemdescription"]').each(function() {
                    itemdescription.push(this.value);
                });
                var quantity=[];
                //push quantity array
                $('input[name^="quantity"]').each(function() {
                    quantity.push(this.value);
                });
                var expectedprice=[];
                //push expected price
                $('input[name^="expectedprice"]').each(function() {
                    expectedprice.push(this.value);
                });
                var actualprice=[];
                //push actual price
                $('input[name^="actualprice"]').each(function() {
                    actualprice.push(this.value);
                });
                var supplier=[];
                //push supplier
                $('input[name^="supplier"]').each(function() {
                    supplier.push(this.value);
                });
                var suppliername=[];
                //push supplier name array
                $('input[name^="suppliername"]').each(function() {
                    suppliername.push(this.value);
                });
                var amount=[];
                //push amount array
                $('input[name^="amount"]').each(function() {
                    amount.push(this.value);
                });
                var approvequoteid=[];
                //push approvequoteid array
                $('input[name^="approvequoteid"]').each(function() {
                    approvequoteid.push(this.value);
                });
                var department1=[];
                //push amount array
                $('select[name^="department1"]').each(function() {
                    department1.push(this.value);
                });
                $.ajax({
                    url: 'connector.php',
                    type: 'post',
                    data: {itemdescription:itemdescription, quantity:quantity,expectedprice:expectedprice,
                        actualprice:actualprice,supplier:supplier,
                        suppliername:suppliername,amount:amount,department1:department1,approvequoteid:approvequoteid,
                        userid:$('#userid').val(),department2:$('#department2').val()
                    },
                    success: function(result){
                            alert(result);
                        }}); 
                        
                        });
                        $('#insert_form')[0].reset();
            });
        </script>
    </form>       
    </div>    
    </div>
    </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
</body>
</html>


