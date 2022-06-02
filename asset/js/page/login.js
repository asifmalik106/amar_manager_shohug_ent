$('#passwordDummy').on('input', function(){
  var pass = $(this).val();
  $('#password').val($('#password').val() + pass.charAt(pass.length-1));
});