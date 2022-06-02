$( ".datepicker" ).datepicker({
  changeMonth: true,
  changeYear: true,
  maxDate: new Date(),
  dateFormat: 'dd-mm-yy'
});
$(".datepicker").datepicker("setDate", new Date());