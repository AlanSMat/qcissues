<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title></title>
  <style type="text/css">		
    body 	    
	  #pageid {
		  float:left;
		  padding:2px 0px 2px 0px;
		  width:125px;
		  text-align:center;
		  background-color:#ccc;
		  color:#000;
		  cursor:pointer;
		  border: 1px solid #ccc;
		  xborder-right:0px;			
	  }
		
	  a.remake {
		  color:#0000ff;
		  text-decoration:underline;
		  padding-left:10px;
	  }
	  
    .gradbg 
    {
      background-image:url('images/topgrad.gif');
    }
	  
  </style>
  <script language="JavaScript" type="text/javascript">
	  function printpage() {
		  window.print();  
	  }
		
	  function refresh_page() {
		  document.location = document.location;
	  }
	  
	  function windowNew(url, width, height) 
	  {
	    if(!width)
	      width = 600;
	    if(!height)
	      height = 500;
	    var left = (screen.width / 2) - (width / 2);
	    var top = (screen.height / 2) - (height / 2);
	    link = window.open(url,"Link","toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=1,width=" + width + ",height=" + height + ",left=" + left + ",top=" + top + ""); 
	  }
		
  </script>    
  <link rel="stylesheet" type="text/css" href="http://chulriph/qcissues/assets/client/css/default.css"  media="screen" />    
  <link rel="stylesheet" type="text/css" href="http://chulriph/qcissues/assets/client/css/print.css" media="print" />    
</head>
<body>
  <div class="mainBodyContainer">
    <div class="mainPageWidthAndHeight" align="center">   
      <div class="noprint">
	  	<table cellpadding="0" cellspacing="0" border="0" width="100%">
	  	  <tr>
	  	    <td class="bannerbg" align="left"><img src="http://chulriph/qcissues/assets/client/images/NWNBanner.jpg"width="314" height="35" alt="" /></td>
		  </tr>
		  <tr>
		    <td background="http://chulriph/qcissues/assets/client/images/topgrad.gif">  	 	  
			  <div class="mainTitle"><b>Chullora Quality Issues</b></div>
			</td>
		  </tr>
		</table>
		<div class="navTopContainer">		     
		  <div class="navItemTop" id="default" style="border-right:1px outset #ccc;float:left;" onMouseOut="this.className='navItemTop'" onMouseOver="this.className='navItemOverTop'" onClick="document.location='<%=rootURL %>/default.aspx?pageId=default'">New QC Issue</div>	  					  	        
		  <div class="navItemTop" id="search" style="border-right:1px outset #ccc;float:left;" onMouseOut="this.className='navItemTop'" onMouseOver="this.className='navItemOverTop'" onClick="document.location='<%=rootURL %>/default.aspx?pageId=search'">Search</div>
		  <div class="navItemTop" id="browse" style="float:left;" onMouseOut="this.className='navItemTop'" onMouseOver="this.className='navItemOverTop'" onClick="document.location='<%=rootURL %>/browse.aspx?pageId=browse'"">Browse</div>		      
		  <div class="navItemTop" id="errorResponses" style="float:right" onMouseOut="this.className='navItemTop'" onMouseOver="this.className='navItemOverTop'" onClick="document.location = '<%=rootURL %>/errorResponses/listErrorResponses.aspx?pageId=errorResponses'">Error Responses</div>		  		  		 
		  <div class="navItemTop" id="operators" style="float:right" onMouseOut="this.className='navItemTop'" onMouseOver="this.className='navItemOverTop'" onClick="document.location = '<%=rootURL %>/operators/listOperators.aspx?pageId=operators'">Operators</div>
		  <div class="navItemTop" id="errorTypes" style="float:right" onMouseOut="this.className='navItemTop'" onMouseOver="this.className='navItemOverTop'" onClick="document.location = '<%=rootURL %>/errorTypes/listErrorTypes.aspx?pageId=errorTypes&departmentId=0'">Error Types</div>          
		  <div class="clear">&nbsp;</div>
	    </div><!-- end navTopContainer -->
	  </div><!-- end noprint -->       <script language="javascript" src="http://chulriph/qcissues/assets/client/scripts/chainedselects.js"></script>
    	<script language="javascript">
	//var hide_empty_list=true; //uncomment this line to hide empty selection lists
	var disable_empty_list=true; //uncomment this line to disable empty selection lists
  	  	 
    addListGroup("ert_groups", "dep_department");
    addOption("dep_department", " -- select company -- ", "", "", 1); //Empty starter option
        addList("dep_department", "Holt St.", "1", "holt_st.");
	    addOption("holt_st.", " -- select publication -- ", "", "", 1); //Empty starter option
          
      addList("holt_st.", "Complex PDF", "1", "complex_pdf");
            
      addList("holt_st.", "Wrong Folio", "2", "wrong_folio");
            addList("dep_department", "Cumberland", "2", "cumberland");
	    addOption("cumberland", " -- select publication -- ", "", "", 1); //Empty starter option
          
      addList("cumberland", "Complex PDF", "3", "complex_pdf");
            
      addList("cumberland", "Under Inked", "4", "under_inked");
        	</script>
  		<script language="javascript">
	//var hide_empty_list=true; //uncomment this line to hide empty selection lists
	var disable_empty_list=true; //uncomment this line to disable empty selection lists
  	  	 
    addListGroup("publication_groups", "com_company");
    addOption("com_company", " -- select company -- ", "", "", 1); //Empty starter option
        addList("com_company", "Nationwide News", "1", "nationwide_news");
	    addOption("nationwide_news", " -- select publication -- ", "", "", 1); //Empty starter option
          
      addList("nationwide_news", "Daily Telegraph", "1", "daily_telegraph");
          addOption("daily_telegraph", " -- select Edition -- ", "", "", 1); //Empty starter option
            
      addList("daily_telegraph", "State", "1", "state");  	
          
      addList("nationwide_news", "The Australian", "2", "the_australian");
          addOption("the_australian", " -- select Edition -- ", "", "", 1); //Empty starter option
            
      addList("the_australian", "All Country", "2", "all_country");  	
          addList("com_company", "Cumberland", "2", "cumberland");
	    addOption("cumberland", " -- select publication -- ", "", "", 1); //Empty starter option
          
      addList("cumberland", "Hillshire Times", "3", "hillshire_times");
          addOption("hillshire_times", " -- select Edition -- ", "", "", 1); //Empty starter option
            
      addList("hillshire_times", "Main Book", "3", "main_book");  	
          
      addList("cumberland", "North Shore Times", "4", "north_shore_times");
          addOption("north_shore_times", " -- select Edition -- ", "", "", 1); //Empty starter option
            
      addList("north_shore_times", "Main Book", "4", "main_book");  	
      	</script>
  			<link rel="stylesheet" href="http://chulriph/qcissues/assets/client/css/calendar.css" type="text/css" />
		<!-- main calendar program -->
		<script type="text/javascript" src="http://chulriph/qcissues/assets/client/scripts/calendar/calendar.js"></script>
	
		<!-- language for the calendar -->
		<script type="text/javascript" src="http://chulriph/qcissues/assets/client/scripts/calendar/calendar-en.js"></script>
	
		<!-- the following script defines the Calendar.setup helper function, which makes
				 adding a calendar a matter of 1 or 2 lines of code. -->
	
		<script type="text/javascript" src="http://chulriph/qcissues/assets/client/scripts/calendar/calendar-setup.js"></script>
		

