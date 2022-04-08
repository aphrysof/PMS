<?php
include 'config.php';


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
    UPDATE Requisitionlines SET itemdescription = '$itemdescription[$i]',expectedprice = '$expectedprice[$i]', actualprice = '$actualprice[$i]', 
    quantity ='$quantity[$i]',supplier = '$supplier[$i]',suppliername = '$suppliername[$i]', approvequoteid = '$approvequoteid[$i]',
    amount = '$amount[$i]', reqlinestatus = '$choice[$i]' WHERE Reqlineid = $Reqlineid[$i]";

    $stmt = sqlsrv_query($conn, $sql);
    }
    if($stmt){
        echo "update successful";
    }else {
        die(print_r(sqlsrv_errors(), true));
    }
    




?>