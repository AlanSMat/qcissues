<?php

class Search {

	public function __construct( $table = "", $post_vars = "", $order_by = "", $max_results = "" ) {
		
		$this->error_check($table);		
		$this->error_check($post_vars);
		
		$this->table         = $table;
		$this->post_vars     = $post_vars;
		$this->prefix        = substr_replace($this->table, "" , 3);
		$this->order_by      = $order_by;	
		$this->max_results   = $max_results;
		$this->page          = $this->get_page();
		$this->limit_from    = $this->limit_from();
		$this->filtered_vars = $this->filter_vars();
		$this->search_string = $this->search_string();
	}
  
	private function get_page() 
	{
		// If current page number, use it
		// if not, set one.		
		if(!isset($_GET['page'])){
				$page = 1;
		} else {
				$page = $_GET['page'];
		}
		return $page;
	}
	
	private function limit_from() 
	{	  
			// Figure out the limit for the query based
		// on the current page number.
		$from = (($this->page * $this->max_results) - $this->max_results);
		return $from;
	}
	
	private function error_check($var) 
	{
    	if($var == "") {			
    		echo "ERROR: missing argument";					
    		exit;
    	}	
	}
	
	private function filter_vars() 
	{					
		foreach($this->post_vars as $key => $value) 
		{		
			if ( ereg( $this->prefix, $key )) 
			{				
				if($value != "") 
				{	
					if(ereg("date", $key)) 
					{
						$value = strtotime($value);
					}			
					$table_data[$key] = $value;						
				}			
			}				
		}	
		
		return $table_data;
		
	}
	
	private function display_filtered_vars() 
	{		
		foreach( $this->filtered_vars as $key => $value ) 
		{			
			echo $key . " " . $value . "<br>";			
		}
		
	}

	private function get_page_limit() 
	{		
		// If current page number, use it
		// if not, set one.		
		if(!isset($_GET['page'])){
				$this->page = 1;
		} else {
				$this->page = $_GET['page'];
		}
		
		// Figure out the limit for the query based
		// on the current page number.
		$from = (($this->page * $this->max_results) - $this->max_results);
		
		$limit = "LIMIT " . $from . ", " . $this->max_results . "";
										
		return $limit;
	}
	
	private function where_clause_string($key, $value, $type) 
	{	    
        switch($key) 
        {
          case ereg("date", $key) == 1:
            $where_clause = $this->str_range("fromdate", "todate", "cir_pubdate", $key, $value, $type);
            break;
            
          case ereg("pagerange", $key) == 1:	             
            $where_clause = $this->str_range("frompagerange", "topagerange", "prq_totalpages", $key, $value, $type);
            break;
            
          case ereg("quantity", $key) == 1:
            $where_clause = $this->str_range("fromquantity", "toquantity", "prq_quantity", $key, $value, $type);
            break;
            
          case ereg("cost", $key) == 1:
            $where_clause = $this->str_range("fromcost", "tocost", "prq_totalcost", $key, $value, $type);
            break;
          default :
            if(is_numeric($value)) 
            {  
                $where_clause = "" . $type . " " . $key . " = '" . $value . "'";
            } 
            else 
            {
                $where_clause = "" . $type . " " . $key . " LIKE '%" . $value . "%' ";
            } 
            break;
        }   
	    return $where_clause;
	}
	
	private function where_clause() 
	{
		$i = 1;
    $where_clause = "";
    
		if(count($this->filtered_vars) > 0) 
		{	
 
    		foreach( $this->filtered_vars as $key => $value ) 
    		{ 
    			if( $i == 1 ) 
    			{
			      $where_clause .= $this->where_clause_string($key, $value, "WHERE");
    			} 
    			elseif( $i > 1) 
    			{ 
    			  $where_clause .= $this->where_clause_string($key, $value, " AND");		
    			}
    			
    		  $i++;
    		}
		}
		return $where_clause;	
	}
	
	private function limit_clause() 
	{
	  $limit_clause = "";
		if($this->order_by != "") 
		{
			$limit_clause .= "ORDER BY " . $this->order_by . " DESC ";
		}
	
		if($this->max_results != "") {
			$limit_clause .= $this->get_page_limit();
		}
		return $limit_clause;
	}
	
