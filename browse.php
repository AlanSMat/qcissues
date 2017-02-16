<?php
session_start();
require("globals.php");

$page_title = "QC Issues - Browse Issue";

if(isset($_REQUEST["issue"]) && $_REQUEST["issue"] == "internal") 
{
  $issue_reported_by = "internal";
}
else if(isset($_REQUEST["issue"]) && $_REQUEST["issue"] == "client") 
{
  $issue_reported_by = "client";
}
else 
{
  $issue_reported_by = "all";
}

isset($_REQUEST['qcoperator']) ? $qcoperator_request_variable = '&qcoperator=2' :$qcoperator_request_variable = '' ;

include(CLASSES_PATH . "/class.DDText.php");
include(CLASSES_PATH . "/class.Page_list.php");

include(INCLUDES_PATH . "/site_header.php");

?>
<style type="text/css">
	.issue_padding 
	{
		padding:0px 0px 10px 151px;
		!padding:0px 0px 10px 136px;
				
	}
</style>
  <div class="pageTitleContainer">
    <div class="pageTitle">
      <div class="pageTitleSpacing">&nbsp;</div>	      
    </div>
  </div> 
  <div style="width:915px;">
      <form method="post" name="search_results">   
     <?php  
          
        ?>
        <div style="text-align:left;clear:both;">
          <table cellpadding="0" cellspacing="0" border="0">
            <tr>
              <td>Issue reported by:&nbsp;</td>
              <td>All&nbsp;</td>
              <td><input type="radio" id="all" name="issue" value="all" onclick="submit_form(this.form, '<?php echo ROOT_URL; ?>/browse.php?issue=all&pageid=browse')" />&nbsp;&nbsp;</td>
          		<td>Internal&nbsp;</td>    
          		<td><input type="radio" id="internal" name="issue" value="internal" onclick="submit_form(this.form, '<?php echo ROOT_URL; ?>/browse.php?issue=internal&pageid=browse')" />&nbsp;&nbsp;</td>
          		<td>Client&nbsp;</td>
          		<td><input type="radio" id="client" name="issue" value="client" onclick="submit_form(this.form, '<?php echo ROOT_URL; ?>/browse.php?issue=client&pageid=browse')"  />&nbsp;&nbsp;</td>
            </tr>
          </table>    
        </div>
        <table cellpadding="2" cellspacing="1" border="0">      
          <tr>
            <td class="header" style="width:55px;">Issue Id</td>
            <td class="header" style="width:85px; text-align:center;">Log Date</td>
            <td class="header" style="width:85px; text-align:center;">Pub Date</td>
            <td class="header" style="width:170px; text-align:center;">Publication</td>
            <td class="header" style="width:200px; text-align:center;">QC Issue</td>
            <td class="header" style="width:150px; text-align:center;">Logged By</td>
            <td class="header" style="width:85px; text-align:center;">Status</td>
            <td class="header" style="width:75px">&nbsp;</td>
          </tr>
          <?php
          
          $db_table     = "qcc_qcissues";
          $max_results  = 20;
          $order_by     = "qcc_logdate";
          
          switch($issue_reported_by) 
          {
            case "internal":        
              $where_clause = "qcc_reporttype='0'";
              break;
            case "client":
              $where_clause = "qcc_reporttype='1'";
              break;
            default:
              $where_clause = "'1'";
          }
          
          $page_list = new page_list($db_table, $max_results, $order_by,  $where_clause);
            
          $i = 0;
          while($row = $page_list->page_query->next()) 
          {
            //$query = new Query("SELECT * FROM qcc_qcissues WHERE qcc_id='" . $_REQUEST['issue_id'] . "'");
            //$row = $query->next();
           
            $i++;
            $dd_text = new DDText($row);
            
            switch($row->qcc_status)  
            {
              case "InProgress" :
                  $status = "<div style=\"color:orange;padding-left:5px;\">In Progress</div>";
                break;
              case "Closed" :
                  $status = "<div style=\"color:green;padding-left:5px;\">Closed</div>";
                break;
              default :
                  $status = "<div style=\"color:red;padding-left:5px;\">Open</div>";
                break;
            }
            ?>
            <tr class="<?php ($i % 2) ? print "bgRowColor" : print "altBgRowColor" ; ?>">
              <td><?php echo $row->qcc_id ?></td> 
              <td><?php echo rt_date($row->qcc_logdate) ?></td>
              <td><?php echo rt_date($row->qcc_pubdate) ?></td>          
              <td><?php echo $dd_text->publication; ?></td>
              <td><?php echo $dd_text->error_type ?></td>
              <td><?php echo $dd_text->operator ?></td>
              <td><?php echo $status ?></td>
              <td>
                  <div style="text-align:center;">
                    <span class="editLink"><a href="view.php?issue_id=<?php echo $row->qcc_id ?><?php echo $qcoperator_request_variable ?>&pageid=null">View</a></span>
                    <?php 
                    if($qcoperator_request_variable != "") 
                    {       
                    ?>
                    <span class="separator">|</span>
                    <span class="editLink"><a href="index.php?issue_id=<?php echo $row->qcc_id ?>&pageid=browse&qcoperator=1">Edit</a></span>
                    <!--  <div class="editLink"><a href="delete_issue.php?issue_id=<?php echo $row->qcc_id ?>">Delete</a></div>  -->
                    <?php 
                    }
                    ?> 
                  </div>  
              </td>
            </tr>
          <?php          
          }
          ?>
          <tr>
            <td colspan="8">&nbsp;</td>
          </tr>   
          <tr>
            <td colspan="8">
                <?php
                    if($qcoperator_request_variable != '') 
                    {
                        $page_args = "pageid=" . $_REQUEST["pageid"] . "&issue=" . $issue_reported_by . "&qcoperator=" . $_REQUEST["qcoperator"];
                    } 
                    else 
                    {
                        $page_args = "pageid=" . $_REQUEST["pageid"] . "&issue=" . $issue_reported_by;
                    }                    
                
                    $page_list->build_page_numbers($page_args); 
                ?>
            </td>
          </tr>      
        </table>    
      </form>  
  </div> 
  <script type="text/javascript">
		var issue_reported_by = "<?php echo $issue_reported_by ?>";

		switch(issue_reported_by) 
		{
			case "all":
				document.getElementById("all").checked = true;
				break;
			case "internal":
				document.getElementById("internal").checked = true;
				break;
			case "client":
				document.getElementById("client").checked = true;
				break;
		}

		
  </script>
<?php
include(INCLUDES_PATH . "/site_footer.php");
?>