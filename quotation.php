<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <title>Create Quotation</title>
</head>
<script type = "text/javascript">
    $(document).ready(function () {
        var count = $(".itemrow").length;
        $("#additem").click(function () { 
        count++;
        var html = '<tr><td hidden><input type="checkbox" class="itemrow" id="itemrow'+count+'" name="itemrow" hidden/></td><td><input id = "description'+count+'" type = "text" class = "form-control" name = "itemdescription[]" autocomplete = "off"></td><td><input id= "quantity'+count+'" type = "text" class = "form-control" autocomplete = "off" name= "quantity[]"></td>';
        html += '<td><input id = "unitprice'+count+'" type = "text" class = "form-control" name = "unitprice[]" autocomplete = "off"></td><td><input id= "exclprice'+count+'" type = "text" class = "form-control"  name = "exclprice[]" value = 0 disabled></td><td><input id ="tax'+count+'" type = "text" class = "form-control" name = "vat[]" value = 0 disabled></td>';
    //    Dynamisc lines code tax calculations
        $(document).on('keyup','#unitprice'+count+',#quantity'+count+'', function(){
                    var unitp = $('#unitprice'+count+'').val();
                    var qty =$('#quantity'+count+'').val();

                    var amount =  qty * unitp;
                    var excl = amount / 1.16 ;
                    $('#exclprice'+count+'').val(parseFloat(excl.toFixed(2)));
                    var vat = amount - excl ;
                    $('#tax'+count+'').val(parseFloat(vat.toFixed(2)));
                    var incl = excl + vat ;
                    $('#inclprice'+count+'').val(parseFloat(incl.toFixed(2)));
                    
                });
            
$(document).on('keyup','#unitprice'+count+',#quantity'+count+'', function(){ 
        //$('#unitprice'+count+', #quantity'+count+'').keyup(function () {                 
            var totalAmount = 0; 
            $("[id^='exclprice']").each(function() {
                
                var id = $(this).attr('id');
                id = id.replace("exclprice",'');
                var price = $('#exclprice'+id).val();
                var total = (parseFloat(price));
                //$('#total_'+id).val(parseFloat(total));
                totalAmount += total;
            });
            $('#totalexclusive').text(parseFloat(totalAmount.toFixed(2)));
            var taxamt=0;
            taxamt=totalAmount*0.16;
            $('#totalvat').text(parseFloat(taxamt.toFixed(2)));
            var totinc=0;
            totinc=totalAmount+=(totalAmount*0.16);
            $('#totalinclusive').text(parseFloat(totinc.toFixed(2)));
     });
         html += '<td><input id = "inclprice'+count+'" type = "text" class = "form-control" name = "inclprice[]" value = 0 disabled></td><td><button class = "btn btn-danger d-flex align-items-center" id = "removeitem"><i class="fa-solid fa-minus"></i> Item</button></td></tr>';
        $("#tables").append(html);
        });
        $('#tables').on('click', '#removeitem',function () {
                $(this).closest('tr').remove();
        });
        
        $('select').selectpicker();
        // Code for calculating tax 
        $("#unitprice1, #quantity1").keyup(function () { 
            var unitp = $('#unitprice1').val();
            var qty = $('#quantity1').val();

            var amount =  qty * unitp;
            var excl = amount / 1.16 ;
            $("#exclprice1").val(parseFloat(excl.toFixed(2)));
            var vat = amount - excl ;
            $("#vat1").val(parseFloat(vat.toFixed(2)));
            var incl = excl + vat ;
            $("#inclprice1").val(parseFloat(incl.toFixed(2)));
        });

    });
</script>
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

 <!-- our code -->
