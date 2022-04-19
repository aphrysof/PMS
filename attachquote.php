<?php

session_start();
$_SESSION['reqlineid']=$_GET['Reqlineid'] ?? $_SESSION['reqlineid2'] ?? 0;

include 'config.php';
$sql = " select cn.Quote_id, cn.Quote_no, cs.Quoteline_id, cs.itemdescription, cs.Unit_price, cs.quantity, cn.total_vat,
cn.total_amt_incl, ss.suppliername from cplquotation cn join cplquotationlines cs on cs.Quote_id = cn.Quote_id join
cplsuppliers ss on cn.supplierId = ss.supplierId";
$result = sqlsrv_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link href="css/styles.css" rel="stylesheet" />
    <title>Document</title>
    
</head>
<body>
    <div class = "container-fluid px-4 py-4">
        <div class = "card">
            <div class = "card-header">
                Attach Quote
            </div>
            <div class = "card-body ">
            <form name="quotes" method="post" action="reqattachquery.php" >
                <table class = "table table-hover" id="datatablesSimple">
                    <thead>
                    <tr>
                        <th scope="col">Quotation Number</th>
                        <th scope = "col">Supplier Name</th>
                        <th scope="col">Item Description</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Unit price</th>
                        <th scope="col">Total Vat</th>
                        <th scope="col">Total Inclusive</th>
                        <th scope="col">Select</th>

                    </tr>
                    </thead>
                    <?php while( $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) { ?>
                    <tr>
                        <td><?php echo $row['Quote_no']?></td>
                        <td><?php echo $row['suppliername'] ?></td>
                        <td><?php echo $row['itemdescription']?></td>
                        <td><?php echo $row['quantity']?></td>
                        <td><?php echo $row['Unit_price']?></td>
                        <td><?php echo $row['total_vat']?></td>
                        <td><?php echo $row['total_amt_incl']?></td>
                        <td><input name='quotes[]' type = "checkbox" id='checkboxNoLabel' value = "<?php echo $row['Quote_id'];?>"/></td>
                    </tr>
                    <?php } ?>
                    
                </table>
                <button class="btn btn-success " type="submit" name="submit" >Attach Quotations</button>
                        </form>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>
</html>