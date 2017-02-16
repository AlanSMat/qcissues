<?php
/**
 USAGE
 $dd_ert = new Dropdowns("ert_groups", "dep_department", "ert_errortype");
 $dd_ert->inc_chained_select_script();
 $dd_ert->lvl2_db_col = "ert_errortype";
 $dd_ert->main_js_functions();

 <div class="row">
 <div class="textSpacing">Publication *</div>
 <div style="float:left"><?php $dd_pub->select("qcc_publication"); ?></div>
 </div>
 <div class="row">
 <div class="textSpacing">Edition *</div>
 <div style="float:left"><?php $dd_pub->select("qcc_edition"); ?></div>
 </div>

 $dd_ert->window_onload();


 <?php
 class myclass {
 public $value = null;
 public $key = null;
 public $column = null;
 public $table = null;
 public function __construct() {
 $vars = get_class_vars();
 for($i=0; $i<func_num_args();$i++) {
 $this->${$vars[$i]}=func_get_arg($i);
 }
 }
 }

 //usage
 $c = new myclass("value", "tablekey", "tablecol", "table");
 echo $c->key;
 //prints 'tablekey'
 ?>

 */
class DD_Data
{
  private $_args;
  private $_list = array();
  private $_selected_value;

  public function __construct()
  {
    $this->num_args        = func_num_args();
    $this->args            = func_get_args();
    $this->_list           = $this->data();
    $this->_selected_value = $this->_list["select_row"]["" . $this->_list["select_column"] . ""];  
   // echo $this->_list["select_column"] . " " . $this->_selected_value . "<br />";
    //$this->_set_cookies($this->_selected_value);
  }

  public function data()
  {
  	$vars[0] = "select_row";  // entire row from db
  	$vars[1] = "select_column"; // selected column
    $vars[2] = "db_table";
    $vars[3] = "dropdown_title";
    $vars[4] = "db_id";
    $vars[5] = "db_list_column";
    $vars[6] = "db_foreign_key";

    $list_data = array();

    for($i = 0; $i < $this->num_args; $i++)
    {
      $list_data[$vars[$i]] = $this->args[$i];     
    }

    $this->_list = $list_data;

    return $list_data;
  } 
} 
class Dropdowns extends DD_Data
{
  private $_level_one_list   = array();
  private $_level_two_list   = array();
  private $_level_three_list = array();
  private $_level_one_select_name = null;
  private $_level_two_select_name = null;
  private $_level_three_select_name = null;

  public function __construct($list_group) {    
    $this->list_group = $list_group;
  }

  public function level_one_data($obj)
  {
    $this->_level_one_list = $obj->data();
    $cookie_name = $this->_level_one_list["db_table"] . "_0";    
  	$cookie_value = ($this->_level_one_list["select_row"]["" . $this->_level_one_list["select_column"] . ""]);  
    setcookie($cookie_name, $cookie_value);
  }
  
  public function level_two_data($obj)
  {
    $this->_level_two_list = $obj->data();    
    $cookie_name = $this->_level_one_list["db_table"] . "_1";
  	$cookie_value = ($this->_level_two_list["select_row"]["" . $this->_level_two_list["select_column"] . ""]);  
    setcookie($cookie_name, $cookie_value);
  }
  
  public function level_three_data($obj)
  {
    $this->_level_three_list = $obj->data();
    $cookie_name = $this->_level_one_list["db_table"] . "_2";
  	$cookie_value = ($this->_level_three_list["select_row"]["" . $this->_level_three_list["select_column"] . ""]);
    setcookie($cookie_name, $cookie_value);
  }

  private function _clear_cookies($selected_value)
  { 
    foreach($_COOKIE as $key => $value)
    {
      if(ereg($this->_list["db_table"] , $key))
      {       
        setcookie($key, "0", 1);
      }
    }   
  }  

  private function _set_cookies($selected_value)
  { 
    foreach($_COOKIE as $key => $value)
    {
      if(ereg($this->_list["db_table"] , $key))
      {
        if(isset($_COOKIE[$key]) && ($selected_value == ""))
        {         
          setcookie($key, "0", 1);           
        }
        else if(isset($_COOKIE[$key]) && ($selected_value != "")) 
        {          
          setcookie($key, "" . $selected_value . "");
        }
      }
    }   
  }
  
  public function inc_chained_select_script()
  {
    ?>
	<script	language="javascript" src="<?php echo SCRIPTS_URL ?>/chainedselects.js"></script>
    <?php
  }

