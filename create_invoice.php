<?php
session_start();
?>
<html>
<?php include ("config.php") ?>
<title>
</title>
<link rel="stylesheet" type="text/css" href="bootstrap1.css"/>
<link rel="stylesheet" type="text/css" href="bootstrap2.css"/>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="bootstrap1.js"></script>
<script src="bootstrap2.js"></script>
<script src="bootstrap3.js"></script>
<script src="jquery1.js"></script>
<script src="jquery2.js"></script>
<!---------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------php functions--------------------------------------------------->
<?php
function readaccounts() {
    include "config.php";
    $sql = "select master_sub_account, description from accounts where iaccounttype=9";	
    $stmt = sqlsrv_query($conn,$sql);
    if ($stmt) {
        $select = '<select name="select">';
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $select.='<option value="' . $row["description"] . '">' . $row["description"] . '</option>';
        }
    }
    $select.="</select>";
    echo $select;
      }
function readorigin() {
        include "config.php";
        $sql = "select distinct FROMLOCATION from  _CPLLOCATIONS";	
        $stmt = sqlsrv_query($conn,$sql);
        if ($stmt) {
            $select = '<select name="select">';
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                $select.='<option value="' . $row["FROMLOCATION"] . '">' . $row["FROMLOCATION"] . '</option>';
            }
        }
        $select.="</select>";
        echo $select;
          }
function readdestination() {
include "config.php";
$sql = "select distinct locationname from  _CPLLOCATIONS"; 	
$stmt = sqlsrv_query($conn,$sql);
if ($stmt) {
    $select = '<select name="select">';
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $select.='<option value="' . $row["locationname"] . '">' . $row["locationname"] . '</option>';
    }
}
$select.="</select>";
echo $select;
    }
function readband() {
    include "config.php";
    $sql = "select band from _cplpricelistname where PRICELISTNAME<>'cisco'"; 	
    $stmt = sqlsrv_query($conn,$sql);
    if ($stmt) {
        $select = '<select name="select">';
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $select.='<option value="' . $row["band"] . '">' . $row["band"] . '</option>';
        }
    }
    $select.="</select>";
    echo $select;
        }
function readpacking() {
    include "config.php";
    $sql = "select distinct packing from  _CPLPRICELISTDETAILS where packing is not null and packing<>''"; 	
    $stmt = sqlsrv_query($conn,$sql);
    if ($stmt) {
        $select = '<select name="select">';
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $select.='<option value="' . $row["packing"] . '">' . $row["packing"] . '</option>';
        }
    }
    $select.="</select>";
    echo $select;
        }
?>

