var baseURL = 'https://app.amar-manager.com/';
//Add Customer Function
$('#customerList').dataTable({
"order": [[ 0, "desc" ]],
  "lengthMenu": [ [ 25, 50, 100, 250, -1], [ 25, 50, 100, 250, "All"] ] 
	});
function addCustomer()
{
	
	var newCustomerName = $('#newCustomerName').val();
	var newCustomerFather = $('#newCustomerFather').val();
	var newCustomerPhone = $('#newCustomerPhone').val();
	var newCustomerAddress = $('#newCustomerAddress').val();
	var newCustomerLimit = $('#newCustomerLimit').val();
    $("#customerStatusLoading").show();
     	 $.post(baseURL+'manager/customer/add/',
	    {
	        newCName: newCustomerName,
	        newCFather: newCustomerFather,
	        newCPhone: newCustomerPhone,
	        newCAddress: newCustomerAddress,
	        newCLimit: newCustomerLimit,
	        submit: "true"
	    },
	    function(data, status){
	        $("#customerStatusLoading").hide();
	        if(data=="true"){
	        	$("#customerStatusTrue").fadeIn();
	        	setTimeout(function(){ 
	        		$("#customerStatusTrue").fadeOut(); 
	        	}, 8000);
	        	$('#newCustomerName').val('');
				$('#newCustomerFather').val('');
				$('#newCustomerPhone').val('');
				$('#newCustomerAddress').val('');
				$('#newCustomerLimit').val('');
	        }
	        else if(data=="duplicate"){
	        	$("#customerStatusDuplicate").fadeIn();
	        	setTimeout(function(){ 
	        		$("#customerStatusDuplicate").fadeOut(); 
	        	}, 8000);
	        }
	        else if(data=="empty"){
	        	$("#customerStatusEmpty").fadeIn();
	        	setTimeout(function(){ 
	        		$("#customerStatusEmpty").fadeOut(); 
	        	}, 8000);
	        }
	        else{
	        	$("#customerStatusFalse").fadeIn();
	        	setTimeout(function(){ 
	        		$("#customerStatusFalse").fadeOut(); 
	        	}, 8000);
	        }
	    });

}
