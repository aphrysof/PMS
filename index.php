
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <title>REQ FORM</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
       .table--container{
           width: 100%;
           border: 1px solid black;
        
       }
       .table--contents{
           margin: 10px;
           display: flex;
           gap: 5px;
           align-items: center;
           overflow-x: auto;
    
       }
     
       .contents{
           text-align: center;
       }
       .justification{
            display:flex;
            flex-direction: column;
            width: fit-content;
            padding: 10px 0;
       }
       .buttons{
           padding: 10px;
       }
    </style>

</head>
<body>
    <h1>REQUISITION FORM</h1>
    <form action="connector.php" method="POST">
        <div>
            <label>REQUISITION NUMBER:</label><input type="text" name="Reqnumber"    /><br/>
            <label>DATE REQUESTED:</label><input type="date"  name="Reqdate"/><br/>
            <label>USER ID:</label><input type="text" name="Userid" /><br/>
            <label>DEPARTMENT:</label><input type="text" name="Department" /><br/>
            <label>REQUISITION STATUS:</label><input type="checkbox" /><br/>
            <div>
            <label for="pet-select">Approver:</label>

<select name="approver" id="approver-select">
    <option value="" >--Please choose the approver--</option>
    <option value="User">User</option>
    <option value="Aprrover Groups">Approver Groups</option>

</select>
<select name="user" id="user-select">
    <option value="" ></option>
    <option value="john">John</option>
    <option value="john">Antony</option>
</select>

            </div>
        </div>
</br>

        <div class = "table--container">
            <div class = "table--contents">
                <div class = "contents">
                    <label>Item Description</label>
                    <input type="text"  name = "itemdescription" required/>
                </div>
                <div class = "contents">
                    <label>Quantity</label>
                    <input type="number"  name = "quantity" required/>
                </div>
                <div class = "contents">
                    <label>EP/Unit</label>
                    <input type="number"  name = " expectedprice" required/>
                </div>
                <div class = "contents">
                    <label>Actual price</label>
                    <input type="number"  name = "actualprice" />
                </div>
                <div class = "contents">
                    <label>supplier</label>
                    <input type="text"  name = "supplier" />
                </div>
                <div class = "contents">
                    <label>Supplier name</label>
                    <input type="text"  name = "suppliername" required/>
                </div>
                <div class = "contents">
                    <label>Approved quot-ID</label>
                    <input type="text"  name = "approvequoteid" />
                </div>
                <div class = "contents">
                    <label>Amount</label>
                    <input type="number"  name = "amount" required/>
                </div>
                <div class = "contents">
                    <label>Status</label>
                    <select name = "choice">
                    <option>Approved</option>
                    <option>Rejected</option>
                    <option>Pending</option>
               </select>
                </div>
                <div class = "contents">
                    <label>Attach file</label>
                    <input type = "file" name = "file"/>
                </div>
            </div>
            <div class = "buttons">
            <button>Add more +</button>
            <button id = "delete">Delete</button>
            </div>
        </div>
        <div class = "justification">
        <label>Justification</label>
        <textarea  name="justification" rows="5" cols="40"></textarea>
        </div>
        <input type="submit" name = "submit" value = "submit"/>
        <!-- <hr/>
        <table>
            <tr>
                <th>Item description</th>
                <th>Quantity</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
              


            </tr>
            <tr>
               <td></td> 
               <td</td> 
               <td></td> 
               <td></td> 
               <td></td> 
               <td></td> 
               <td></td> 
               <td></td> 
               <td>
                </td> 
               <td></td> 
            </tr>
    </table>
        
        <br/>
       
        <br/>
        -->
    </form>
</body>
</html>


