<?php
include 'config.php';
    session_start();
    $userid=$_SESSION['userid'];
    $Reqlineid  = $_POST['Reqlineid'] ?? 0;
    $department1 = $_POST['department1'] ?? 0;
    $itemdescription = $_POST['itemdescription'] ?? '';
    $quantity = $_POST['quantity'] ?? 0;
    $expectedprice = $_POST['expectedprice'] ?? 0;
    $actualprice = $_POST['actualprice'] ?? 0;
    $supplier = $_POST['supplier'] ?? '';
    $suppliername = $_POST['suppliername'] ?? '';
    $amount = $_POST['amount'] ?? 0;
    $approvequoteid = $_POST['approvequoteid'] ?? 0;
    $choice = $_POST['choice'] ?? '';

    for($i = 0; $i < count($itemdescription); $i++) {
    $sql = "
    UPDATE Requisitionlines SET itemdescription = '$itemdescription[$i]', actualprice = '$actualprice[$i]', 
    quantity ='$quantity[$i]',supplier = '$supplier[$i]',suppliername = '$suppliername[$i]',
    amount = '$amount[$i]' WHERE Reqlineid = $Reqlineid[$i]";

    $stmt = sqlsrv_query($conn, $sql);
    
    $update = "update cplrequestapproval set status=$choice[$i] from  cplrequestapproval where Reqlineid=$Reqlineid[$i] and userid=$userid";
    sqlsrv_query($conn, $update);
    }
    if($stmt){
        echo "update successful";
    }else {
        die(print_r(sqlsrv_errors(), true));
    }
    




?>