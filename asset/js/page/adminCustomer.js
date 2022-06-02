
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
  var newCustomerDue = $('#newCustomerDue').val();
  var newCustomerDue2 = $('#newCustomerDue2').val();
  if(newCustomerDue==newCustomerDue2){
    $("#customerStatusLoading").show();
     	 $.post(baseURL+'admin/customer/add/',
	    {
	        newCName: newCustomerName,
	        newCFather: newCustomerFather,
	        newCPhone: newCustomerPhone,
	        newCAddress: newCustomerAddress,
	        newCLimit: newCustomerLimit,
          newCDue: newCustomerDue,
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
        $('#newCustomerDue').val('');
        $('#newCustomerDue2').val('');
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
  }else{
    alert("Previous Due Not Matched, Please Verify The Previous Due");   
  }

}
