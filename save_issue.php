<?php
session_start();
require("globals.php");

$page_title = "QC Issues - Save Issue";

include(CLASSES_PATH . "/class.DDText.php");
include(INCLUDES_PATH . "/site_header.php");
include(CLASSES_PATH . "/class.QCIssue.php");
include(CLASSES_PATH . "/class.Email.php");

?>
  <div class="pageTitleContainer">
    <div class="pageTitle">
      <div class="pageTitleSpacing">&nbsp;</div>	      
    </div>
  </div>
<?php
//dump($_POST);

if($_POST["qcc_submitted"] == 0) 
{
  $qc_issue = new InsertQCIssue($_POST, new Query());
  
  $mail = new Email($_POST["qcc_department"]);  
  
  $mail->to       = $mail->get_to_email_string();  
  $mail->from     = $qc_issue->operator_email;
  $mail->subject  = "QC Issue " . $qc_issue->issue_id . " - " . $qc_issue->error_type . " - " . $qc_issue->publication;
  $mail->cc       = $mail->get_cc_email_string($mail->to, $mail->from);  
  $mail->body     = $_POST["qcc_errordetails"];
  $href_link_text = "To send an email regarding this issue ";   
}
else 
{	
  $qc_issue = new UpdateQCIssue($_POST, new Query());

  $mail = new Email($_POST["qcc_department"]); 
  
  $mail->to       = $qc_issue->operator_email;
  $mail->from     = $qc_issue->manager_email;
  $mail->subject  = "RE: QC Issue " . $qc_issue->issue_id . " - " . $qc_issue->error_type . " - " . $qc_issue->publication;
  $mail->cc       = $mail->get_cc_email_string($mail->to, $mail->from);  
  $mail->body     = $_POST["qcc_responsedetails"];
  $href_link_text = "To send an email update regarding this issue ";
}
?>
<div style="text-align:center; padding-top:200px;line-height:14px;">
<?php echo $mail->get_email_link($href_link_text); ?>
</div>
<?php

include(INCLUDES_PATH . "/site_footer.php");
?>