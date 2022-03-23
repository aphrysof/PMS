<?php
include('config.php');

if(isset($_POST['save'])){
$reqnumber = $_POST['Reqnumber'] ?? 0;
$reqdate =  $_POST['Reqdate'] ?? 0;
$userid = $_POST['userid'] ?? 0;
$department = $_POST['department'] ?? '';
$approver = $_POST['approver'] ?? '';
$itemdescription = $_POST['itemdescription'] ?? '';
$quantity = $_POST['quantity'] ?? 0;
$expectedprice = $_POST['expectedprice'] ?? 0;
$actualprice = $_POST['actualprice'] ?? 0;
$supplier = $_POST['supplier'] ?? '';
$suppliername = $_POST['suppliername'] ?? '';
$amount = $_POST['amount'] ?? 0;
$choice = $_POST['choice'] ?? '';
$file = $_POST['file'] ?? '';
$createdon = $_POST['createdon'] ?? 0;
$modifiedon = $_POST['modifiedon'] ?? 0;

$sql = "
--declare req as a variable
DECLARE @req as varchar(50)

--give the variable a value from set sql function which will be the requisition number
set @req= (select ('REQ' + cast(format(nextno,'00000') as varchar)) from cplreqdf)
INSERT INTO Requsition(ReqNumber,ReqDate,userId,Approver,departmentId,CreatedOn,ModifiedOn) 
        VALUES (@req,getdate(),'$userid','$approver','$department',getdate(), getdate())";

sqlsrv_query($conn, $sql);

for($i = 0; $i < count($itemdescription); $i++){    
    $save = "
    --declare req and reqno as variables
    DECLARE @req as varchar(50)
    DECLARE @reqno as int
    
    --give the variable a value from set sql function which will be the requisition number
    set @req= (select ('REQ' + cast(format(nextno,'00000') as varchar)) from cplreqdf)

    --set the requisition id on variable @reqno
    set @reqno=(select top(1) ReqId from Requsition where ReqNumber=@req)
    
    INSERT INTO Requisitionlines(ReqId,itemdescription,expectedprice,actualprice,quantity,supplier,suppliername,createdon,modifiedon)
    VALUES(@reqno,'".$itemdescription[$i]."', '".$expectedprice[$i]."', '".$actualprice[$i]."','".$quantity[$i]."','".$supplier[$i]."',
    '".$suppliername[$i]."', getdate(), getdate())";
    sqlsrv_query($conn, $save);
}

    $updatereqno="
    --increase the next number of requisition by one 
    update cplreqdf set nextno=nextno+1 from cplreqdf";
    $stmt2 = sqlsrv_query($conn, $updatereqno);

    if($stmt2) {
        echo "<h3>data stored in a database successfully.</h3>" ;
    }else{
        echo die( print_r( sqlsrv_errors(), true));
    }

}

?>
