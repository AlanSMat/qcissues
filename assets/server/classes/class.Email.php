<?php 
class Email
{
  public $disable_email = false;
  public $send_test = true;
  public $to;
  public $from;
  public $subject;
  public $body;
  public $cc = false;
  
  public function __construct($department_id) 
  {
    $this->department_id = $department_id;    
  }
  
  public function get_managers_email_addresses() 
  {
      $query = new Query("SELECT * FROM opr_operator WHERE opr_manager='1'");
      $num_rows = $query->num_rows();      
      $email_string = "";
      
      while($row = $query->next()) 
      {
          
          $email_string .= $row->opr_email . ";";        
          
      }
      
      return $email_string;
  }
  
  //** get the person(s) to send the email to based on department logging issue and return as a string
  public function get_to_email_array() 
  {
      $query = new Query("SELECT opr_email FROM opr_operator "
                        . "WHERE opr_receivenotifications = '1'"
                        . "AND opr_active = '1'"
                        );
      
      $to_operator_details = array();
      $to_operator_details = $query->fetch_array();
      
      return $to_operator_details;
  }

  public function get_to_email_string() 
  {
      $to_email_addresses = "";
      
      $operator_details = $this->get_to_email_array();
      
      for($i = 0; $i < count($operator_details); $i++) 
      {   
          $to_email_addresses .= $operator_details[$i]["opr_email"] . ";";
          
      }
      
      return $to_email_addresses;
  }
  
  //** get the person(s) to send the email to based on department logging issue and return as a string
  public function get_cc_email_array() 
  {
      $query = new Query("SELECT opr.* AS opr, ecc.* 
      					  FROM opr_operator AS opr, ecc_emailccdepartmentoperator AS ecc 
      					  WHERE opr.opr_id=ecc.ecc_operatorid 
      					  AND ecc.ecc_departmentid=" . $this->department_id . "
      					 ");
      
      $cc_operator_details = array();
      $cc_operator_details = $query->fetch_array();
            
      return $cc_operator_details;
  }

  public function get_cc_email_string($to_email_string, $from_email_string) 
  {
  	  $cc_operator_details = $this->get_cc_email_array();
  	  $to_operator_details = $this->get_to_email_array();
  	  $cc_email_string = "";
  	  
  	  //** find out whether the person sending to is in the email cc list and remove if they are
      for($i = 0; $i < count($cc_operator_details); $i++) 
      {
          $cc_email_string .= $cc_operator_details[$i]["opr_email"] . ";";
      }
      
      //** remove the to_operator_email string from the cc_email_string
      $cc_email_string = preg_replace("/" . $to_email_string . "/", "", $cc_email_string);

      //** remove the from_operator_email string from the cc_email_string
      $cc_email_string = preg_replace("/" . $from_email_string . "/", "", $cc_email_string);
      
      return $cc_email_string;
  }
  
  public function get_email_link($href_link_text, $is_update_message = false) 
  {
      if(!$href_link_text) 
          trigger_error("ERROR: link text not supplied");    
      
      //** look for a line break in the message and replace it with an %0A for outlook
      $body = str_replace("\n", "%0A", $this->body);
      
      if(!$is_update_message)               
          return $save_message = "<br /><br />" . $href_link_text . "<a href=\"mailTo:" . $this->to . "?subject=" . $this->subject . "&cc="  . $this->cc . "&body=" . $body . "\"><b>click here</b></a>";
      else 
          return $save_message = "";
  }
  
  private function get_message_html() 
  {
    //echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . CSS_URL . "/default.css\" />";
    $message  = "<html>";
    $message .= "<head>";
    $message .= "<style>";
    $message .= ".text,a {font-family:arial, helvetica; sans-serif;font-size:14px;}";
    $message .= "</style>";
    $message .= "</head>";
    $message .= "<body>";
    if($this->send_test) 
    {
      $message .= "<div class='text'><b>This is a test please disregard!</b></div><br />";
    }
    $message .= "<div class='text'>" . nl2br($this->body) . "</div>";
    $message .= "</body>";
    $message .= "</head>";
    $message .= "</html>";
    
    return $message;
  }
  
  private function get_html_headers() 
  {
      // To send HTML mail, the Content-type header must be set
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  
    // Additional headers
    $headers .= "To: " . $this->to . "" . "\r\n";
    $headers .= "From: " . $this->from . "" . "\r\n";
    
    return $headers;
  }
  
  public function send_mail() 
  {
    if(!$this->disable_email) 
    {
      // Mail it
      mail($this->to, $this->subject, $this->get_message_html(), $this->get_html_headers());
    }
  }
  
}

?>