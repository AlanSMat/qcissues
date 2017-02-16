<?php 
require(CLASSES_PATH . "/class.DDText.php");

class ExportCSV
{
    public $file_name;

	public function __construct($query_string = false, $dd_array = false) 
	{
		if(!$query_string) 
		{
		  echo "ERROR: missing query string";
		  exit;
		}
		
		$this->file_name = "export.csv";		
		$this->query_string = $query_string;	
		$this->query = $this->query();
		$this->result = $this->query->result;
		$this->num_fields = $this->query->num_fields();		
		$this->export_to_file();
	}
	
	public function query() 
	{
	  $query = new Query($this->query_string);	  
	  return $query;
	}
  
	private function csv_header() 
	{ 
    $header = "";
    
	  for($i = 0; $i < $this->query()->num_fields(); $i++) 
	  {
	    $field_name = mysql_field_name($this->result, $i);
	    if($i < $this->query()->num_fields() - 1) 
	    {
	      $header .= substr($field_name, 4, strlen($field_name)) . ",";  
	    }
	    else 
	    {
	      $header .= substr($field_name, 4, strlen($field_name));
	    }
             
	  } 
	  
    $header .= "\n";   
    
    return $header;
	}
	
	private function export_to_file()  
	{
	  $csv_content = "";
	  
      while($row = $this->query->next())
	  {
	  	$dd_text = new DDText($row);
  
      	  for($i = 0; $i < $this->num_fields; $i++) 
      	  {
      	    $meta = mysql_fetch_field($this->result, $i);
      	    
      	    switch($meta->name)
      	    {
      	      case "qcc_logdate" :
      	        $row->qcc_logdate =  date("d M Y", $row->{$meta->name});
      	        break;
      	      case "qcc_pubdate" :
      	        $row->qcc_pubdate =  date("d M Y", $row->{$meta->name});
      	        break;
      	      case "qcc_publication" :
      	        $row->qcc_publication =  $dd_text->publication;      	        
      	        break;
      	      case "qcc_errortype" :
      	        $row->qcc_errortype =  $dd_text->error_type;      	        
      	        break;  
      	      case "qcc_operator" :
      	        $row->qcc_operator =  $dd_text->operator;      	        
      	        break;        	     
      	    }
      	    //$text = str_replace(array("\r\n", "\r", "\n", "\t"), '', $text);
      	    if($i < ($this->num_fields - 1)) 
      	    {
      	        if($meta->name != "qcc_submitted") 
      	        {
      	          $csv_content .= str_replace(array("\r\n", "\r", "\n", "\t", ","), '', $row->{$meta->name}) . ",";
      	        }
      	    }
      	    else 
      	    {
      	      $csv_content .= str_replace(array("\r\n", "\r", "\n", "\t", ","), '', $row->{$meta->name});
      	    }  
      	  }
  	  $csv_content .= "\n";  	  
	  }

    // Output to browser with appropriate mime type, you choose ;)
    header("Content-type: text/x-csv");
    header("Content-Disposition: attachment; filename=$this->file_name");
    echo $csv_content;
    exit;    
	}
}
?>