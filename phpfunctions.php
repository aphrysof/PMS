<?php
include('config.php');
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
?>