<!------------------------------------------------------------------------------------------------->
<!------------------------------JAVA SCRIPT-------------------------------------------------------->
<!------------------------------------------------------------------------------------------------->
<script>
//remove rows
$(document).on('click', '#removeRows', function(){
		$(".itemRow:checked").each(function() {
			$(this).closest('tr').remove();
		});
		$('#checkAll').prop('checked', false);
        var totalAmount = 0; 
                        $("[id^='usd_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("usd_",'');
                            var price = $('#usd_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotal').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmount').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertax').val(parseFloat(totinc.toFixed(2)));
	});
  //Add row function
  $(document).ready(function(){
	$(document).on('click', '#checkAll', function() {          	
		$(".itemRow").prop("checked", this.checked);
	});	
	$(document).on('click', '.itemRow', function() {  	
		if ($('.itemRow:checked').length == $('.itemRow').length) {
			$('#checkAll').prop('checked', true);
		} else {
			$('#checkAll').prop('checked', false);
		}
	});  
	var count = $(".itemRow").length;
	$(document).on('click', '#addRows', function() { 
		count++;
		var htmlRows = '';
		htmlRows += '<tr>';
		htmlRows += '<td><input class="itemRow" type="checkbox"></td>';          
        htmlRows += '<td><SELECT  style="height:5%; width:160px;" id="description_'+count+'" class="form-control" name="description[]" onchange="document.write(<?php readaccounts(); ?>'
        htmlRows += '</select></td>';
        htmlRows += '<td><SELECT id="origin_'+count+'" style="height:5%; width:100px;" class="form-control" name="origin[]" onchange="document.write(<?php readorigin(); ?> </SELECT>';
                    $(document).on('change','#origin_'+count+'', function(){            
                        $.ajax({
                            url: 'QueryUsd.php',
                            type: 'post',
                            data: {Weight: $('#weight_'+count+'').val(),Origin: $('#origin_'+count+'').val(), Destination: $('#destination_'+count+'').val(),
                            Band: $('#band_'+count+'').val(), Packing: $('#packing_'+count+'').val(), Dimension: $('#dimension_'+count+'').val(),Rate: $('#rate').val()},
                            success: function(result){
                                $('#usd_'+count+'').val(result);
                            }
                            })
                    });
                    $(document).on('change','#origin_'+count+'', function(){  
                        $.ajax({
                            url: 'QueryKes.php',
                            type: 'post',
                            data: {Weight: $('#weight_'+count+'').val(),Origin: $('#origin_'+count+'').val(), Destination: $('#destination_'+count+'').val(),
                            Band: $('#band_'+count+'').val(), Packing: $('#packing_'+count+'').val(), Dimension: $('#dimension_'+count+'').val(),Rate: $('#rate').val()},
                            success: function(result){
                                $('#kes_'+count+'').val(result);
                            }
                            })
                    });
                    $(document).on('blur','#origin_'+count+'', function(){ 
                        var totalAmount = 0; 
                        $("[id^='usd_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("usd_",'');
                            var price = $('#usd_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotal').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmount').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertax').val(parseFloat(totinc.toFixed(2)));
                        });
                    $(document).on('blur','#origin_'+count+'', function(){ 
                        var totalAmount = 0; 
                        $("[id^='kes_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("kes_",'');
                            var price = $('#kes_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotalkes').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmountkes').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertaxkes').val(parseFloat(totinc.toFixed(2)));
                        });
        htmlRows += '</td>';
        htmlRows += '<td><SELECT style="height:5%;width:140px" class="form-control" id="destination_'+count+'" name="destination[]" onchange="document.write(<?php readdestination(); ?> </SELECT>';
                    $(document).on('change','#destination_'+count+'', function(){  
                        $.ajax({
                            url: 'QueryUsd.php',
                            type: 'post',
                            data: {Weight: $('#weight_'+count+'').val(),Origin: $('#origin_'+count+'').val(), Destination: $('#destination_'+count+'').val(),
                            Band: $('#band_'+count+'').val(), Packing: $('#packing_'+count+'').val(), Dimension: $('#dimension_'+count+'').val(),Rate: $('#rate').val()},
                            success: function(result){
                                $('#usd_'+count+'').val(result);
                            }
                            })
                    });
                    $(document).on('change','#destination_'+count+'', function(){  
                        $.ajax({
                            url: 'QueryKes.php',
                            type: 'post',
                            data: {Weight: $('#weight_'+count+'').val(),Origin: $('#origin_'+count+'').val(), Destination: $('#destination_'+count+'').val(),
                            Band: $('#band_'+count+'').val(), Packing: $('#packing_'+count+'').val(), Dimension: $('#dimension_'+count+'').val(),Rate: $('#rate').val()},
                            success: function(result){
                                $('#kes_'+count+'').val(result);
                            }
                            })
                    });   
                    $(document).on('blur','#destination_'+count+'', function(){ 
                        var totalAmount = 0; 
                        $("[id^='kes_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("kes_",'');
                            var price = $('#kes_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotalkes').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmountkes').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertaxkes').val(parseFloat(totinc.toFixed(2)));
                        });
                    $(document).on('blur','#destination_'+count+'', function(){ 
                        var totalAmount = 0; 
                        $("[id^='usd_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("usd_",'');
                            var price = $('#usd_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotal').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmount').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertax').val(parseFloat(totinc.toFixed(2)));
                        });
        htmlRows += '</td>';
        htmlRows += '<td><input type="text" class="form-control" id="awb_'+count+'" name="awb[]" style="width:150px;"/></td>';
        htmlRows += '<td><SELECT style="height:5%;width:120px" class="form-control" id="band_'+count+'" name="band[]" onchange="document.write(<?php readband(); ?> </SELECT>';
                    $(document).on('change','#band_'+count+'', function(){  
                        $.ajax({
                            url: 'QueryUsd.php',
                            type: 'post',
                            data: {Weight: $('#weight_'+count+'').val(),Origin: $('#origin_'+count+'').val(), Destination: $('#destination_'+count+'').val(),
                            Band: $('#band_'+count+'').val(), Packing: $('#packing_'+count+'').val(), Dimension: $('#dimension_'+count+'').val(),Rate: $('#rate').val()},
                            success: function(result){
                                $('#usd_'+count+'').val(result);
                            }
                            })
                    });
                    $(document).on('change','#band_'+count+'', function(){  
                        $.ajax({
                            url: 'QueryKes.php',
                            type: 'post',
                            data: {Weight: $('#weight_'+count+'').val(),Origin: $('#origin_'+count+'').val(), Destination: $('#destination_'+count+'').val(),
                            Band: $('#band_'+count+'').val(), Packing: $('#packing_'+count+'').val(), Dimension: $('#dimension_'+count+'').val(),Rate: $('#rate').val()},
                            success: function(result){
                                $('#kes_'+count+'').val(result);
                            }
                            })
                    }); 
                    $(document).on('blur','#band_'+count+'', function(){ 
                        var totalAmount = 0; 
                        $("[id^='usd_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("usd_",'');
                            var price = $('#usd_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotal').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmount').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertax').val(parseFloat(totinc.toFixed(2)));
                        });
                    $(document).on('blur','#band_'+count+'', function(){ 
                        var totalAmount = 0; 
                        $("[id^='kes_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("kes_",'');
                            var price = $('#kes_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotalkes').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmountkes').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertaxkes').val(parseFloat(totinc.toFixed(2)));
                        });    
        htmlRows += '</td>';
        htmlRows += '<td><input style="width:80px" class="form-control" id="width_'+count+'" type="number" name="width[]" value=0 />'
                    $(document).on('keyup','#width_'+count+'', function(){  
                        $.ajax({
                            url: 'QueryUsd.php',
                            type: 'post',
                            data: {Weight: $('#weight_'+count+'').val(),Origin: $('#origin_'+count+'').val(), Destination: $('#destination_'+count+'').val(),
                            Band: $('#band_'+count+'').val(), Packing: $('#packing_'+count+'').val(), Dimension: $('#dimension_'+count+'').val(),Rate: $('#rate').val()},
                            success: function(result){
                                $('#usd_'+count+'').val(result);
                            }
                            })
                    });
                    $(document).on('keyup','#width_'+count+'', function(){  
                        $.ajax({
                            url: 'QueryKes.php',
                            type: 'post',
                            data: {Weight: $('#weight_'+count+'').val(),Origin: $('#origin_'+count+'').val(), Destination: $('#destination_'+count+'').val(),
                            Band: $('#band_'+count+'').val(), Packing: $('#packing_'+count+'').val(), Dimension: $('#dimension_'+count+'').val(),Rate: $('#rate').val()},
                            success: function(result){
                                $('#kes_'+count+'').val(result);
                            }
                            })
                    });
                    $(document).on('blur','#width_'+count+'', function(){ 
                        var totalAmount = 0; 
                        $("[id^='usd_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("usd_",'');
                            var price = $('#usd_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotal').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmount').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertax').val(parseFloat(totinc.toFixed(2)));
                        });
                    $(document).on('blur','#width_'+count+'', function(){ 
                        var totalAmount = 0; 
                        $("[id^='kes_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("kes_",'');
                            var price = $('#kes_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotalkes').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmountkes').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertaxkes').val(parseFloat(totinc.toFixed(2)));
                        });
        htmlRows += '</td><td><input style="width:80px" class="form-control" id="height_'+count+'"" type="number" name="height[]" value=0 />'
                    $(document).on('keyup','#height_'+count+'', function(){  
                        $.ajax({
                            url: 'QueryUsd.php',
                            type: 'post',
                            data: {Weight: $('#weight_'+count+'').val(),Origin: $('#origin_'+count+'').val(), Destination: $('#destination_'+count+'').val(),
                            Band: $('#band_'+count+'').val(), Packing: $('#packing_'+count+'').val(), Dimension: $('#dimension_'+count+'').val(),Rate: $('#rate').val()},
                            success: function(result){
                                $('#usd_'+count+'').val(result);
                            }
                            })
                    }); 
                    $(document).on('keyup','#height_'+count+'', function(){  
                        $.ajax({
                            url: 'QueryKes.php',
                            type: 'post',
                            data: {Weight: $('#weight_'+count+'').val(),Origin: $('#origin_'+count+'').val(), Destination: $('#destination_'+count+'').val(),
                            Band: $('#band_'+count+'').val(), Packing: $('#packing_'+count+'').val(), Dimension: $('#dimension_'+count+'').val(),Rate: $('#rate').val()},
                            success: function(result){
                                $('#kes_'+count+'').val(result);
                            }
                            })
                    });
                    $(document).on('blur','#height_'+count+'', function(){ 
                        var totalAmount = 0; 
                        $("[id^='usd_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("usd_",'');
                            var price = $('#usd_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotal').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmount').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertax').val(parseFloat(totinc.toFixed(2)));
                        });
                    $(document).on('blur','#height_'+count+'', function(){ 
                        var totalAmount = 0; 
                        $("[id^='kes_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("kes_",'');
                            var price = $('#kes_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotalkes').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmountkes').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertaxkes').val(parseFloat(totinc.toFixed(2)));
                        });
        htmlRows += '</td>'
        htmlRows += '<td><input style="width:80px" class="form-control" id="length_'+count+'"" type="number" name="length[]" value=0 />'
                    $(document).on('keyup','#length_'+count+'', function(){  
                        $.ajax({
                            url: 'QueryUsd.php',
                            type: 'post',
                            data: {Weight: $('#weight_'+count+'').val(),Origin: $('#origin_'+count+'').val(), Destination: $('#destination_'+count+'').val(),
                            Band: $('#band_'+count+'').val(), Packing: $('#packing_'+count+'').val(), Dimension: $('#dimension_'+count+'').val(),Rate: $('#rate').val()},
                            success: function(result){
                                $('#usd_'+count+'').val(result);
                            }
                            })
                    });
                    $(document).on('keyup','#length_'+count+'', function(){  
                        $.ajax({
                            url: 'QueryKes.php',
                            type: 'post',
                            data: {Weight: $('#weight_'+count+'').val(),Origin: $('#origin_'+count+'').val(), Destination: $('#destination_'+count+'').val(),
                            Band: $('#band_'+count+'').val(), Packing: $('#packing_'+count+'').val(), Dimension: $('#dimension_'+count+'').val(),Rate: $('#rate').val()},
                            success: function(result){
                                $('#kes_'+count+'').val(result);
                            }
                            })
                    }); 
                    $(document).on('blur','#length_'+count+'', function(){ 
                        var totalAmount = 0; 
                        $("[id^='usd_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("usd_",'');
                            var price = $('#usd_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotal').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmount').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertax').val(parseFloat(totinc.toFixed(2)));
                        }); 
                    $(document).on('blur','#length_'+count+'', function(){ 
                        var totalAmount = 0; 
                        $("[id^='kes_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("kes_",'');
                            var price = $('#kes_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotalkes').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmountkes').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertaxkes').val(parseFloat(totinc.toFixed(2)));
                        });     
        htmlRows += '</td><td><input style="width:80px" class="form-control" id="dimension_'+count+'" type="text" name="dimension[]" value=0 readonly />'
                    $(document).on('keyup','#dimension_'+count+'', function(){  
                        $.ajax({
                            url: 'QueryUsd.php',
                            type: 'post',
                            data: {Weight: $('#weight_'+count+'').val(),Origin: $('#origin_'+count+'').val(), Destination: $('#destination_'+count+'').val(),
                            Band: $('#band_'+count+'').val(), Packing: $('#packing_'+count+'').val(), Dimension: $('#dimension_'+count+'').val(),Rate: $('#rate').val()},
                            success: function(result){
                                $('#usd_'+count+'').val(result);
                            }
                            })
                    });
                    $(document).on('keyup','#dimension_'+count+'', function(){  
                        $.ajax({
                            url: 'QueryKes.php',
                            type: 'post',
                            data: {Weight: $('#weight_'+count+'').val(),Origin: $('#origin_'+count+'').val(), Destination: $('#destination_'+count+'').val(),
                            Band: $('#band_'+count+'').val(), Packing: $('#packing_'+count+'').val(), Dimension: $('#dimension_'+count+'').val(),Rate: $('#rate').val()},
                            success: function(result){
                                $('#kes_'+count+'').val(result);
                            }
                            })
                    }); 
                    $(document).on('blur','#dimension_'+count+'', function(){ 
                        var totalAmount = 0; 
                        $("[id^='usd_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("usd_",'');
                            var price = $('#usd_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotal').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmount').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertax').val(parseFloat(totinc.toFixed(2)));
                        });
                    $(document).on('blur','#dimension_'+count+'', function(){ 
                        var totalAmount = 0; 
                        $("[id^='kes_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("kes_",'');
                            var price = $('#kes_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotalkes').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmountkes').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertaxkes').val(parseFloat(totinc.toFixed(2)));
                        });
        htmlRows += '</td>'
                    $(document).on('change','#width_'+count+', #height_'+count+',#length_'+count+'', function(){
                    var width = parseFloat($('#width_'+count+'').val()) || 0;
                    var height = parseFloat($('#height_'+count+'').val()) || 0;
                    var length = parseFloat($('#length_'+count+'').val()) || 0;
                    $('#dimension_'+count+'').val((width * height * length)/(5000)); });
        htmlRows += '<td><select style="height:5%;width:110px" class="form-control" id="packing_'+count+'" name="packing[]" onchange="document.write(<?php readpacking(); ?> </select>';
                    $(document).on('change','#packing_'+count+'', function(){  
                        $.ajax({
                            url: 'QueryUsd.php',
                            type: 'post',
                            data: {Weight: $('#weight_'+count+'').val(),Origin: $('#origin_'+count+'').val(), Destination: $('#destination_'+count+'').val(),
                            Band: $('#band_'+count+'').val(), Packing: $('#packing_'+count+'').val(), Dimension: $('#dimension_'+count+'').val(),Rate: $('#rate').val()},
                            success: function(result){
                                $('#usd_'+count+'').val(result);
                            }
                            })
                    });
                    $(document).on('change','#packing_'+count+'', function(){  
                        $.ajax({
                            url: 'QueryKes.php',
                            type: 'post',
                            data: {Weight: $('#weight_'+count+'').val(),Origin: $('#origin_'+count+'').val(), Destination: $('#destination_'+count+'').val(),
                            Band: $('#band_'+count+'').val(), Packing: $('#packing_'+count+'').val(), Dimension: $('#dimension_'+count+'').val(),Rate: $('#rate').val()},
                            success: function(result){
                                $('#kes_'+count+'').val(result);
                            }
                            })
                    });  
                    $(document).on('blur','#packing_'+count+'', function(){ 
                        var totalAmount = 0; 
                        $("[id^='usd_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("usd_",'');
                            var price = $('#usd_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotal').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmount').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertax').val(parseFloat(totinc.toFixed(2)));
                        }); 
                    $(document).on('blur','#packing_'+count+'', function(){ 
                        var totalAmount = 0; 
                        $("[id^='kes_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("kes_",'');
                            var price = $('#kes_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotalkes').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmountkes').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertaxkes').val(parseFloat(totinc.toFixed(2)));
                        }); 
        htmlRows += '</td>'
        htmlRows += '<td><input class="form-control" style="width:80px" type="number" id="weight_'+count+'" name="weight[]" value=0 />'
                    $(document).on('keyup','#weight_'+count+'', function(){  
                        $.ajax({
                            url: 'QueryUsd.php',
                            type: 'post',
                            data: {Weight: $('#weight_'+count+'').val(),Origin: $('#origin_'+count+'').val(), Destination: $('#destination_'+count+'').val(),
                            Band: $('#band_'+count+'').val(), Packing: $('#packing_'+count+'').val(), Dimension: $('#dimension_'+count+'').val(),Rate: $('#rate').val()},
                            success: function(result){
                                $('#usd_'+count+'').val(result);
                            }
                            })
                    });
                    $(document).on('keyup','#weight_'+count+'', function(){  
                        $.ajax({
                            url: 'QueryKes.php',
                            type: 'post',
                            data: {Weight: $('#weight_'+count+'').val(),Origin: $('#origin_'+count+'').val(), Destination: $('#destination_'+count+'').val(),
                            Band: $('#band_'+count+'').val(), Packing: $('#packing_'+count+'').val(), Dimension: $('#dimension_'+count+'').val(),Rate: $('#rate').val()},
                            success: function(result){
                                $('#kes_'+count+'').val(result);
                            }
                            })
                    });   
                    $(document).on('blur','#weight_'+count+'', function(){ 
                        var totalAmount = 0; 
                        $("[id^='usd_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("usd_",'');
                            var price = $('#usd_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotal').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmount').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertax').val(parseFloat(totinc.toFixed(2)));
                        }); 
                    $(document).on('blur','#weight_'+count+'', function(){ 
                        var totalAmount = 0; 
                        $("[id^='kes_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("kes_",'');
                            var price = $('#kes_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotalkes').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmountkes').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertaxkes').val(parseFloat(totinc.toFixed(2)));
                        });        
        htmlRows += '</td>'
        htmlRows += '<td><input style="width: 100px" class="form-control" type="text" id="usd_'+count+'" name="usd[]" value=0 readonly /></td>'
        htmlRows += '<td><input style="width: 100px" class="form-control" type="text" id="kes_'+count+'" name="kes[]" value=0 readonly /></td>'
        htmlRows += '<td><input style="width: 100px" class="form-control" type="number" id="branchusd_'+count+'" name="branchusd[]" value=0 /></td>'
        htmlRows += '<td><input style="width: 100px" class="form-control" type="number" id="branchkes_'+count+'" name="branchkes[]" value=0 /></td>'
        htmlRows += '</tr>';
		$('#invoiceItem').append(htmlRows);
	});
});
//function to get the destination
    function destination() {
        obj4 = document.getElementsByName("destination[]");
        objd = obj4[0];
        objd.options.length = 0;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var rows = JSON.parse(this.responseText);
            for (var i = 0; i < rows.length; i++) {
                var option = document.createElement("option");
                option.text = rows[i].locationname;
                option.value = rows[i].locationname;					
                objd.add(option, null);
                }
            }
        }
        xmlhttp.open("GET", "getdestinationvalue.php?de=destination", true);
        xmlhttp.send();
    }
