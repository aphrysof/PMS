<?php
session_start();
    if(isset($_POST['submit'])){

     include('config.php');
     $sql = "select ('REQ' + cast(format(nextno,'00000') as varchar)) as reqnumber from cplreqdf"; 
     $stmt = sqlsrv_query($conn,$sql);
     $row = sqlsrv_num_rows($stmt);
     if(isset($row)) {
        while( $rows = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {
         
            $_SESSION['myname']= $rows["reqnumber"];
        }
     }

     sqlsrv_close($conn); }


 include('config.php');

 
 $userid = $_POST['userid'];
 $department2 = $_POST['department2'] ?? 0;
 $department1 = $_POST['department1'] ?? '';
 //$approver = $_POST['approver'] ?? '';
 $itemdescription = $_POST['itemdescription'] ?? '';
 $quantity = $_POST['quantity'] ?? 0;
 $actualprice = $_POST['actualprice'] ?? 0;
 $supplier = $_POST['supplier'] ?? '';
 $suppliername = $_POST['suppliername'] ?? '';
 $amount = $_POST['amount'] ?? 0;
 $approvequoteid =$_POST['approvequoteid'] ?? 0;
 
 $sql = "
 --declare req as a variable
 DECLARE @req as varchar(50)
 
 --give the variable a value from set sql function which will be the requisition number
 set @req= (select ('REQ' + cast(format(nextno,'00000') as varchar)) from cplreqdf)
 INSERT INTO Requsition(ReqNumber,ReqDate,userId,Approver,departmentId,CreatedOn,ModifiedOn) 
         VALUES (@req,getdate(),'$userid','NULL','$department2',getdate(), getdate())";
 
 sqlsrv_query($conn, $sql) or die(print_r( sqlsrv_errors(), true));
 
 
 for($i = 0; $i < count($itemdescription); $i++) {    
     $save = "
     --declare req and reqno as variables
     DECLARE @req as varchar(50)
     DECLARE @reqno as int
     
     --give the variable a value from set sql function which will be the requisition number
     set @req= (select ('REQ' + cast(format(nextno,'00000') as varchar)) from cplreqdf);
 
     --set the requisition id on variable @reqno
     set @reqno=(select top(1) ReqId from Requsition where ReqNumber=@req);
 
     INSERT INTO Requisitionlines(ReqId,itemdescription,actualprice,quantity,supplier,suppliername,amount,createdon,modifiedon,departmentId)
     VALUES(@reqno,'".$itemdescription[$i]."','".$actualprice[$i]."','".$quantity[$i]."','".$supplier[$i]."',
     '".$suppliername[$i]."','".$amount[$i]."', getdate(), getdate(),'".$department1[$i]."' )";
     
     sqlsrv_query($conn, $save)  or die(print_r( sqlsrv_errors(), true));
     

     // foreach(array($approvequoteid[$i]) as  $item)
 
     // {
     //     for($s = 0; $s < count(array($item)); $s++)
     //      {
             
     //         $query = "
     //         DECLARE @req as varchar(50)
     //         DECLARE @reqlineno as int
     //         DECLARE @reqno as int
         
     //         --give the variable a value from set sql function which will be the requisition number
     //         set @req= (select ('REQ' + cast(format(nextno,'00000') as varchar)) from cplreqdf);
         
     //         --set the requisition id on variable @reqno
     //         set @reqno=(select top(1) ReqId from Requsition where ReqNumber=@req);
         
     //         --set the requisition line id on variable @reqlineno
     //         set @reqlineno=(select top(1) reqlineid from Requisitionlines rs join Requsition r
     //         on rs.ReqId=r.ReqId where r.ReqNumber=@req
     //         order by Reqlineid desc);
         
     //         INSERT INTO cplapproves (Reqlineid,Quote_id) VALUES (@reqlineno, '$item[$s]')";
     //         sqlsrv_query($conn, $query) or die(print_r( sqlsrv_errors(), true));
     //     }
    
 
     // }
 }
     //insert into requests 
    $savelines="
    --declare req and reqno as variables
    DECLARE @req as varchar(50)
    DECLARE @reqno as int
    
    --give the variable a value from set sql function which will be the requisition number
    set @req= (select ('REQ' + cast(format(nextno,'00000') as varchar)) from cplreqdf);

    insert into cplrequestapproval (groupid, userid,reqlineid, status, created_by,created_on,modified_on,modified_by)
    (select  (groupid), (cp.userid),rs.reqlineid, 0, getdate(),getdate(),getdate(),getdate() from cplapprovergroup cp 
    left join cpldepartment ct on cp.departmentid=ct.departmentid
    left join requisitionlines rs on ct.departmentid=rs.departmentid 
    left join requsition rn on rn.reqid=rs.reqid
    where rn.reqnumber=@req)";
    
    sqlsrv_query($conn, $savelines)  or die(print_r( sqlsrv_errors(), true));
 
     $updatereqno="
     --increase the next number of requisition by one 
     update cplreqdf set nextno=nextno+1 from cplreqdf";
     sqlsrv_query($conn, $updatereqno)  or die(print_r( sqlsrv_errors(), true));
    
     header('location:req-attachquote.php');

 ?>

    


