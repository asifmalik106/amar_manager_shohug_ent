var baseURL = "https://app.amar-manager.com/";
$( "#datepicker" ).datepicker({ minDate: -1, maxDate: "+1D" });
$( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
$('#invoiceList').dataTable({
"order": [[ 0, "desc" ]],
  "lengthMenu": [ [ 25, 50, 100, 250, -1], [ 25, 50, 100, 250, "All"] ] 
	});
$('#transactionList').dataTable({
"order": [[ 0, "desc" ]],
  "lengthMenu": [ [ 25, 50, 100, 250, -1], [ 25, 50, 100, 250, "All"] ] 
	});
function fillEditProfile(){
	$('#editSCName').val($('#SCName').html());
	$('#editSCFather').val($('#SCFather').html());
	$('#editSCPhone').val($('#SCPhone').html());
	$('#editSCAddress').val($('#SCAddress').html());
	$('#editSCLimit').val($('#SCLimit').html());
}
function editCustomer()
{
	$("#catStatusLoading").show();
	var editSCID = $('#scID').val();
	var editSCName = $('#editSCName').val();
	var editSCFather = $('#editSCFather').val();
	var editSCPhone = $('#editSCPhone').val();
	var editSCAddress = $('#editSCAddress').val();
	var editSCLimit = $('#editSCLimit').val();
	 $.post(baseURL+'manager/customer/editProfile/',
	    {
		 			editSCID: editSCID,
	        editSCName: editSCName,
	        editSCFather: editSCFather,
	        editSCPhone: editSCPhone,
	        editSCAddress: editSCAddress,
	        editSCLimit: editSCLimit,
	        submit: "true"
	    },
	    function(data, status)
			{
	        $("#editStatusLoading").hide();
	        if(data=="true"){
	        	$("#editStatusTrue").fadeIn();
	        	setTimeout(function(){ 
	        		$("#editStatusTrue").fadeOut(); 
	        	}, 8000);
						loadProfile();
	        	$('#editSCName').val('');
				$('#editSCFather').val('');
				$('#editSCPhone').val('');
				$('#editSCAddress').val('');
				$('#editSCLimit').val('');
	        }
	        else if(data=="duplicate"){
	        	$("#editStatusDuplicate").fadeIn();
	        	setTimeout(function(){ 
	        		$("#editStatusDuplicate").fadeOut(); 
	        	}, 8000);
	        }
	        else if(data=="empty"){
	        	$("#editStatusEmpty").fadeIn();
	        	setTimeout(function(){ 
	        		$("#editStatusEmpty").fadeOut(); 
	        	}, 8000);
	        }
	        else{
	        	$("#editStatusFalse").fadeIn();
	        	setTimeout(function(){ 
	        		$("#editStatusFalse").fadeOut(); 
	        	}, 8000);
	        }
	    });
}
function loadProfile(){
	var scID = $('#scID').val();
	$.post(baseURL+'manager/customer/getProfile/'+scID+'/',
	    {
		submit: "true"
	},
	    function(data, status){
	    	$("#loadProfile").html(data);
	    });
}
function payNow(invID, invDate, invTime, invTotal, invPaid){
	$('#payInvoicePayment').val('');
  $('#payInvoiceID').html(invID);
  $('#payInvoiceDate').html(invDate);
  $('#payInvoiceTime').html(invTime);
  $('#payInvoiceTotal').html(invTotal);
  $('#payInvoicePaid').html(invPaid);
	var balance = parseFloat($('#mainBalance').html());
	if(balance > 0){
		$('#payFromBalanceSection').show();
	}else{
		$('#payFromBalanceSection').hide();	
	}
	totalAndDue();
}
$('#payInvoicePayment').on('input', function(){
	totalAndDue();
	checkBalance();
	totalAndDue();
});
$('#payFromBalanceAmount').on('input', function(){
	var ab = parseFloat($('#mainBalance').html());
	if(ab< $(this).val())
	{
		$(this).val('');
	}
	totalAndDue();
});
function checkBalance(){
	var acBalance = parseFloat($('#availableCashBalance').val());
	var payInput = parseFloat($('#payInvoicePayment').val());
	if(payInput>acBalance){
		$('#payInvoicePayment').val('');
	}
}
function totalAndDue(){
	var total = parseFloat($('#payInvoiceTotal').html());
  var paid = parseFloat($('#payInvoicePaid').html());
	var paidNow = parseFloat($('#payInvoicePayment').val());
	var payFromBalance = parseFloat($("#payFromBalanceAmount").val());
	if(isNaN(paidNow)){
		paidNow = 0;
	}
	if(isNaN(payFromBalance)){
		payFromBalance = 0;
	}
  if(total < (paid + paidNow + payFromBalance)){
		$('#payInvoicePayment').val('');
		$("#payFromBalanceAmount").val('');
		paidNow = 0;
		payFromBalance = 0;
	}
	var due = total-paid-paidNow-payFromBalance;
	
  due = due.toFixed(2);
	$('#payInvoiceDue').html(due);
}

function loadAllInvoice(){
	var scID = $('#scID').val();
	$("#loadingCategory").show();
	$.post(baseURL+'manager/customer/getInvoices/'+scID+'/',
	    {
		submit: "true"
	},
	    function(data, status){
	    	$("#loadInvoices").html(data);
		    $('#invoiceList').dataTable({'order': [[ 0, 'desc' ]]});
	    	$("#loadingCategory").hide();
	    });
}
function loadAllTransactions(){
	var scID = $('#scID').val();
	$("#loadingTransactions").show();
	$.post(baseURL+'manager/customer/getTransactions/'+scID+'/',
	   {
		submit: "true"
	},
	    function(data, status){
	    	$("#loadTransactions").html(data);
				$('#transactionList').dataTable({'order': [[ 0, 'desc' ]]});
	    	$("#loadingTransactions").hide();
	    });
}
function addCashToInvoice()
{
	$("#catStatusLoading").show();
  $("#addCashToInvoice").prop("disabled",true);
	var scID    = $('#scID').val();
	var invID   = $('#payInvoiceID').html();
	var payment = $('#payInvoicePayment').val();
	var fromBalance = $('#payFromBalanceAmount').val();
  var addCashDate = $('#datepicker').val();
	console.log(scID+" "+invID+" "+payment+" "+fromBalance);
	 $.post(baseURL+'manager/invoice/payment',
	    {
	        scID: scID,
	        invID: invID,
		 			payment: payment,
		 			fromBalance: fromBalance,
          payDate: addCashDate,
	        submit: "true"
	    },
	    function(data, status){
	        $("#catStatusLoading").hide();
	        if(data=="true"){
	        	$("#catStatusTrue").fadeIn();
            $("#addCashToInvoice").prop("disabled",false);
	        	setTimeout(function(){ 
	        		$("#catStatusTrue").fadeOut(); 
	        	}, 3000);
	        	$('#payInvoicePayment').val('');
	        	 loadAllInvoice();
						 loadAllInvoice();
						getBalance();
						getBalance();
						loadAllTransactions();
						loadAllTransactions();
						setTimeout(function(){ 
	        		$('#payNow').modal('toggle');
	        	}, 1200);
						
  
	        }
	        else if(data=="empty"){
	        	$("#catStatusEmpty").fadeIn();
	        	setTimeout(function(){ 
	        		$("#catStatusEmpty").fadeOut(); 
	        	}, 3000);
            $("#addCashToInvoice").prop("disabled",false);
	        }
	        else{
	        	$("#catStatusFalse").fadeIn();
	        	setTimeout(function(){ 
	        		$("#catStatusFalse").fadeOut(); 
	        	}, 3000);
            $("#addCashToInvoice").prop("disabled",false);
	        }
	    });
}

function payCashToInvoice()
{
	$("#catStatusLoading").show();
	var scID    = $('#scID').val();
	var invID   = $('#payInvoiceID').html();
	var cashID = $('#cashSelect').val();
	var fromBalance = $("#payFromBalanceAmount").val();
	var payment = $('#payInvoicePayment').val();
	if(cashID)
	{
		cashID = cashID.split(",");
		cashID = cashID[0];
	}
	console.log(scID+" "+invID+" "+cashID+" "+payment);
	$.post(baseURL+'manager/invoice/purchasePayment',
	{
		scID: scID,
		invID: invID,
		cashID: cashID,
		fromBalance: fromBalance,
		payment: payment,
		submit: "true"
	},
	    function(data, status){
	        $("#catStatusLoading").hide();
	        if(data=="true"){
	        	$("#catStatusTrue").fadeIn();
	        	setTimeout(function(){ 
	        		$("#catStatusTrue").fadeOut(); 
	        	}, 3000);
	        	$('#payInvoicePayment').val('');
	        	 loadAllInvoice();
						 loadAllInvoice();
						getBalance();
						getBalance();
						loadAllTransactions();
						loadAllTransactions();
						setTimeout(function(){ 
	        		$('#payNow').modal('toggle');
	        	}, 1200);
						
	        }
	        else if(data=="empty"){
	        	$("#catStatusEmpty").fadeIn();
	        	setTimeout(function(){ 
	        		$("#catStatusEmpty").fadeOut(); 
	        	}, 3000);
	        }
	        else{
	        	$("#catStatusFalse").fadeIn();
	        	setTimeout(function(){ 
	        		$("#catStatusFalse").fadeOut(); 
	        	}, 3000);
	        }
	    });
}

function addCashAdvance()
{
	$("#advStatusLoading").show();
	var x = parseFloat($("#payAdvancePayment1").val());
	var y = parseFloat($("#payAdvancePayment2").val());
	var advNote = $("#cashAvdanceNote").val();
	var scID = $('#scID').val();
	if( x == y ){
			$.post(baseURL+'manager/customer/addAdvance',
	    {
	        scID: scID,
	        advAmount: x,
		 			note: advNote,
	        submit: "true"
	    },
			function(data, status){
	        $("#advStatusLoading").hide();
	        if(data=="true"){
	        	$("#advStatusTrue").fadeIn();
	        	setTimeout(function(){ 
	        		$("#advStatusTrue").fadeOut(); 
	        	}, 3000);
	        	$("#payAdvancePayment2").val('');
						$("#payAdvancePayment1").val('');
						getBalance();
						getBalance();
						setBalance();
						setBalance();
						loadAllTransactions();
						loadAllTransactions();
	        }
	        else if(data=="empty"){
	        	$("#advStatusEmpty").fadeIn();
	        	setTimeout(function(){ 
	        		$("#advStatusEmpty").fadeOut(); 
	        	}, 3000);
	        }
	        else{
	        	$("#advStatusFalse").fadeIn();
	        	setTimeout(function(){ 
	        		$("#advStatusFalse").fadeOut(); 
	        	}, 3000);
	        }
	    });
	}
	    
}


function addCashAdvancePayment()
{
	$("#advStatusLoading").show();
	
	var scID    = $('#scID').val();
	var cashID = $('#cashSelectDeposit').val();
	var payment1 = parseFloat($('#payDepositPayment1').val());
	var payment2 = parseFloat($('#payDepositPayment2').val());
	var advNote = $("#cashAvdanceNote").val();
	cashID = cashID.split(",");
	if( payment1 == payment2 ){
		$.post(baseURL+'manager/supplier/addAdvance',
		{
			scID: scID,
			cashID: cashID[0],
			payment: payment1,
			note: advNote,
			submit: "true"
		},
			function(data, status){
	        $("#advStatusLoading").hide();
	        if(data=="true"){
	        	$("#advStatusTrue").fadeIn();
	        	setTimeout(function(){ 
	        		$("#advStatusTrue").fadeOut(); 
	        	}, 3000);
	        	$("#payAdvancePayment2").val('');
						$("#payAdvancePayment1").val('');
						getBalance();
						getBalance();
						setBalance();
						setBalance();
						loadAllTransactions();
						loadAllTransactions();
	        }
	        else if(data=="empty"){
	        	$("#advStatusEmpty").fadeIn();
	        	setTimeout(function(){ 
	        		$("#advStatusEmpty").fadeOut(); 
	        	}, 3000);
	        }
	        else{
	        	$("#advStatusFalse").fadeIn();
	        	setTimeout(function(){ 
	        		$("#advStatusFalse").fadeOut(); 
	        	}, 3000);
	        }
	    });
	}

	    
}



function withdrawBalanceSubmit()
{
	$("#wStatusLoading").show();
	var x = parseFloat($("#withdrawBalance1").val());
	var y = parseFloat($("#withdrawBalance2").val());
	var wNote = $("#cashWithdrawNote").val();
	var scID = $('#scID').val();
	if( x == y ){
			$.post(baseURL+'manager/customer/withdrawBalance',
	    {
	        scID: scID,
	        wAmount: x,
		 			note: wNote,
	        submit: "true"
	    },
			function(data, status){
	        $("#wStatusLoading").hide();
	        if(data=="true"){
	        	$("#wStatusTrue").fadeIn();
	        	setTimeout(function(){ 
	        		$("#wStatusTrue").fadeOut(); 
	        	}, 3000);
	        	$("#withdrawBalance2").val('');
						$("#withdrawBalance1").val('');
						getBalance();
						getBalance();
						setBalance();
						setBalance();
						loadAllTransactions();
						loadAllTransactions();
	        }
	        else if(data=="empty"){
	        	$("#wStatusEmpty").fadeIn();
	        	setTimeout(function(){ 
	        		$("#wStatusEmpty").fadeOut(); 
	        	}, 3000);
	        }
	        else{
	        	$("#wStatusFalse").fadeIn();
	        	setTimeout(function(){ 
	        		$("#wStatusFalse").fadeOut(); 
	        	}, 3000);
	        }
	    });
	}
	    
}


function withdrawBalanceSubmitSupplier()
{
	$("#wStatusLoading").show();
	var x = parseFloat($("#withdrawBalance1").val());
	var y = parseFloat($("#withdrawBalance2").val());
	var wNote = $("#cashWithdrawNote").val();
	var scID = $('#scID').val();
	if( x == y ){
			$.post(baseURL+'manager/supplier/withdrawBalance',
	    {
	        scID: scID,
	        wAmount: x,
		 			note: wNote,
	        submit: "true"
	    },
			function(data, status){
	        $("#wStatusLoading").hide();
	        if(data=="true"){
	        	$("#wStatusTrue").fadeIn();
	        	setTimeout(function(){ 
	        		$("#wStatusTrue").fadeOut(); 
	        	}, 3000);
	        	$("#withdrawBalance2").val('');
						$("#withdrawBalance1").val('');
						getBalance();
						getBalance();
						setBalance();
						setBalance();
						loadAllTransactions();
						loadAllTransactions();
	        }
	        else if(data=="empty"){
	        	$("#wStatusEmpty").fadeIn();
	        	setTimeout(function(){ 
	        		$("#wStatusEmpty").fadeOut(); 
	        	}, 3000);
	        }
	        else{
	        	$("#wStatusFalse").fadeIn();
	        	setTimeout(function(){ 
	        		$("#wStatusFalse").fadeOut(); 
	        	}, 3000);
	        }
	    });
	}
	    
}




function getBalance()
{
	var scID    = $('#scID').val();
	 $.post(baseURL+'manager/customer/getBalance',
	    {
	        scID: scID,
	    },
	    function(data, status){
				$("#balance").html(data);
	    });
}
function setBalance(){
	$("#currentBalance").html($('#profileBalance').html());
	$("#currentBalanceW").html($('#profileBalance').html());
}



$("#payAdvancePayment1").on('input', function(){
	var x = parseFloat($("#payAdvancePayment1").val());
	var y = parseFloat($("#payAdvancePayment2").val());
	if( x == y ){
		$("#newBalanceStatus").hide();
		var a = parseFloat($("#mainBalance").html());
		var z = a + x;
		if( a > z)
		{
			$("#payAdvancePayment2").val('');
			$("#payAdvancePayment1").val('');
			$("#newBalance").html('<i id="newBalanceStatus" class="delete glyphicon glyphicon-warning-sign"></i>');
		}else{
			$("#newBalance").html(z);
			if(z<0){
				$("#newBalance").attr("class", "delete");
			}else{
				$("#newBalance").attr("class", "edit");
			}
		}
	}else{
		$("#newBalance").html('<i id="newBalanceStatus" class="delete glyphicon glyphicon-warning-sign"></i>');
	}
});
$("#payAdvancePayment2").on('input', function(){
	var x = parseFloat($("#payAdvancePayment1").val());
	var y = parseFloat($("#payAdvancePayment2").val());
	if( x == y ){
		$("#newBalanceStatus").hide();
		var a = parseFloat($("#mainBalance").html());
		var z = a + x;
		if( a > z)
		{
			$("#payAdvancePayment2").val('');
			$("#payAdvancePayment1").val('');
			$("#newBalance").html('<i id="newBalanceStatus" class="delete glyphicon glyphicon-warning-sign"></i>');
		}else{
			$("#newBalance").html(z);
			if(z<0){
				$("#newBalance").attr("class", "delete");
			}else{
				$("#newBalance").attr("class", "edit");
			}
		}
	}else{
		$("#newBalance").html('<i id="newBalanceStatus" class="delete glyphicon glyphicon-warning-sign"></i>');
	}
});
$("#withdrawBalance1").on('input', function(){
	var x = parseFloat($("#withdrawBalance1").val());
	var y = parseFloat($("#withdrawBalance2").val());
	if( x == y ){
		$("#newWithdrawBalanceStatus").hide();
		var a = parseFloat($("#mainBalance").html());
		if( x > a)
		{
			$("#withdrawBalance1").val('');
			$("#withdrawBalance2").val('');
			$("#newWithdrawBalance").html('<i id="newBalanceStatus" class="delete glyphicon glyphicon-warning-sign"></i>');
		}else{
			$("#newWithdrawBalance").html((a-x).toFixed(2));
			$("#newWithdrawBalance").attr("class", "edit");
		}
	}else{
		$("#newWithdrawBalance").html('<i id="newBalanceStatus" class="delete glyphicon glyphicon-warning-sign"></i>');
	}
});
$("#withdrawBalance2").on('input', function(){
	var x = parseFloat($("#withdrawBalance1").val());
	var y = parseFloat($("#withdrawBalance2").val());
	if( x == y ){
		$("#newWithdrawBalanceStatus").hide();
		var a = parseFloat($("#mainBalance").html());
		if( x > a)
		{
			$("#withdrawBalance1").val('');
			$("#withdrawBalance2").val('');
			$("#newWithdrawBalance").html('<i id="newBalanceStatus" class="delete glyphicon glyphicon-warning-sign"></i>');
		}else{
			$("#newWithdrawBalance").html((a-x).toFixed(2));
			$("#newWithdrawBalance").attr("class", "edit");
		}
	}else{
		$("#newWithdrawBalance").html('<i id="newBalanceStatus" class="delete glyphicon glyphicon-warning-sign"></i>');
	}
});
$("#useBalance").change(function(){
if($("#useBalance").is(':checked')){
    $("#payFromBalance").show();  // checked
		$("#availableBalance").html($('#mainBalance').html());
}
else{
    $("#payFromBalance").hide();  // unchecked
		$("#availableBalance").html("");
	}
});

$("#cashSelect").on('change', function(){
	
	var cash = $(this).val();
	var cArray = cash.split(",");
	$('#availableCashBalance').val(cArray[2]);
	$('#availableBalanceLabel').html("Available Balance: "+cArray[2]+"<br>");
});

$("#cashSelectDeposit").on('change', function(){
	var cash = $(this).val();
	var cArray = cash.split(",");
	$('#availableCashBalanceDeposit').val(cArray[2]);
	$('#availableBalanceLabelDeposit').html("Available Balance: "+cArray[2]+"<br>");
});
function depositPaymentSupplier(){
	var dp1 = parseFloat($("#payDepositPayment1").val());
	var dp2 = parseFloat($("#payDepositPayment2").val());
	var bal = parseFloat($("#availableCashBalanceDeposit").val());
	if(dp1>bal || dp2>bal){
		$("#payDepositPayment1").val('');
		$("#payDepositPayment2").val('');
	}
}
loadProfile();
loadAllInvoice();
loadAllTransactions();
getBalance();
