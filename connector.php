<?php
include('config.php');

$reqnumber = $_REQUEST['Reqnumber'] ?? 0;
$reqdate =  $_REQUEST['Reqdate'] ?? 0;
$userid = $_REQUEST['Userid'] ?? 0;
$department = $_REQUEST['Department'] ?? '';
$approver = $_REQUEST['approver'] ?? '';
$itemdescription = $_REQUEST['itemdescription'] ?? '';
$quantity = $_REQUEST['quantity'] ?? 0;
$expectedprice = $_REQUEST['expectedprice'] ?? 0;
$actualprice = $_REQUEST['actualprice'] ?? 0;
$supplier = $_REQUEST['supplier'] ?? '';
$suppliername = $_REQUEST['suppliername'] ?? '';
$amount = $_REQUEST['amount'] ?? 0;
$choice = $_REQUEST['choice'] ?? '';
$file = $_REQUEST['file'] ?? '';
// $createdby = $_REQUEST['createdby'] ?? 0;
$createdon = $_REQUEST['createdon'] ?? 0;
$modifiedon = $_REQUEST['modifiedon'] ?? 0;

// $modifiedby = $_REQUEST['modifiedby'] ?? '';

$sql = "INSERT INTO Requsition(ReqNumber,ReqDate,UserId,Approver,DepartmentId,CreatedOn,ModifiedOn) 
        VALUES ('$reqnumber',getdate(),'$userid','$approver','$department',getdate(), getdate())";

foreach ($itemdescription as $key => $value) 
{
    $save = "INSERT INTO Requisitionlines(itemdescription,expectedprice,actualprice,quantity,supplier,suppliername,createdon,modifiedon)
    VALUES('".$value."', '".$expectedprice[$key]."', '".$actualprice[$key]."','".$quantity[$key]."','".$supplier[$key]."',
    '".$suppliername[$key]."', getdate(), getdate())";

    
    $stmt2 = sqlsrv_query($conn, $save);

    if($stmt2) {
        echo "<h3>data stored in a database successfully.</h3>" ;
    }else{
        die( print_r( sqlsrv_errors(), true));
    }
}

$stmt = sqlsrv_query($conn, $sql);


?>