//get the description
    function description() {
        obj2 = document.getElementsByName("description[]");
        obj = obj2[0];
        obj.options.length = 0;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var rows = JSON.parse(this.responseText);
            for (var i = 0; i < rows.length; i++) {
                var option = document.createElement("option");
                option.text = rows[i].description;
                option.value = rows[i].description;					
                obj.add(option, null);
                }
            }
        }
        xmlhttp.open("GET", "getmastervalue.php?d=accounts", true);
        xmlhttp.send();
    }
//get the origin
    function origin() {
            obj3 = document.getElementsByName("origin[]");
            objo = obj3[0];
            objo.options.length = 0;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
				var rows = JSON.parse(this.responseText);
                for (var i = 0; i < rows.length; i++) {
					var option = document.createElement("option");
					option.text = rows[i].FROMLOCATION;
					option.value = rows[i].FROMLOCATION;					
					objo.add(option, null);
				    }
                }
            }
            xmlhttp.open("GET", "getoriginvalue.php?o=origin", true);
            xmlhttp.send();
        }
//get the band
        function band() {
            obj5 = document.getElementsByName("band[]");
            objb = obj5[0];
            objb.options.length = 0;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
				var rows = JSON.parse(this.responseText);
                for (var i = 0; i < rows.length; i++) {
					var option = document.createElement("option");
					option.text = rows[i].band;
					option.value = rows[i].band;					
					objb.add(option, null);
				    }
                }
            }
            xmlhttp.open("GET", "getbandvalue.php?b=band", true);
            xmlhttp.send();
        }
//get packing
        function packing() {
            obj6 = document.getElementsByName("packing[]");
            objp = obj6[0];
            objp.options.length = 0;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
				var rows = JSON.parse(this.responseText);
                for (var i = 0; i < rows.length; i++) {
					var option = document.createElement("option");
					option.text = rows[i].packing;
					option.value = rows[i].packing;					
					objp.add(option, null);
				    }
                }
            }
            xmlhttp.open("GET", "getpackingvalue.php?p=packing", true);
            xmlhttp.send();
        }

</script>
<!-------------------------------------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------INVOICE SYSTEM------------------------------------------------>
<head>
<center>
<img src="delta_logo.jpg">
<h2>QUOTATION ENTRY</h2>
</center>
</head>
<body style="background-color: ghostwhite;">
<div class="container content-invoice" >
<form action="" id="invoice-form" method="post" class="invoice-form" role="form" novalidate="">
<div class="load-animate animated fadeInUp">
<div class="row">
<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
<table><tr><td>
<?php include('menu.php');?></td><td><label style='margin-left:100px;'>
<?php echo 'You are Logged in as:' . $_SESSION['users']; ?></label><td><td><label style="margin-left:10px;"><a href="index.php">sign out</a></label></td></tr></table>
</div>
</div>
<hr class='btn-info'>
<input id="currency" type="hidden" value="$">
<div class="container">
<!--------------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------------->
<!-----------------------------------------------Left floating Div----------------------------------------------->
<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
Quote reference no.:<input style="width:50%;" id="refno" name="refno" class="form-control" value='<?php
        $conn = sqlsrv_connect( $servername, $connectioninfo);  
        $sql = "select (prefix + '00000' + cast(nextautono as varchar)) as qono from _cplquoteno";
        $stmt = sqlsrv_query($conn,$sql);
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                echo $row["qono"];
        }
        sqlsrv_close($conn);	
        ?>' readonly/>
        <script type="text/javascript">
                document.getElementById('refno').value = "<?php echo $_GET['refno'];?>";
        </script>
        Quote date:<input style="width:50%;" type="date" id="date" name="date" class="form-control" required />
        <script type="text/javascript">
                document.getElementById('date').value = "<?php echo $_GET['date'];?>";
        </script>
        Customer Name:
        <?php
                    //type drop down
		            $conn = sqlsrv_connect( $servername, $connectioninfo);  
	                $sql = "select name from  client where dclink=4689";	
			        // $params = array();
			        // $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                    $stmt = sqlsrv_query($conn,$sql);
                    if ($stmt) {
                    echo"<select style='width:50%;height:5%' id='client' name='client' class='form-control' required >";
                    //echo "<option  value=" .$row["id"]. "> " .$row["shipment_no"]. "</option>";
                    echo "<option  value='' disabled selected hidden>Select client</option>";
                        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                            echo "<option  value='" .$row["name"]. "'> " .$row["name"]. "</option>";
                        }
                    echo"</select>";
                    }
                sqlsrv_close($conn);
                ?>
                <script type="text/javascript">
                        document.getElementById('name').value = "<?php echo $_GET['name'];?>";
                </script>
        Address:<input style="width:50%;" type="text" id="Address" name="address" class="form-control" required />
        <script type="text/javascript">
                document.getElementById('address').value = "<?php echo $_GET['address'];?>";
        </script>
        Contact No:<input style="width:50%;" type="text" id="contactno" name="contactno" class="form-control" required />
        <script type="text/javascript">
                document.getElementById('contactno').value = "<?php echo $_GET['contactno'];?>";
        </script>
        Contact Person:</label><input style="width:50%;margin-bottom:10px;" type="text" id="contperson" name="contperson" class="form-control" required />
        <script type="text/javascript">
                document.getElementById('contperson').value = "<?php echo $_GET['contperson'];?>";
        </script>            
</div>
<!-------------------------------------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------Right floating Div-------------------------------------------->
<div class="float-right">
Shipment Type:               
        <?php
                    //type drop down
		            $conn = sqlsrv_connect( $servername, $connectioninfo);  
	                $sql = "select distinct type from  _CPLPRICELISTNAME";	
			        // $params = array();
			        // $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                    $stmt = sqlsrv_query($conn,$sql);
                    if ($stmt) {
                    echo"<select style='height:5%' id='type' name='type' class='form-control float-right' required >";
                    //echo "<option  value=" .$row["id"]. "> " .$row["shipment_no"]. "</option>";
                    echo "<option  value='' disabled selected hidden>Select type</option>";
                        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                            echo "<option  value='" .$row["type"]. "'> " .$row["type"]. "</option>";
                        }
                    echo"</select>";
                    }
                sqlsrv_close($conn);
                ?>
                <script type="text/javascript">
                        document.getElementById('type').value = "<?php echo $_GET['type'];?>";
                </script>
                </br>
                Quote Status:<select style='height:5%' id='status' name='status' class='form-control float-right' required >
                    <option  value='' disabled selected hidden>Select status</option>
                    <option  value='In Progress'>In Progress</option>
                    <option  value='Lost'>Lost</option>
                    <option  value='Won'>Won</option>
                    <option  value='On Hold'>On Hold</option>
                </select>
                <script type="text/javascript">
                    document.getElementById('status').value = "<?php echo $_GET['status'];?>";
                </script>
                <br>
                Sales Person:</label>
                <?php
                    //sales rep drop down
		            $conn = sqlsrv_connect( $servername, $connectioninfo);  
	                $sql = "select name from salesrep where Rep_On_Hold='N'";	
                    $stmt = sqlsrv_query($conn,$sql);
                    if ($stmt) {
                    echo"<select style='height:5%' id='name' name='name' class='form-control float-right' required >";
                    echo "<option  value='' disabled selected hidden>Select rep</option>";
                        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                            echo "<option  value='" .$row["name"]. "'> " .$row["name"]. "</option>";
                        }
                    echo"</select>";
                    }
                sqlsrv_close($conn);
                ?>
                <script type="text/javascript">
                        document.getElementById('name').value = "<?php echo $_GET['name'];?>";
                </script>
        <br>
        Sales Supervisor:<input class="form-control" id="supervisor" name="supervisor" required />
        WSC:
        <?php
                    //sales project drop down
		            $conn = sqlsrv_connect( $servername, $connectioninfo);  
	                $sql = "select projectname from project where ActiveProject=1";	
                    $stmt = sqlsrv_query($conn,$sql);
                    if ($stmt) {
                    echo"<select style='height:5%' id='projectname' name='projectname' class='form-control float-right' required >";
                    echo "<option  value='' disabled selected hidden>Select WSC</option>";
                        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                            echo "<option  value='" .$row["projectname"]. "'> " .$row["projectname"]. "</option>";
                        }
                    echo"</select>";
                    }
                sqlsrv_close($conn);
                ?>
                <script type="text/javascript">
                        document.getElementById('projectname').value = "<?php echo $_GET['projectname'];?>";
                </script>
        <br>
         Exchange Rate(USD):<input type='number' id="rate" name="rate" class="form-control" value=1 required />
         <script>
            $(document).ready(function(){
            $('#rate').blur(function(){
                $.ajax({
                    url: 'QueryUsd.php',
                    type: 'post',
                    data: {Weight: $('#weight_1').val(),Origin: $('#origin_1').val(), Destination: $('destination_1').val(),
                    Band: $('#band_1').val(), Packing: $('#packing_1').val(), Dimension: $('#dimension_1').val(), Rate: $('#rate').val()},
                    success: function(result){
                        $('#usd_1').val(result);
                    }
                    })
                            }); 
                        });

        </script>
        <script type="text/javascript">
                        document.getElementById('rate').value = "<?php echo $_GET['rate'];?>";
        </script>
