<?php
session_start();
require("globals.php");

//if(!isset($_REQUEST["qcoperator"])) 
header("LOCATION: browse.php?pageid=browse&qcoperator=1");

ob_start();

$page_title = "QC Issues - Index";

include(CLASSES_PATH . "/class.Dropdowns.php");
include(CLASSES_PATH . "/class.Calendar.php");

isset($_REQUEST["issue_id"]) ? $issue_id = $_REQUEST["issue_id"] : $issue_id = 0;

if(!isset($_SESSION["qcissues"]))
{
  $q = new Query("SELECT * FROM qcc_qcissues WHERE qcc_id='" . $issue_id . "'");
  $a = $q->fetch_row_assoc();
  $_SESSION["qcissues"] = $a;
}
$_SESSION["qcissues"]["qcc_pubdate"] == 0 ? $pub_date = "" : $pub_date = rt_date($_SESSION["qcissues"]["qcc_pubdate"]) ;

$dd_ert = new Dropdowns("ert_groups");
$dd_ert->inc_chained_select_script();
$dd_ert->level_one_data(new DD_Data($_SESSION["qcissues"], "qcc_department", "dep_department", " -- select department -- ", "dep_id", "dep_name"));
$dd_ert->level_two_data(new DD_Data($_SESSION["qcissues"], "qcc_errortype", "ert_errortype", " -- select error type -- ", "ert_id", "ert_errortype", "ert_departmentid"));
$dd_ert->main_js_functions();

$dd_pub = new Dropdowns("publication_groups");
$dd_pub->level_one_data(new DD_Data($_SESSION["qcissues"], "qcc_company", "com_company", " -- select company -- ", "com_id", "com_name"));
$dd_pub->level_two_data(new DD_Data($_SESSION["qcissues"], "qcc_publication", "pub_publication", " -- select publication -- ", "pub_id", "pub_name", "pub_companyid"));
$dd_pub->level_three_data(new DD_Data($_SESSION["qcissues"], "qcc_edition", "edi_edition", " -- select edition -- ", "edi_id", "edi_name", "edi_publicationid"));
$dd_pub->main_js_functions();

ob_end_flush();

include(INCLUDES_PATH . "/site_header.php");
$calendar = new Calendar();
?>
  <div class="pageTitleContainer">
    <div class="pageTitle">
      <div class="pageTitleSpacing">&nbsp;</div>	      
    </div>
  </div> 
