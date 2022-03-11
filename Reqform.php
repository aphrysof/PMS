<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <title>REQ FORM</title>
    <style>
        table,tr,th,td{
            border: 1px solid black;
            border-collapse: collapse;
        }
        td{
           height: 20px; 
        }
        table{
            width: 100%; 
            margin: 20px 0 0;
        }
        input[type="file"] {
            text-align: center;
        }
    </style>

</head>
<body>
    <h1>REQUISITION FORM</h1>
    <form>
        <div>
            <label>REQUISITION ID:</label><input type="text" /><br/> <br/>
            <label>REQUISITION NUMBER:</label><input type="text" /><br/>
            <label>DATE REQUESTER:</label><input type="date" /><br/>
            <label>USER ID:</label><input type="text" /><br/>
            <label>DEPARTMENT:</label><input type="text" /><br/>
            <label>REQUISITION STATUS:</label><input type="checkbox" /><br/>
        </div>
</br>
        <hr/>
        <table>
            <tr>
                <th>Item description</th>
                <th>Quantity</th>
                <th>EP/Unit</th>
                <th>Actual price</th>
                <th>supplier</th>
                <th>Supplier name</th>
                <th>Approved quot_ID</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Attach file</th>
              


            </tr>
            <tr>
               <td></td> 
               <td></td> 
               <td></td> 
               <td></td> 
               <td></td> 
               <td></td> 
               <td></td> 
               <td></td> 
               <td></td> 
               <td><input type = "file"/></td> 
               <td><button>Delete</button></td>
            </tr>
            
        </table>
        <button>Add</button>
    </form>
</body>
</html>

