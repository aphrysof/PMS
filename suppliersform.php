<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Suppliersform</title>
</head>
<script>
    $(document).ready(function () {
      
    });
</script>
<body style = "background: #f0f0f0">
  <div class = "container">
  <div class = "row justify-content-center">
    <div class = "col-md-8">
        <div class = "card mt-5">
            <div class = "card-header text-center">
                <h3>Suppliers Form</h3>
            </div>
            <div class = "card-body">
              <form action = "" method = "post"> 
                <div class="mb-3 col-md-12">
                  <label class="form-label">Supplier No</label>
                  <input type="text" id = "supplierno" name = "supplierno" class="form-control" placeholder = "" value = "" readonly>
                </div>
                <div class="mb-3 col-md-12">
                  <input type="text" class="form-control" name= "suppliername"  placeholder = "Supplier Name" >
                </div>
                <div class="mb-3 col-md-12">
                  <input type="email" class="form-control" placeholder="supplier@example.com" name = "emailaddress">
                </div>
                <div class="mb-3 col-md-12">
                  <input type="text" class="form-control" name = "streetaddress"  placeholder = "streetaddress" >
                </div>
              <div class = "row">
              <div class="col-md-6">
                  <label  class="form-label">City</label>
                  <input type="text" class="form-control" name = "city">
                </div>
                <div class="col-md-6">
                  <label  class="form-label">Country</label>
                  <select class="form-select" name = "country">
                    <option selected>Choose...</option>
                    <option>Kenya</option>
                    <option>Uganda</option>
                    <option>Tanzania</option>
                  </select>
                </div>
                </div>
                <div class="mb-3 col-md-12">
                <label class="form-label">Telephone</label>
                <input type="tel" class="form-control" name = "telephone">
              </div>
                <center>
                  <input type = "submit" class = "btn btn-primary btn-lg" value = "Submit" name = "submit">
                </center>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
<?php
include('config.php');
if(isset($_POST['submit'])){

$suppliername = $_POST['suppliername'] ?? '';
$emailaddress = $_POST['emailaddress'] ?? '';
$streetaddress = $_POST['streetaddress'] ?? '';
$country = $_POST['country'] ?? '';
$city = $_POST['city'] ?? '';
$telephone = $_POST['telephone'] ?? 0;

$sql = "INSERT INTO cplsuppliers(suppliername,Telephone_no,email_address,streetaddress,city,country,created_on,modified_on)
VALUES('$suppliername', '$emailaddress','$streetaddress','$country', '$city','$telephone', getdate(), getdate())";

$stmt = sqlsrv_query($conn, $sql);

if($stmt) {
  echo '<script language="javascript">';
  echo 'alert("message successfully sent")';
  echo '</script>';
}else{
  die( print_r( sqlsrv_errors(), true));
}
}
?>





