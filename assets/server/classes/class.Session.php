<?php
class Load_session 
{
  public function __construct($array) 
  {
    $this->array = $array;
    session_register($this->array); 	
  }	
}
?>