<?php
include('config.php');
include 'connector.php';


$sql = "select * from cpldepartment";
$stmt = sqlsrv_query($conn,$sql);
if ($stmt) {
    $option = '';
    while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $option.='<option value="' . $row["departmentId"] . '">' . $row["description"] . '</option>';
        
    }
    
}

$sql2 = "select * from cplusers";
$stmt2 = sqlsrv_query($conn,$sql2);
if($stmt2) {
    $options = " ";
    while($row = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
        $options.='<option value="' . $row["userId"] . '">' . $row["username"] . '</option>';
        
    }
    
}

function readdepartment() {
    include "config.php";
    $sql = "select * from cpldepartment";
    $stmt = sqlsrv_query($conn,$sql);
    if ($stmt) {
        $select = '<select name="department1[]">';
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $select.='<option value="' . $row["departmentId"] . '">' . $row["description"] . '</option>';
        }
    }
    $select.="</select>";
    echo $select;
}
function addquotation () {
    include 'config.php';
    $sql = "select * from cplquotation";
    $stmt = sqlsrv_query($conn, $sql);
    if($stmt) {
        $select = '<select name ="approvequoteid[]">';
        while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $select.='<option value = "' .$row["Quote_id"].'"> '.$row["Quote_no"].'</option>';
        }
        $select.='</select>';
        echo $select;
}
}
?>


   