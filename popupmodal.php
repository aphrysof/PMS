<?php
include 'config.php';
if(isset($_POST['Reqlineid'])){

  $output= '';

  $sql = "select approvequote_id, Quote_no, qs.itemdescription, qs.quantity, Unit_price, total_amt_incl 
  from cplquotationlines as qs join cplquotation 
  on cplquotation.Quote_id = qs.Quote_id
  join cplapprovequote on cplapprovequote.Quote_id = cplquotation.Quote_id 
  join Requisitionlines rs on rs.Reqlineid=cplapprovequote.Reqlineid where rs.Reqlineid = '".$_POST['Reqlineid']."'";

  $result = sqlsrv_query($conn, $sql);

  $output .= "
  <table class='table table-striped table-hover'>
  <tr>
      <th>Quote no</th>
      <th>Item Description</th>
      <th>Quantity</th>
      <th>Unit Price</th>
      <th>Total Amount</th>
      <th>Select</th>
  </tr>";
  while( $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $output .="
    <tr>
        <td>".$row['Quote_no']."</td>
        <td>".$row['itemdescription']."</td>
        <td>".$row['quantity']."</td>
        <td>".$row['Unit_price']."</td>
        <td>".$row['total_amt_incl']."</td>
        <td><div><input class='form-check-input' type='checkbox' id='checkboxNoLabel' value= '".$row['approvequote_id']."' name = 'check[]'></div></td>
    </tr>
    ";
  }
  $output .="</table>";
  echo $output;
}


?>