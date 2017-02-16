
/*	function select_option(form, optionName, selected) 
	{
		form.elements[optionName]  	
	}*/

function select_option (aForm,aElm,aOpValue) {	
	var lOption = document.forms[aForm].elements[aElm].options;		
	for (var i = 0; i < lOption.length; i++) {
		if (lOption[i].value == aOpValue) {
			lOption[i].selected = true;
		}
	}	
}

function submit_form(form, href) 
{	
	form.action = href;
	form.submit();
}

function text_counter(field,cntfield,maxlimit) {
	if (field.value.length > maxlimit) // if too long...trim it!
			field.value = field.value.substring(0, maxlimit);			
	else
		cntfield.value = maxlimit - field.value.length;
}
