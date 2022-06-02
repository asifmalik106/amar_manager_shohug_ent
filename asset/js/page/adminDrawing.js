

function addDrawing() {
	$("#cashStatusLoading").show();
	var cashAccount     = $('#selectCashAccountS').val()
	var drawingAmount = $('#drawingAmount').val();
	var drawingNote = $('#drawingNote').val();
	alert(cashAccount+" "+drawingAmount+" "+drawingNote);
	$.post(baseURL + 'admin/drawing/addDrawing/', {
			cAccount : cashAccount,
			dAmount: drawingAmount,
			dNote: drawingNote,
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
				$('#drawingAmount').val('');
				$('#drawingNote').val('');
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
	$('#drawingAmount').removeAttr( "readonly" )
});
$('#drawingAmount').on('input', function(){
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
