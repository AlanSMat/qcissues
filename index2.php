<?php
session_start();
require("globals.php");

ob_start();

$page_title = "QC Issues - Index";

include(CLASSES_PATH . "/class.Dropdowns2.php");
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
//$dd_ert->level_one_data(new DD_Data($_SESSION["qcissues"], "qcc_department", "dep_department", "dep_id", "dep_name"));
//$dd_ert->level_two_data(new DD_Data($_SESSION["qcissues"], "qcc_errortype", "ert_errortype", "ert_id", "ert_errortype", "ert_departmentid"));


$dd_ert->dd_data[1]                 = new DD_Data();
$dd_ert->dd_data[1]->select_row     = $_SESSION["qcissues"];
$dd_ert->dd_data[1]->select_column  = "qcc_department";
$dd_ert->dd_data[1]->db_table       = "dep_department";
$dd_ert->dd_data[1]->db_id          = "dep_id";
$dd_ert->dd_data[1]->db_list_column = "dep_name";

$dd_ert->dd_data[2]                 = new DD_Data();
$dd_ert->dd_data[2]->select_row     = $_SESSION["qcissues"];
$dd_ert->dd_data[2]->select_column  = "qcc_errortype";
$dd_ert->dd_data[2]->db_table       = "ert_errortype";
$dd_ert->dd_data[2]->db_id          = "ert_id";
$dd_ert->dd_data[2]->db_list_column = "ert_errortype";
$dd_ert->dd_data[2]->db_foreign_key = "ert_departmentid";

$dd_ert->js_output2();
//$dd_ert->dd_data["dd_lvl_2"] = new DD_Data($_SESSION["qcissues"], "qcc_errortype", "ert_errortype", "ert_id", "ert_errortype", "ert_departmentid");
//echo "a".$dd_ert->dd_data["dd_lvl_1"]->select_row;
//$dd_ert->js_output2();

$dd_test = new DD_Test();

//$dd_pub = new Dropdowns("publication_groups");
//$dd_pub->level_one_data(new DD_Data($_SESSION["qcissues"], "qcc_company", "com_company", "com_id", "com_name"));
//$dd_pub->level_two_data(new DD_Data($_SESSION["qcissues"], "qcc_publication", "pub_publication", "pub_id", "pub_name", "pub_companyid"));
//$dd_pub->level_three_data(new DD_Data($_SESSION["qcissues"], "qcc_edition", "edi_edition", "edi_id", "edi_name", "edi_publicationid"));
//$dd_pub->js_output();

ob_end_flush();

include(INCLUDES_PATH . "/site_header.php");
$calendar = new Calendar();
//$dd_ert->js_output();
?>
  <div class="pageTitleContainer">
    <div class="pageTitle">
      <div class="pageTitleSpacing">&nbsp;</div>	      
    </div>
  </div> 
