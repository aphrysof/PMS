<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Document</title>
</head>

<script type = "text/javascript">
    $document.ready(function(){
        

    })



</script>

<body>
        <!-- use this field to generate data from the database as per the reqno inserted by the user, use js to hide
        after click  to generate the req form  for approvals -->
            <form action = "" method = "GET">
            <div>
            <input type = "text" name = "ReqId" id = "fetch_form" value ='<?php if(isset($_GET['ReqId'])){echo $_GET['ReqId'];}?>'>
            <input type = "submit" value = "Search">
            </div>
            
            <?php
           include('config.php');

            if(isset($_GET['ReqId']))
            {
                $ReqId = $_GET['ReqId'];
                $query = "select * from Requsition where id ='$ReqId'";
                $stmt = sqlsrv_query($conn, $query);
            
                if( $stmt === false) {
                    die( print_r( sqlsrv_errors(), true) );
                }

                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                    echo $row['ReqNumber'];
                }

                sqlsrv_free_stmt($stmt);

            }
            ?>
            </form>

</body>
</html>