<?php
session_start();
require("../globals.php");

$page_title = "Edit error types";

isset($_REQUEST["error_type_id"]) ? $id = $_REQUEST["error_type_id"] : $id = 0 ;

$q = new Query("SELECT * FROM ert_errortype WHERE ert_id='" . $id . "'");
$a = $q->fetch_row_assoc();

include(INCLUDES_PATH . "/site_header.php");
?>
    <div class="pageTitleContainer">
      <div class="pageTitle">
        <div class="pageTitleSpacing">&nbsp;</div>        
      </div>
    </div>
    <div style="width:500px">
      <form name="ert" method="post" action="save_error_type.php">
        <input type="hidden" name="error_type_id" value="<?php echo $id ?>">
        <input type="hidden" name="ert_departmentid" value="<?php $id == 0 ? print $_POST["ert_departmentid"] : print $a["ert_departmentid"]; ?>"  />
        <table cellpadding="2" cellspacing="1" border="0" style="width:500px">
          <tr>
            <td colspan="2" class="header">Add/Edit Error Type</td>
          </tr>
          <tr>
            <td class="altBgRowColor">Error Type</td>
            <td class="altBgRowColor"><input name="ert_errortype" type="text" class="textBox" value="<?php echo $a["ert_errortype"] ?>" style="width:350px;" /></td>
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