<form name="qccform" method="post" action="save_issue.php?pageid=none&qcoperator=1">
  <input type="hidden" name="issue_id" value="<?php echo $issue_id ?>" />
  <input type="hidden" name="qcc_submitted" value="<?php $_SESSION["qcissues"]["qcc_submitted"] ? print 1 : print 0 ;?>" />
  <div class="mainFormContainer">
    <div class="row">
      <div class="formLeftColumn">Department (Logged By) *</div>
      <div class="formRightColumn"><?php $dd_ert->select("qcc_department"); ?></div>
    </div>
    <div class="row">
      <div class="formLeftColumn">Error Type *</div>
      <div class="formRightColumn"><?php $dd_ert->select("qcc_errortype"); ?></div>
    </div>
    <div class="row">
      <div class="formLeftColumn">Publication Date *</div>
      <div style="float:left"><?php $calendar->input("qcc_pubdate", $pub_date); ?></div>
      <div style="float:left;padding:1px 0px 0px 5px;"><?php $calendar->image(); ?></div>
    </div>
    <div class="row">
      <div class="formLeftColumn">Company *</div>
      <div class="formRightColumn"><?php $dd_pub->select("qcc_company"); ?></div>
    </div>
    <div class="row">
      <div class="formLeftColumn">Publication *</div>
      <div class="formRightColumn"><?php $dd_pub->select("qcc_publication"); ?></div>
    </div>
    <div class="row">
      <div class="formLeftColumn">Edition *</div>
      <div class="formRightColumn"><?php $dd_pub->select("qcc_edition"); ?></div>
    </div>
    <div class="row">
      <div class="formLeftColumn">Press</div>
      <div class="formRightColumn">
      	<select name="qcc_press">
      		<option value=""> -- select press -- </option>
      		<option value="C">C</option>
      		<option value="D">D</option>
      		<option value="E">E</option>
      		<option value="F1">F1</option>
      		<option value="F2">F2</option>
      	</select>
      </div>
    </div>
      	<div class="row" style="padding:10px 0px 0px 65px;">        	
    		<table cellpadding="2" cellspacing="1" border="0">
    	      <tr>
    	        <td width="89px" align="right">Press Crew</td>    	           	        
    	      	<td>Day</td>
    	      	<td><input type="checkbox" name="qcc_dayshift" value="1" <?php echo $_SESSION["qcissues"]["qcc_dayshift"] ? print "checked=\"checked\"" : print ""; ?> /></td>
    	      	<td>&nbsp;Afternoon</td>
    	      	<td><input type="checkbox" name="qcc_afternoonshift" value="1" <?php echo $_SESSION["qcissues"]["qcc_afternoonshift"] ? print "checked=\"checked\"" : print ""; ?> /></td>
    	      	<td>&nbsp;Night</td>
    	      	<td><input type="checkbox" name="qcc_nightshift" value="1" <?php echo $_SESSION["qcissues"]["qcc_nightshift"] ? print "checked=\"checked\"" : print ""; ?> /></td>
    	      </tr>        		
    		</table>
      	</div>
    <div class="row">
      <div class="formLeftColumn">Page No(s)</div>
      <div class="formRightColumn"><input type="text" name="qcc_pageno" class="textBox" value="<?php echo $_SESSION["qcissues"]["qcc_pageno"] ?>" /></div>
    </div>
    <div class="row">
      <div class="formLeftColumn">Agent Name</div>
      <div class="formRightColumn"><input type="text" name="qcc_agent" size="40" class="textBox" value="<?php echo $_SESSION["qcissues"]["qcc_agent"] ?>" /></div>
      <div class="formLeftColumn" style="width:40px">Phone</div>
      <div style="float:left;width:150px;"><input name="qcc_agentphone" type="text" class="textBox" style="width:140px;" value="<?php echo $_SESSION["qcissues"]["qcc_agentphone"] ?>" /></div>
    </div>
    <div class="row">
      <div class="formLeftColumn">Client</div>
      <div class="formRightColumn"><input type="text" name="qcc_client" size="40" class="textBox" value="<?php echo $_SESSION["qcissues"]["qcc_client"] ?>" /></div>
      <div class="formLeftColumn" style="width:40px;">Phone</div>
      <div style="float:left;width:150px;border:0px solid #000;"><input name="qcc_clientphone" type="text" class="textBox" style="width:140px;" value="<?php echo $_SESSION["qcissues"]["qcc_clientphone"] ?>" /></div>
    </div>
    <div class="row">
      <div class="formLeftColumn">Logged By *</div>
      <div class="formRightColumn">
  	    <select name="qcc_operator">
  	      <option value=""> -- select logged by -- </option>
  	      <?php
  	      $query = new Query("SELECT * FROM opr_operator WHERE opr_active='1'");
  	      while($row = $query->next())
  	      {
  	      ?>
  	      <option value="<?php echo $row->opr_id ?>"><?php echo $row->opr_name ?></option>
  	      <?php
  	      }
  	      ?>
  	    </select>
      </div>
      <div class="row" style="padding-top:6px;">
        <div class="formLeftColumn">Issue reported by</div>
        <div style="float:left;padding:0px 3px 0px 0px;"">Internal</div>
        <div style="float:left;padding:0px 10px 0px 0px;"><input type="radio" name="qcc_reporttype" onclick="this.value=0" value="<?php $_SESSION["qcissues"]["qcc_reporttype"] == 0 ? print '0' : print "" ; ?>" <?php $_SESSION["qcissues"]["qcc_reporttype"] == 0 ? print "checked='checked'" : print "" ; ?> /></div>
        <div style="float:left;padding:0px 3px 0px 0px;">Client</div>
        <div style="float:left;padding:0px 5px 0px 0px;"><input type="radio" name="qcc_reporttype" onclick="this.value=1" value="<?php $_SESSION["qcissues"]["qcc_reporttype"] == 1 ? print '1' : print "" ; ?>" <?php $_SESSION["qcissues"]["qcc_reporttype"] == 1 ? print "checked='checked'" : print "" ; ?> /></div>
      </div>
      <div class="row" style="padding:10px 0px 0px 0px">
        <div class="formLeftColumn">Error Details *<br>(Max 1255 chars)</div>          
        <div class="formRightColumn"><textarea name="qcc_errordetails" style="height:100px;width:400px;" class="textBox" onkeydown="text_counter(this, this.form.count_error_details, 1285)" onkeyup="text_counter(this, this.form.count_error_details, 1255)"><?php echo stripslashes($_SESSION["qcissues"]["qcc_errordetails"]) ?></textarea></div>
      </div>
      <div class="row">
        <div class="formLeftColumn">&nbsp</div>
        <div class="formRightColumn"><input readonly type="text" name="count_error_details" value="" class="textBox" size="4" /> Characters remaining</div>
      </div>
      <?php 
      if($_SESSION["qcissues"]["qcc_submitted"]) 
      {
      ?>
      	<div class="row" style="padding:10px 0px 0px 0px;">
        	<div class="formLeftColumn">Copies Affected</div>
        	<div style="float:left"><input type="text" name="qcc_copiesaffected" class="textBox" value="<?php echo $_SESSION["qcissues"]["qcc_copiesaffected"] ?>" /></div>
      	</div>    
  	    <div class="row" style="padding:10px 0px 0px 45px">              
          <div class="row">
            <table cellpadding="0" cellspacing="0" border="0" align="left">
              <tr>
                <td><div style="padding:0px 10px 3px 0px;">Issue Status:</div></td>
                <td><div style="padding:0px 2px 3px 0px;">In Progress</div></td>
                <td><div style="padding:0px 5px 0px 0px;"><input type="radio" name="qcc_status" value="InProgress" <?php $_SESSION["qcissues"]["qcc_status"] != "Closed" ? print "checked=\"checked\"": print "";?> /></div></td>
                <td><div style="padding:0px 2px 3px 0px;">Closed</div></td>
                <td><div style="padding:0px 0px 0px 0px;"><input type="radio" name="qcc_status" value="Closed" <?php $_SESSION["qcissues"]["qcc_status"] == "Closed" ? print "checked=\"checked\"": print "";?> /></div></td>
              </tr>
            </table>
          </div> 
        </div>      
        <div class="row" style="padding:10px 0px 0px 0px;">
    	  	<div class="formLeftColumn">Responding Operator * </div>
          <div style="float:left;">
      	    <select name="qcc_respondingmanager">
      	      <option value=""> -- select operator -- </option>
      	      <?php
      	      $query = new Query("SELECT * FROM opr_operator 
      	      					  WHERE opr_active='1' 
      	      					  ORDER BY opr_name");
      	      while($row = $query->next())
      	      {
      	      ?>
      	      	<option value="<?php echo $row->opr_id ?>"><?php echo $row->opr_name ?></option>
      	      <?php
      	      }
      	      ?>
      	    </select>
          </div>
        </div>
        <div class="row" style="padding:10px 0px 10px 0px">
    	  	<div class="formLeftColumn">Error Response * </div>
          <div style="float:left">
      	    <select name="qcc_errorresponse">
      	      <option value=""> -- select error response -- </option>
      	      <?php
      	      $query = new Query("SELECT * FROM err_errorresponse ORDER BY err_errorresponse");
      	      while($row = $query->next())
      	      {
      	      ?>
      	      	<option value="<?php echo $row->err_id ?>"><?php echo $row->err_errorresponse ?></option>
      	      <?php
      	      }
      	      ?>
      	    </select>
          </div>
        </div>
        <div style="padding:10px 0px 0px 0px;">
          <div class="row">
            <div class="formLeftColumn">Response Details *<br>(Max 1255 chars)</div>
            <div class="formRightColumn"><textarea name= "qcc_responsedetails" rows="2" cols="20" class="textBox" style="height:100px;width:400px;" onkeydown="text_counter(this, this.form.count_response_details, 1255)" onkeyup="text_counter(this, this.form.count_response_details, 1285)"><?php echo stripslashes($_SESSION["qcissues"]["qcc_responsedetails"]) ?></textarea></div>
          </div>
          <div class="row">
            <div class="formLeftColumn">&nbsp</div>
            <div class="formRightColumn"><input readonly type="text" name="count_response_details" value="" class="textBox" size="4" /> Characters remaining</div>
          </div>
        </div>        
        <script type="text/javascript">        
        	select_option ("qccform", "qcc_press", "<?php echo $_SESSION["qcissues"]["qcc_press"] ?>");
        	select_option ("qccform", "qcc_respondingmanager", "<?php echo $_SESSION["qcissues"]["qcc_respondingmanager"] ?>");
            select_option ("qccform", "qcc_errorresponse", "<?php echo $_SESSION["qcissues"]["qcc_errorresponse"] ?>");
            var elms = document.forms[0].elements;
            var max_chars = 1255;
			elms.count_response_details.value = (max_chars - elms.qcc_responsedetails.value.length);    
        </script>
      <?php 
      }
      ?>
      <div class="row" style="padding-top:10px;">
          <div class="formLeftColumn">&nbsp;</div>
    	  <div class="formRightColumn"><input type="button" value="Submit Form" class="button" onclick="isReady(this.form)"></div>
        </div>
    </div>
  </div>
</form>
<script type="text/javascript">
	select_option ("qccform", "qcc_operator", "<?php echo $_SESSION["qcissues"]["qcc_operator"] ?>");
	 var elms = document.forms[0].elements;
	 var max_chars = 1255;	
     elms.count_error_details.value = (max_chars - elms.qcc_errordetails.value.length);
</script>

<?php
$calendar->init();

$dd_ert->init();
$dd_pub->init();

if($_REQUEST["qcoperator"]) 
{
    session_unset($_SESSION["qcissues"]);
    session_destroy();
}

include(INCLUDES_PATH . "/site_footer.php");
?>