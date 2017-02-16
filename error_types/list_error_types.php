<?php
session_start();
require("../globals.php");

$page_title = "List Error Types";

include(INCLUDES_PATH . "/site_header.php");
?>
<script language="javascript">

function submit_form(form, opt)
{
	var dep_id = opt.options[opt.options.selectedIndex].value;

	form.action = "list_error_types.php?dep_id=" + dep_id + "&pageid=errorTypes&qcoperator=1";
	form.submit();
}

</script>
<div class="pageTitleContainer">
  <div class="pageTitle">
    <div class="pageTitleSpacing">&nbsp;</div>
  </div>
</div>
<div style="width:725px">
	<form action="edit_error_type.php?pageid=errorTypes" method="post" name="ert_form">
  	<table cellspacing="1" cellpadding="3" border="0" style="width:500px">
    	<tr>
      	<td class="header">Error Type</td>
      	<td class="header">&nbsp;</td>
    	</tr>
    	<tr>
    		<td colspan="2" style="background-color:#ccc; padding-left:3px; border:outset 1px #666;">
    	  		<select name="ert_departmentid" onchange="submit_form(this.form, this)">
    	  		  <option value="0"> -- select department -- </option>
    			  <?php
    			  $q_dep = new Query("SELECT * FROM dep_department");

    			  while($row = $q_dep->next())
    			  {
    			  ?>
    				<option value="<?php echo $row->dep_id ?>"><?php echo $row->dep_name ?></option>
    			  <?php
    			  }
    			  ?>
    			</select>
    		</td>
    	</tr>
    	<?php
    	if(isset($_REQUEST["dep_id"]) && $_REQUEST["dep_id"] != 0)
    	{
    		$q_ert = new Query("SELECT * FROM ert_errortype WHERE ert_departmentid='" . $_REQUEST["dep_id"] . "'");

    		$i = 0;

    		while($row = $q_ert->next())
    		{
    			$i++;
    		?>
    			<tr class="<?php ($i % 2) ? print "bgRowColor" : print "altBgRowColor" ; ?>">
    				<td><?php echo $row->ert_errortype ?></td>
        	  <td style="width:85px; align="center">
        	  	<div style="padding-left:6px;">
              		<span class="editLink"><a href="edit_error_type.php?error_type_id=<?php echo $row->ert_id ?>&pageid=errorTypes&qcoperator=1">Edit</a></span>
              		<span class="seperator">|</span>
              		<span class="editLink"><a href="delete_error_type.php?error_type_id=<?php echo $row->ert_id ?>">Delete</a></span>
              	</div>
            </td>
    			</tr>
    		<?php
    		}
    		?>
    		<tr>
    			<td><input type="submit" value="Add New" class="button" /></td>
    		</tr>
    		<?php
    	}
    	?>
  	</table>
	</form>
  <?php
  if(isset($_REQUEST["dep_id"]))
  {
  ?>
		<script type="text/javascript">
			select_option("ert_form", "ert_departmentid", <?php echo $_REQUEST["dep_id"] ?>);
		</script>
	<?php
  }
	?>
</div>
<?php
include(INCLUDES_PATH . "/site_footer.php");
?>
