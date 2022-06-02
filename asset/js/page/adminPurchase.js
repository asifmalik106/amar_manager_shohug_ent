$('#selectSupplier').select2();
$('#productForPurchase').dataTable({
  "lengthMenu": [ [3, 10, 25, 50, -1], [3, 10 , 25, 50, "All"] ]
});
var i = 2;

$(document).on('click', 'tr.mouseHover', function(){
	var cartStatus = $(this).find('.cartStatus');
	var productID = $(this).find('.pID').html();
	var productName = $(this).find('.pName').html();
	var productBatch = $(this).find('.pBatch').html();
	var productPurchase = $(this).find('.pPurchase').html();
	var productSale = $(this).find('.pSale').html();
	var productQuantity = $(this).find('.pQuantity').html();
	
	if(cartStatus.val()=='0'){
		var last = $('tr.item').length+1;
			var newRow = '<tr class="item">'+
			'<td> <span id="snum'+i+'">'+last+'</span> </td>'+
			'<td> <input type="hidden" name="pID[]" value="'+productID+'" required> <p class="purProductName">'+productName+'</p>  </td>';
			if(productBatch){
				newRow +='<td>'+
                '<input class="form-control input-sm" name="batch[]" value="'+productBatch+'" readonly>  <input type="checkbox" class="newBatch"> New</input>'+
           		'</td>'+
				'<td> <input class="form-control input-sm" type="number" step="0.01" name="quantity[]" oninput="getTotal()" value="1"> </td>'+
            	'<td> <input class="form-control input-sm" type="" name="purchaseRate[]" oninput="getTotal()" value="'+productPurchase+'" readonly> </td>'+
            	'<td> <input class="form-control input-sm" type="" name="retailRate[]" value="'+productSale+'" readonly> </td>'+
            	'<td> <input class="form-control input-sm" type="" name="total" oninput="getTotal()" value="" readonly> </td>';
            }
            else{
            	newRow +='<td>'+
                '<input class="form-control input-sm" name="batch[]" value="New" readonly>'+
				'<td> <input class="form-control input-sm" type="number" step="0.01" name="quantity[]" oninput="getTotal()" value="1"> </td>'+
            	'<td> <input class="form-control input-sm" type="" name="purchaseRate[]" oninput="getTotal()" value="'+productPurchase+'"> </td>'+
            	'<td> <input class="form-control input-sm" type="" name="retailRate[]" value="'+productSale+'"> </td>'+
            	'<td> <input class="form-control input-sm" type="" name="total" value="0.0"> </td>';
            }
            newRow += '<td> <i class="fa fa-times fa-lg delete" title="Delete category"></i> </td>'+
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


/*
$(document).on('click', 'tr.mouseHover', function(){
	var productID = $(this).find('.pID').html();
	var productName = $(this).find('.pName').html();
	var productBatch = $(this).find('.pBatch').html();
	var productPurchase = $(this).find('.pPurchase').html();
	var productSale = $(this).find('.pSale').html();
	var productQuantity = $(this).find('.pQuantity').html();
	/*
	if(productBatch){
		alert("true");
	}else{
		alert("false");
	}
	
	var last = $('tr.item').length+1;
	var newRow = '<tr class="item">'+
			'<td> <span id="snum'+i+'">'+last+'</span> </td>'+
			'<td> <input type="hidden" name="pID[]" value="'+productID+'" required> <p class="purProductName">'+productName+'</p>  </td>';
			if(productBatch){
				newRow +='<td>'+
                '<input class="form-control input-sm" name="batch[]" value="'+productBatch+'" readonly>  <input type="checkbox" class="newBatch"> New</input>'+
           		'</td>'+
				'<td> <input class="form-control input-sm" type="number" name="quantity[]" oninput="getTotal()" value="1"> </td>'+
            	'<td> <input class="form-control input-sm" type="" name="purchaseRate[]" oninput="getTotal()" value="'+productPurchase+'" readonly> </td>'+
            	'<td> <input class="form-control input-sm" type="" name="retailRate[]" value="'+productSale+'" readonly> </td>'+
            	'<td> <input class="form-control input-sm" type="" name="total" oninput="getTotal()" value="" readonly> </td>';
            }
            else{
            	newRow +='<td>'+
                '<input class="form-control input-sm" name="batch[]" value="New" readonly>'+
				'<td> <input class="form-control input-sm" type="number" name="quantity[]" oninput="getTotal()" value="1"> </td>'+
            	'<td> <input class="form-control input-sm" type="" name="purchaseRate[]" oninput="getTotal()" value="'+productPurchase+'"> </td>'+
            	'<td> <input class="form-control input-sm" type="" name="retailRate[]" value="'+productSale+'"> </td>'+
            	'<td> <input class="form-control input-sm" type="" name="total" value="0.0"> </td>';
            }
            newRow += '<td> <i class="fa fa-times fa-lg delete" title="Delete category"></i> </td>'+
		'</tr>';
		i++;
	$('tbody.purchase').append(newRow);
	getTotal();
	getDueAdvance();

});*/


$('.addRow').click(function(){

});

function getTotal(){
	var ttl = 0;
	$('tr.item').each(function(){
		var q = parseFloat($(this).find("[name='quantity[]']").val());
		var u = parseFloat($(this).find("[name='purchaseRate[]']").val());
		var r = q*u;
		

		$(this).find("[name='total']").val(r);
		ttl+=r;
	});

	$('#grandTotal').html(ttl.toFixed(2));
	var balance = parseFloat($("#supplierBalance").html());
	if(balance>0){
		if(balance<=ttl){
			$("#payFromSupplierBalance").val(balance.toFixed(2));
		}else{
			$("#payFromSupplierBalance").val(ttl.toFixed(2));
		}
	}else{
		$("#payFromSupplierBalance").val('');
	}
	$("input[name='grandTotal']").val(ttl);
	getDueAdvance();

}

$(document).on('click', '.delete', function(){
$(this).parents('tr').remove();
getTotal();
getDueAdvance();
check();
	});
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
$(document).on('change', '.newBatch', function() {
    // this will contain a reference to the checkbox   
    if (this.checked) {
    	$(this).parents('tr').find("[name='purchaseRate[]']").prop({'readonly':false,'value': 0.0});
    	$(this).parents('tr').find("[name='retailRate[]']").prop({'readonly':false,'value': 0.0});
    	$(this).parents('tr').find("[name='total']").prop({'readonly':false,'value': 0.0});
    	$(this).parents('td').find('input').val('New');
    	
    } else {
        $(this).parents('tr').remove();
		getTotal();
		getDueAdvance();
		check();
    }
});
$(document).on("input", "[name='total']", function(){
	var q = parseFloat($(this).parents('tr').find("[name='quantity[]']").val());
	var t = parseFloat($(this).val());
	var pUnit = t/q;
	$(this).parents('tr').find("[name='purchaseRate[]']").val(pUnit);
	var pr = $(this).parents('tr').find("[name='purchaseRate[]']");
	if(t==0 || isNaN(t) ){
		pr.prop('readonly', false);
		pr.prop('value', 0.0);
	}else{
		pr.prop('readonly', true);

	}
	getTotal();
	getDueAdvance();
});


$(document).on("input", "[name='purchaseRate[]']", function(){
	var t = parseFloat($(this).val());
	var pr = $(this).parents('tr').find("[name='total']");
	if(t==0 || isNaN(t) ){
		pr.prop('readonly', false);
		pr.prop('value', 0.0);
	}else{
		pr.prop('readonly', true);

	}

});

$(document).on("input", "[name='quantity[]']", function(){
	//alert($(this).parents('tr').find("[name='purchaseRate[]']").val());
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
	var bal = parseFloat($("#payFromSupplierBalance").val());
	if(isNaN(bal)){
		bal = 0;
	}
	if(bal<0){
		bal=0;
	}
	var gtp = bal + pmt;
	var t = parseFloat($("input[name='grandTotal']").val());
		if(isNaN(t)){
		t = 0;
	}
	if(gtp>t){
		$(this).val('');
		pmt = 0;
		$('.cashAmount').each(function(){
			var p = parseFloat($(this).val());
			if(isNaN(p)){
				p=0;
			}
			pmt+=p;
		});
	}
	a = $(this).val();
	b = $(this).parents("div.form-group").find("[name='cashBalance']").val();
	c = b-a;
	if(c>=0){
		$(this).parents("div.form-group").find(".cashLeft").html(c);
	}else{
		$(this).val('');
		$(this).parents("div.form-group").find(".cashLeft").html(b);
	}
	gtp = bal + pmt;
	$('#paymentTotal').html(gtp);
	$("input[name='paymentTotal']").val(gtp);
	getDueAdvance();
});
	
$("#selectSupplier").on('change', function(){
	$('.selectSupplierVisible').show();
	var balance = parseFloat($("#selectSupplier option:selected").attr('balance'));
	$("#supplierBalance").html(balance);
	$('.cashAmount').each(function(){
		$(this).val('');
		var b = $(this).parents("div.form-group").find("[name='cashBalance']").val();
$(this).parents("div.form-group").find(".cashLeft").html(b);
	});
	getTotal();
	getDueAdvance();
});




function getDueAdvance() {
	var t = parseFloat($("input[name='grandTotal']").val());
	
	var pmt = 0;
	$('.cashAmount').each(function(){
		var p = parseFloat($(this).val());
		if(isNaN(p)){
			p=0;
		}
		pmt+=p;
	});
	var bal = parseFloat($("#payFromSupplierBalance").val());

	
	if(isNaN(bal)){
		bal = 0;
	}
	if(bal<0){
		bal=0;
	}
	var pay = bal + pmt;
	$('#paymentTotal').html(pay.toFixed(2));
		console.log("Pay From Supplier Balance:"+bal);
	console.log("Total Due:"+t);
	
	var f = t-pay;
	console.log("total-paid:"+f);
	if(f>=0){
		$('#dueTotal').html(f.toFixed(2));
		$('#advanceTotal').html(0.0);
	}else{
		$('#dueTotal').html(0.0);
		$('#advanceTotal').html(f*(-1).toFixed(2));
	}
}