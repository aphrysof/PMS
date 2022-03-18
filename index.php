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
        table,tr,th,td{
            border-collapse: collapse;
        } 
        
        table{
            table-layout: fixed;
            width: 100%; 
        
        }
      
    </style>

    <!-- Using jquery to add input fields and remove them dynamically inside a table -->
    <script type = "text/javascript">
        $(document).ready(function () {

            var html = '<tr><td><input class = "form-control" type="text"  name = "itemdescription[]" required/></td><td><input class = "form-control" type="number"  name = "quantity[]" required/></td><td><input class = "form-control" type="number"  name = " expectedprice[]" required/></td><td><input class = "form-control" type="number"  name = "actualprice[]" /></td><td><input class = "form-control" type="text"  name = "supplier[]" /></td><td><input class = "form-control" type="text"  name = "suppliername[]" required/></td><td><input class = "form-control" type="text"  name = "approvequoteid[]" /></td><td><input class = "form-control" type="number"  name = "amount[]" required/></td><td><select name = "choice[]" class = "form-control" disabled ><option value = " " selected>Approve Item</option><option value = "approved">Approved</option><option value = "rejected">Rejected</option><option value = "pending">Pending</option></select></td><td><input class = "btn btn-warning" type = "button" name = "remove" id = "remove" value = "Remove"></td></tr>';

            var x = 1;
            //to add rows
            $('#add').click(function () {
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
    <h1>REQUISITION FORM</h1>
    <div>
    <form action="connector.php" method="POST" id= "insert_form" action = "">
        <div id = "requisition_header">
            <label>REQUISITION NUMBER:</label><input type="text" name="Reqnumber"    /><br/>
            <label>DATE REQUESTED:</label><input type="date"  name="Reqdate"/><br/>
            <label>USER ID:</label><input type="text" name="Userid" /><br/>
            <label>DEPARTMENT:</label><input type="text" name="Department" /><br/>
            <label>REQUISITION STATUS:</label><input type="checkbox" /><br/>
            <label for="Approver">Approver:</label>

<select name="approver" id="approver-select">
    <option value="" >--Please choose the approver--</option>
    <option value="User">User</option>
    <option value="Aprrover Groups">Approver Groups</option>

</select>
<select name="user" id="user-select">
    <option value="" ></option>
    <option value="john">John</option>
    <option value="john">Antony</option>
    <option value="group">Department group</option>
</select>

            </div>
        </div>
<hr>
        <div class = "input--field">
            <table class = "table table-bordered" id = "table_field">
                <tr>
                    <th>Item Description</th>
                    <th>Quantity</th>
                    <th>Expected Price</th>
                    <th>Actual Price</th>
                    <th>Supplier</th>
                    <th>Supplier Name</th>
                    <th>Approve Quote_id</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                <tr>
                    <td><input class = "form-control " type="text" name = "itemdescription[]" required/></td>
                    <td><input class = "form-control" type="number"  name = "quantity[]" required/></td>
                    <td><input class = "form-control" type="number"  name = " expectedprice[]" required/></td>
                    <td><input class = "form-control" type="number"  name = "actualprice[]" /></td>
                    <td><input class = "form-control" type="text"  name = "supplier[]" /></td>
                    <td><input class = "form-control" type="text"  name = "suppliername[]" required/></td>
                    <td><input class = "form-control" type="text"  name = "approvequoteid[]" /></td>
                    <td><input class = "form-control" type="number"  name = "amount[]" required/></td>
                    <td>
                        <select name = "choice[]" style ="width:124px" class = "form-control" disabled>
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
            <input class = "btn btn-success" type = "submit" name = "save" id = "save" value = "Save Data">
            </center>
        </div>
    </form>
    </div>
</body>
</html>