	public function select_string() 
	{
	    return $select_string = "SELECT * FROM " . $this->table . " " . $this->where_clause() . " " . $this->limit_clause() . "";;  
	}
	
	private function search_string($limit = true) 
	{
		$i = 1;
		
		foreach( $this->filtered_vars as $key => $value ) 
		{					
			if( $i == 1 ) 
			{
			  if(is_numeric($value)) 
			  {
			     $search_string = "WHERE " . $key . " = '" . $value . "' "; 
			  }
			  else 
			  {
			     $search_string = "WHERE " . $key . " LIKE '%" . $value . "%' "; 
			  }			  			
			} 
			elseif( $i > 1) 
			{					
			  
			  if(is_numeric($value)) 
			  {				
				$search_string .= "AND " . $key . " = '" . $value . "' ";
			  }
			  else 
			  {
			    $search_string .= "AND " . $key . " LIKE '%" . $value . "%' ";
			  }				
			} 			
										
		  $i++;
		}
		
		if($this->order_by != "") 
		{
			$search_string .= "ORDER BY " . $this->order_by . " DESC ";
		}
 		
		if($limit) 
		{
			$search_string .= "LIMIT " . $this->limit_from . ", " . $this->max_results . " ";
		}

		return $search_string;
	
	}

  public function build_page_numbers($a_args = "", $type = "normal") 
  {
	  $query = "SELECT COUNT(*) as Num FROM " . $this->table . " " . $this->search_string(false) . "";

		// Figure out the total number of results in DB:
		$total_results = mysql_result(mysql_query($query),0);
		
		// Figure out the total number of pages. Always round up using ceil()
		$total_pages = ceil($total_results / $this->max_results);
		
		?>
		<div align="center">
		<?php
		switch($type) {
		
			case "normal" :
			
				// Build Previous Link
				if($this->page > 1){
					$l_prev = ($this->page - 1);
					echo "<a href=\"".$_SERVER['PHP_SELF']."?page=" . $l_prev . "&" . $a_args . "\"><<</a> ";
				}
				/*else 
				{
				  echo "<span style='color:#C6DBFF'>prev</span> ";
				}*/
				
				for($i = 1; $i <= $total_pages; $i++){
				   if(($this->page) == $i)
				   {
				     echo "<span class=\"pageNumberSelected\">" . $i . " </span>";
				   } 
				   else 
				   {
				     echo "<a href=\"".$_SERVER['PHP_SELF']."?page=" . $i . "&" . $a_args . "\">" . $i . "</a> ";
				   }
				}
				
				// Build Next Link
				if($this->page < $total_pages){
						$l_next = ($this->page + 1);
						echo "<a href=\"".$_SERVER['PHP_SELF']."?page=" . $l_next . "&" . $a_args . "\">>></a>";
				}
			
			break;
			
			case "select" :
			
				// Build Previous Link
				if($this->page > 1){
						$l_prev = ($this->page - 1);
						echo "<a href=\"" . $_SERVER['PHP_SELF'] . "?page=" . $l_prev . "&" . $a_args . "\"><<</a> ";
				}
				?>
				<script language="javascript">
					
					function page(selected) {
						href = "<?php echo $_SERVER['PHP_SELF'] ?>?page=" + selected + "&<?php echo $a_args ?>"; 
						document.location = href
					}
					
				</script>
				<form method="get">
					<select name="pages" onchange="page(this.options[this.options.selectedIndex].value)">
						<?php
						for($i = 1; $i <= $total_pages; $i++){
								if(($this->page) == $i){
										echo "" . $i . "";
										} else {
										?>							
											<option value="<?php echo $i ?>"><?php echo $i ?></option>								
										
										<?php
								}
						}
						?>
					</select>
				</form>
				<?php			
				// Build Next Link
				if($this->page < $total_pages){
						$l_next = ($this->page + 1);
						echo "<a href=\"".$_SERVER['PHP_SELF']."?page=" . $l_next . "&" . $a_args . "\">>></a>";
				}					
			    else 
				{
				  echo "<span style='color:#ccc'>next</span> ";
				}			
			break;	
		}
		?>
		</div>
		<?php
	}
	
	public function search_results() 
	{	  
	  $query = new Query("SELECT * FROM " . $this->table . " " . $this->search_string . "");
	  return $query;	
	}
	
	function expired_date() 
	{
		return $expired_date = strtotime('last month');
	}
}


?>