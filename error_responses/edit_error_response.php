<?php
session_start();
require("../globals.php");

$page_title = "Edit Error Response";

isset($_REQUEST["error_response_id"]) ? $id = $_REQUEST["error_response_id"] : $id = 0 ;

$q = new Query("SELECT * FROM err_errorresponse WHERE err_id='" . $id . "'");
$a = $q->fetch_row_assoc();

include(INCLUDES_PATH . "/site_header.php");
?>
<div class="pageTitleContainer">  
  <div class="pageTitle">
    <div class="pageTitleSpacing">&nbsp;</div>	      
  </div>
</div>
<div style="width:500px">
  <form name="ert" method="post" action="save_error_response.php">
    <input type="hidden" name="error_response_id" value="<?php echo $id ?>">  
    <table cellpadding="2" cellspacing="1" border="0" style="width:500px">
      <tr>
        <td colspan="2" class="header">Add/Edit Error Response</td>
      </tr>
      <tr>
        <td class="altBgRowColor">Error Response</td>
        <td class="altBgRowColor"><input name="err_errorresponse" type="text" class="textBox" value="<?php echo $a["err_errorresponse"] ?>" style="width:350px;" /></td>
      </tr>          
    </table>
    <div class="buttonSpacing">
      <input type="button" value="Back" class="button" onclick="javascript:history.back();" />
      <input type="submit" value="Submit" class="button" />
    </div>
  </form>
</div>
<?php
include(INCLUDES_PATH . "/site_footer.php");
?>