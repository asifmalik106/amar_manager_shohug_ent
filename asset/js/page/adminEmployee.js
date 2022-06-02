

$( ".datepicker" ).datepicker({
  changeMonth: true,
  changeYear: true,
  maxDate: new Date(),
  dateFormat: 'dd-mm-yy'
});
$(".datepicker").on('click', function(){
	$(this).datepicker("setDate", new Date());
});
$('.unlock').click(function(){
	$(".lock").removeAttr('disabled');
	$(this).hide();
	$(".edit-data").show();

});

//Add Category Function
function addEmployee()
{
	$('button').prop('disabled', true);
	$("#employeeStatusLoading").show();
	var newEmployeeName			= $('#newEmployeeName').val();
	var newEmployeePhone  	= $('#newEmployeePhone').val();
	var newEmployeeSalary		= $('#newEmployeeSalary').val();
	var newEmployeeFine 		= $('#newEmployeeFine').val();
	var newEmployeeInfo 		= $('#newEmployeeInfo').val();

	 $.post(baseURL+'admin/employee/add/',
	    {
	        name: newEmployeeName,
	        phone: newEmployeePhone,
	        salary: newEmployeeSalary,
	        fine: newEmployeeFine,
		 			info: newEmployeeInfo,
	        submit: "true"
	    },
	    function(data, status){
	        $("#employeeStatusLoading").hide();
	        if(data=="true"){
	        	$("#employeeStatusTrue").fadeIn();
	        	setTimeout(function(){ 
	        		$("#employeeStatusTrue").fadeOut(); 
	        	}, 3000);
	        		$('#newEmployeeName').val('');
							$('#newEmployeePhone').val('');
							$('#newEmployeeSalary').val('');
							$('#newEmployeeFine').val('');
							$('#newEmployeeInfo').val('');
	        }
	        else if(data=="duplicate"){
	        	$("#employeeStatusDuplicate").fadeIn();
	        	setTimeout(function(){ 
	        		$("#employeeStatusDuplicate").fadeOut(); 
	        	}, 3000);
	        }
	        else if(data=="empty"){
	        	$("#employeeStatusEmpty").fadeIn();
	        	setTimeout(function(){ 
	        		$("#employeeStatusEmpty").fadeOut(); 
	        	}, 3000);
	        }
	        else{
	        	$("#employeeStatusFalse").fadeIn();
	        	setTimeout(function(){ 
	        		$("#employeeStatusFalse").fadeOut(); 
	        	}, 3000);
	        }
		 		$('button').prop('disabled', false);
	    });
}
