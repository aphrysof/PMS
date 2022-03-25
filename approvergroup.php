
<?php
include('phpfunctions.php');

if(isset($_POST["submit"])) {
    $groupname = $_POST['groupname'] ?? '';
    $selectdep = $_POST['selectdep'] ?? 0;
    $selectusers = $_POST['selectusers'] ?? 0;
    $role = $_POST['role'] ?? '';
    $createdon = $_POST['createdon'] ?? 0;
    $modifiedon = $_POST['modifiedon'] ?? 0;


    $sql3 = " INSERT INTO cplapprovergroup(userId, description, departmentId,role,created_on,modified_on) 
    VALUES ('$selectusers', '$groupname', '$selectdep', '$role',getdate(), getdate())";
 
    $result = sqlsrv_query($conn, $sql3);
    
if($result) {
    echo '<script language="javascript">';
    echo 'alert("message successfully sent")';
    echo '</script>';
  }else{
    die( print_r( sqlsrv_errors(), true));
  }
// print_r($selectusers);
// print_r($groupname);
// print_r($selectdep);
// print_r($role);
}
// PRINT OUT //
       
 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
    <title>Aprrover group</title>

   
</head>

<script type = "text/javascript">
     $(document).ready(function () {
        $('select').selectpicker();
    });

</script>
<body style = "background: #f0f0f0">
    <div class = "container">
        <div class = "row justify-content-center">
            <div class = "col-md-8">
                <div class = "card mt-5">
                    <div class = "card-header text-center">
                        <h3>Approver Groups</h3>
                    </div>
                    <div class = "card-body">
                        <form action = "" method = "post">
                        <div class = "col-md-12">
                        <div class="mb-3">
                        <label for=" " class="form-label">Group Name:</label>
                        <input type="text" class="form-control" name = "groupname">
                        </div>
                        <div class = "mb-3">
                        <label for=" " class="form-label">Select department:</label>
                            <select class = "select form-control" title = "Select department..." name = "selectdep">
                            <?php echo $option;?>
                            </select>
                        </div>
                        <div class = "mb-3">
                        <label for=" " class="form-label">Select Users:</label>
                        <select class="selectpicker form-control" multiple title="Select Users..." name = "selectusers">
                        <?php echo $options; ?>
                        </select>
                        </div>
                        <div class="mb-3">
                        <label for=" " class="form-label">Role:</label>
                       <select class = >

                       </select>
                        </div>
                        </div>
                        <center>
                            <button type = "submit" class = "btn btn-primary" value = "submit" name="submit" id="submit">Submit</button>
                        </center>
                    
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>