<form name="qccform" method="post" action="save_issue.php?pageid=none">
  <input type="hidden" name="issue_id" value="<?php echo $issue_id ?>" />
  <input type="hidden" name="qcc_submitted" value="<?php $_SESSION["qcissues"]["qcc_submitted"] ? print 1 : print 0 ;?>" />
  <div class="mainFormContainer">
    <div class="row">
      <div class="textSpacing">Department *</div>
      <div style="float:left"><?php $dd_ert->select("qcc_department"); ?></div>
    </div>
    <div class="row">
      <div class="textSpacing">Error Type *</div>
      <div style="float:left"><?php $dd_ert->select("qcc_errortype"); ?></div>
    </div><br /><br />
    <div class="row">
      <div class="textSpacing">Publication Date *</div>
      <div style="float:left"><?php $calendar->input("qcc_pubdate", $pub_date); ?></div>
      <div style="float:left; padding:1px 0px 0px 3px;"><?php $calendar->image(); ?></div>
    </div>
    <div class="row">
      <div class="textSpacing">Company *</div>
      <div style="float:left"><?php $dd_pub->select("qcc_company"); ?></div>
    </div>
    <div class="row">
      <div class="textSpacing">Publication *</div>
      <div style="float:left"><?php $dd_pub->select("qcc_publication"); ?></div>
    </div>
    <div class="row">
      <div class="textSpacing">Edition *</div>
      <div style="float:left"><?php $dd_pub->select("qcc_edition"); ?></div>
    </div>
    <div class="row">
      <div class="textSpacing">Press</div>
      <div style="float:left"><input type="text" name="qcc_press" class="textBox" size="10" value="<?php echo $_SESSION["qcissues"]["qcc_press"] ?>" /></div>
    </div>
    <div class="row">
      <div class="textSpacing">Press Crew</div>
      <div style="float:left">
        <div class="checkBoxText">Day</div>
        <div class="checkBoxContainer"><input type="checkbox" name="qcc_dayshift" value="1" <?php echo $_SESSION["qcissues"]["qcc_dayshift"] ? print "checked=\"checked\"" : print ""; ?> /></div>
        <div class="checkBoxText">Afternoon</div>
        <div class="checkBoxContainer"><input type="checkbox" name="qcc_afternoonshift" value="1" <?php echo $_SESSION["qcissues"]["qcc_afternoonshift"] ? print "checked=\"checked\"" : print ""; ?> /></div>
        <div class="checkBoxText">Night</div>
        <div class="checkBoxContainer"><input type="checkbox" name="qcc_nightshift" value="1" <?php echo $_SESSION["qcissues"]["qcc_nightshift"] ? print "checked=\"checked\"" : print ""; ?> /></div>
      </div>
    </div>
    <div class="row">
      <div class="textSpacing">Copies Affected</div>
      <div style="float:left"><input type="text" name="qcc_copiesaffected" class="textBox" value="<?php echo $_SESSION["qcissues"]["qcc_copiesaffected"] ?>" /></div>
    </div>
    <div class="row">
      <div class="textSpacing">Page No</div>
      <div style="float:left"><input type="text" name="qcc_pageno" class="textBox" value="<?php echo $_SESSION["qcissues"]["qcc_pageno"] ?>" /></div>
    </div>
    <div class="row">
      <div class="textSpacing">Agent Name</div>
      <div style="float:left"><input type="text" name="qcc_agent" size="40" class="textBox" value="<?php echo $_SESSION["qcissues"]["qcc_agent"] ?>" /></div>
      <div class="textSpacing" style="width:40px">Phone</div>
      <div style="float:left"><input name="qcc_agentphone" type="text" class="textBox" style="width:140px;" value="<?php echo $_SESSION["qcissues"]["qcc_agentphone"] ?>" /></div>
    </div>
    <div class="row">
      <div class="textSpacing">Client</div>
      <div style="float:left"><input type="text" name="qcc_client" size="40" class="textBox" value="<?php echo $_SESSION["qcissues"]["qcc_client"] ?>" /></div>
      <div class="textSpacing" style="width:40px">Phone</div>
      <div style="float:left"><input name="qcc_clientphone" type="text" class="textBox" style="width:140px;" value="<?php echo $_SESSION["qcissues"]["qcc_clientphone"] ?>" /></div>
    </div>
    <div class="row">
      <div class="textSpacing">Operator *</div>
      <div style="float:left">
  	    <select name="qcc_operator">
  	      <option value=""> -- select operator -- </option>
  	      <?php
  	      $query = new Query("SELECT * FROM opr_operator");
  	      while($row = $query->next())
  	      {
  	      ?>
  	      <option value="<?php echo $row->opr_id ?>"><?php echo $row->opr_name ?></option>
  	      <?php
  	      }
  	      ?>
  	    </select>
      </div>
      <div class="row">
        <div class="textSpacing">Issue reported by</div>
        <div style="float:left;padding:2px 3px 0px 0px;"">Internal</div>
        <div style="float:left;padding:0px 10px 0px 0px;"><input type="radio" name="qcc_reporttype" onclick="this.value=0" value="<?php $_SESSION["qcissues"]["qcc_reporttype"] == 0 ? print '0' : print "" ; ?>" <?php $_SESSION["qcissues"]["qcc_reporttype"] == 0 ? print "checked='checked'" : print "" ; ?> /></div>
        <div style="float:left;padding:2px 3px 0px 0px;">Client</div>
        <div style="float:left;padding:0px 5px 0px 0px;"><input type="radio" name="qcc_reporttype" onclick="this.value=1" value="<?php $_SESSION["qcissues"]["qcc_reporttype"] == 1 ? print '1' : print "" ; ?>" <?php $_SESSION["qcissues"]["qcc_reporttype"] == 1 ? print "checked='checked'" : print "" ; ?> /></div>
      </div>  
      <div style="padding:10px 0px 0px 46px">
        <div class="row" style="padding:10px 0px 0px 0px">
          <div style="clear:both; text-align:left;">Error Details *</div>
          <div style="float:left"><textarea name= "qcc_errordetails" rows="2" cols="20" class="textArea" style="height:100px;width:500px;"><?php echo stripslashes($_SESSION["qcissues"]["qcc_errordetails"]) ?></textarea></div>
        </div>
      </div>      
      <?php 
      if($_SESSION["qcissues"]["qcc_submitted"]) 
      {
      ?>    
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
        <div class="row" style="padding:20px 0px 0px 0px">
    	  <div class="textSpacing">Error Response</div>
          <div style="float:left">
      	    <select name="qcc_errorresponse">
      	      <option value="0"> -- select error response -- </option>
      	      <?php
      	      $query = new Query("SELECT * FROM err_errorresponse");
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
        <div style="padding:10px 0px 0px 46px">
          <div class="row">
            <div style="clear:both; text-align:left;">Error Response Details *</div>
            <div style="float:left"><textarea name= "qcc_responsedetails" rows="2" cols="20" class="textArea" style="height:100px;width:500px;"><?php echo stripslashes($_SESSION["qcissues"]["qcc_responsedetails"]) ?></textarea></div>
          </div>
        </div>
        <script type="text/javascript">
          select_option ("qccform", "qcc_errorresponse", "<?php echo $_SESSION["qcissues"]["qcc_errorresponse"] ?>")
        </script>
      <?php 
      }
      ?>
      <div style="padding:10px 0px 0px 46px">
        <div class="row">
    	    <div style="clear:all;text-align:left;"><input type="button" value="Submit Form" class="button" onclick="isReady(this.form)"></div>
        </div>
      </div>
    </div>
  </div>
</form>
<script type="text/javascript">
	select_option ("qccform", "qcc_operator", "<?php echo $_SESSION["qcissues"]["qcc_operator"] ?>");
</script>

<?php
$calendar->init();

$dd_ert->init();
$dd_pub->init();

session_unset($_SESSION["qcissues"]);
session_destroy();

include(INCLUDES_PATH . "/site_footer.php");
?>