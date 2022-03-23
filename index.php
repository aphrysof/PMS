<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
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
                //counter
                count++;
                var html = '<tr><td hidden><input id="itemrow'+count+'" class = "itemrow" type="checkbox"  name = "itemrow" required hidden/></td><td><input class = "form-control" id="itemdescription'+count+'" type="text"  name = "itemdescription[]" required/></td><td><input id="quantity'+count+'" class = "form-control" type="number"  name = "quantity[]" required/></td><td><input id="expectedprice'+count+'" class = "form-control" type="number"  name = " expectedprice[]" required/></td><td><input id="actualprice'+count+'" class = "form-control" type="number"  name = "actualprice[]"/></td><td><input id="supplier'+count+'" class = "form-control" type="text"  name = "supplier[]" /></td><td><input class = "form-control" type="text" id="suppliername'+count+'" name = "suppliername[]" required/></td><td><input class = "form-control" type="text" id="approvedquoteid'+count+'"  name = "approvequoteid[]" /></td><td> <td><input id="departmentid1" class = "form-control" type="text"  name = "departmentid[]" /></td><input class = "form-control" type="number" id="amount'+count+'"  name = "amount[]" required/></td><td><select name = "choice[]" class = "form-control" disabled id="choice'+count+'" ><option value = " " selected>Approve Item</option><option value = "approved">Approved</option><option value = "rejected">Rejected</option><option value = "pending">Pending</option></select></td><td><input class = "btn btn-warning" type = "button" name = "remove" id = "remove" value = "Remove"></td></tr>';
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
<body>
   
    <div class = "container">
    <form action="" method="POST" id= "insert_form" >
        <div id = "requisition_header">
        <h1>REQUISITION FORM</h1>
        <!-- Fetching the reqnumber from the database giving it a readonly attribute -->
            <label>REQUISITION NUMBER:</label><input type="text" name="Reqnumber" id="reqno" value ='<?php
             include('config.php');
             $sql = "select ('REQ' + cast(format(nextno,'00000') as varchar)) as reqnumber from cplreqdf"; 
             $stmt = sqlsrv_query($conn,$sql);
             while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
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
                    echo "<select name ='department' id ='department'  required>";
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
                    <td><input id="expectedprice1" class = "form-control" type="number"  name = " expectedprice[]" required/></td>
                    <td><input id="actualprice1" class = "form-control" type="number"  name = "actualprice[]" /></td>
                    <td><input id="supplier1" class = "form-control" type="text"  name = "supplier[]" /></td>
                    <td><input id="suppliername1" class = "form-control" type="text"  name = "suppliername[]" required/></td>
                    <td><input id="approvequoteid1" class = "form-control" type="text"  name = "approvequoteid[]" /></td>
                    <td><input id="departmentid1" class = "form-control" type="text"  name = "departmentid[]" /></td>
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
                $.ajax({
                    url: 'connector.php',
                    type: 'post',
                    data: {itemdescription:itemdescription, quantity:quantity,expectedprice:expectedprice,
                        actualprice:actualprice,supplier:supplier,
                        suppliername:suppliername,amount:amount},
                    success: function(result){
                            alert(result);
                        },
                    error: function(result) {
                            alert(result);
                    }
                            }); 
                        });
            });
        </script>
    </form>
    </div>
</body>
</html>


