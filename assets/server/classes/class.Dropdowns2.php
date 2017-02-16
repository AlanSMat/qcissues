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

class Custom_Exception extends Exception
{
  public function error_message() 
  {
    $error_msg = $this->getMessage() . "is missing or not valid";
    return $errorMsg;
  }    
}

class DD_Test 
{
  private $_list_names;

  public function __construct()
  {
    $this->_list_names = array("select_row" => "",
    									         "select_column" => ""
    									       //  "db_table" => "",
    									       //  "db_id" => "",
    									       //  "db_list_column" => "",
    									       //  "db_foreign_key" => ""
                               );    
  }  

  public function __get($list_name) 
  {
    return $this->_list_names[$list_name];  
  }
  
  public function __set($list_name, $value) 
  {
    if (array_key_exists($list_name, $this->_list_names))
    {
      $this->_list_names[$list_name] = $value;
    }
  }  
  
}

class DD_Data
{
  private $_list_names;
  
  public function __construct()
  {
    $this->_list_names = array("select_row" => "",
    									         "select_column" => "",
    									         "db_table" => "",
    									         "db_id" => "",
    									         "db_list_column" => "",
    									         "db_foreign_key" => ""
                               );    
  }  
  
  public function __get($list_name) 
  {
    return $this->_list_names[$list_name];  
  }
  
  public function __set($list_name, $value) 
  {
    if (array_key_exists($list_name, $this->_list_names))
    {
      $this->_list_names[$list_name] = $value;
    }
  }  
} 
class Dropdowns
{
  private $_level_one_list   = array();
  private $_level_two_list   = array();
  private $_level_three_list = array();
  private $_level_one_select_name = null;
  private $_level_two_select_name = null;
  private $_level_three_select_name = null;
  public $dd_data = array();
  private $_dd_list = array();

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
  
  public function set_dd_cookies() 
  {
    $i = 0;
    foreach($this->dd_data as $dd_lvl) 
    {
      $cookie_name        = $dd_lvl->db_table . "_" . $i; 
      $cookie_value       = $dd_lvl->select_row;     
      //setcookie($cookie_name, $cookie_value);
      $i++;
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
  
  public function recur_test($id = 1) 
  {
    
    /*echo $this->_level_one_list["db_table"];
    if($id < 3) 
    {
      $id++;
      echo $id;
      $this->recur_test($id);
    }*/
  }
/*
 *   		addListGroup("ert_groups", "dep_department"); addOption("dep_department", " -- select company -- ", "", "", 1); //Empty starter option
    	  addList("dep_department", "Holt St.", "1", "holt_st.");
          addOption("holt_st.", " -- select publication -- ", "", "", 1); //Empty starter option
          addList("holt_st.", "Complex PDF", "1", "complex_pdf");
 * 
 * */  
  public function js_output2() 
  {
    //$this->open_script_tags();
   

    ?>
			addListGroup("<?php echo $this->list_group ?>", "<?php echo $this->dd_data[1]->db_table ?>"); addOption("<?php echo $this->dd_data[1]->db_table ?>", " -- select company -- ", "", "", 1); //Empty starter option
    <?php
    $qry = new Query("SELECT * FROM " . $this->dd_data[1]->db_table . "");

    while($row = $qry->next(ROW_AS_ARRAY))
    {
      $list_name = strtolower(ereg_replace(" ", "_", $row["". $this->dd_data[1]->db_list_column . ""]));

      $first_level = $this->js_addList("", 1, $list_name, $row);
      $this->second_level($row["". $this->_level_one_list["db_id"] . ""], $list_name);
    }
    
    //$this->close_script_tags();
  }
  
  private function js_addList($id = false, $iteration, $list_name = false, $row) 
  {
    try
    {    
    ?>
	  	addList("<?php echo $this->dd_data[$iteration]->db_table ?>", "<?php echo $row["". $this->dd_data[$iteration]->db_list_column . ""] ?>", "<?php echo $row[$id] ?>", "<?php echo $list_name ?>");
    <?php
    }
    catch(Exception $e)
    {
      //echo $e->errorMessage();
    }
  }
  
  public function js_output()
  {  	
    $this->open_script_tags();
    ?>
		addListGroup("<?php echo $this->list_group ?>", "<?php echo $this->dd_data["dd_lvl_1"]->db_table ?>"); addOption("<?php echo $this->dd_data["dd_lvl_1"]->db_table ?>", " -- select company -- ", "", "", 1); //Empty starter option
    <?php

    $qry = new Query("SELECT * FROM " . $this->dd_data[0]->db_table . "");	

    while($row = $qry->next(ROW_AS_ARRAY))
    {
      $list_name = strtolower(ereg_replace(" ", "_", $row["". $this->dd_data[0]->db_list_column . ""]));

      ?>
	  	addList("<?php echo $this->dd_data[0]->db_table ?>", "<?php echo $row["". $this->dd_data[0]->db_list_column . ""] ?>", "<?php echo $row["". $this->dd_data[0]->db_id . ""] ?>", "<?php echo $list_name ?>");
      <?php
      $this->second_level($row["". $this->_level_one_list["db_id"] . ""], $list_name);
    }
    $this->close_script_tags();
  }//** end first_level

  private function second_level($id, $first_level_list_name)
  {
    $qry = new Query("SELECT * FROM " . $this->_level_two_list["db_table"] . " WHERE " . $this->_level_two_list["db_foreign_key"] . "='" . $id . "'");    
    ?>
    addOption("<?php echo $first_level_list_name ?>", " -- select publication -- ", "", "", 1); //Empty starter option
    <?php
    $i = 1;
    while($row = $qry->next(ROW_AS_ARRAY))
    {
      $list_name = strtolower(ereg_replace(" ", "_", $row[$this->_level_two_list["db_list_column"]]));
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
    addOption("<?php echo $second_level_list_name ?>", " -- select Edition -- ", "", "", 1); //Empty starter option
    <?php
    $i = 1;
    while($row = $qry->next(ROW_AS_ARRAY))
    {
      $list_name = strtolower(ereg_replace(" ", "_", $row[$this->_level_three_list["db_list_column"]]));
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
