<?php
session_start();

$reqlineid=$_SESSION['reqlineid'];
include("config.php");
if(isset($_POST["submit"])) {
    foreach ($_POST["quotes"] as $key => $value){
        $id=$_POST["quotes"][$key];
        $insert="insert into cplapprovequote (Reqlineid,Quote_id) values ($reqlineid,$id)";
        sqlsrv_query($conn, $insert);
    }
}   
header("Location:req-attachquote.php"); 
?>
