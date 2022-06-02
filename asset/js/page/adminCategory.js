

//Fill Category Data to Edit Category Modal
function fillModifyCategoryData(catID, catName, catUnit){
	$("#catEditStatusTrue").hide();
	$("#catEditStatusFlase").hide();
	$("#catEditStatusDuplicate").hide();
	$("#catEditStatusEmpty").hide();
	$('#modifyCategoryID').val(catID);
	$('#modifyCategoryName').val(catName);
	$('#modifyCategoryUnit').val(catUnit);
}

//Fill Category Data to Delete Modal
function fillDeleteCategoryData(catID, catName, catCount, catUnit){
	$("#catDeleteStatusTrue").hide();
	$("#catDeleteStatusFalse").hide();
	if(catCount==0){
		$('.cannot-delete-category').hide();
		$('.delete-category').show();
		$('#deleteCategoryID').val(catID);
		$('#deleteCategoryName').val(catName);
		$('#deleteCategoryUnit').val(catUnit);
	}else{
		$('.delete-category').hide();
		$('.cannot-delete-category').show();
	}
}

//Add Category Function
function addCategory()
{
	$("#catStatusLoading").show();
	var newCategoryName = $('#newCategoryName').val();
	var newCategoryUnit = $('#newCategoryUnit').val();
	 $.post(baseURL+'admin/category/addCategory/',
	    {
	        newCatName: newCategoryName,
	        newCatUnit: newCategoryUnit,
	        submit: "true"
	    },
	    function(data, status){
	        $("#catStatusLoading").hide();
	        if(data=="true"){
	        	$("#catStatusTrue").fadeIn();
	        	setTimeout(function(){ 
	        		$("#catStatusTrue").fadeOut(); 
	        	}, 3000);
	        	$('#newCategoryUnit').val('');
	        	$('#newCategoryName').val('');
	        	loadCategory();
				loadCategory();
	        }
	        else if(data=="duplicate"){
	        	$("#catStatusDuplicate").fadeIn();
	        	setTimeout(function(){ 
	        		$("#catStatusDuplicate").fadeOut(); 
	        	}, 3000);
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

//Load Category Function
function loadCategory(){
	$("#loadingCategory").show();
	$.post(baseURL+'admin/category/getAllCategory/',
	    {},
	    function(data, status){
	    	$("#loadCategory").html(data);
	    	$("#loadingCategory").hide();
	    });
}

//Executing Load Category When Page is Loaded...
loadCategory();

function editCategory(){
	$("#catEditStatusLoading").show();
	var editCategoryID   = $('#modifyCategoryID').val();
	var editCategoryName = $('#modifyCategoryName').val();
	var editCategoryUnit = $('#modifyCategoryUnit').val();
	 $.post(baseURL+'admin/category/editCategory/',
	    {
	    	editCatID: editCategoryID,
	        editCatName: editCategoryName,
	        editCatUnit: editCategoryUnit,
	        submit: "true"
	    },
	    function(data, status){
	        $("#catEditStatusLoading").hide();
	        if(data=="true"){
	        	$("#catEditStatusTrue").show();
	        	setTimeout(function(){ 
	        		$("#catEditStatusTrue").fadeOut(); 
	        	}, 3000);
	        	loadCategory();
				loadCategory();
	        }
	        else if(data=="duplicate"){
	        	$("#catEditStatusDuplicate").fadeIn();
	        	setTimeout(function(){ 
	        		$("#catStatusDuplicate").fadeOut(); 
	        	}, 3000);
	        }
	        else if(data=="empty"){
	        	$("#catEditStatusEmpty").fadeIn();
	        	setTimeout(function(){ 
	        		$("#catEditStatusEmpty").fadeOut(); 
	        	}, 3000);
	        }
	        else{
	        	$("#catEditStatusFalse").fadeIn();
	        	setTimeout(function(){ 
	        		$("#catEditStatusFalse").fadeOut(); 
	        	}, 3000);
	        }
	    });
	loadCategory();
	loadCategory();
}

function searchCat() {
	var kword = $('#searchCategory').val();
	$('#loadingCategory').show();
	$.post(baseURL+'admin/category/searchCategory/',
	    { searchCategory: kword},
	    function(data, status){
	    	$("#loadCategory").html(data);
	    	$('#loadingCategory').hide();
	        //alert("Data: " + data + "\nStatus: " + status);
	    });
}
function deleteCategory(){
	$("#catDeleteStatusLoading").show();
	var catID = $('#deleteCategoryID').val();
	$.post(baseURL+'admin/category/deleteCategory/',
	    {
	        deleteCatID: catID,
	        submit: "true"
	    },
	    function(data, status){
	    	//document.write(data);
	        $("#catDeleteStatusLoading").hide();
	        if(data=="true"){
	        	$('.delete-category').hide();
	        	$("#catDeleteStatusTrue").fadeIn();
	        	setTimeout(function(){ 
	        		$("#catDeleteStatusTrue").fadeOut(); 
	        	}, 3000);
	        	loadCategory();
	 			loadCategory();
	        }
	        else{
	        	$("#catDeleteStatusFalse").fadeIn();
	        	setTimeout(function(){ 
	        		$("#catDeleteStatusFalse").fadeOut(); 
	        	}, 3000);
	        }
	    });
}