</div>
</div>
<!------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------Grid-Lines--------------------------------------------------->
<div class="row" style="overflow:scroll">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<table class="table table-bordered" id="invoiceItem">
<tr class='btn-success'>
<th width="2%"><input id="checkAll" class="formcontrol" type="checkbox"></th>
<th >GL Account</th><th>Origin</th><th>Destination</th><th>Awb</th><th>Band</th>
<th>Width(CM)</th><th>Height(CM)</th><th>Length(CM)</th><th>Dimensional Weight</th><th>Packing</th>
<th>Package Weight(KG)</th><th>Charge USD</th><th>Charge KES</th><th width="50%">Charge to Branch USD</th>
<th>Charge to Branch KES</th>
</tr>
<tr>
<td><input class="itemRow" type="checkbox" ></td>
<td><SELECT  style='height:5%; width:160px;' id="description_1" name="description[]" class='form-control' > <script>description();</script> </SELECT></td>
<td><SELECT style='height:5%;width:100px;' id="origin_1" name="origin[]" class='form-control' > <script>origin();</script> </SELECT>
<script>
    $(document).ready(function(){
    $('#origin_1').change(function(){
        $.ajax({
            url: 'QueryUsd.php',
            type: 'post',
            data: {Weight: $('#weight_1').val(),Origin: $('#origin_1').val(), Destination: $('destination_1').val(),
            Band: $('#band_1').val(), Packing: $('#packing_1').val(), Dimension: $('#dimension_1').val(), Rate: $('#rate').val()},
            success: function(result){
                $('#usd_1').val(result);
            }
            })
                    }); 
                });
</script>
<script>
 $(document).ready(function(){
    $('#origin_1').blur(function(){
    var totalAmount = 0; 
                        $("[id^='usd_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("usd_",'');
                            var price = $('#usd_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotal').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmount').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertax').val(parseFloat(totinc.toFixed(2)));
    });
 });
</script>
<!------kes totals------>
<script>
 $(document).ready(function(){
    $('#origin_1').blur(function(){
    var totalAmount = 0; 
                        $("[id^='kes_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("kes_",'');
                            var price = $('#kes_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotalkes').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmountkes').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertaxkes').val(parseFloat(totinc.toFixed(2)));
    });
 });
</script>
<script>
    $(document).ready(function(){
    $('#origin_1').change(function(){
        $.ajax({
            url: 'QueryKes.php',
            type: 'post',
            data: {Weight: $('#weight_1').val(),Origin: $('#origin_1').val(), Destination: $('#destination_1').val(),
            Band: $('#band_1').val(), Packing: $('packing_1').val(), Dimension: $('#dimension_1').val(), Rate: $('#rate').val()},
            success: function(result){
                $('#kes_1').val(result);
            }
            })
                    }); 
                });
</script>
</td>
<td><SELECT style='height:5%;width:140px' id="destination_1" name="destination[]" class='form-control'> <script>destination();</script> </SELECT>
<script>
    $(document).ready(function(){
    $('#destination_1').change(function(){
        $.ajax({
            url: 'QueryUsd.php',
            type: 'post',
            data: {Weight: $('#weight_1').val(),Origin: $('#origin_1').val(), Destination: $('#destination_1').val(),
            Band: $('#band_1').val(), Packing: $('#packing_1').val(), Dimension: $('#dimension_1').val(), Rate: $('#rate').val()},
            success: function(result){
                $('#usd_1').val(result);
            }
            })
                    }); 
                });
</script>
            <script>
    $(document).ready(function(){
    $('#destination_1').change(function(){
        $.ajax({
            url: 'QueryKes.php',
            type: 'post',
            data: {Weight: $('#weight_1').val(),Origin: $('#origin_1').val(), Destination: $('#destination_1').val(),
            Band: $('#band_1').val(), Packing: $('#packing_1').val(), Dimension: $('#dimension_1').val(), Rate: $('#rate').val()},
            success: function(result){
                $('#kes_1').val(result);
            }
            })
                    }); 
                });
</script>
<script>
 $(document).ready(function(){
    $('#destination_1').blur(function(){
    var totalAmount = 0; 
                        $("[id^='usd_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("usd_",'');
                            var price = $('#usd_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotal').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmount').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertax').val(parseFloat(totinc.toFixed(2)));
    });
 });
</script>
<script>
 $(document).ready(function(){
    $('#destination_1').blur(function(){
    var totalAmount = 0; 
                        $("[id^='kes_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("kes_",'');
                            var price = $('#kes_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotalkes').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmountkes').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertaxkes').val(parseFloat(totinc.toFixed(2)));
    });
 });
</script>
</td>
<td><input type="text" class="form-control" id="awb_1" name="awb[]" style="width:150px;" /></td>
            <td><SELECT style='height:5%;width:120px' id="band_1" name="band[]" class='form-control'> <script>band();</script> </SELECT>
            <script>
                $(document).ready(function(){
                $('#band_1').change(function(){
                    $.ajax({
                        url: 'QueryUsd.php',
                        type: 'post',
                        data: {Weight: $('#weight_1').val(),Origin: $('#origin_1').val(), Destination: $('#destination_1').val(),
                        Band: $('#band_1').val(), Packing: $('#packing_1').val(), Dimension: $('#dimension_1').val(), Rate: $('#rate').val()},
                        success: function(result){
                            $('#usd_1').val(result);
                        }
                        })
                    }); 
                });
            </script>
            <script>
                $(document).ready(function(){
                $('#band_1').change(function(){
                    $.ajax({
                        url: 'QueryKes.php',
                        type: 'post',
                        data: {Weight: $('#weight_1').val(),Origin: $('#origin_1').val(), Destination: $('#destination_1').val(),
                        Band: $('#band_1').val(), Packing: $('#packing_1').val(), Dimension: $('#dimension_1').val(),Rate: $('#rate').val()},
                        success: function(result){
                            $('#kes_1').val(result);
                        }
                        })
                    }); 
                });
            </script>
            <script>
            $(document).ready(function(){
                $('#band_1').blur(function(){
                var totalAmount = 0; 
                        $("[id^='usd_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("usd_",'');
                            var price = $('#usd_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotal').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmount').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertax').val(parseFloat(totinc.toFixed(2)));
                });
            });
</script>
<script>
            $(document).ready(function(){
                $('#band_1').blur(function(){
                var totalAmount = 0; 
                        $("[id^='kes_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("kes_",'');
                            var price = $('#kes_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotalkes').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmountkes').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertaxkes').val(parseFloat(totinc.toFixed(2)));
                });
            });
</script>
            </td>
            <td><input  style='width:80px' id="width_1" type="number" name="width[]" value=0 class='form-control' />
            <script>
                $(document).ready(function(){
                $('#width_1').keyup(function(){
                    $.ajax({
                        url: 'QueryUsd.php',
                        type: 'post',
                        data: {Weight: $('#weight_1').val(),Origin: $('#origin_1').val(), Destination: $('#destination_1').val(),
                        Band: $('#band_1').val(), Packing: $('#packing_1').val(), Dimension: $('#dimension_1').val(),Rate: $('#rate').val()},
                        success: function(result){
                            $('#usd_1').val(result);
                        }
                        })
                    }); 
                });
            </script>
            <script>
                $(document).ready(function(){
                $('#width_1').keyup(function(){
                    $.ajax({
                        url: 'QueryKes.php',
                        type: 'post',
                        data: {Weight: $('#weight_1').val(),Origin: $('#origin_1').val(), Destination: $('#destination_1').val(),
                        Band: $('#band_1').val(), Packing: $('#packing_1').val(), Dimension: $('#dimension_1').val(),Rate: $('#rate').val()},
                        success: function(result){
                            $('#kes_1').val(result);
                        }
                        })
                    }); 
                });
            </script>
            <script>
            $(document).ready(function(){
                $('#width_1').blur(function(){
                var totalAmount = 0; 
                        $("[id^='usd_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("usd_",'');
                            var price = $('#usd_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotal').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmount').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertax').val(parseFloat(totinc.toFixed(2)));
                });
            });
</script>
<script>
            $(document).ready(function(){
                $('#width_1').blur(function(){
                var totalAmount = 0; 
                        $("[id^='kes_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("kes_",'');
                            var price = $('#kes_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotalkes').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmountkes').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertaxkes').val(parseFloat(totinc.toFixed(2)));
                });
            });
