<?php  
session_start();
include 'config.php';
$ReqId = $_GET['ReqId'] ?? '';
$sql = "select ReqId, ReqNumber, username, ct.description, ReqDate from Requsition rn join cplusers cs
on rn.userId = cs.userId join cpldepartment ct on rn.departmentId = ct.departmentId where ReqId=$ReqId";
$result = sqlsrv_query($conn, $sql);

$Reqlineid = $_GET['Reqlineid'] ?? '';
$sql2 = "select Reqlineid, itemdescription,actualprice, quantity,supplier,suppliername,description,Quote_id,amount from Requisitionlines rs 
join cpldepartment ct on rs.departmentId = ct.departmentId where ReqId=$ReqId";
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
                    <div class="card mb-4">
                    <div id = "requisition_header">
                        <?php
                        while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ) {?>
                        <h1>REQUISITION FORM</h1>
                    <!-- Fetching the reqnumber from the database giving it a readonly attribute -->
                        <label>REQUISITION NUMBER:</label><input type="text" name="Reqnumber" id="reqno" value = "<?php echo $row['ReqNumber'] ?>" disabled/>
                        <br/>
                        <label>DATE REQUESTED:</label>
                        
                        <input type="text"  name="Reqdate" id = "datereq" value = "<?php echo  $row['ReqDate']->format('d/m/Y')?>" disabled/><br/>
                        <label>USER ID:</label>
                            <input type="text"  name="userid" id = "userid" value ="<?php echo $row['username'] ?>" disabled/>
                        <br/>
                        <label>DEPARTMENT:</label>
                        <input type="text"  name="department2" id = "department2" value ="<?php echo $row['description'] ?>" disabled/> <br/>    
                    <?php }?>
                        </div>
                    </div>
                    <hr>
                    <table class = "table table-bordered" id = "table_field">
                        <tr>
                        <th hidden><input type="checkbox" class="itemrow" name="checkall" id="checkall" hidden/></th>
                        <th>Item Description</th>
                        <th>Quantity</th>
                        <th>Actual Price</th>
                        <th>Supplier</th>
                        <th>Supplier Name</th>
                        <th>Approve-quote</th>
                        <th>Department_id</th>
                        <th>Amount</th>
                        <th></th>
                        
                        </tr>
                        <?php
                        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) { ?>
                                <tr>
                                <input type = "text" name="Reqlineid[]" value = "<?php echo $row['Reqlineid']?>" hidden />
                                <td hidden><input type="checkbox" class="itemrow" id="itemrow1" hidden/></td>
                                <td><input id="itemdescription1" class = "form-control " type="text" name = "itemdescription[]" value = "<?php echo $row['itemdescription']; ?>" /></td>
                                <td><input id="quantity1" class = "form-control" type="number"  name = "quantity[]"  value = "<?php echo $row['quantity'] ?>" /></td>
                                <td><input id="actualprice1" class = "form-control" type="number"  name = "actualprice[]" value = "<?php echo $row['actualprice'] ?>" /></td>
                                <td><input id="supplier1" class = "form-control" type="text"  name = "supplier[]" value = "<?php echo $row['supplier'] ?>"  /></td>
                                <td><input id="suppliername1" class = "form-control" type="text"  name = "suppliername[]" value = "<?php echo $row['suppliername'] ?>" /></td>
                                <td><button class = "btn btn-primary approvebtn" id = "<?php echo $row['Reqlineid']?>">Quotation</button></td>
                                <td><input id="department1" class = "form-control" type="text"  name = "department[]" value = "<?php echo $row['description'] ?>" readonly /></td>
                                <td><input id="amount1" class = "form-control" type="number"  name = "amount[]" value = "<?php echo $row['amount'] ?>" /></td>
                                <td>
                                    <select id="choice1" name = "choice[]" style ="width:124px" class = "form-select">
                                    <option value = " " hidden>Approve Item</option>   
                                    <option value = "1">Approved</option>
                                    <option value = "2">Rejected</option>
                                    </select>
                                </td>
                            </tr>
                        <?php } ?>
                     </table>
                        <center>
                        <button class = "btn btn-success" type = "submit" name = "update" id = "update">Save Changes</button>
                        </center>
                </div>
                    <?php 

                    include 'config.php';


                    $sql = "select approvequote_id, Quote_no, qs.itemdescription, qs.quantity, Unit_price, total_amt_incl from cplquotationlines as qs join cplquotation 
                    on cplquotation.Quote_id = qs.Quote_id join Requisitionlines as rs on rs.Quote_id = cplquotation.Quote_id 
                    join cplapprovequote on cplapprovequote.Reqlineid = rs.Reqlineid where rs.Reqlineid = $Reqlineid";

                    $result = sqlsrv_query($conn, $sql);

                    ?>
                        <!-- Modal -->
                    
                    <div class="modal" id = "myModal">
                    <div class="modal-dialog  modal-xl">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Quotations</h5>
                        </div>
                        <form action=" " method="POST">
                        <div class="modal-body">
                           
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name = "save_changes">Save changes</button>
                        </div>
                         </form>
                </div>
            </div>
                        
    </main>
</div>
<script>
$(document).ready(function () {
    $('.approvebtn').click(function () { 
    
      var id_reqline = $(this).attr('id');
       $.ajax({
           method:"post",
           url: "popupmodal.php",
           data: {Reqlineid:id_reqline},
           success: function (result) {
              $(".modal-body").html(result);
       }});
        $('#myModal').modal('show');
        
    });
    

});
</script>
        <script>
            $(document).ready(function () {
                $('#update').click(function () { 
                   
                var Reqlineid=[];
                //push item description array
                $('input[name^="Reqlineid"]').each(function() {
                    Reqlineid.push(this.value);
                });
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
        
                var choice = [];
                $('select[name^="choice"]').each(function () {
                    choice.push(this.value);
                });

                    $.ajax({
                        type: "POST",
                        url: "updateform.php",
                        data: {Reqlineid:Reqlineid, itemdescription:itemdescription, quantity:quantity, actualprice:actualprice,
                        supplier:supplier, suppliername:suppliername, amount:amount, choice:choice},
                        success: function (result) {
                            alert(result);
                        },
                    }); 
                });
            });
        </script>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>
<?php 
                       
                       include("config.php");
                       if(isset($_POST["save_changes"])) {
                           foreach ($_POST["check"] as $key => $value){
                               $id=$_POST["check"][$key];
                               $update="update cplapprovequote set status=1 from cplapprovequote where approvequote_id=$id";
                               sqlsrv_query($conn, $update);
                           }
                           // header('Location:viewform.php'); 
                       }   
                       
                       ?>

