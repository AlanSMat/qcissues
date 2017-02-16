<?php
class DDText
{  
  public function __construct($row) 
  {
    $this->row = $row;
    $this->publication_array = $this->publication_details();    
    $this->publication_id = $this->publication_array["pub_id"];      
    $this->publication = $this->publication_array["pub_name"];     
    $this->edition = $this->edition();
    $this->operator = $this->operator();
    $this->error_type = $this->error_type($row->qcc_department, $row->qcc_errortype);
  }
  
  private function publication_details()
  {
    $query ="SELECT * FROM pub_publication WHERE pub_companyid='" . $this->row->qcc_company . "'";
   
    $q = new Query($query);
    $publication_array = array();
    
    $i = 1;
    while($row = $q->next(ROW_AS_ARRAY)) 
    {
     $publication_array[$i++] = $row;    
    }	
    
    return $publication_array[$this->row->qcc_publication];
  }
  
  public function publication() 
  {    
    if(!$company_id) 
    { 
      echo "Error: company_id missing";
      exit;
    }
    
    if(!$option_value) 
    { 
      echo "Error: option_value missing";
      exit;
    }
        
    return $publication_details["pub_name"];
  }
  
  
  public function dd_list($dd_table, $dd_field, $dd_id) 
  {
    $query = new Query("SELECT * FROM " . $dd_table . " WHERE " . $dd_field . "='" . $dd_id . "'");
    return $row = $query->next();
  }

  public function error_type($department_id = false, $option_value = false) 
  {
    if(!$department_id) 
    { 
      trigger_error("Error: department_id missing");
      exit;
    }
    if(!$option_value) 
    { 
      trigger_error("Error: option_value missing");
      exit;
    }

    $query = new Query("SELECT * FROM ert_errortype WHERE ert_departmentid='" . $this->row->qcc_department . "'");
    
    $i = 1;
    while($row = $query->next(ROW_AS_ARRAY)) 
    {
      $ary[$i++] = $row;  
    } 
    
	if(isset($ary[$this->row->qcc_errortype]["ert_errortype"])) 
	{
		return $ary[$this->row->qcc_errortype]["ert_errortype"];	
	}
    else 
    {
    	return "";
    }
    			
  }

  public function edition()
  {     
    $query ="SELECT * FROM edi_edition WHERE edi_companyid='" .  $this->row->qcc_company . "' AND edi_publicationid='" . $this->publication_array["pub_id"] . "'";

    $q = new Query($query);	
    $i = 1;    
    while($row = $q->next(ROW_AS_ARRAY)) 
    { 
      $ary[$i++] = $row["edi_name"];
    }	
    
    if(count($ary) == 0)  
    {
      echo "Error: dd_value array empty";
      exit;
    }
    
    return $ary[$this->row->qcc_edition];	
  }
  
  private function operator() 
  {
  	$query = new Query("SELECT * FROM opr_operator WHERE opr_id = '" . $this->row->qcc_operator . "'"); 
  	
  	if($query->num_rows() > 0) 
  	{
  	  $row = $query->next();
  	  return $row->opr_name;
  	}
  	else 
  	{
      return "";
  	}
  }
  
} 

?>
