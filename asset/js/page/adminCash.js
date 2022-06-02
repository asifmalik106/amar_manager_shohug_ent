

//Add Category Function
function addCashAccount() {
	$("#cashAccountStatusLoading").show();
	var newCashAccountName = $('#newCashAccountName').val();
	$.post(baseURL + 'admin/cash/addCashAccount/', {
			newCashName: newCashAccountName,
			submit: "true"
		},
		function(data, status) {
			$("#cashAccountStatusLoading").hide();
			if (data == "true") {
				$("#cashAccountStatusTrue").fadeIn();
				setTimeout(function() {
					$("#cashAccountStatusTrue").fadeOut();
				}, 3000);
				$('#newCashAccountName').val('');
				loadCashAccounts();
				loadCashAccounts();
			} else if (data == "empty") {
				$("#cashAccountStatusEmpty").fadeIn();
				setTimeout(function() {
					$("#cashAccountStatusEmpty").fadeOut();
				}, 3000);
			} else {
				$("#cashAccountStatusFalse").fadeIn();
				setTimeout(function() {
					$("#cashAccountStatusFalse").fadeOut();
				}, 3000);
			}
		});
}

function addCash() {
	$("#cashStatusLoading").show();
	var cashAccount = $('#selectCashAccount').val();
	var cashAmount = $('#cashAmount').val();
	var cashNote = $('#cashNote').val();
	$.post(baseURL + 'admin/cash/addCash/', {
			cAccount: cashAccount,
			cAmount: cashAmount,
			cNote: cashNote,
			submit: "true"
		},
		function(data, status) {
			$("#cashStatusLoading").hide();
			if (data == "true") {
				$("#cashStatusTrue").fadeIn();
				setTimeout(function() {
					$("#cashStatusTrue").fadeOut();
				}, 8000);
				$('#selectCashAccount').val('').change();
				$('#cashAmount').val('');
				$('#cashNote').val('');
			} else if (data == "empty") {
				$("#cashStatusEmpty").fadeIn();
				setTimeout(function() {
					$("#cashStatusEmpty").fadeOut();
				}, 8000);
			} else {
				$("#cashStatusFalse").fadeIn();
				setTimeout(function() {
					$("#cashStatusFalse").fadeOut();
				}, 8000);
			}
		});
}

//Load Category Function
function loadCashAccounts() {
	$("#loadingCashAccounts").show();
	$.post(baseURL + 'admin/cash/get/', {},
		function(data, status) {
			$("#loadCashAccounts").html(data);
			$("#loadingCashAccounts").hide();
		});
}

//Executing Load Category When Page is Loaded...
loadCashAccounts();

function transferCash() {
	$("#cashStatusLoading").show();
	var sourceAccount = $('#selectCashAccountS').val();
	var destinatedAccount = $('#selectCashAccountD').val();
	var Amount = $('#cashAmountTransfer').val();
	var cashNote = $('#cashTransferNote').val();
	$.post(baseURL + 'admin/cash/transferCash/', {
			sAccount: sourceAccount,
			dAccount: destinatedAccount,
			dAmount: Amount,
			cNote: cashNote,
			submit: "true"
		},
		function(data, status) {
			$("#cashStatusLoading").hide();
			if (data == "true") {
				$("#cashStatusTrue").fadeIn();
				setTimeout(function() {
					$("#cashStatusTrue").fadeOut();
				}, 8000);
				$('#selectCashAccountS').val('').change();
				$('#selectCashAccountD').val('');
				$('#cashAmountTransfer').val('');
				$('#cashTransferNote').val('');
			} else if (data == "empty") {
				$("#cashStatusEmpty").fadeIn();
				setTimeout(function() {
					$("#cashStatusEmpty").fadeOut();
				}, 8000);
			} else {
				$("#cashStatusFalse").fadeIn();
				setTimeout(function() {
					$("#cashStatusFalse").fadeOut();
				}, 8000);
			}
		});
}

$("#addCashToggle").click(function() {
	$("#transferCashDiv").hide();
	$("#addCashDiv").fadeIn();
	
});
$("#transferCashToggle").click(function() {
	$("#addCashDiv").hide();
	$("#transferCashDiv").fadeIn();
});
$('#selectCashAccountS').on('change', function(){
	$('#cashAmountAvailable').val(parseFloat($("#selectCashAccountS option:selected").attr('balance')).toFixed(2));
	$('#selectCashAccountD').html($('#selectCashAccountS').html());
	var des = "#selectCashAccountD option[value='"+$(this).val()+"']";
	$(des).remove(); 
});
$('#cashAmountTransfer').on('input', function(){
	if(parseFloat($(this).val()) > parseFloat($('#cashAmountAvailable').val())){
		$(this).val('');
	}
})
$('#cashList').dataTable({
	"order": [
		[0, "desc"]
	],
	"lengthMenu": [
		[25, 50, 100, 250, -1],
		[25, 50, 100, 250, "All"]
	]
});
