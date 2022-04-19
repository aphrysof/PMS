<?php
session_start();

if (isset($_POST['submit'])){
$name=$_POST['username'];
$password=$_POST['password'];
//$_SESSION['db']=$_POST['database'];
include("config.php");
$sqlQuery = "select userid, username, passwords FROM cplusers WHERE username='$name' AND passwords='$password'";
$user=sqlsrv_query($conn, $sqlQuery);
$row=sqlsrv_num_rows($user);
if(!isset($user)) {
    $loginError = "Invalid email or password!";
    echo "<script> alert('$loginError'); </script>";
} else {
    while( $rows = sqlsrv_fetch_array( $user, SQLSRV_FETCH_ASSOC) ) {
     $_SESSION['users']=$rows['username']; 
     $_SESSION['userid'] = $rows['userid'];

    header("Location:home.php");
    }
}}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Login Form</title>
</head>
<body style = "background: #f0f0f0">
<div class = "container">
        <div class = "row justify-content-center">
            <div class = "col-md-6">
                <div class = "card mt-5">
                    <div class = "card-header text-center">
                        <h3>Login</h3>
                    </div>
                    <div class = "card-body">
                        <form action = "" method = "post" id="registration">
                        <div class="form-group mb-3">
                        <label for=" " class="form-label">Username:</label>
                             <input type="text" class="form-control form-control-lg" name="username" id = "username" required>
                        </div>
                        
                        <div class="form-group mb-3">
                        <label for=" " class="form-label">Password</label>
                             <input type="password" class="form-control form-control-lg" name="password" id = "password" autocomplete="new-password" minlength="6" required>
                        </div>
                        
                        <center>
                        <input type="submit" class=" btn btn-primary btn-lg col-12 mx-auto" style = "margin-top: 20px"; value="Login" name = "submit" id = "submit"> 
                        </center>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>