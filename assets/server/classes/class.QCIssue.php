<?php
/**
 * 
 * @author mathers
 * base class for updating QC issues in DB
 *
 */
class QCIssue
{
  protected $issue_id;  
  protected $post;

	public function __construct($post, $query) 
	{
	  $post["qcc_errordetails"] = addslashes($post["qcc_errordetails"]);
	  $post["qcc_pubdate"] = strtotime($post["qcc_pubdate"]);
	  
		$this->post = $post;
		$this->query = $query;
	}
	
	protected function get_post() 
	{
	  return $this->post;
	}
   
  protected function get_qc_row($issue_id, $response = false) 
  {
    //** get details for email
    $query = new Query("SELECT * FROM qcc_qcissues WHERE qcc_id='" . $issue_id . "'");
    $row = $query->next(); 
    
    $dd_text    = new DDText($row);

    $qc_row["logdate"]          = date("d M Y G:i", $row->qcc_logdate);
    $qc_row["issue_id"]         = $issue_id;
    $qc_row["operator_name"]    = $dd_text->dd_list("opr_operator", "opr_id", $row->qcc_operator)->opr_name;
    $qc_row["operator_email"]   = $dd_text->dd_list("opr_operator", "opr_id", $row->qcc_operator)->opr_email;
    $qc_row["error_type"]       = $dd_text->error_type;    
    $qc_row["error_details"]    = stripslashes($row->qcc_errordetails);
    $qc_row["pub_date"]         = rt_date($row->qcc_pubdate);
    $qc_row["publication"]      = $dd_text->publication;
    $qc_row["edition"]          = $dd_text->edition;
    
    if($response) 
    {
      $qc_row["manager"]          = $dd_text->dd_list("opr_operator", "opr_id", $row->qcc_respondingmanager)->opr_name;
      $qc_row["manager_email"]    = $dd_text->dd_list("opr_operator", "opr_id", $row->qcc_respondingmanager)->opr_email;
      $qc_row["error_response"]   = $dd_text->dd_list("err_errorresponse", "err_id", $row->qcc_errorresponse)->err_errorresponse;
      $qc_row["response_details"] = stripslashes($row->qcc_responsedetails);
      $qc_row["email_sent"]       = $row->qcc_responseemailsent;
    }
    
    return $qc_row;
  }
  
  //** sends back common publication details text to include in an email
  protected function publication_details_text($pub_date, $error_type, $publication, $edition) 
  {
    $text  = "<b>Problem: </b>" . $error_type . "<br />";
    $text .= "<b>Publication Date: </b>". $pub_date . "<br />";
    $text .= "<b>Publication: </b>". $publication . "<br />";
    $text .= "<b>Edition: </b>". $edition . "<br /><br />";
    
    return $text;
  }
}
/**
 * 
 * @author mathers
 * inserts QC issue in DB from Browse input form
 *
 */
class InsertQCIssue extends QCIssue 
{
  public $issue_id;
  public $error_type;
  public $publication;
    
	public function __construct($post, $query) 
	{
    $post["qcc_submitted"]    = 1;
    $post["qcc_status"]       = "Open";
    $post["qcc_logdate"]      = strtotime("now");    

    parent::__construct($post, $query);
    
		$this->post          = parent::get_post();
		$this->issue_id      = $this->insert_record();
		
		$this->qc_row           = parent::get_qc_row($this->issue_id);		
		$this->operator_email   = $this->qc_row["operator_email"];		
		$this->error_type       = $this->qc_row["error_type"];
		$this->error_details    = $this->qc_row["error_details"];
		$this->pub_date         = $this->qc_row["pub_date"];
		$this->publication      = $this->qc_row["publication"];
		$this->edition          = $this->qc_row["edition"];
		$this->publication_text = parent::publication_details_text($this->pub_date, $this->error_type, $this->publication, $this->edition);
	}

	private function insert_record() 
	{
	  return $id = $this->query->insert_record("qcc_qcissues", $this->post);
	}
}
/**
 * 
 * @author mathers
 * update QC issue in DB from Browse input form
 *
 */
class UpdateQCIssue extends QCIssue 
{
  public $issue_id;
  public $email_subject;
  public $operator_name;
  public $operator_email;
  public $manager;
  public $manager_email;
  public $error_details;
  public $error_type;
  public $error_response;
  public $responding_operator;
  public $response_details;   
  public $log_date;
  public $email_sent;
  public $publication;
  
	public function __construct($post, $query) 
	{
	  //** set the shift checkboxes, these are checked by the responding manager
    !isset($post["qcc_dayshift"])       ? $post["qcc_dayshift"]       = 0 : $post["qcc_dayshift"] = 1;
    !isset($post["qcc_afternoonshift"]) ? $post["qcc_afternoonshift"] = 0 : $post["qcc_afternoonshift"] = 1;
    !isset($post["qcc_nightshift"])     ? $post["qcc_nightshift"]     = 0 : $post["qcc_nightshift"] = 1;
    !isset($post["qcc_errorresponse"])  ? $post["qcc_errorresponse"]  = 0 : $post["qcc_errorresponse"] = 1;
    
    $post["qcc_responsedetails"] = addslashes($post["qcc_responsedetails"]);
    
    parent::__construct($post, $query);
    
		$this->post             = parent::get_post();
		
		$this->update_record();
		
		$this->issue_id                  = $post["issue_id"];
		$this->qc_row                    = parent::get_qc_row($post["issue_id"], true);	
		$this->operator_name             = $this->qc_row["operator_name"];	
		$this->operator_email            = $this->qc_row["operator_email"];
		$this->manager                   = $this->qc_row["manager"];
		$this->manager_email             = $this->qc_row["manager_email"];
		$this->error_type                = $this->qc_row["error_type"];
		$this->error_details             = $this->qc_row["error_details"];
		$this->error_response            = $this->qc_row["error_response"];
		$this->responding_operator_email = $this->get_responding_operator_email($post["qcc_respondingmanager"]);		
		$this->response_details          = $this->qc_row["response_details"];
		$this->log_date                  = $this->qc_row["logdate"];
		$this->pub_date                  = $this->qc_row["pub_date"];
		$this->publication               = $this->qc_row["publication"];
		$this->edition                   = $this->qc_row["edition"];
		$this->publication_text          = parent::publication_details_text($this->pub_date, $this->error_type, $this->publication, $this->edition);
		$this->email_sent                = $this->qc_row["email_sent"];		
	}
	
	private function get_responding_operator_email($id) 
	{
		$query = new Query("SELECT * FROM opr_operator WHERE opr_id='" . $this->post["qcc_respondingmanager"] . "'");
		$row = $query->next();
		
		return $row->opr_email;
	}
	
	private function update_record() 
	{
	  $where_clause = "WHERE qcc_id='" . $this->post["issue_id"] . "'";
    $this->query->update_record("qcc_qcissues", $this->post, $where_clause);
	}
}
?>