  public function open_script_tags()
  {
    ?>
	<script language="javascript">
	//var hide_empty_list=true; //uncomment this line to hide empty selection lists
	var disable_empty_list=true; //uncomment this line to disable empty selection lists
  	<?php
  }

  public function close_script_tags()
  {
  	?>
  	</script>
  	<?php
  }

  public function main_js_functions()
  {  	
    $this->open_script_tags();
    ?>
	addListGroup("<?php echo $this->list_group ?>", "<?php echo $this->_level_one_list["db_table"] ?>"); addOption("<?php echo $this->_level_one_list["db_table"] ?>", "<?php echo $this->_level_one_list["dropdown_title"] ?>", "", "", 1); //Empty starter option
    <?php

    $qry = new Query("SELECT * FROM " . $this->_level_one_list["db_table"] . "");	

    while($row = $qry->next(ROW_AS_ARRAY))
    {
      $list_name = strtolower(preg_replace("/ /", "_", $row["". $this->_level_one_list["db_list_column"] . ""]));

      ?>
	  addList("<?php echo $this->_level_one_list["db_table"] ?>", "<?php echo $row[$this->_level_one_list["db_list_column"]] ?>", "<?php echo $row["". $this->_level_one_list["db_id"] . ""] ?>", "<?php echo $list_name ?>");
      <?php
      $this->second_level($row["". $this->_level_one_list["db_id"] . ""], $list_name);
    }
    $this->close_script_tags();
  }//** end first_level

  private function second_level($id, $first_level_list_name)
  {
    $qry = new Query("SELECT * FROM " . $this->_level_two_list["db_table"] . " WHERE " . $this->_level_two_list["db_foreign_key"] . "='" . $id . "'");    
    ?>
    addOption("<?php echo $first_level_list_name ?>", "<?php echo $this->_level_two_list["dropdown_title"] ?>", "", "", 1); //Empty starter option
    <?php
    $i = 1;
    while($row = $qry->next(ROW_AS_ARRAY))
    {
      $list_name = strtolower(preg_replace("/ /", "_", $row[$this->_level_two_list["db_list_column"]]));
      ?>
      addList("<?php echo $first_level_list_name ?>", "<?php echo $row[$this->_level_two_list["db_list_column"]] ?>", "<?php echo $i++ ?>", "<?php echo $list_name ?>");
      <?php
      if(count($this->_level_three_list) > 0)
      {
        $this->third_level($row[$this->_level_two_list["db_id"]], $list_name);
      }
    }
  }

  private function third_level($id, $second_level_list_name)
  {
   	$qry = new Query("SELECT * FROM " . $this->_level_three_list["db_table"] . " WHERE " . $this->_level_three_list["db_foreign_key"] .  "='" . $id . "'");

    ?>
    addOption("<?php echo $second_level_list_name ?>", "<?php echo $this->_level_three_list["dropdown_title"] ?>", "", "", 1); //Empty starter option
    <?php
    $i = 1;
    while($row = $qry->next(ROW_AS_ARRAY))
    {
      $list_name = strtolower(preg_replace("/ /", "_", $row[$this->_level_three_list["db_list_column"]]));
      ?>
      addList("<?php echo $second_level_list_name ?>", "<?php echo $row[$this->_level_three_list["db_list_column"]] ?>", "<?php echo $i++ ?>", "<?php echo $list_name ?>");
      <?php
    }
  }

  public function select($select_name)
  {

    if($this->_level_one_select_name == null)
    {
      $this->_level_one_select_name = $select_name;
    }
    else if($this->_level_two_select_name == null)
    {
      $this->_level_two_select_name = $select_name;
    }
    else if($this->_level_three_select_name == null)
    {
      $this->_level_three_select_name = $select_name;
    }
    ?>
	  <select  name="<?php echo $select_name ?>" style="width: 160px"></select>
    <?php
  }

  public function init()
  {
    ?>
	<script language="javascript">     
  	  initListGroup("<?php echo $this->list_group ?>", document.forms[0].elements["<?php echo $this->_level_one_select_name ?>"], document.forms[0]["<?php echo $this->_level_two_select_name; ?>"], <?php $this->_level_three_select_name != null ? print "document.forms[0][\"" . $this->_level_three_select_name  . "\"]," : print "" ?> '<?php echo $this->_level_one_list["db_table"] ?>');
	</script>
	<?php
  }
}//** end class
