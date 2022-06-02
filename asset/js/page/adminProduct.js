

	$('#batchTable').dataTable();

  $('#newProductCategory').select2({
  });
  $('#editProductCategory').select2({
  	width: '100%'
  });
function fillModifyProductData(pID, pName, pDes, cID, pLimit){
	$('#editProductID').val(pID);
	$('#editProductName').val(pName);
	$('#editProductDescription').val(pDes);
	$('#editProductCategory').val(cID).change();
	$('#editProductLimit').val(pLimit);
}

function fillModifyBatchData(batch, saleUnit){
	$('#exBatchName').val(batch);
	$('#batchName').val(batch);
	$('#saleUnit').val(saleUnit);
}

function fillDeleteBatch(batch, quantity, purchase){
	var q = parseFloat(quantity);
	if(q>0){
		$('.deleteTrue').hide();
		$('.deleteFalse').show();
		$('#deleteBatchName').val('');
		$('#deleteBatchPurchase').val('');
	}
	else{
		$('.deleteTrue').show();
		$('.deleteFalse').hide();
		$('#deleteBatchName').val(batch);
		$('#deleteBatchPurchase').val(purchase);
	}
}
//************************************************************
	
	function editBatchSale()
{
	$("#batchEditStatusLoading").show();
	var pID = $('#productID').val();
	var batchName = $('#batchName').val();
	var exBatchName = $('#exBatchName').val();
	var saleUnit = $('#saleUnit').val();
	 $.post(baseURL+'admin/product/batch/edit/',
	    {
		 			pID: pID,
		 			exBatch: exBatchName,
	        batch: batchName,
	       	saleUnit: saleUnit,
	        submit: "true"
	    },
	    function(data, status){
	        $("#batchEditStatusLoading").hide();
	        if(data=="true"){
	        	$("#batchEditStatusTrue").fadeIn();
	        	setTimeout(function(){ 
	        		$("#batchEditStatusTrue").fadeOut(); 
	        	}, 3000);
						loadBatch();
						loadBatch()
	        }
	        else if(data=="duplicate"){
	        	$("#batchEditStatusDuplicate").fadeIn();
	        	setTimeout(function(){ 
	        		$("#batchEditStatusDuplicate").fadeOut(); 
	        	}, 3000);
	        }
	        else if(data=="empty"){
	        	$("#batchEditStatusEmpty").fadeIn();
	        	setTimeout(function(){ 
	        		$("#batchEditStatusEmpty").fadeOut(); 
	        	}, 3000);
	        }
	        else{
	        	$("#batchEditStatusFalse").fadeIn();
	        	setTimeout(function(){ 
	        		$("#batchEditStatusFalse").fadeOut(); 
	        	}, 3000);
	        }
	    });
}

	function deleteBatchData()
{
	$("#batchDeleteStatusLoading").show();
	var pID = $('#productID').val();
	var batchName = $('#deleteBatchName').val();
	 $.post(baseURL+'admin/product/batch/delete/',
	    {
		 			pID: pID,
	        batch: batchName,
	        submit: "true"
	    },
	    function(data, status){
	        $("#batchDeleteStatusLoading").hide();
	        if(data=="true"){
	        	$("#batchDeleteStatusTrue").fadeIn();
	        	setTimeout(function(){ 
	        		$("#batchDeleteStatusTrue").fadeOut(); 
	        	}, 3000);
						loadBatch();
						loadBatch();
	        }
	        else{
	        	$("#batchDeleteStatusFalse").fadeIn();
	        	setTimeout(function(){ 
	        		$("#batchDeleteStatusFalse").fadeOut(); 
	        	}, 3000);
	        }
	    });
}
	
	//*****************************************************************

//Load Product Function
function loadProduct(){
	$("#loadingProduct").show();
	$.post(baseURL+'admin/product/all/',
	    {},
	    function(data, status){
	    	$("#loadProduct").html(data);
	    	$("#loadingProduct").hide();
	    });
}
loadProduct();

