
$("#selectProduct").on('change', function(){
  $('#selectBatch').empty().append('<option selected="selected" disabled>Select Product Batch</option>')
  var barcodeArray = $('option:selected', this).attr('barcode');
  barcodeArray = barcodeArray.split(',');
  
  var saleArray = $('option:selected', this).attr('saleUnit');
  saleArray = saleArray.split(',');
  
  var batchArray = $('option:selected', this).attr('batch');
  batchArray = batchArray.split(',');
  
  for(var j = 0; j<batchArray.length-1; j++){
    console.log(j+" Batch Unit "+batchArray[j]+"\n");
    var text = batchArray[j]+" (Sale Unit: "+saleArray[j]+")"; 
    addBatch(barcodeArray[j], text, saleArray[j]);
  }
  //alert($('option:selected', this).attr('barcode')+" "+$('option:selected', this).attr('saleUnit')+" "+$('option:selected', this).attr('batch'));
})
$("#selectBatch").on('change', function(){
  var name = $("option:selected","#selectProduct").attr('name');
  var sale = $("option:selected",this).attr('sale');
  var barcode = $("option:selected",this).attr('value');
  var text = name+"<br>"+sale;
  $(".printBARCODE").JsBarcode(barcode, {width:2,height:45, fontSize:14});
  $(".name").html(text);
});
function addBatch(value, text, sale){
  $('#selectBatch').append($("<option></option>").attr({"value":value, "sale":sale}).text(text)); 
}