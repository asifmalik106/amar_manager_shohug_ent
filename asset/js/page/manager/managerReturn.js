var baseURL = "https://app.amar-manager.com/";
//Add Category Function
function loadInvoice()
{
	$("#catStatusLoading").show();
	var invoiceID = $('#invoiceID').val();
	 $.post(baseURL+'manager/invoiceReturn/get/',
	    {
	        invoiceID: invoiceID,
	        submit: true
	    },
	    function(data, status){
	    	$("#catStatusLoading").hide();
	      $("#invoiceArea").html(data);
	    });
}