</script>
            </td>
            <td><input style='width:80px' id="height_1" type="number" name="height[]" value=0 class='form-control'/>
            <script>
                $(document).ready(function(){
                $('#height_1').keyup(function(){
                    $.ajax({
                        url: 'QueryUsd.php',
                        type: 'post',
                        data: {Weight: $('#weight_1').val(),Origin: $('#origin_1').val(), Destination: $('#destination_1').val(),
                        Band: $('#band_1').val(), Packing: $('#packing_1').val(), Dimension: $('#dimension_1').val(),Rate: $('#rate').val()},
                        success: function(result){
                            $('#usd_1').val(result);
                        }
                        })
                    }); 
                }); 
            </script>
                        <script>
                $(document).ready(function(){
                $('#height_1').keyup(function(){
                    $.ajax({
                        url: 'QueryKes.php',
                        type: 'post',
                        data: {Weight: $('#weight_1').val(),Origin: $('#origin_1').val(), Destination: $('#destination_1').val(),
                        Band: $('#band_1').val(), Packing: $('#packing_1').val(), Dimension: $('#dimension_1').val(),Rate: $('#rate').val()},
                        success: function(result){
                            $('#kes_1').val(result);
                        }
                        })
                    }); 
                });
            </script>
            <script>
            $(document).ready(function(){
                $('#height_1').blur(function(){
                var totalAmount = 0; 
                        $("[id^='usd_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("usd_",'');
                            var price = $('#usd_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotal').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmount').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertax').val(parseFloat(totinc.toFixed(2)));
                });
            });
</script>
<script>
            $(document).ready(function(){
                $('#height_1').blur(function(){
                var totalAmount = 0; 
                        $("[id^='kes_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("kes_",'');
                            var price = $('#kes_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotalkes').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmountkes').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertaxkes').val(parseFloat(totinc.toFixed(2)));
                });
            });
</script>
            </td>
            <td><input style='width:80px' id="length_1" type="number" name="length[]" value=0 class='form-control'/>
            <script>
                $(document).ready(function(){
                $('#length').keyup(function(){
                    $.ajax({
                        url: 'QueryUsd.php',
                        type: 'post',
                        data: {Weight: $('#weight_1').val(),Origin: $('#origin_1').val(), Destination: $('#destination_1').val(),
                        Band: $('#band_1').val(), Packing: $('#packing_1').val(), Dimension: $('#dimension_1').val(),Rate: $('#rate').val()},
                        success: function(result){
                            $('#usd_1').val(result);
                        }
                        })
                    }); 
                });
            </script>
                        <script>
                $(document).ready(function(){
                $('#length').keyup(function(){
                    $.ajax({
                        url: 'QueryKes.php',
                        type: 'post',
                        data: {Weight: $('#weight_1').val(),Origin: $('#origin_1').val(), Destination: $('#destination_1').val(),
                        Band: $('#band_1').val(), Packing: $('#packing_1').val(), Dimension: $('#dimension_1').val(),Rate: $('#rate').val()},
                        success: function(result){
                            $('#kes_1').val(result);
                        }
                        })
                    }); 
                });
            </script>
            <script>
            $(document).ready(function(){
                $('#length_1').blur(function(){
                var totalAmount = 0; 
                        $("[id^='usd_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("usd_",'');
                            var price = $('#usd_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotal').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmount').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertax').val(parseFloat(totinc.toFixed(2)));
                });
            });
</script>
            <script>
            $(document).ready(function(){
                $('#height_1').blur(function(){
                var totalAmount = 0; 
                        $("[id^='usd_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("usd_",'');
                            var price = $('#usd_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotal').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmount').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertax').val(parseFloat(totinc.toFixed(2)));
                });
            });
</script>
<script>
            $(document).ready(function(){
                $('#height_1').blur(function(){
                var totalAmount = 0; 
                        $("[id^='kes_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("kes_",'');
                            var price = $('#kes_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotalkes').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmountkes').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertaxkes').val(parseFloat(totinc.toFixed(2)));
                });
            });
</script>
            </td>
            <td><input style='width:80px' id="dimension_1" type="number" name="dimension[]" value=0 readonly class='form-control' />
<!--------------------------------script to pass parameters to get price on dimension change-------------->
<!-------------------------------------------------------------------------------------------------------->
            <script>
                $(document).ready(function(){
                $('#dimension_1').keyup(function(){
                    $.ajax({
                        url: 'QueryUsd.php',
                        type: 'post',
                        data: {Weight: $('#weight_1').val(),Origin: $('#origin_1').val(), Destination: $('#destination_1').val(),
                        Band: $('#band_1').val(), Packing: $('#packing_1').val(), Dimension: $('#dimension_1').val(),Rate: $('#rate').val()},
                        success: function(result){
                            $('#usd_1').val(result);
                        }
                        })
                    }); 
                });
            </script>
                        <script>
                $(document).ready(function(){
                $('#dimension_1').keyup(function(){
                    $.ajax({
                        url: 'QueryKes.php',
                        type: 'post',
                        data: {Weight: $('#weight_1').val(),Origin: $('#origin_1').val(), Destination: $('#destination_1').val(),
                        Band: $('#band_1').val(), Packing: $('#packing_1').val(), Dimension: $('#dimension_1').val(),Rate: $('#rate').val()},
                        success: function(result){
                            $('#kes_1').val(result);
                        }
                        })
                    });  
                });
            </script>
            <script>
            $(document).ready(function(){
                $('#dimension_1').blur(function(){
                var totalAmount = 0; 
                        $("[id^='usd_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("usd_",'');
                            var price = $('#usd_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotal').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmount').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertax').val(parseFloat(totinc.toFixed(2)));
                });
            });
</script>
<script>
            $(document).ready(function(){
                $('#dimension_1').blur(function(){
                var totalAmount = 0; 
                        $("[id^='kes_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("kes_",'');
                            var price = $('#kes_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotalkes').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmountkes').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertaxkes').val(parseFloat(totinc.toFixed(2)));
                });
            });
</script>
            </td>
            <script>
                    $(document).on("change","#width_1, #height_1,#length_1", function(){
                        var width = parseFloat($("#width_1").val()) || 0;
                        var height = parseFloat($("#height_1").val()) || 0;
                        var length = parseFloat($('#length_1').val()) || 0;
                        $('#dimension_1').val((width * height * length)/(5000));   
                    });
            </script>
            <td><SELECT style='height:5%;width:110px' id="packing_1" name="packing[]" class='form-control'> <script>packing();</script> </SELECT>
<!-----------------------------------script to pass parameters to get price on packing change-------------->
<!--------------------------------------------------------------------------------------------------------->
            <script>
                $(document).ready(function(){
                $('#packing_1').change(function(){
                    $.ajax({
                        url: 'QueryUsd.php',
                        type: 'post',
                        data: {Weight: $('#weight_1').val(),Origin: $('#origin_1').val(), Destination: $('#destination_1').val(),
                        Band: $('#band_1').val(), Packing: $('#packing_1').val(), Dimension: $('#dimension_1').val(),Rate: $('#rate').val()},
                        success: function(result){
                            $('#usd_1').val(result);
                        }
                        })
                    }); 
                });
            </script>
            <script>
                $(document).ready(function(){
                $('#packing_1').change(function(){
                    $.ajax({
                        url: 'QueryKes.php',
                        type: 'post',
                        data: {Weight: $('#weight_1').val(),Origin: $('#origin_1').val(), Destination: $('#destination_1').val(),
                        Band: $('#band_1').val(), Packing: $('#packing_1').val(), Dimension: $('#dimension_1').val(),Rate: $('#rate').val()},
                        success: function(result){
                            $('#kes_1').val(result);
                        }
                        })
                    }); 
                });
            </script>
            <script>
            $(document).ready(function(){
                $('#packing_1').blur(function(){
                var totalAmount = 0; 
                        $("[id^='usd_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("usd_",'');
                            var price = $('#usd_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotal').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmount').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertax').val(parseFloat(totinc.toFixed(2)));
                });
            });
</script>
<script>
            $(document).ready(function(){
                $('#packing_1').blur(function(){
                var totalAmount = 0; 
                        $("[id^='kes_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("kes_",'');
                            var price = $('#kes_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotalkes').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmountkes').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertaxkes').val(parseFloat(totinc.toFixed(2)));
                });
            });
</script>
            </td>
            <td><input style='width:80px' id="weight_1" type="number" name="weight[]" value=0 class='form-control'/>
<!-----------------------------------script to pass parameters to get price on weight change-------------->
<!-------------------------------------------------------------------------------------------------------->
            <script>
                $(document).ready(function(){
                $('#weight_1').keyup(function(){
                    $.ajax({
                        url: 'QueryUsd.php',
                        type: 'post',
                        data: {Weight: $('#weight_1').val(),Origin: $('#origin_1').val(), Destination: $('#destination_1').val(),
                        Band: $('#band_1').val(), Packing: $('#packing_1').val(), Dimension: $('#dimension_1').val(),Rate: $('#rate').val()},
                        success: function(result){
                            $('#usd_1').val(result);
                        }
                        })
                    });  
                });
            </script>
            <script>
                $(document).ready(function(){
                $('#weight_1').keyup(function(){
                    $.ajax({
                        url: 'Querykes.php',
                        type: 'post',
                        data: {Weight: $('#weight_1').val(),Origin: $('#origin_1').val(), Destination: $('#destination_1').val(),
                        Band: $('#band_1').val(), Packing: $('#packing_1').val(), Dimension: $('#dimension_1').val(),Rate: $('#rate').val()},
                        success: function(result){
                            $('#kes_1').val(result);
                        }
                        })
              
                    }); 
                });
            </script>
            <script>
            $(document).ready(function(){
                $('#weight_1').blur(function(){
                var totalAmount = 0; 
                        $("[id^='usd_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("usd_",'');
                            var price = $('#usd_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotal').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmount').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertax').val(parseFloat(totinc.toFixed(2)));
                });
            });
</script>
<script>
            $(document).ready(function(){
                $('#weight_1').blur(function(){
                var totalAmount = 0; 
                        $("[id^='kes_']").each(function() {
                            var id = $(this).attr('id');
                            id = id.replace("kes_",'');
                            var price = $('#kes_'+id).val();
                            var total = (parseFloat(price));
                            //$('#total_'+id).val(parseFloat(total));
                            totalAmount += total;	
                        });
                        $('#subTotalkes').val(parseFloat(totalAmount.toFixed(2)));
                        var taxamt=0;
                        taxamt=totalAmount*0.16;
                        $('#taxAmountkes').val(parseFloat(taxamt.toFixed(2)));
                        var totinc=0;
                        totinc=totalAmount+=(totalAmount*0.16);
                        $('#totalAftertaxkes').val(parseFloat(totinc.toFixed(2)));
                });
            });
