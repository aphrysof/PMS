<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Department Form</title>
        <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
        <style>
          *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
          }
          body{
            min-height: 100vh;
            background: #eee;
            display: flex;
            font-family: serif;
          }
          .container{
            margin: auto;
            width: 500px;
            max-width: 90%;
          }
          .container form{
            width: 100%;
            height: 100%;
            padding: 20px;
            background: #eee;
            border-radius: 4px;
            box-shadow: 0 8px 16px rgba(0, 0, 0,.3);
          }
          .container form h2{
            text-align: center;
            margin-bottom: 24px;
            color: #222;
          }
          .container form .form-control{
            width: 100%;
            height: 40px;
            background: white;
            border-radius: 4px;
            border: 1px solid silver;
            margin: 15px 0 18px 0;
            padding: 0 10px;
          }
          .container form .btn{
            margin-left: 40%;
            transform: translateX(-50);
            width: 100px;
            height: 34px;
            border: none;
            outline: none;
            background: grey;
            cursor: pointer;
            font-size: 16px;
            text-transform: uppercase;
            border-radius: 4px;
            transition: .3s;
          }

        </style>
        
    </head>
    
<body>
        
   
<div class="container">   
    <form action="" method = "post">
    <h2>New Department</h2>
      <div class="form-group">
        <label for="">Department ID</label>
        <input type="text" class="form-control" name="Dep_id" required>
      </div>
      <div class="form-group">
        <label for="">Description</label>
        <input type="text" class="form-control" name="Department_description" required>
      </div>
     <input type="submit" class="btn" value="create" name = "insert">
    </form>

</html>
</body>

<?php
include('config.php'); 
if(isset($_POST['insert'])){

  $Dep_id=$_POST ['Dep_id'];
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
