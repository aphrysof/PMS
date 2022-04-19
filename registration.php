<?php 
include('config.php');
include('phpfunctions.php');

if(isset($_POST['register'])){
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$department = $_POST['department'];



$sql = "insert into cplusers(userId,username,email,passwords,departmentId) values('4','$username','$email','$password','$department')";

    }

    else {
        echo "<span class = 'invalid-feedback'>Fill in all the fields!</span>";
    }


    $sql = "insert into cplusers(userId,username,email,passwords,departmentId) values('5','$username','$email','$password','$department')";

    $stmt = sqlsrv_query($conn, $sql);




}
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
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


    <title>Registration Form</title>
</head>
<script>
    $(document).ready(function () {
        
        // adding an onclick event on the btn 
        $('form').submit(function (e) { 
            e.preventDefault();
            
            var username = $('#username').val();
            var email = $('#email').val();
            var password = $('#password').val();
            var department = $('#department').val();
            var submit = $('#submit').val();
            $("#form-message").load('' , {
                username : username;
                email: email;
                password: password;
                department : department;
                submit : submit;
            })


            
        });
        var Errorempty = "<?php echo $Errorempty; ?>";
        var Erroremail = "<?php echo $Erroremail; ?>";


        if (Errorempty == true){
            $("#username, #password, #department").addClass('is-invalid');
        }
        if(Erroremail == true){
            $("#email").addClass('is-invalid');
        }
    });
    
</script>
<body style = "background: #f0f0f0">
<div class = "container">
        <div class = "row justify-content-center">
            <div class = "col-md-6">
                <div class = "card mt-5">
                    <div class = "card-header text-center">
                        <h3>Register</h3>
                    </div>
                    <div class = "card-body">
                        <form action = "" method = "post" id="registration" class = "needs-validation">
                        <div class="form-group mb-3">
                        <label for=" " class="form-label">Username:</label>
                             <input type="text" class="form-control form-control-lg" name="username" id = "username" required>
                        </div>
                        <div class="form-group mb-3">
                        <label for=" " class="form-label">Email:</label>
                             <input type="email" class="form-control form-control-lg" name="email" id= "email" required>
                        </div>
                        <div class="form-group mb-3">
                        <label for=" " class="form-label">Password</label>
                             <input type="password" class="form-control form-control-lg" name="password" id = "password" autocomplete="new-password" minlength="6" required>
                        </div>
                        <div class="form-group mb-8">
                        <label for=" " class="form-label">Select department:</label>
                        <select class = "form-select form-select-lg" name = "department" id = "department" required>
                            <?php echo $option;?>
                            </select>
                        </div>
                        <center>
                        <input type="submit" class=" btn btn-primary btn-lg col-12 mx-auto" style = "margin-top: 20px"; value="Register" name = "submit" id = "submit"> 
                        </center>
                        <p id = "form-message"></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>