<?php
session_start();
require("../globals.php");

$page_title = "List Error Responses";

include(INCLUDES_PATH . "/site_header.php");
?>
<div class="pageTitleContainer">  
  <div class="pageTitle">
    <div class="pageTitleSpacing">&nbsp;</div>	      
  </div>
</div>
<div style="width:470px">
  <table cellspacing="1" cellpadding="3" border="0"> 
    <tr>
      <td class="header">Error Response</td>      
      <td class="header">&nbsp;</td>
    </tr>
    <?php 
    $q = new Query("SELECT * FROM err_errorresponse ORDER BY err_errorresponse");
    
    $i = 0;
    while($row = $q->next()) 
    {
      $i++;
      ?>	
      <tr class="<?php ($i % 2) ? print "bgRowColor" : print "altBgRowColor" ; ?>">
        <td style="width:400px"><?php echo $row->err_errorresponse ?></td>        
        <td style="width:70px;" align="center">
          <p class="editLink"><a href="edit_error_response.php?pageid=errorResponses&error_response_id=<?php echo $row->err_id ?>&qcoperator=1">Edit</a></p>
          <p class="separator">|</p>
          <p class="editLink"><a href="delete_error_response.php?error_response_id=<?php echo $row->err_id ?>">Delete</a></p>              
        </td>
      </tr>
      <?php
    }
    ?>
  </table>
	<div class="buttonSpacing"> 
	  <form name="err_form" method="post" action="edit_error_response.php">
	    <input type="Submit" value="Add New" class="button" />
	  </form>
	</div>
</div>
<?php
include(INCLUDES_PATH . "/site_footer.php");
?>