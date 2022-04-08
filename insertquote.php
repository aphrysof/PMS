<?php
include 'config.php';

$quotenumber = $_POST['quotenumber'] ?? 0;
$supplierid = $_POST['supplierid'] ?? '';
$itemdescription = $_POST['itemdescription'] ?? '';
$quantity = $_POST['quantity'] ?? 0;
$unitprice = $_POST['unitprice'] ?? 0;
$exclprice = $_POST['exclprice'] ?? 0;
$vat = $_POST['vat'] ?? 0;
$inclprice = $_POST['inclprice'] ?? 0;
$totalexclusive = $_POST['totalexclusive'] ?? 0;
$totalvat = $_POST['totalvat'] ?? 0;
$totalinclusive = $_POST['totalinclusive'] ?? 0;


$sql = "
--declare req as a variable
DECLARE @quote as varchar(50)

set @quote= (select ('QUOT' + cast(format(nextno,'00000') as varchar)) from cplquotedf);

INSERT INTO cplquotation(Quote_no,Quotation_date,supplierId,created_on,modified_on,total_amt_excl,total_vat,total_amt_incl) 
VALUES (@quote,getdate(),'$supplierid',getdate(), getdate(),'$totalexclusive','$totalvat','$totalinclusive')";

$stmt = sqlsrv_query($conn, $sql);


for($i = 0; $i < count($itemdescription); $i++) {    
    $save = "
    --declare req and reqno as variables
    DECLARE @quote as varchar(50)
    DECLARE @quote                 
    
    set @quote= (select ('QUOT' + cast(format(nextno,'00000') as varchar)) from cplquotedf);

    set @quoteno=(select top(1) Quote_id from cplquotation where Quote_no=@quote);

    INSERT INTO cplquotationlines(Quote_id,itemdescription,quantity,Unit_price,Excl_price,Tax,Incl_price,created_on,modified_on)
    VALUES(@quoteno,'".$itemdescription[$i]."','".$quantity[$i]."','".$unitprice[$i]."','".$exclprice[$i]."','".$vat[$i]."',
    '".$inclprice[$i]."', getdate(), getdate())";
    
   $stmt2= sqlsrv_query($conn, $save);     
}

$updatereqno="

    update cplquotedf set nextno=nextno+1 from cplquotedf";
    sqlsrv_query($conn, $updatereqno);

?>

