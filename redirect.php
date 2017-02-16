<?php 
session_start();
require("globals.php");

include(INCLUDES_PATH . "/login_header.php");
?>
<form method="post" action="login.php">	
	<div style="margin-width:auto;margin-height:auto;padding-top:20px;">
    	<table cellpadding="2" cellspacing="1" border="0" align="center" class="mainTableTop">
    		<tr>
    			<td colspan="2">
    				<div style="color:red;font-weight:bold;">
    			  		
    			    </div>
    			</td>
    		</tr>			
			</table>
	</div>
	<input type="hidden" name="login" value="1" />
</form>
<?php 
include(INCLUDES_PATH . "/login_footer.php");
?>