</script>
            </td>
            <td><input style='width: 100px' id="usd_1" type="number" name="usd[]" value=0 readonly class='form-control'/></td>
            <td><input style='width: 100px' id="kes_1" type="number" name="kes[]" value=0 readonly class='form-control'/></td>
            <td><input style='width: 100px' type="text" id="branchusd_1" name="branchusd[]" value=0 class='form-control' /></td>
            <td><input style='width: 100px' type="text" id="branchkes_1" name="branchkes[]" value=0 class='form-control'/></td> 
</tr>
</table>
</div>
</div>
<!-----------------------------BOTTOM PART OF THE QUOTE DOCUMENT------------------->
<!--------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------->
<div class="row" style="margin-bottom:10px;">
<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
<button class="btn btn-danger delete" id="removeRows" type="button" style="margin-top:10px;">- Delete</button>
<button class="btn btn-success" id="addRows" type="button" style="margin-top:10px;">+ Add More</button>
</div>
</div>
<div class="row">
<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
<h3>Notes: </h3>
<div class="form-group">
<textarea class="form-control txt" rows="2" name="notes" id="notes" placeholder="Your Notes"></textarea>
<br>
PAYMENT DETAILS:<br>
<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
PAYMENT MODE1:
<select id="mode1" name="mode1" class="form-control" style="width:150px;height:30px">
    <option value="None">None</option>
    <option value="Card">Card</option>
    <option value="Cash">Cash</option>
    <option value="EFT">EFT</option>
    <option value="Cheque">Cheque</option>
    <option value="Mpesa">Mpesa</option>
</select>
MPESA REF1:
<input class="form-control" id="ref1" name="ref1" type="text" style="width:150px;" value="None" />
PAYMENT1:
<input class="form-control" id="pay1" name="pay1" type="number" style="width:150px;" value=0 />
</div>
<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
PAYMENT MODE2:
<select id="mode2" name="mode2" class="form-control" style="width:150px;height:30px">
    <option value="None">None</option>
    <option value="Card">Card</option>
    <option value="Cash">Cash</option>
    <option value="EFT">EFT</option>
    <option value="Cheque">Cheque</option>
    <option value="Mpesa">Mpesa</option>
</select>
MPESA REF2:
<input class="form-control" id="ref2" name="ref2" type="text" style="width:150px;" value="None" />
PAYMENT2:
<input class="form-control" id="pay2" name="pay2" type="number" style="width:150px;" value=0 />
</div>
</div>
<br>
<div class="form-group">
<input type="hidden" value="<?php echo $_SESSION['userid']; ?>" class="form-control" name="userId">
<br>
<input data-loading-text="Saving Quote..." type="submit" name="invoice_btn" value="Save Quote" class="btn btn-success submit_btn invoice-save-btm" style="margin-top:10px;">
<input data-loading-text="Saving Quote..." type="submit" name="sage_btn" value="Post To Sage" class="btn btn-success submit_btn invoice-save-btm" style="margin-top:10px;">

