<?php
require("../globals.php");

$page_title = "List Operators";

include(INCLUDES_PATH . "/site_header.php");
?>
<div class="pageTitleContainer">  
  <div class="pageTitle">
    <div class="pageTitleSpacing">&nbsp;</div>	      
  </div>
</div>
<div style="width:625px">
  <table cellspacing="1" cellpadding="3" border="0"> 
    <tr>
      <td class="header">Operator</td>
      <td class="header">Email Address</td>
      <!-- <td class="header">Recieve All Notifications</td> -->
      <td class="header">&nbsp;</td>
    </tr>
    <?php 
    $q = new Query("SELECT * FROM opr_operator WHERE opr_active='1'");
    
    $i = 0;
    while($row = $q->next()) 
    {
      $i++;
      ?>	
      <tr class="<?php ($i % 2) ? print "bgRowColor" : print "altBgRowColor" ; ?>">
        <td style="width:200px"><?php echo $row->opr_name ?></td>
        <td style="width:350px"><?php echo $row->opr_email ?></td>
        <!-- <td style="width:350px;text-align:center;"><?php ($row->opr_receivenotifications == 1) ? print "Yes" : print "No" ; ?></td> -->
        <td style="width:75px; text-align:center;" align="center">
          <div class="editLink"><a href="edit_operator.php?operator_id=<?php echo $row->opr_id ?>&pageid=operators&qcoperator=1">Edit</a></div>
          <!-- <div class="separator">|</div>
          <div class="editLink"><a href="delete_operator.php?operator_id=<?php echo $row->opr_id ?>">Delete</a></div> -->              
        </td>
      </tr>
      <?php
    }
    ?>
  </table>
	<div class="buttonSpacing"> 
	  <form name="opr_form" method="post" action="edit_operator.php?pageid=operators" id="aspnetForm">
	    <input type="Submit" value="Add New" class="button" />
	  </form>
	</div>
</div>
<?php
include(INCLUDES_PATH . "/site_footer.php");
?>
