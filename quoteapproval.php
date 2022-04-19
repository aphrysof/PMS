<?php
include("config.php");
if(isset($_POST["save_changes"])) {
    foreach ($_POST["check"] as $key => $value){
        $id=$_POST["check"][$key];
        $update="update cplapprovequote set status=1 from cplapprovequote where approvequote_id=$id";
        sqlsrv_query($conn, $update);
    }
    // header('Location:viewform.php'); 
}   

?>