</div>
</div>
<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
<span class="form-inline">
<div class="form-group">
<label>Subtotal:  </label>
<div class="input-group">
<div class="input-group-addon currency">$</div>
<input  style="width:130px;margin-right:5px;" type="number" class="form-control" name="subTotal" id="subTotal" placeholder="Subtotal" readonly/>
<div class="input-group-addon currency">Kshs</div>
<input style="width:130px;" type="number" class="form-control" name="subTotalkes" id="subTotalkes" placeholder="Subtotal" readonly/>
</div>
</div>
<div class="form-group">
<label>Tax Rate:  </label>
<div class="input-group">
<input style="width:319px" type="number" class="form-control" name="taxRate" id="taxRate"  value=16 readonly/>
<div class="input-group-addon">%</div>
</div>
</div>
<div class="form-group">
<label>Tax Amount:  </label>
<div class="input-group">
<div class="input-group-addon currency">$</div>
<input style="width:130px;margin-right:5px;" type="number" class="form-control" name="taxAmount" id="taxAmount" placeholder="Tax Amount" readonly />
<div class="input-group-addon currency">Kshs</div>
<input style="width:130px;" type="number" class="form-control" name="taxAmountkes" id="taxAmountkes" placeholder="Tax Amount" readonly />
</div>
</div>
<div class="form-group">
<label>Total:  </label>
<div class="input-group">
<div class="input-group-addon currency">$</div>
<input style="width:130px;margin-right:5px;" type="number" class="form-control" name="totalAftertax" id="totalAftertax" placeholder="Total" readonly />
<div class="input-group-addon currency">Kshs</div>
<input style="width:130px;" type="number" class="form-control" name="totalAftertaxkes" id="totalAftertaxkes" placeholder="Total" readonly />
</div>
</div>
</span>
</div>
</div>
<div class="clearfix"></div>
</div>
<!--------------------POST INTO UTILITY------>
<?php
include("config.php");
if(isset($_POST['invoice_btn'])){ 
///top form
$refno=$_POST['refno'] ?? '';
$date=$_POST['date'] ?? '';
$address=$_POST['address'] ?? '';
$contactno=$_POST['contactno'] ?? '';
$contperson=$_POST['contperson'] ?? '';
$type=$_POST['type'] ?? '';
$status=$_POST['status'] ?? '';
$name=$_POST['name'] ?? '';
$supervisor=$_POST['supervisor'] ?? '';
$projectname=$_POST['projectname'] ?? '';
$rate=$_POST['rate'] ?? 0;
$client=$_POST['client'] ?? '';
$subtotal=$_POST['subTotal'] ?? 0;
$totaltax=$_POST['taxAmount'] ?? 0;
$total=$_POST['totalAftertax'] ?? 0;
$subtotalkes=$_POST['subTotalkes'] ?? 0;
$totaltaxkes=$_POST['taxAmountkes'] ?? 0;
$totalkes=$_POST['totalAftertaxkes'] ?? 0;
$ref1=$_POST['ref1'] ?? '';
$pay1=$_POST['pay1'] ?? 0;
$ref2=$_POST['ref2'] ?? '';
$pay2=$_POST['pay2'] ?? 0;
$mode1=$_POST['mode1'] ?? '';
$mode2=$_POST['mode2'] ?? '';
$notes=$_POST['notes'] ?? '';
///grid lines
$description = $_POST['description'] ?? '';
$origin = $_POST['origin'] ?? '';
$destination = $_POST['destination'] ?? '';
$awb = $_POST['awb'] ?? '';
$band = $_POST['band'] ?? '';
$width = $_POST['width'] ?? 0;
$height = $_POST['height'] ?? 0;
$length = $_POST['length'] ?? 0;
$dimension = $_POST['dimension'] ?? 0;
$packing = $_POST['packing'] ?? '';
$weight = $_POST['weight'] ?? '';
$usd = $_POST['usd'] ?? 0;
$kes = $_POST['kes'] ?? 0;
$branchusd = $_POST['branchusd'] ?? 0;
$branchkes = $_POST['branchkes'] ?? 0;

$id=$_SESSION['userid'];
///insert top part of quote
$update="
declare @quno as varchar(50)
set @quno =(select 'QO'+ cast(format(NextAutoNo,'0000000') as varchar) from _CPLQUOTENO)
insert into _cplquotemaster(user_id, order_date,contact_person,contact_no,order_no,order_receiver_name, order_receiver_address, shipment_type, 
status,  sales_person, sales_supervisor, wsc, order_total_before_tax, order_total_tax, order_total_after_tax, order_amount_paid, order_total_amount_due,rate,
mpesaref1,payment1, mpesaref2, payment2,paymenttype1,paymenttype2,order_total_before_tax_kes,order_total_tax_kes,order_total_after_tax_kes,notes) 
values ($id,convert(date,'$date'),'$contperson','$contactno', @quno,'$client', '$address', '$type','$status',
'$name','$supervisor','$projectname',$subtotal,$totaltax, $total,0,0,$rate,'$ref1',$pay1,'$ref2',$pay2,'$mode1','$mode2',$subtotalkes,$totaltaxkes,$totalkes,'$notes')";

sqlsrv_query($conn, $update) or die(print_r( sqlsrv_errors(), true));
///insert bottom part of the quote
for($i = 0; $i < count($description); $i++){
$insertgrid="
declare @quno as varchar(50)
set @quno =(select 'QO'+ cast(format(NextAutoNo,'0000000') as varchar) from _CPLQUOTENO)
insert into _cplquotelines (order_id,item_code,item_name,origin,destination,band,width,height,length,dimension,packing,package_weight,
order_item_quantity, order_item_price_usd, order_item_price_kes, charge_branch_usd, charge_branch_kes,awb) 
values (@quno,'$description[$i]','$description[$i]', '$origin[$i]','$destination[$i]','$band[$i]',
'$width[$i]','$height[$i]','$length[$i]','$dimension[$i]','$packing[$i]', '$weight[$i]',1,$usd[$i],$kes[$i],$branchusd[$i],$branchkes[$i],'$awb[$i]')";
sqlsrv_query($conn, $insertgrid) or die(print_r( sqlsrv_errors(), true));
}
$refno="(select ('QO'+ cast(format(NextAutoNo,'0000000') as varchar)) as no from _CPLQUOTENO)";
$st=sqlsrv_query($conn, $refno);
while( $row = sqlsrv_fetch_array( $st, SQLSRV_FETCH_ASSOC)) {
$no=$row["no"];
echo("<script> alert('Quote no.$no has been created');document.getElementById('myForm').style.display = 'block';</script>");
}
///update the next quote number
$updatenextno="update _cplquoteno set nextautono=nextautono+1";
sqlsrv_query($conn, $updatenextno) or die(print_r( sqlsrv_errors(), true));
}
?>
<!--------------------POST INTO SAGE------>
<?php
include("config.php");
if(isset($_POST['sage_btn'])){ 
///top form
$refno=$_POST['refno'] ?? '';
$date=$_POST['date'] ?? '';
$address=$_POST['address'] ?? '';
$contactno=$_POST['contactno'] ?? '';
$contperson=$_POST['contperson'] ?? '';
$type=$_POST['type'] ?? '';
$status=$_POST['status'] ?? '';
$name=$_POST['name'] ?? '';
$supervisor=$_POST['supervisor'] ?? '';
$projectname=$_POST['projectname'] ?? '';
$rate=$_POST['rate'] ?? 0;
$client=$_POST['client'] ?? '';
$subtotal=$_POST['subTotal'] ?? 0;
$totaltax=$_POST['taxAmount'] ?? 0;
$total=$_POST['totalAftertax'] ?? 0;
$subtotalkes=$_POST['subTotalkes'] ?? 0;
$totaltaxkes=$_POST['taxAmountkes'] ?? 0;
$totalkes=$_POST['totalAftertaxkes'] ?? 0;
$ref1=$_POST['ref1'] ?? '';
$pay1=$_POST['pay1'] ?? 0;
$ref2=$_POST['ref2'] ?? '';
$pay2=$_POST['pay2'] ?? 0;
$mode1=$_POST['mode1'] ?? '';
$mode2=$_POST['mode2'] ?? '';
$notes=$_POST['notes'] ?? '';

///grid lines
$description = $_POST['description'] ?? '';
$origin = $_POST['origin'] ?? '';
$destination = $_POST['destination'] ?? '';
$awb = $_POST['awb'] ?? '';
$band = $_POST['band'] ?? '';
$width = $_POST['width'] ?? 0;
$height = $_POST['height'] ?? 0;
$length = $_POST['length'] ?? 0;
$dimension = $_POST['dimension'] ?? 0;
$packing = $_POST['packing'] ?? '';
$weight = $_POST['weight'] ?? 0;
$usd = $_POST['usd'] ?? 0;
$kes = $_POST['kes'] ?? 0;
$branchusd = $_POST['branchusd'] ?? 0;
$branchkes = $_POST['branchkes'] ?? 0;
$check="select order_no from _cplquotemaster where order_no='$refno'";
$stmt1=sqlsrv_query($conn, $check);
$row=sqlsrv_num_rows($stmt1);
//Check if quote has been created in _cplquotemaster
if ($row==0) {
        $id=$_SESSION['userid'];
        $update="
        declare @quno as varchar(50)
        set @quno =(select 'QO'+ cast(format(NextAutoNo,'0000000') as varchar) from _CPLQUOTENO)
        insert into _cplquotemaster(user_id, order_date,contact_person,contact_no,order_no,order_receiver_name, order_receiver_address, shipment_type, 
        status,  sales_person, sales_supervisor, wsc, order_total_before_tax, order_total_tax, order_total_after_tax, order_amount_paid, order_total_amount_due,rate,
        mpesaref1,payment1, mpesaref2, payment2,paymenttype1,paymenttype2, order_total_before_tax_kes, order_total_tax_kes,order_total_after_tax_kes,notes) 
        values ($id,convert(date,'$date'),'$contperson','$contactno', @quno,'$client', '$address', '$type','$status',
        '$name','$supervisor','$projectname',$subtotal,$totaltax, $total,0,0,$rate,'$ref1',$pay1,'$ref2',$pay2,'$mode1','$mode2',$subtotalkes,$totaltaxkes,$totalkes,'$notes')";
        sqlsrv_query($conn, $update) or die(print_r( sqlsrv_errors(), true));
        ///insert bottom part of the quote
        for($i = 0; $i < count($description); $i++){
        $insertgrid="
        declare @quno as varchar(50)
        set @quno =(select 'QO'+ cast(format(NextAutoNo,'0000000') as varchar) from _CPLQUOTENO)
        insert into _cplquotelines (order_id,item_code,item_name,origin,destination,band,width,height,length,dimension,packing,package_weight,
        order_item_quantity, order_item_price_usd, order_item_price_kes, charge_branch_usd, charge_branch_kes,awb) 
        values (@quno,'$description[$i]','$description[$i]', '$origin[$i]','$destination[$i]','$band[$i]',
        '$width[$i]','$height[$i]','$length[$i]','$dimension[$i]','$packing[$i]', '$weight[$i]',1,$usd[$i],$kes[$i],$branchusd[$i],$branchkes[$i],'$awb[$i]')";
        sqlsrv_query($conn, $insertgrid) or die(print_r( sqlsrv_errors(), true));
        }
        $refno="(select ('QO'+ cast(format(NextAutoNo,'0000000') as varchar)) as no from _CPLQUOTENO)";
        $st=sqlsrv_query($conn, $refno);
        while( $row = sqlsrv_fetch_array( $st, SQLSRV_FETCH_ASSOC)) {
        $no=$row["no"];
        echo("<script> alert('Quote no.$no has been created');document.getElementById('myForm').style.display = 'block';</script>");
        }
        ///update the next quote number
        $updatenextno="update _cplquoteno set nextautono=nextautono+1";
        sqlsrv_query($conn, $updatenextno) or die(print_r( sqlsrv_errors(), true));
        
///insert top part of quote
$update="declare @qno as varchar(50)
declare @custid as varchar(50)
declare @proj as varchar(50)
declare @currid as int
declare @docrep as int
declare @agentid as int
set @qno =(select 'IVQ'+ cast(format(QuoteNum,'0000') as varchar) from stdftbl)
set @custid=(select dclink from client where name='$client')
set @proj=(select projectlink from project where projectname='$projectname')
set @currid=(select icurrencyid from client where name='$client')
set @docrep=(select idSalesRep from salesrep where name='$name')
set @agentid=(select sageid from _cplusers where first_name='".$_SESSION['users']."')
----insert into invnum
insert into invnum (doctype, docversion,  docstate, docflag, docrepid,invnumber,Address1,Address2,Address3, grvnumber,accountid, Description, invdate, orderdate, duedate, deliverydate,
taxinclusive, ordernum , projectid, invtotexcldex,InvTotTaxDEx,InvTotInclDEx,invtotexcl, invtottax, [InvTotIncl],[OrdDiscAmnt],[OrdDiscAmntEx]
,[OrdTotExclDEx],[OrdTotTaxDEx],[OrdTotInclDEx], [OrdTotExcl], [OrdTotTax], [OrdTotIncl],[fInvTotExclDExForeign],[fInvTotTaxDExForeign],[fInvTotInclDExForeign],[fInvTotExclForeign]
,[fInvTotTaxForeign],[fInvTotInclForeign],[fOrdTotExclDExForeign],[fOrdTotTaxDExForeign],
[fOrdTotInclDExForeign],[fOrdTotExclForeign],[fOrdTotTaxForeign],[fOrdTotInclForeign],bUseFixedPrices, [iDocPrinted], [iINVNUMAgentID],
[fExchangeRate],foreigncurrencyID, [cTaxNumber],cAccountName,ucIDInvRefNo,ufIDInvPmt1Amt,ucIDInvPmt2Ref,ufIDInvPmt2Amt,ulIDInvPmtMode,ulIDInvPmt2Mode)
values
(0,1,2,0,@docrep,@qno,'$contperson','$address','$contactno','',@custid,'$awb[0]','$date','$date','$date','$date',1,'$awb[0]',@proj,$subtotalkes,$totaltaxkes,$totalkes,$subtotalkes,$totaltaxkes,$totalkes,
0,0,$subtotalkes,$totaltaxkes,$totalkes,$subtotalkes,$totaltaxkes,$totalkes,$subtotal,$totaltax,$total,$subtotal,$totaltax,$total,$subtotal,$totaltax,$total,$subtotal,$totaltax,$total,
0,NULL,@agentid,$rate,@currid,'','$client','$ref1',$pay1,'$ref2',$pay2,'$mode1','$mode2')";
$stmt=sqlsrv_query($conn, $update) or die(print_r( sqlsrv_errors(), true));
///insert bottom part of the quote

for($i = 0; $i < count($description); $i++){
$insertgrid="declare @invno as int
declare @qno as varchar(50)
declare @prjid as int
declare @repid as int
set @qno =(select 'IVQ'+ cast(format(QuoteNum,'0000') as varchar) from stdftbl)
set @invno=(select top(1) autoindex from invnum where invnumber=@qno order by autoindex desc)
set @prjid=(select projectlink from project where projectname='$projectname')
set @repid=(select idSalesRep from salesrep  where name='$name')

insert into _btblinvoicelines ([iInvoiceID],[cDescription],[fQuantity]
,[fQtyChange],[fQtyToProcess],[fUnitPriceExcl],[fUnitPriceIncl],[fTaxRate],[iTaxTypeID],[fQuantityLineTotIncl],[fQuantityLineTotExcl]
,[fQuantityLineTotInclNoDisc],[fQuantityLineTotExclNoDisc],[fQuantityLineTaxAmount],[fQuantityLineTaxAmountNoDisc]
,[fQtyChangeLineTotIncl],[fQtyChangeLineTotExcl],[fQtyChangeLineTotInclNoDisc],[fQtyChangeLineTotExclNoDisc]
,[fQtyChangeLineTaxAmount],[fQtyChangeLineTaxAmountNoDisc],[fQtyToProcessLineTotIncl],[fQtyToProcessLineTotExcl]
,[fQtyToProcessLineTotInclNoDisc],[fQtyToProcessLineTotExclNoDisc],[fQtyToProcessLineTaxAmount],[fQtyToProcessLineTaxAmountNoDisc]
,[fUnitPriceExclForeign],[fUnitPriceInclForeign],[fUnitCostForeign],[iLineRepID],[iLineProjectID],[iLedgerAccountID],[iModule],[bChargeCom],
[iLineID],[fLength],[fWidth],[fHeight],[fQuantityUR],[fQtyChangeUR],[fQtyToProcessUR],ufIDInvTxCMweight,ucIDInvTxCMAWB,ucIDInvTxCMORIGIN,ucIDInvTxCMDestination
,ulIDInvTxCMPckg,ulIDInvTxCMType,ulIDInvTxCMDiscount)
values(@invno,'$description[$i]',1,1,1,$usd[$i]*$rate,(($usd[$i]*$rate)*0.16)+($usd[$i]*$rate),16,8,(($usd[$i]*$rate)*0.16)+($usd[$i]*$rate),($usd[$i]*$rate),
(($usd[$i]*$rate)*0.16)+($usd[$i]*$rate),($usd[$i]*$rate),(($usd[$i]*$rate)*0.16),(($usd[$i]*$rate)*0.16),(($usd[$i]*$rate)*0.16)+($usd[$i]*$rate),($usd[$i]*$rate),
(($usd[$i]*$rate)*0.16)+($usd[$i]*$rate),($usd[$i]*$rate),(($usd[$i]*$rate)*0.16),(($usd[$i]*$rate)*0.16),(($usd[$i]*$rate)*0.16)+($usd[$i]*$rate),($usd[$i]*$rate),
(($usd[$i]*$rate)*0.16)+($usd[$i]*$rate),($usd[$i]*$rate),(($usd[$i]*$rate)*0.16),(($usd[$i]*$rate)*0.16),($usd[$i]*$rate),($usd[$i]*0.16)+$usd[$i],$usd[$i],@repid,@prjid,(select accountlink from accounts where description='$description[$i]'),1,
1,$i,$length[$i],$height[$i],$width[$i],1,1,1,$weight[$i],'$awb[$i]', '$origin[$i]', '$destination[$i]','$packing[$i]',(case when '$band[$i]' LIKE '%IP%' THEN  'IP' when '$band[$i]' like '%IE%' then 'IE' end),case when '$band[$i]' LIKE '%3%' THEN  'Band-3' when '$band[$i]' like '%4%' then 'Band-4' when '$band[$i]' like '%1%' then 
'Band-1' when '$band[$i]' like '%0%' then 'Band-0' end )";
sqlsrv_query($conn, $insertgrid) or die(print_r( sqlsrv_errors(), true));
}
///get quote number
$quoteno="select ('IVQ'+ cast(QuoteNum as varchar)) as no from stdftbl";
$stm=sqlsrv_query($conn, $quoteno) or die(print_r( sqlsrv_errors(), true));
while( $row = sqlsrv_fetch_array( $stm, SQLSRV_FETCH_ASSOC) ) {
$data=$row['no'];
//Display Sage quote number
echo("<script> alert('Sage quote no. $data has been created');</script>");
}
///update the next quote number
$updatenextno="declare @qno as varchar(50)
set @qno =(select ('IVQ'+ cast(QuoteNum as varchar)) as no from stdftbl)

update stdftbl set Quotenum=Quotenum+1";
sqlsrv_query($conn, $updatenextno) or die(print_r( sqlsrv_errors(), true));
} else {
///insert top part of quote
$update="declare @qno as varchar(50)
declare @custid as varchar(50)
declare @proj as varchar(50)
declare @currid as int
declare @docrep as int
set @qno =(select 'IVQ'+ cast(format(QuoteNum,'0000') as varchar) from stdftbl)
set @custid=(select dclink from client where name='$client')
set @proj=(select projectlink from project where projectname='$projectname')
set @currid=(select icurrencyid from client where name='$client')
set @docrep=(select idSalesRep from salesrep where name='$name')
set @agentid=(select sageid from _cplusers where first_name='".$_SESSION['users']."')
----insert into invnum
insert into invnum (doctype, docversion,  docstate, docflag,docrepid, invnumber,Address1,Address2,Address3, grvnumber,accountid, Description, invdate, orderdate, duedate, deliverydate,
taxinclusive, ordernum , projectid, invtotexcldex,InvTotTaxDEx,InvTotInclDEx,invtotexcl, invtottax, [InvTotIncl],[OrdDiscAmnt],[OrdDiscAmntEx]
,[OrdTotExclDEx],[OrdTotTaxDEx],[OrdTotInclDEx], [OrdTotExcl], [OrdTotTax], [OrdTotIncl],[fInvTotExclDExForeign],[fInvTotTaxDExForeign],[fInvTotInclDExForeign],[fInvTotExclForeign]
,[fInvTotTaxForeign],[fInvTotInclForeign],[fOrdTotExclDExForeign],[fOrdTotTaxDExForeign],
[fOrdTotInclDExForeign],[fOrdTotExclForeign],[fOrdTotTaxForeign],[fOrdTotInclForeign],bUseFixedPrices, [iDocPrinted], [iINVNUMAgentID],
[fExchangeRate],foreigncurrencyID, [cTaxNumber],cAccountName,ucIDInvRefNo,ufIDInvPmt1Amt,ucIDInvPmt2Ref,ufIDInvPmt2Amt,ulIDInvPmtMode,ulIDInvPmt2Mode)
values
(0,1,2,0,@docrep,@qno,'$contperson','$address','$contactno','',@custid,'$awb[0]','$date','$date','$date','$date',1,'$awb[0]',@proj,$subtotalkes,$totaltaxkes,$totalkes,$subtotalkes,$totaltaxkes,$totalkes,
0,0,$subtotalkes,$totaltaxkes,$totalkes,$subtotalkes,$totaltaxkes,$totalkes,$subtotal,$totaltax,$total,$subtotal,$totaltax,$total,$subtotal,$totaltax,$total,$subtotal,$totaltax,$total,
0,NULL,@agentid,$rate,@currid,'','$client','$ref1',$pay1,'$ref2',$pay2,'$mode1','$mode2')";
$stmt=sqlsrv_query($conn, $update) or die(print_r( sqlsrv_errors(), true));
///insert bottom part of the quote

for($i = 0; $i < count($description); $i++){
$insertgrid="declare @invno as int
declare @qno as varchar(50)
declare @prjid as int
declare @repid as int
set @qno =(select 'IVQ'+ cast(format(QuoteNum,'0000') as varchar) from stdftbl)
set @invno=(select top(1) autoindex from invnum where invnumber=@qno order by autoindex desc)
set @prjid=(select projectlink from project where projectname='$projectname')
set @repid=(select idSalesRep from salesrep  where name='$name')

insert into _btblinvoicelines ([iInvoiceID],[cDescription],[fQuantity]
,[fQtyChange],[fQtyToProcess],[fUnitPriceExcl],[fUnitPriceIncl],[fTaxRate],[iTaxTypeID],[fQuantityLineTotIncl],[fQuantityLineTotExcl]
,[fQuantityLineTotInclNoDisc],[fQuantityLineTotExclNoDisc],[fQuantityLineTaxAmount],[fQuantityLineTaxAmountNoDisc]
,[fQtyChangeLineTotIncl],[fQtyChangeLineTotExcl],[fQtyChangeLineTotInclNoDisc],[fQtyChangeLineTotExclNoDisc]
,[fQtyChangeLineTaxAmount],[fQtyChangeLineTaxAmountNoDisc],[fQtyToProcessLineTotIncl],[fQtyToProcessLineTotExcl]
,[fQtyToProcessLineTotInclNoDisc],[fQtyToProcessLineTotExclNoDisc],[fQtyToProcessLineTaxAmount],[fQtyToProcessLineTaxAmountNoDisc]
,[fUnitPriceExclForeign],[fUnitPriceInclForeign],[fUnitCostForeign],[iLineRepID],[iLineProjectID],[iLedgerAccountID],[iModule],[bChargeCom],
[iLineID],[fLength],[fWidth],[fHeight],[fQuantityUR],[fQtyChangeUR],[fQtyToProcessUR],ufIDInvTxCMweight,ucIDInvTxCMAWB,ucIDInvTxCMORIGIN,ucIDInvTxCMDestination
,ulIDInvTxCMPckg,ulIDInvTxCMType,ulIDInvTxCMDiscount)
values(@invno,'$description[$i]',1,1,1,$usd[$i]*$rate,(($usd[$i]*$rate)*0.16)+($usd[$i]*$rate),16,8,(($usd[$i]*$rate)*0.16)+($usd[$i]*$rate),($usd[$i]*$rate),
(($usd[$i]*$rate)*0.16)+($usd[$i]*$rate),($usd[$i]*$rate),(($usd[$i]*$rate)*0.16),(($usd[$i]*$rate)*0.16),(($usd[$i]*$rate)*0.16)+($usd[$i]*$rate),($usd[$i]*$rate),
(($usd[$i]*$rate)*0.16)+($usd[$i]*$rate),($usd[$i]*$rate),(($usd[$i]*$rate)*0.16),(($usd[$i]*$rate)*0.16),(($usd[$i]*$rate)*0.16)+($usd[$i]*$rate),($usd[$i]*$rate),
(($usd[$i]*$rate)*0.16)+($usd[$i]*$rate),($usd[$i]*$rate),(($usd[$i]*$rate)*0.16),(($usd[$i]*$rate)*0.16),($usd[$i]*$rate),($usd[$i]*0.16)+$usd[$i],$usd[$i],@repid,@prjid,(select accountlink from accounts where description='$description[$i]'),1,
1,$i,$length[$i],$height[$i],$width[$i],1,1,1,$weight[$i],'$awb[$i]', '$origin[$i]', '$destination[$i]','$packing[$i]',(case when '$band[$i]' LIKE '%IP%' THEN  'IP' when '$band[$i]' like '%IE%' then 'IE' end),case when '$band[$i]' LIKE '%3%' THEN  'Band-3' when '$band[$i]' like '%4%' then 'Band-4' when '$band[$i]' like '%1%' then 
'Band-1' when '$band[$i]' like '%0%' then 'Band-0' end )";
sqlsrv_query($conn, $insertgrid) or die(print_r( sqlsrv_errors(), true));
}
///get quote number
$quoteno="select ('IVQ'+ cast(QuoteNum as varchar)) as no from stdftbl";
$stm=sqlsrv_query($conn, $quoteno) or die(print_r( sqlsrv_errors(), true));
while( $row = sqlsrv_fetch_array( $stm, SQLSRV_FETCH_ASSOC) ) {
$data=$row['no'];
//Display Sage quote number
echo("<script> alert('Sage quote no. $data has been created');</script>");
}
///update the next quote number
$updatenextno="declare @qno as varchar(50)
set @qno =(select 'IVQ'+ cast(QuoteNum as varchar) from stdftbl)

update stdftbl set Quotenum=Quotenum+1";
sqlsrv_query($conn, $updatenextno) or die(print_r( sqlsrv_errors(), true));
}
}
?>
</form>
</div>
</body>
</html>