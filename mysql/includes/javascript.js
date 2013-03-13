function checkUncheckAll(theElement) {
	var theForm = theElement.form, z = 0;
	for(z=0; z<theForm.length;z++){
		if(theForm[z].type == 'checkbox' && theForm[z].name != 'checkall'){
			theForm[z].checked = theElement.checked;
		}
	}
}
function manRow(id, doIt){
	var theForm = document.tableoverview, z = 0;
	var checked = new Array();
	for(z=0; z<theForm.length; z++){
		if(theForm[z].type == 'checkbox'){
			checked[z] = theForm[z].checked;
			theForm[z].checked = false;
		}
	}
	var theElement = document.getElementById(id);
	theElement.checked = true;
	document.tableoverview.action.value = doIt;
	document.tableoverview.submit();
	for(z=0; z<theForm.length; z++){
		if(theForm[z].type == 'checkbox'){
			theForm[z].checked = checked[z];
		}
	}
	document.tableoverview.action.value = '';
}
function manTable(id, doIt){
	var theForm = document.tableopperations, z = 0;
	var checked = new Array();
	for(z=0; z<theForm.length; z++){
		if(theForm[z].type == 'checkbox'){
			checked[z] = theForm[z].checked;
			theForm[z].checked = false;
		}
	}
	var theElement = document.getElementById(id);
	theElement.checked = true;
	document.tableopperations.action.value = doIt;
	document.tableopperations.submit();
	for(z=0; z<theForm.length; z++){
		if(theForm[z].type == 'checkbox'){
			theForm[z].checked = checked[z];
		}
	}
	document.tableopperations.action.value = '';
}
function manAll(id, doIt){
	var theForm = document.tableoverview, z = 0;
	var checked = new Array();
	for(z=0; z<theForm.length; z++){
		if(theForm[z].type == 'checkbox'){
			checked[z] = theForm[z].checked;
			theForm[z].checked = false;
		}
	}
	var theElement = document.getElementById(id);
	theElement.checked = true;
	document.tableoverview.action.value = doIt;
	document.tableoverview.submit();
	for(z=0; z<theForm.length; z++){
		if(theForm[z].type == 'checkbox'){
			theForm[z].checked = checked[z];
		}
	}
	document.tableoverview.action.value = '';
}
function manDb(id, doIt){
	var theForm = document.dboverview, z = 0;
	var checked = new Array();
	for(z=0; z<theForm.length; z++){
		if(theForm[z].type == 'checkbox'){
			checked[z] = theForm[z].checked;
			theForm[z].checked = false;
		}
	}
	var theElement = document.getElementById(id);
	theElement.checked = true;
	document.dboverview.action.value = doIt;
	document.dboverview.submit();
	for(z=0; z<theForm.length; z++){
		if(theForm[z].type == 'checkbox'){
			theForm[z].checked = checked[z];
		}
	}
	document.dboverview.action.value = '';
}