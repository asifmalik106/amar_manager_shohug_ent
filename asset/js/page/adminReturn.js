
//Add Category Function
function loadInvoice()
{
	$("#catStatusLoading").show();
	var invoiceID = $('#invoiceID').val();
	 $.post(baseURL+'admin/invoiceReturn/get/',
	    {
	        invoiceID: invoiceID,
	        submit: true
	    },
	    function(data, status){
	    	$("#catStatusLoading").hide();
	      $("#invoiceArea").html(data);
	    });
}
