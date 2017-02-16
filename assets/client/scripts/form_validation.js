	function check_delete(form_name,page,client) {		
		if (confirm("Delete " + client + "?")) {
			document.forms[form_name].action = page;
			document.forms[form_name].submit();
		}
	}
	
	function valid_option (aForm,aMin,aMax) {	
				
		var lMin = document.forms[aForm.name].elements[aMin.name].options;		
		var lMax = document.forms[aForm.name].elements[aMax.name].options;		
				
		for (var i = 0; i < lMin.length; i++) {		
			if (lMin[i].selected) {
				lMinValue = parseInt(lMin[i].value);
			}
		}	
		
		for (var i = 0; i < lMax.length; i++) {		
			if (lMax[i].selected) {
				lMaxValue = parseInt(lMax[i].value);
			}
		}	
		
		if (lMinValue >= lMaxValue) {
			alert("Maximum Salary value must be greater than Minimum Salary value");
			return false;
		}
		
		return true;
	}	
	
	function reset_select(aForm,aElement) {
			
		document.forms[aForm].elements[aElement].options.selectedIndex = 0;
	}
	
	function uncheck(aForm,aElement) {	
		
		document.forms[aForm].elements[aElement].checked = false;
	}

	function isFilled(elm) 
	{	
		if(elm != null) 
		{	
			if(elm.value == "" ) 
			{
				return false;
			}
		}
	}
	
	function isPhone(aElement) {
		var lElement = (aElement.value + "");
		var lCleanstring = "";
		for (var i = 0; i < lElement.length; i++) {
			if (lElement.charAt(i) >= "0" && lElement.charAt(i) <= "9") {
				lCleanstring += lElement.charAt(i);
			}
		}
		if (lCleanstring.length != 10) {
			alert("Please enter your telephone number (include 2 digit prefix)");
			return false;
		}
		return true;
	}
	
	function isSelected(elm) 
	{
		//alert(elm.name);
		if(elm.options[elm.options.selectedIndex].value == "")
		{
			return false;	
		}
		
	}

	function isEmail(aElement) {				
		if (aElement.value.indexOf("@") == -1) {
			alert("Please fill out a valid email address"); 
			return false;
		}
		return true;
	}
		
	function isReady(form) {		
		// is fullname element filled?
		var submitForm = true;
		if (isSelected(form.qcc_department) == false) 
		{
		   alert("Department must be selected!");		   
		   submitForm = false;
		}
		
		if (isSelected(form.qcc_errortype) == false) 
		{
			   alert("Error Type must be selected!");		   
			   submitForm = false;
		}
		
		if (isSelected(form.qcc_company) == false) 
		{
			   alert("Company must be selected!");		   
			   submitForm = false;
		}	
		
		if (isSelected(form.qcc_publication) == false) 
		{
			   alert("Publication must be selected!");		   
			   submitForm = false;
		}			
		
		if (isSelected(form.qcc_edition) == false) 
		{
			   alert("Edition must be selected!");		   
			   submitForm = false;
		}			

		if (isFilled(form.qcc_pubdate) == false) 
		{
			   alert("Publication date must be entered!");		   
			   submitForm = false;
		}
		
		if (isSelected(form.qcc_operator) == false) 
		{
			   alert("Operator must be selected!");		   
			   submitForm = false;
		}	

		if(form.qcc_respondingmanager != null) 
		{ 
			if (isSelected(form.qcc_respondingmanager) == false) 
			{
			   alert("Responding Manager must be selected!");		   
			   submitForm = false;
			}
		}

		if(form.qcc_errorresponse != null) 
		{ 
			if (isSelected(form.qcc_errorresponse) == false) 
			{
			   alert("Error response must be selected!");		   
			   submitForm = false;
			}
		}

		if (isFilled(form.qcc_errordetails) == false) 
		{
			   alert("Error details must be entered!");		
			   form.qcc_errordetails.focus();
			   submitForm = false;
		}
		
		//qcc_responsedetails

		if (isFilled(form.qcc_responsedetails) == false) 
		{
			alert("Error response details must be entered!");
			form.qcc_responsedetails.focus();
			submitForm = false;
		}
		
		if(submitForm) 
		{
			form.submit();
		}		
		return true;
	}
	