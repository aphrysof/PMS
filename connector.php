<?php
include('config.php');

if(isset($_POST['save'])){

$userid = $_POST['userid'] ?? '';
$department2 = $_POST['department2'] ?? '';
$department1 = $_POST['department1'] ?? 0;
//$approver = $_POST['approver'] ?? '';
$itemdescription = $_POST['itemdescription'] ?? '';
$quantity = $_POST['quantity'] ?? 0;
$expectedprice = $_POST['expectedprice'] ?? 0;
$actualprice = $_POST['actualprice'] ?? 0;
$supplier = $_POST['supplier'] ?? '';
$suppliername = $_POST['suppliername'] ?? '';
$amount = $_POST['amount'] ?? 0;
$approvequoteid = $_POST['approvequoteid'] ?? 0;


$sql = "
--declare req as a variable
DECLARE @req as varchar(50)

--give the variable a value from set sql function which will be the requisition number
set @req= (select ('REQ' + cast(format(nextno,'00000') as varchar)) from cplreqdf)
INSERT INTO Requsition(ReqNumber,ReqDate,userId,Approver,departmentId,CreatedOn,ModifiedOn) 
        VALUES (@req,getdate(),'$userid','NULL','$department2',getdate(), getdate())";

sqlsrv_query($conn, $sql);

for($i = 0; $i < count($itemdescription); $i++) {    
    $save = "
    --declare req and reqno as variables
    DECLARE @req as varchar(50)
    DECLARE @reqno as int
    
    --give the variable a value from set sql function which will be the requisition number
    set @req= (select ('REQ' + cast(format(nextno,'00000') as varchar)) from cplreqdf);

    --set the requisition id on variable @reqno
    set @reqno=(select top(1) ReqId from Requsition where ReqNumber=@req);


    INSERT INTO Requisitionlines(ReqId,itemdescription,expectedprice,actualprice,quantity,supplier,suppliername,approvequoteid,amount,createdon,modifiedon,departmentId)
    VALUES(@reqno,'".$itemdescription[$i]."','".$expectedprice[$i]."','".$actualprice[$i]."','".$quantity[$i]."','".$supplier[$i]."',
    '".$suppliername[$i]."','".$amount[$i]."','".$approvequoteid[$i]."', getdate(), getdate(),'".$department1[$i]."')";
    
    sqlsrv_query($conn, $save);
    
    header('location: index.php');

}

    $updatereqno="
    --increase the next number of requisition by one 
    update cplreqdf set nextno=nextno+1 from cplreqdf";
    $stmt2 = sqlsrv_query($conn, $updatereqno);

    if($stmt2) {
        
        echo alert("message successfully sent");
    }else{
        echo die( print_r( sqlsrv_errors(), true));
    }
    
}

?>


                                                   