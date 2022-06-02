

//Add Category Function
function addExpenseCategory() 
{
	$("#expenseCategoryStatusLoading").show();
	var newExpenseCategoryName = $('#newExpenseCategoryName').val();
	$.post(baseURL + 'admin/expense/addExpenseCategory/', {
			newExpenseName: newExpenseCategoryName,
			submit: "true"
		},
		function(data, status) {
			$("#expenseCategoryStatusLoading").hide();
			if (data == "true") {
				$("#expenseCategoryStatusTrue").fadeIn();
				setTimeout(function() {
					$("#expenseCategoryStatusTrue").fadeOut();
				}, 3000);
				$('#newExpenseCategoryName').val('');
				loadExpenseCategory();
				loadExpenseCategory();
			} 
			else if (data == "duplicate") {
				$("#expenseCategoryStatusDuplicate").fadeIn();
				setTimeout(function() {
					$("#expenseCategoryStatusDuplicate").fadeOut();
				}, 3000);
			}
		
		else if (data == "empty") {
				$("#expenseCategoryStatusEmpty").fadeIn();
				setTimeout(function() {
					$("#expenseCategoryStatusEmpty").fadeOut();
				}, 3000);
			} else {
				$("#expenseCategoryStatusFalse").fadeIn();
				setTimeout(function() {
					$("#expenseCategoryStatusFalse").fadeOut();
				}, 3000);
			}
		});
}

function addExpense() {
	$("#cashStatusLoading").show();
	var cashAccount     = $('#selectCashAccountS').val()
	var expenseCategory = $('#selectExpenseCategory').val();
	var expenseAmount = $('#expenseAmount').val();
	var expenseNote = $('#expenseNote').val();
	$.post(baseURL + 'admin/expense/addExpense/', {
			cAccount : cashAccount,
			eCategory: expenseCategory,
			eAmount: expenseAmount,
			eNote: expenseNote,
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
function loadExpenseCategory() {
	$("#loadingCashAccounts").show();
	$.post(baseURL + 'admin/expense/get/', {},
		function(data, status) {
			$("#loadExpenseCategory").html(data);
			$("#loadingExpenseCategory").hide();
		});
}

//Executing Load Category When Page is Loaded...
loadExpenseCategory();

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
	$('#expenseAmount').removeAttr( "readonly" )
});
$('#expenseAmount').on('input', function(){
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
