<?php
session_start();
require("globals.php");

include(CLASSES_PATH . "/class.Search.php");
include(CLASSES_PATH . "/class.DDText.php");

$page_title = "Search Results";
$order_by = "qcc_id";
$max_results = "20";

if(isset($_POST["issue_id"])) 
{ 
  $_SESSION["post"] = $_POST;
}

$search = new Search("qcc_qcissues", $post_vars = $_SESSION["post"], $order_by, $max_results);

//** copy the search variables into the session so that they can be used for form re-population
$_SESSION["search_results"] = $search->filtered_vars;

include(INCLUDES_PATH . "/site_header.php");

$_SESSION["csv_query_string"] = $search->select_string();
?>
  <div class="pageTitleContainer">
    <div class="pageTitle">
      <div class="pageTitleSpacing">&nbsp;</div>	      
    </div>
  </div>    
 <?php  
   
    ?>
    <table cellpadding="2" cellspacing="1" border="0">      
      <tr>
        <td class="header" style="width:55px;">Issue Id</td>
        <td class="header" style="width:90px; text-align:center;">Log Date</td>
        <td class="header" style="width:90px; text-align:center;">Pub Date</td>
        <td class="header" style="width:170px; text-align:center;">Publication</td>
        <td class="header" style="width:200px; text-align:center;">QC Issue</td>
        <td class="header" style="width:120px; text-align:center;">Logged By</td>
        <!-- <td class="header" style="width:80px; text-align:center;">Status</td> -->
        <td class="header" style="width:80px">&nbsp;</td>
      </tr>
      <?php

      $query = $search->search_results();

      /*
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
       * 
       * */
      
      
      $i = 0;
      while($row = $query->next()) 
      {
        $i++;
        $dd_text = new DDText($row);
        ?>
        <tr class="<?php ($i % 2) ? print "bgRowColor" : print "altBgRowColor" ; ?>">
          <td><?php echo $row->qcc_id ?></td> 
          <td><?php echo rt_date($row->qcc_logdate) ?></td>
          <td><?php echo rt_date($row->qcc_pubdate) ?></td>          
          <td><?php echo $dd_text->publication; ?></td>
          <td><?php echo $dd_text->error_type($row->qcc_department, $row->qcc_errortype)?></td>
          <td><?php echo $dd_text->operator; ?></td>
          <!-- <td><? echo "status" ?></td> -->
          <td>
            <span class="editLink"><a href="view.php?issue_id=<?php echo $row->qcc_id ?>&pageid=none&qcoperator=1">View</a></span>
            <span class="separator">|</span>
            <span class="editLink"><a href="index.php?issue_id=<?php echo $row->qcc_id ?>&pageid=none&qcoperator=1">Edit</a></span>
            <!--  <div class="editLink"><a href="delete_issue.php?issue_id=<?php echo $row->qcc_id ?>">Delete</a></div>  -->   
          </td>
        </tr>
      <?php  
      }
      
      if($i == 0) 
      {
        ?>
        <tr>
          <td colspan="8" style="text-align:center;">No Search Results Found</td>
        </tr>
        <?php 
      }
      ?> 
      <tr>
        <td colspan="8">&nbsp;</td>
      </tr>   
      <tr>
        <td colspan="8"><?php $search->build_page_numbers("pageid=" . $_REQUEST["pageid"] . "&qcoperator=1"); ?></td>
      </tr>      
    </table>
	<div class="buttonSpacing" style="clear:both;width:850px;">
    	<div style="float:left"><input type="button" value="Back to Search Form" class="button" onclick="javascript:document.location='<?php echo ROOT_URL?>/search.php?pageid=search&qcoperator=1';" /></div>
    	<div style="float:left; padding-left:10px;"><input type="button" value="Export to CSV" class="button" onclick="document.location='csv.php'" /></div>
    </div><br style="clear:both;" />
<?php
include(INCLUDES_PATH . "/site_footer.php");
?>