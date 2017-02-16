<?php
class DD_text
{  
  public function __construct($row) 
  {
    $this->row = $row;
    $this->company = $this->company();     
    $this->publication_array = $this->publication_details();    
    $this->publication_id = $this->publication_array["pub_id"];      
    $this->publication = $this->publication_array["pub_name"];     
    $this->edition = $this->edition();
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
  
  public function company() 
  {     	
    $query = new Query("SELECT * FROM com_company WHERE com_id='" . $this->row->qcc_company . "'");
    $row = $query->next();    
    	  
    return $row->com_name;		  
  }	
  
  public function department($department_id = false) 
  {
    if(!$department_id) { 
      echo "Error: company_id missing";
      exit;
    }
        	
    $query = new Query("SELECT * FROM dep_department WHERE dep_id='" . $department_id . "'");
    	  
    return $row = $query->next();		  
  }	
  
  public function qc_issue() 
  {
    $query = new Query("SELECT * FROM ");
  }
  
  public function error_type($department_id = false, $option_value = false) 
  {
    if(!$department_id) 
    { 
      echo "Error: department_id missing";
      exit;
    }
    if(!$option_value) 
    { 
      echo "Error: option_value missing";
      exit;
    }

    $query = new Query("SELECT * FROM ert_errortype WHERE ert_departmentid='" . $this->row->qcc_department . "'");
    
    $i = 1;
    while($row = $query->next(ROW_AS_ARRAY)) 
    {
      $ary[$i++] = $row;  
    }    

    if(count($ary) < 1) 
    {
    	return "";
    }
    else 
    {
    	return $ary[$this->row->qcc_errortype]["ert_errortype"];	
    }
    			
  }
  
  public function error_response($error_id = 0) 
  {
    $query = new Query("SELECT * FROM err_errorresponse WHERE err_id='" . $error_id . "'");	 
    
    if($error_id && $query->num_rows() > 0) 
    {
      $row = $query->next();   	   	  	  
      return $row->err_errorresponse;  		
    }
    else 
    {
      return "";
    }			
  }
  	
  public function operator($id = false) 
  {
    $operator_name = "";
    if(!$id) 
    { 
      echo "Error: id missing";	
      exit;    
    }     	
    $query = new Query("SELECT * FROM opr_operator WHERE opr_id='" . $id . "'");
    
    if($query->num_rows() < 1) 
    {
      $operator_name = "";
    }
    else 
    { 
      return $row = $query->next(ROW_AS_ARRAY);  
    }
     
    return $operator_name;			
  }
  
  public function manager_email($id = false) 
  {
    $manager_name = "";
    if(!$id) 
    { 
      echo "Error: id missing";	
      exit;    
    }     	
    $query = new Query("SELECT * FROM man_manager WHERE man_id='" . $id . "'");
    
    if($query->num_rows() < 1) 
    {
      $manager_name = "";
    }
    else 
    { 
      return $row = $query->next(ROW_AS_ARRAY);
    }
     
    return $manager_name;			
  }
  
  public function dd_list($dd_table, $dd_field, $dd_id) 
  {
    $query = new Query("SELECT * FROM " . $dd_table . " WHERE " . $dd_field . "='" . $dd_id . "'");
    return $row = $query->next();
  }
  
}

?>