<div  id="layoutSidenav_content">
   <div class = "container-fluid px-4 py-4">
        <div class = "card">
             <div class="card-header text-center">
                <h3>Create Quotation</h3>
            </div>
            <div class="card-body">
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label ms-4" >Quotation Number:</label>
                     <div class="col-sm-3">
                    <input type="text" class="form-control text-center" id="quotationnumber" name = "quotenumber[]" value = "<?php
                     include('config.php');
                     $sql = "select ('QUOT' + cast(format(nextno,'00000') as varchar)) as quotenumber from cplquotedf"; 
                     $stmt = sqlsrv_query($conn,$sql);
                     while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {
                             echo $row["quotenumber"];
                     }
                     sqlsrv_close($conn); 
                    ?>" disabled>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label ms-4">Date:</label>
                        <div class="col-sm-3">
                        <input type="text" class="form-control" id="date" name = "date" value = "
                        <?php
                        echo date('Y-m-d'); 
                        ?>
                        " disabled>
                        </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label ms-4">Select Supplier:</label>
                     <div class="col-sm-3">
                     <?php
                    include('config.php');
                    $sql = "select * from cplsuppliers";
                    $stmt = sqlsrv_query($conn, $sql);
                    if($stmt) {
                    echo "<select name = 'supplierid' class = 'form-control' data-live-search='true' id = 'supplierid' required>";
                    echo "<option value = ''>Select user</option>";
                    while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                    echo "<option value = " .$row["supplierId"] . "> " .$row["suppliername"]."</option>";
                    }
                   echo "</select>";
                    }
                    ?>
                    </div>
                </div>
            </div>
                <hr>
                <div  class = "input--field">
                        <table class = "table table-bordered" id = "tables">
                        <tr>
                            <th hidden><input type="checkbox" class="itemrow" name="checkall" id="checkall" hidden/></th>
                            <th>Item Description</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Excl Price</th>
                            <th>VAT</th>
                            <th>Incl Price</th>
                            <th></th>
                        </tr>
                        <tr>
                            <td hidden><input type="checkbox" class="itemrow" id="itemrow1" name="itemrow" hidden/></td>
                            <td><input id ="description1"  type = "text" class = "form-control" name = "itemdescription[]"autocomplete = "off"></td>
                            <td><input id = "quantity1" type = "text" class = "form-control" name= "quantity[]" autocomplete = "off"></td>
                            <script>
                                        $(document).ready(function(){
                                            $('#quantity1,#unitprice1').keyup(function(){
                                                
                                            var totalAmount = 0; 
                                                    $("[id^='exclprice']").each(function() {
                                                        
                                                        var id = $(this).attr('id');
                                                        id = id.replace("exclprice",'');
                                                        var price = $('#exclprice'+id).val();
                                                        var total = (parseFloat(price));
                                                        //$('#total_'+id).val(parseFloat(total));
                                                        totalAmount += total;
                                                        console.log(totalAmount);	
                                                    });
                                                    $('#totalexclusive').text(parseFloat(totalAmount.toFixed(2)));
                                                    var taxamt=0;
                                                    taxamt=totalAmount*0.16;
                                                    $('#totalvat').text(parseFloat(taxamt.toFixed(2)));
                                                    var totinc=0;
                                                    totinc=totalAmount+=(totalAmount*0.16);
                                                    $('#totalinclusive').text(parseFloat(totinc.toFixed(2)));
                                            });
                                        });
                            </script>
                            <td><input id = "unitprice1" type = "text" class = "form-control" name = "unitprice[]" autocomplete = "off"></td>
                            <td><input id = "exclprice1" type = "text" class = "form-control" name = "exclprice[]" value = 0 disabled></td>
                            <td><input id = "vat1" type = "text" class = "form-control" name = "vat[]" value = 0 disabled></td>
                            <td><input id = "inclprice1" type = "text" class = "form-control" name = "inclprice[]" value = 0 disabled></td>
                            <td><button class = "btn btn-danger d-flex align-items-center"  id ="additem"><i class="fa-solid fa-plus"></i> Item</button></td>
                        </tr>
                        </table>
                        <div class = "d-flex justify-content-between mx-2">
                            <div>
                            <p class = "fs-5">Total Amount Exc VAT</p>
                            <p class = "fs-5">VAT</p>
                            <p class = "fs-5">Total Amount Inc VAT</p>
                            </div>
                            <div>
                            <p class = "fs-5">Ksh<span class="mx-2" id = "totalexclusive" name="totalexclusive">0.00</span></p>
                            <p class = "fs-5">Ksh<span class="mx-2" id = "totalvat" name="totalvat">0.00</span></p>
                            <p class = "fs-5">Ksh<span class="mx-2" id = "totalinclusive" name="totalinclusive">0.00</span></p>
                            </div> 
                        </div>
                        <center>
                            <input type = "submit" class = "btn btn-success" value = "Save Quotation" name = "save" id = "save">
                        </center>
                    </div>
                
                <script>
                        $(document).ready(function(){
                            $("#save").click(function(){
                                var itemdescription=[];
                                $('input[name^="itemdescription"]').each(function() {
                                    itemdescription.push(this.value);
                                });
                                var quantity=[];
                                $('input[name^="quantity"]').each(function() {
                                    quantity.push(this.value);
                                });
                                var unitprice=[];
                                $('input[name^="unitprice"]').each(function() {
                                    unitprice.push(this.value);
                                });
                                var exclprice=[];
                                $('input[name^="exclprice"]').each(function() {
                                    exclprice.push(this.value);
                                });
                                var vat=[];
                                $('input[name^="vat"]').each(function() {
                                    vat.push(this.value);
                                });
                                var inclprice=[];
                                $('input[name^="inclprice"]').each(function() {
                                    inclprice.push(this.value);
                                });

                            $.ajax({
                            url: 'insertquote.php',
                            type: 'post',
                            data: {itemdescription:itemdescription, quantity:quantity,unitprice:unitprice,
                                    exclprice:exclprice,vat:vat,inclprice:inclprice,
                                    supplierid:$('#supplierid').val(),totalexclusive:$('#totalexclusive').text(),
                                    totalvat:$('#totalvat').text(),totalinclusive:$('#totalinclusive').text()},
                            success: function(result){
                                alert(result);
                            }
                        });       
                        });
                    });
                    </script>
            </div>
        </div>
        </div>
<script src="js/scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    </body>
</html>