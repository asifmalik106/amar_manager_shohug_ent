// 1. Select Customer with Select2
$('#selectCustomer').select2();

// 2. Product For Sale Table with DataTable
$('#productForSale').dataTable({
  "lengthMenu": [ [3, 10, 25, 50, -1], [3, 10 , 25, 50, "All"] ]
});

$( "#datepicker" ).datepicker({ minDate: -30, maxDate: "+30D" });
$( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
$('#datepicker').datepicker("setDate", new Date() );
// 3. Add to Cart on Click From Product For Sale Table
var i = 2;
$(document).on('click', 'tr.mouseHover', function(){
	var cartStatus = $(this).find('.cartStatus');
	var productID = $(this).find('.pID').html();
	var productName = $(this).find('.pName').html();
	var productBatch = $(this).find('.pBatch').html();
	var productPurchase = $(this).find('.pPurchase').html();
	var productSale = $(this).find('.pSale').html();
	var productQuantity = $(this).find('.pQuantity').html();
	if(productQuantity>0 && cartStatus.val()=='0'){
		var last = $('tr.item').length+1;
		var newRow = '<tr class="item">'+
				'<td> <span id="snum'+i+'">'+last+'</span> </td>'+
				'<td> <input type="hidden" name="pID[]" value="'+productID+'" required> <p class="purProductName">'+productName+'</p>  </td>'+
				'<td> <input type="hidden" name="batch[]" value="'+productBatch+'" required>'+productBatch+'</td>'+
				'<td> <input type="hidden" name="stock" value="'+productQuantity+'"> <input class="form-control input-sm" type="number" step=".01" name="quantity[]" min="0" oninput="getTotal()" value="1"> </td>'+
	            '<td> <input class="form-control input-sm" type="hidden" step="any" name="purchaseRate[]" oninput="getTotal()" value="'+productPurchase+'"><input class="form-control input-sm" type="number" min="0" name="saleRate[]" oninput="getTotal()" value="'+productSale+'"> </td>'+
	            '<td> <input class="form-control input-sm" type="number" step=".01" name="total" value=""  min="0"> </td>'+
	            '<td> <i class="fa fa-times fa-lg delete" title="Delete category"></i> </td>'+
				'</tr>';
			i++;
		$('tbody.purchase').append(newRow);
		cartStatus.val(productID)
		getTotal();
		getDueAdvance();getDueAdvance();
		var productResult = productName+'-'+productSale;
		toastr.success("Product Added to Cart Successfully!!", productResult, {"closeButton": true,"progressBar": true,"positionClass": "toast-bottom-left"});
	}
	else if(cartStatus.val()!='0' && productQuantity>0){
		toastr.info("Already Added to Cart!!", "productResult", {"closeButton": true,"progressBar": true,"positionClass": "toast-bottom-left"});
	}
	else{
		var productResult = productName+'-'+productSale;
		toastr.warning("Product Not Available!!", productResult, {"closeButton": true,"progressBar": true,"positionClass": "toast-bottom-left"});
	}
	
});


// 4. Get Total Individual Product
function getTotal(){
	var ttl = 0;
	$('tr.item').each(function(){
		var q = parseFloat($(this).find("[name='quantity[]']").val());
		var u = parseFloat($(this).find("[name='saleRate[]']").val());
		var r = q*u;
		
		if(isNaN(r)){
			$(this).find("[name='total']").val(0.0);
		}else{
			$(this).find("[name='total']").val(r);
			ttl+=r;
		}
		
		
	});

	$('#grandTotal').html(ttl);
	$("input[name='grandTotal']").val(ttl);
	getGrandTotal();
	getDueAdvance();getDueAdvance();

}

// 5. Remove Product From Cart
$(document).on('click', '.delete', function(){
var pID = $(this).parents('tr').find("[name='pID[]']").val();
	
$(this).parents('tr').remove();
toastr.error("Product Deleted from Cart Successfully!!", "productResult", {"closeButton": true,"progressBar": true,"positionClass": "toast-bottom-left"});
//var p = $('#productForSale').find($(this).parents('tr').find("[name='pID[]']"));
$('#productForSale').find('.cartStatus[value="'+pID+'"]').val('0');
getTotal();
getDueAdvance();getDueAdvance();
check();
	});

// 6. Maintain the Cart Serial
function check(){
	obj=$('table tr').find('span');

	$.each( obj, 
		function( key, value ) 
		{
			id=value.id;
			$('#'+id).html(key+1);
		}
	);
}

$(document).on("input", "[name='total']", function(){
	var q = parseFloat($(this).parents('tr').find("[name='quantity[]']").val());
	var t = parseFloat($(this).val());
	var pUnit = t/q;
	$(this).parents('tr').find("[name='saleRate[]']").val(pUnit);
	var pr = $(this).parents('tr').find("[name='saleRate[]']");
	if(t==0 || isNaN(t) ){
		pr.prop('value', 0.0);
	}
	getTotal();
	getDueAdvance();getDueAdvance();
});


$(document).on("input", "[name='saleRate[]']", function(){
	var t = parseFloat($(this).val());
	var pr = $(this).parents('tr').find("[name='total']");
	if(t==0 || isNaN(t) ){
		pr.prop('value', 0.0);
	}

});

$(document).on("input", "[name='quantity[]']", function(){
	var st = parseFloat($(this).parents('td').find("[name='stock']").val());
	var q = parseFloat($(this).val());
	if(q>st){
		$(this).val('');
		getTotal();
	}
});
var pCashAmount = 0;
$(document).on("input", ".cashAmount", function() {
	var a = $(this).val();
	var b = $(this).parents("div.form-group").find("[name='cashBalance']").val();
	var c = b-a;
	if(c>=0){
		$(this).parents("div.form-group").find(".cashLeft").html(c);
	}else{
		$(this).val('');
		$(this).parents("div.form-group").find(".cashLeft").html(b);
	}
	var pmt = 0;
	$('.cashAmount').each(function(){
		var p = parseFloat($(this).val());
		if(isNaN(p)){
			p=0;
		}
		pmt+=p;
	});
	
	$('#paymentTotal').html(pmt);
	$("input[name='paymentTotal']").val(pmt);
	getDueAdvance();getDueAdvance();
});

function getDueAdvance() {
	var t = parseFloat($("#grandFinalTotal").html());
	var cb = parseFloat($("#customerBalance").html());
	var pay = parseFloat($("input[name='paymentTotal']").val());
	var f;
	if(isNaN(cb)){
		cb=0;
	}
	if(isNaN(t)){
		t=0;
	}
	if(isNaN(pay)){
		pay=0;
	}
	if(cb>=t)
	{
		$('#payFromBalance').html(t);
		$('#payFromBalanceInput').val(t);
		$("input[name='paymentTotal']").val('');
		$("input[name='paymentTotal']").prop('disabled', true);
		$('#dueTotal').html(0.0);
		$('#advanceTotal').html(pay);
	}else if(cb<t && cb>0){
		$('#payFromBalance').html(cb);
		$('#payFromBalanceInput').val(cb);
		$("input[name='paymentTotal']").prop('disabled', false);
		f = t-cb-pay;
	}
	else{
		$('#payFromBalance').html(0.0);
		$('#payFromBalanceInput').val(0.0);
		$("input[name='paymentTotal']").prop('disabled', false);
		f = t-pay;
	}
	if(f>0){
		$('#dueTotal').html(f);
		$('#advanceTotal').html(0.0);
	}else{
		$('#dueTotal').html(0.0);
		$('#advanceTotal').html(f*(-1));
	}
}
function getGrandTotal() {
	var t = parseFloat($("input[name='grandTotal']").val());
	var dt = parseFloat($("input[name='discount']").val());
	if(isNaN(dt)){
		dt = 0.0;
	}
	if(isNaN(t)){
		t = 0.0;
	}
	if(dt>t)
	{
		$("input[name='discount']").val('');
		dt=0;
	}
	var gt = t-dt;
	$("#grandFinalTotal").html(gt);
	var cb = parseFloat($("#customerBalance").html());
	var pay = parseFloat($("input[name='paymentTotal']").val());
	if(cb>=gt)
	{
		$('#payFromBalance').html(gt);
		$('#payFromBalanceInput').val(gt);
		$("input[name='paymentTotal']").val('');
		$("input[name='paymentTotal']").prop('disabled', true);
		$('#dueTotal').html(0.0);
		$('#advanceTotal').html(pay);
	}else if(cb<t && cb>0){
		$('#payFromBalance').html(cb);
		$('#payFromBalanceInput').val(cb);
		$("input[name='paymentTotal']").prop('disabled', false);
		f = gt-cb-pay;
	}
	else{
		$('#payFromBalance').html(0.0);
		$('#payFromBalanceInput').val(0.0);
		$("input[name='paymentTotal']").prop('disabled', false);
		f = gt-pay;
	}
	if(f>0){
		$('#dueTotal').html(f);
		$('#advanceTotal').html(0.0);
	}else{
		$('#dueTotal').html(0.0);
		$('#advanceTotal').html(f*(-1));
	}getDueAdvance();
}
$(document).ready(function() {
	$('#salePanel').portamento();	
});

$('#selectCustomer').on('change', function(){
	var balance = parseFloat($("#selectCustomer option:selected").attr('balance'));
	$('#customerBalance').html(balance.toFixed(2));
	var gt = parseFloat($("#grandFinalTotal").html());
	if(gt<=balance){
		$("#payFromBalance").html(gt.toFixed(2));
		$("#payFromBalanceInput").val(gt.toFixed(2));
	}else if(balance<gt && balance>0){
		$("#payFromBalance").html(balance.toFixed(2));
		$("#payFromBalanceInput").val(balance.toFixed(2));
	}
	else{
		$("#payFromBalance").html(0.0);
		$("#payFromBalanceInput").val(0.0);
	}
	getDueAdvance();
	getDueAdvance();
});
