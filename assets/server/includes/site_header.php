<?php 
if(isset($page_title) && $page_title != "QC Issues - Index") 
{
  header('Cache-Control: no-store, no-cache, must-revalidate');
}

if(isset($_REQUEST['pageid'])) 
{
  $page_id = $_REQUEST["pageid"];
}
else 
{
  $page_id = "default";
}

if(!isset($_REQUEST["qcoperator"])) 
{
    $_REQUEST["qcoperator"] = 0;
}

?>
<html xml="http://www.w3.org/1999/xhtml">
<head>
  <title><?php isset($page_title) ? print $page_title : print "Untitled" ; ?> - <?php echo MAIN_TITLE ?></title>
  <meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="pragma" content="no-cache">
  <style type="text/css">
	  #<?php echo $page_id ?> {
		  float:left;
		  xheight:19px;
		  padding:5px 0px 5px 0px;
		  width:134px;
		  text-align:center;
		  background-color:#ccc;
		  color:#000;
		  cursor:pointer;
		  border: 1px solid #ccc;
		  xborder-right:0px;			
	  }
		
	  a.remake {
		  color:#0000ff;
		  text-decoration:underline;
		  padding-left:10px;
	  }
	  
    .gradbg 
    {
      background-image:url('images/topgrad.gif');
    }
	  
  </style>
  <script language="JavaScript" type="text/javascript">
	  function printpage() {
		  window.print();  
	  }
		
	  function refresh_page() {
		  document.location = document.location;
	  }
	  
	  function windowNew(url, width, height) 
	  {
	    if(!width)
	      width = 600;
	    if(!height)
	      height = 500;
	    var left = (screen.width / 2) - (width / 2);
	    var top = (screen.height / 2) - (height / 2);
	    link = window.open(url,"Link","toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=1,width=" + width + ",height=" + height + ",left=" + left + ",top=" + top + ""); 
	  }
		
  </script>    
  <script type="text/javascript" src="<?php echo SCRIPTS_URL ?>/common.js"></script>
  <script type="text/javascript" src="<?php echo SCRIPTS_URL ?>/form_validation.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL ?>/default.css"  media="screen" />    
  <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL ?>/print.css" media="print" /> 
  <style type="text/css">
      .pageTitleBar{margin: 0;background-image:url("<?php echo IMAGES_URL ?>/topgrad.gif");}
  </style>  
</head>
<body>
  <div class="mainBodyContainer">
    <div class="mainPageWidthAndHeight" align="center">   
      <div class="noprint">
	  	<div class="pageHeader">
			<img src="<?php echo IMAGES_URL ?>/heading2.jpg" width="499" height="64" alt="" />	
		</div>
		<div class="pageTitleBar">
			<div class="pageTitle">Chullora QC Issues</div>
		</div>
  		<div class="navTopContainer">
  		  <?php 
  		  if($_REQUEST["qcoperator"]) 
  		  {
  		  ?>
  		  	  <div class="navItemTop" id="default" style="float:left;" onMouseOut="this.className='navItemTop'" onMouseOver="this.className='navItemOverTop'" onClick="document.location='<?php echo ROOT_URL ?>/index.php?pageid=default&qcoperator=1'">New QC Issue</div>
  		      <div class="navItemTop" id="browse" style="float:left;" onMouseOut="this.className='navItemTop'" onMouseOver="this.className='navItemOverTop'" onClick="document.location='<?php echo ROOT_URL ?>/browse.php?pageid=browse&qcoperator=1'">Browse</div>		      
  		  	  <div class="navItemTop" id="search" style="border-right:1px outset #ccc;float:left;" onMouseOut="this.className='navItemTop'" onMouseOver="this.className='navItemOverTop'" onClick="document.location='<?php echo ROOT_URL ?>/search.php?pageid=search&qcoperator=1'">Search</div>
  		  	  <div class="navItemTop" id="errorResponses" style="float:right" onMouseOut="this.className='navItemTop'" onMouseOver="this.className='navItemOverTop'" onClick="document.location = '<?php echo ROOT_URL ?>/error_responses/list_error_responses.php?pageid=errorResponses&qcoperator=1'">Error Responses</div>		  		  		 
  		  	  <div class="navItemTop" id="operators" style="float:right" onMouseOut="this.className='navItemTop'" onMouseOver="this.className='navItemOverTop'" onClick="document.location = '<?php echo ROOT_URL ?>/operators/list_operators.php?pageid=operators&qcoperator=1'">Operators</div>
  		      <div class="navItemTop" id="errorTypes" style="float:right" onMouseOut="this.className='navItemTop'" onMouseOver="this.className='navItemOverTop'" onClick="document.location = '<?php echo ROOT_URL ?>/error_types/list_error_types.php?pageid=errorTypes&qcoperator=1&department_id=0'">Error Types</div>
  		  <?php 
  		  }
  		  else 
  		  {
  		  ?>
  		      <div class="navItemTop" id="browse" style="float:left;" onMouseOut="this.className='navItemTop'" onMouseOver="this.className='navItemOverTop'" onClick="document.location='<?php echo ROOT_URL ?>/browse.php?pageid=browse'">Browse</div>
  		  <?php
  		  }
  		  ?>  		            
  		  <div class="clear">&nbsp;</div>
  		  
  	    </div><!-- end navTopContainer -->
  	  </div><!-- end noprint -->   
        <!-- Breadcrumb Nav -->
        <div class="breadcrumbContainer">
          <div class="breadcrumbs">&nbsp;</div>
          <div class="clear"></div>  
        </div>
  	  