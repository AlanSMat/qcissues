<?php
session_start();
require("globals.php");

$page_title = "View Issue";

$query = new Query("SELECT * FROM qcc_qcissues WHERE qcc_id='" . $_REQUEST['issue_id'] . "'");
$row = $query->next();

include(INCLUDES_PATH . "/site_header.php");
include(CLASSES_PATH . "/class.DD_Text.php");

$dd_text = new DD_Text($row);
?>
<div class="pageTitleContainer">
    <div class="pageTitle">

      <div class="pageTitleSpacing">&nbsp;</div>	      
    </div>
</div>
<div>
  <table cellpadding="2" cellspacing="1" border="0" width="1000">
    <tr>
      <td class="viewCell1">Issue Id</td>
      <td class="viewCell2"><?php echo $row->qcc_id ?></td>
    </tr>
    <tr>
      <td class="viewCell1">Publication Date</td>
      <td class="viewCell2"><?php echo rt_date($row->qcc_pubdate) ?></td>
    </tr>
    <tr>
      <td class="viewCell1">Company Name</td>
      <td class="viewCell2"><?php echo $dd_text->dd_list("com_company", "com_id", $row->qcc_company)->com_name; ?></td>
    </tr>
    <tr>
      <td class="viewCell1">Publication</td>
      <td class="viewCell2"><?php echo $dd_text->publication; ?></td>
    </tr>
    <tr>
      <td class="viewCell1">Edition</td>
      <td class="viewCell2"><?php echo $dd_text->edition; ?></td>
    </tr>   
    <tr>
      <td class="viewCell1">Press</td>
      <td class="viewCell2"><?php echo $row->qcc_press ?></td>
    </tr>  
    <tr>
      <td class="viewCell1">Press Crew</td>
      <td class="viewCell2"><?php echo $row->qcc_presscrew ?></td>
    </tr>
    <tr>
      <td class="viewCell1">Copies Affected</td>
      <td class="viewCell2"><?php echo $row->qcc_copiesaffected ?></td>
    </tr> 
    <tr>
      <td class="viewCell1">Page No</td>
      <td class="viewCell2"><?php echo $row->qcc_pageno ?></td>
    </tr>
    <tr>
      <td class="viewCell1">Agent Name</td>
      <td class="viewCell2"><?php echo $row->qcc_agent ?></td>
    </tr>
    <tr>
      <td class="viewCell1">Agent Phone</td>
      <td class="viewCell2"><?php echo $row->qcc_agentphone ?></td>
    </tr> 
    <tr>
      <td class="viewCell1">Client</td>
      <td class="viewCell2"><?php echo $row->qcc_client ?></td>
    </tr>
    <tr>
      <td class="viewCell1">Client Phone</td>
      <td class="viewCell2"><?php echo $row->qcc_clientphone ?></td>
    </tr>
    <tr>
      <td class="viewCell1">Issue Reported By</td>
      <td class="viewCell2"><?php $row->qcc_reporttype == 0 ? print "Internal" : print "Client" ; ?></td>
    </tr>    
    <tr>
      <td class="viewCell1">Logged By</td>
      <td class="viewCell2"><?php echo $dd_text->dd_list("opr_operator", "opr_id", $row->qcc_operator)->opr_name; ?></td>
    </tr>
    <tr>
      <td class="viewCell1">Department</td>
      <td class="viewCell2"><?php echo $dd_text->dd_list("dep_department", "dep_id", $row->qcc_department)->dep_name; ?></td>
    </tr> 
    <tr>
      <td class="viewCell1">Error Type</td>
      <td class="viewCell2"><?php echo $dd_text->error_type ?></td>
    </tr>                                           
    <tr>
      <td class="viewCell1" valign="top">Error Details</td>
      <td class="viewCell2"><?php echo nl2br(stripslashes($row->qcc_errordetails)) ?></td>
    </tr>
    <?php
    if($row->qcc_responsedetails != "") 
    {
    ?>     
    <tr>
      <td class="viewCell1">Error Response</td>
      <td class="viewCell2"><?php echo $dd_text->dd_list("err_errorresponse", "err_id", $row->qcc_errorresponse)->err_errorresponse; ?></td>
    </tr> 
    <!-- <tr>
      <td class="viewCell1">Responding Manager</td>
      <td class="viewCell2"><?php echo $dd_text->dd_list("man_manager", "man_id", $row->qcc_respondingmanager)->man_name; ?></td>
    </tr> -->        
    <tr>
      <td class="viewCell1" valign="top">Response Details</td>
      <td class="viewCell2"><?php echo nl2br(stripslashes($row->qcc_responsedetails)) ?></td>
    </tr>
    <?php 
    }
    ?>  
    <tr>
      <td colspan="2" align="center">
        <form name="qc" method="post">
          <div style="text-align:center;padding:10px 55px 0px 0px" class="noprint">
            <input type="button" class="button" value="Print Page" onclick="javascript:window.print();" />
          </div>
        </form>
      </td>
    </tr>      
  </table>
</div>   
<?php
include(INCLUDES_PATH . "/site_footer.php");
?>