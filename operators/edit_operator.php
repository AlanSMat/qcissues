<?php
require("../globals.php");

$page_title = "Edit Operators";

isset($_REQUEST["operator_id"]) ? $id = $_REQUEST["operator_id"] : $id = 0 ;

$q = new Query("SELECT * FROM opr_operator WHERE opr_id='" . $id . "'");
$a = $q->fetch_row_assoc();

include(INCLUDES_PATH . "/site_header.php");
?>
    <div class="pageTitleContainer">
      <div class="pageTitle">
        <div class="pageTitleSpacing">&nbsp;</div>        
      </div>
    </div>
    <div style="width:500px">
      <form name="opr" method="post" action="save_operator.php">
        <input type="hidden" name="operator_id" value="<?php echo $id ?>">
        <table cellpadding="2" cellspacing="1" border="0" style="width:500px">
          <tr>
            <td colspan="2" class="header">Add/Edit Operator</td>
          </tr>
          <tr>
            <td class="altBgRowColor">Operator Name</td>
            <td class="altBgRowColor"><input name="opr_name" type="text" class="textBox" value="<?php echo $a["opr_name"] ?>" style="width:350px;" /></td>
          </tr>
          <tr>
            <td class="bgRowColor">Operator Email</td>
            <td class="bgRowColor"><input name="opr_email" type="text" class="textBox" value="<?php echo $a["opr_email"] ?>" style="width:350px;" /></td>
          </tr>          
          <!-- <tr>
            <td class="altBgRowColor">Receive All Notifications</td>
            <td class="altBgRowColor">
            	<table cellpadding="0" cellspacing="0" border="0" align="left">
                  <tr>                    
                    <td><div style="padding:0px 0px 3px 0px;">Yes</div></td>
                    <td><div style="padding:0px 8px 0px 0px;"><input type="radio" name="opr_receivenotifications" value="1" <?php $a["opr_receivenotifications"] == 1 ? print "checked=\"checked\"": print "";?> /></div></td>
                    <td><div style="padding:0px 0px 3px 0px;">No</div></td>
                    <td><div style="padding:0px 0px 0px 0px;"><input type="radio" name="opr_receivenotifications" value="0" <?php $a["opr_receivenotifications"] == 0 ? print "checked=\"checked\"": print "";?> /></div></td>
                  </tr>
                </table>
            </td>
          </tr> -->
        </table>
        <div class="buttonSpacing" style="text-align:left;">
          <span><input type="button" value="Back" class="button" onclick="javascript:history.back()" /></span>
          <span><input type="submit" value="Save" class="button" /></span>
        </div>
      </form>
    </div>
<?php
include(INCLUDES_PATH . "/site_footer.php");
?>