<form name="qccform" method="post" action="save_issue.php">
	<input type="hidden" name="issue_id" value="0" />
  <input type="hidden" name="qcc_submitted" value="" />
  <div class="row">          
    <div class="textSpacing">Department *</div>          
    <div style="float:left">    <select name="qcc_department" style="width:160px"></select>
    </div>
  </div>
  <div class="row">          
    <div class="textSpacing">Error Type *</div>          
    <div style="float:left">    <select name="qcc_errortype" style="width:160px"></select>
    </div>
  </div>
  <div class="row">          
    <div class="textSpacing">Company *</div>          
    <div style="float:left">    <select name="qcc_company" style="width:160px"></select>
    </div>
  </div>
  <div class="row">          
    <div class="textSpacing">Publication *</div>          
    <div style="float:left">    <select name="qcc_publication" style="width:160px"></select>
    </div>
  </div>
  <div class="row">          
    <div class="textSpacing">Edition *</div>          
    <div style="float:left">    <select name="qcc_edition" style="width:160px"></select>
    </div>
  </div>
  <div class="row">          
    <div class="textSpacing">Publication Date *</div>          
    <div style="float:left">		<input type="text" name="qcc_pubdate" id="f_date_c" value="" />
		</div>
    <div style="float:left; padding-top:1px;">		<img src="http://chulriph/qcissues/assets/client/images/calendar/Calendar_scheduleHS.png" id="f_trigger_c" style="cursor: pointer;" title="Date selector" />
		</div>
  <div class="row">          
    <div class="textSpacing">Press</div>          
    <div style="float:left"><input type="text" name="qcc_press" value="" /></div>
  </div>  
  </div>
  <div class="row">          
    <div class="textSpacing">Error Type *</div>          
    <div style="float:left"></div>
  </div>
  <div class="row">
  	<div><input type="submit" value="Submit Form" class="button"></div>
  </div>
</form> 
		<script type="text/javascript">
        Calendar.setup({
            inputField     :    "f_date_c",     // id of the input field
            ifFormat       :    "%e %b %Y",      // format of the input field
            button         :    "f_trigger_c",  // trigger for the calendar (button ID)
            align          :    "Tl",           // alignment (defaults to "Bl")
            singleClick    :    true
        });
    </script>    
        <script language="javascript">
        window.onload = alert("test");
  	  //window.onload = initListGroup("publication_groups", document.forms[0]["qcc_company"], document.forms[0]["qcc_publication"], document.forms[0]["qcc_edition"], 'cs');
	</script>
        <script language="javascript">
  	  //window.onload = initListGroup("ert_groups", document.forms[0]["qcc_department"], document.forms[0]["qcc_errortype"],  'cs');
	</script>
        </div><!-- end mainPageWidthAndHeight -->
  </div><!-- end mainBodyContainer -->
</body>
</html> 