<?php
class page_list {

	public function __construct($table, $max_results, $order_by = 1, $where_clause = 1) {			
		$this->table        = $table;
		$this->max_results  = $max_results;
		$this->order_by     = $order_by;
		$this->where_clause = $where_clause;
		$this->page_query   = $this->_get_page_query();
	}
	
	private function _get_page_query() {
		
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
		
		$query = "SELECT * FROM " . $this->table . " 
    				  WHERE " . $this->where_clause . "
    				  ORDER BY " . $this->order_by . " DESC  								
    				  LIMIT " . $from . ", " . $this->max_results . "							
    				 ";

		$result = new Query($query);
								
		return $result;
	}
	
	public function build_page_numbers($a_args = "", $type = "normal") {
				
		// Figure out the total number of results in DB:
		$total_results = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM " . $this->table . " WHERE " . $this->where_clause . ""),0);
		
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
											<option value="<?php echo $i ?>"><?php echo $i ?></option>;								
										
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
	
	public function num_item() {
	
		$this->page == 1 ? $num_item = $this->page : $num_item = $this->page * $this->max_results - ($this->max_results - 1);
		return $num_item;
	
	}
	
}
?>
