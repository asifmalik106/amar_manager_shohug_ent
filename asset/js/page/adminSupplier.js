$('#supplierList').dataTable({
"order": [[ 0, "desc" ]],
  "lengthMenu": [ [ 25, 50, 100, 250, -1], [ 25, 50, 100, 250, "All"] ] 
	});
//Add Supplier Function
function addSupplier()
{
	$("#supplierStatusLoading").show();
	var newSupplierName = $('#newSupplierName').val();
	var newSupplierFather = $('#newSupplierFather').val();
	var newSupplierPhone = $('#newSupplierPhone').val();
	var newSupplierAddress = $('#newSupplierAddress').val();
	var newSupplierLimit = $('#newSupplierLimit').val();
	 $.post(baseURL+'admin/supplier/add/',
	    {
	        newSName: newSupplierName,
	        newSFather: newSupplierFather,
	        newSPhone: newSupplierPhone,
	        newSAddress: newSupplierAddress,
	        newSLimit: newSupplierLimit,
	        submit: "true"
	    },
	    function(data, status){
	        $("#supplierStatusLoading").hide();
	        if(data=="true"){
	        	$("#supplierStatusTrue").fadeIn();
	        	setTimeout(function(){ 
	        		$("#supplierStatusTrue").fadeOut(); 
	        	}, 5000);
	        	$('#newSupplierName').val('');
				$('#newSupplierFather').val('');
				$('#newSupplierPhone').val('');
				$('#newSupplierAddress').val('');
				$('#newSupplierLimit').val('');
	        }
	        else if(data=="duplicate"){
	        	$("#supplierStatusDuplicate").fadeIn();
	        	setTimeout(function(){ 
	        		$("#supplierStatusDuplicate").fadeOut(); 
	        	}, 5000);
	        }
	        else if(data=="empty"){
	        	$("#supplierStatusEmpty").fadeIn();
	        	setTimeout(function(){ 
	        		$("#supplierStatusEmpty").fadeOut(); 
	        	}, 5000);
	        }
	        else{
	        	$("#supplierStatusFalse").fadeIn();
	        	setTimeout(function(){ 
	        		$("#supplierStatusFalse").fadeOut(); 
	        	}, 5000);
	        }
	    });
}