//Load Product Function
function loadBatch(){
	var pID = $('#productID').val();
	$.post(baseURL+'admin/product/batch/get',
	    { pID: pID},
	    function(data, status){
	    	$("#loadBatch").html(data);
	    });
}
function loadProfile(){
	var pID = $('#productID').val();
	$.post(baseURL+'admin/product/info',
	    { pID: pID,
			submit: "true"
			},
	    function(data, status){
	    	$("#loadProfile").html(data);
	    });
}
//Add Category Function
function addProduct()
{
	$("#productStatusLoading").show();
	var newProductName  	   = $('#newProductName').val();
	var newProductDescription  = $('#newProductDescription').val();
	var newProductCategory     = $('#newProductCategory').val();
	var newProductLimit		   = $('#newProductLimit').val();

	 $.post(baseURL+'admin/product/new/',
	    {
	        name: newProductName,
	        description: newProductDescription,
	        cat: newProductCategory,
	        limit: newProductLimit,
	        submit: "true"
	    },
	    function(data, status){
	        $("#productStatusLoading").hide();
	        if(data=="true"){
	        	$("#productStatusTrue").fadeIn();
	        	setTimeout(function(){ 
	        		$("#productStatusTrue").fadeOut(); 
	        	}, 3000);
	        		$('#newProductName').val('');
					$('#newProductDescription').val('');
					$('#newProductCategory').val('').change();
					$('#newProductLimit').val('');
					loadProduct();
					loadProduct();
	        }
	        else if(data=="duplicate"){
	        	$("#productStatusDuplicate").fadeIn();
	        	setTimeout(function(){ 
	        		$("#productStatusDuplicate").fadeOut(); 
	        	}, 3000);
	        }
	        else if(data=="empty"){
	        	$("#productStatusEmpty").fadeIn();
	        	setTimeout(function(){ 
	        		$("#productStatusEmpty").fadeOut(); 
	        	}, 3000);
	        }
	        else{
	        	$("#productStatusFalse").fadeIn();
	        	setTimeout(function(){ 
	        		$("#productStatusFalse").fadeOut(); 
	        	}, 3000);
	        }
	    });
}

function editProduct(){
	$("#productEditStatusLoading").show();
	var pID   = $('#editProductID').val();
	var pName = $('#editProductName').val();
	var pDes  = $('#editProductDescription').val();
	var cID   = $('#editProductCategory').val();
	var pLimit = $('#editProductLimit').val();
	
	$.post(baseURL+'admin/product/edit/',
	    {
	    	editProductID: pID,
	        editProductName: pName,
	        editProductDescription: pDes,
	        editCatID: cID,
	        editProductLimit: pLimit,
	        submit: "true"
	    },
	    function(data, status){
	    	//document.write(data);
	        $("#productEditStatusLoading").hide();
	        if(data=="true"){
	        	$("#productEditStatusTrue").fadeIn();
	        	setTimeout(function(){ 
	        		$("#productEditStatusTrue").fadeOut(); 
	        	}, 3000);
	        	loadProduct();
	 					loadProduct();
						loadProfile();
						loadProfile();
	        }
	        else if(data=="duplicate"){
	        	$("#productEditStatusDuplicate").fadeIn();
	        	setTimeout(function(){ 
	        		$("#productEditStatusDuplicate").fadeOut(); 
	        	}, 3000);
	        }
	        else if(data=="empty"){
	        	$("#productEditStatusEmpty").fadeIn();
	        	setTimeout(function(){ 
	        		$("#productEditStatusEmpty").fadeOut(); 
	        	}, 3000);
	        }
	        else{
	        	$("#productEditStatusFalse").fadeIn();
	        	setTimeout(function(){ 
	        		$("#productEditStatusFalse").fadeOut(); 
	        	}, 3000);
	        }
	    });

}
